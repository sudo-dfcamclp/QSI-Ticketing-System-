/* ==========================================================
   TICKET TAB — frontend controller
   -------------------------------------------------------------
   Tinatawag ito ng tab-manager.js sa pamamagitan ng
   initTicketTab(container) pagkatapos ma-inject yung
   ticket-tab.php HTML sa loob ng tab panel. HINDI natin
   ginagamit ang 'DOMContentLoaded' dito dahil na-lo-load ang
   script na ito nang dynamic (pagkatapos na pagkatapos ng
   DOMContentLoaded ng buong page), kaya hindi na ulit
   mag-fi-fire yung event na yun.

   Lahat ng data (list, single ticket, submit response, atbp.)
   ay galing sa admin/control/ticket-tab-control.php — AJAX
   JSON endpoint. Walang full page reload kahit kailan.
=========================================================== */

// -----------------------------------------------------------
// GLOBAL CONFIG
// -----------------------------------------------------------
var TICKET_API_URL = '/ticketing/admin/control/ticket-tab-control.php';
var TICKET_PER_PAGE = 10;
var TICKET_POLL_INTERVAL_MS = 5000; // 5 segundo bawat "realtime" check
var TICKET_NOTIF_SOUND_URL = '/ticketing/assets/sounds/notif.mp3';

// -----------------------------------------------------------
// NOTIFICATION PERMISSION — hingin ito NANG ISANG BESES sa
// pagbukas ng Ticket Tab. Kailangan ito ng browser bago
// pumayag magpakita ng OS-level notification (Notification API)
// kapag naka-ibang tab/naka-minimize ang admin.
// -----------------------------------------------------------
if ('Notification' in window && Notification.permission === 'default') {
  Notification.requestPermission();
}

function initTicketTab(container) {
  var root = container || document;

  var list = root.querySelector('#ticket-list');
  if (!list) return;

  // Iwasan ang double-binding/double-polling kapag na-open/na-close
  // /na-open ulit yung tab.
  if (list.dataset.ticketTabBound === 'true') return;
  list.dataset.ticketTabBound = 'true';

  // Kung gusto mong isa lang ang naka-open anytime, gawin itong true
  var EXCLUSIVE_MODE = false;

  // -----------------------------------------------------------
  // STATE (naka-scope sa loob ng init call na ito, per-tab-instance)
  // -----------------------------------------------------------
  var state = {
    currentPage: 1,
    maxSeenId: 0,           // pinaka-mataas na ticket_id na nakita na
    pollTimer: null,
    isPolling: false,
    knownIds: {}            // ticket_id -> true, para hindi dumoble
  };

  var pagination   = root.querySelector('#ticket-pagination');
  var loadingEl    = root.querySelector('#ticket-list-loading');
  var emptyEl      = root.querySelector('#ticket-list-empty');
  var countTextEl  = root.querySelector('#ticket-count-text');
  var liveDot      = root.querySelector('#ticket-live-dot');
  var liveLabel    = root.querySelector('#ticket-live-label');


  /* =============================================================
     STATUS -> COLOR MAPPING (para sa badge/icon styling)
  ============================================================== */
  function statusStyles(status) {
    switch ((status || '').toLowerCase()) {
      case 'open':
        return { badgeBg: 'bg-pinetint', badgeText: 'text-pine', dot: 'bg-pine', iconBg: 'bg-pinetint', iconText: 'text-pine' };
      case 'pending':
        return { badgeBg: 'bg-amber/10', badgeText: 'text-amber', dot: 'bg-amber', iconBg: 'bg-amber/10', iconText: 'text-amber' };
      case 'viewed':
        return { badgeBg: 'bg-green-100', badgeText: 'text-green-700', dot: 'bg-green-500', iconBg: 'bg-green-100', iconText: 'text-green-700' };
      case 'resolved':
        return { badgeBg: 'bg-emerald-100', badgeText: 'text-emerald-700', dot: 'bg-emerald-500', iconBg: 'bg-emerald-100', iconText: 'text-emerald-700' };
      case 'critical':
        return { badgeBg: 'bg-red-100', badgeText: 'text-red-700', dot: 'bg-red-500', iconBg: 'bg-red-100', iconText: 'text-red-700' };
      default:
        return { badgeBg: 'bg-canvas', badgeText: 'text-inkmuted', dot: 'bg-inkmuted', iconBg: 'bg-canvas', iconText: 'text-inkmuted' };
    }
  }

  function escapeHtml(value) {
    var div = document.createElement('div');
    div.textContent = value == null ? '' : String(value);
    return div.innerHTML;
  }

  function formatDateTime(value) {
    if (!value) return '—';
    var d = new Date(value.replace(' ', 'T'));
    if (isNaN(d.getTime())) return value;
    return d.toLocaleString('en-PH', {
      month: 'short', day: 'numeric', year: 'numeric',
      hour: '2-digit', minute: '2-digit'
    });
  }


  /* =============================================================
     BUILD ONE TICKET ITEM (HTML string) — sinusunod ang parehong
     Tailwind structure/classes ng orinal na static markup mo.
  ============================================================== */
  function buildTicketItemHtml(ticket) {
    var s = statusStyles(ticket.status);

    var resolutionBlock = '';
    if (ticket.resolution) {
      resolutionBlock =
        '<div class="mt-4 bg-surface rounded-xl border border-hairline p-4">' +
          '<div class="flex items-center gap-2 mb-3">' +
            '<div class="w-7 h-7 rounded-md bg-emerald-100 text-emerald-700 flex items-center justify-center">' +
              '<i class="fa-solid fa-check text-xs"></i>' +
            '</div>' +
            '<p class="text-[10px] font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted">Resolution</p>' +
          '</div>' +
          '<p class="text-sm text-inkmuted leading-relaxed">' + escapeHtml(ticket.resolution) + '</p>' +
        '</div>';
    }

    return (
      '<div class="ticket-item rounded-xl border border-hairline overflow-hidden bg-surface hover:border-pine/40 hover:shadow-sm transition-all duration-200" data-ticket-id="' + escapeHtml(ticket.ticket_id) + '">' +

        '<button type="button" class="ticket-toggle w-full flex items-center gap-4 px-5 py-4 text-left hover:bg-canvas transition-colors">' +

          '<div class="w-10 h-10 rounded-lg ' + s.iconBg + ' ' + s.iconText + ' flex items-center justify-center shrink-0">' +
            '<i class="fa-solid fa-ticket"></i>' +
          '</div>' +

          '<div class="grid grid-cols-2 sm:grid-cols-4 gap-x-6 gap-y-3 flex-1 min-w-0">' +

            '<div>' +
              '<p class="text-[10px] font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted mb-1">Ticket ID</p>' +
              '<p class="text-sm font-mono font-semibold text-ink">TCK-' + String(ticket.ticket_id).padStart(4, '0') + '</p>' +
            '</div>' +

            '<div>' +
              '<p class="text-[10px] font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted mb-1">Status</p>' +
              '<span class="ticket-status-badge inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md ' + s.badgeBg + ' ' + s.badgeText + ' text-xs font-semibold">' +
                '<span class="w-1.5 h-1.5 rounded-full ' + s.dot + '"></span>' +
                escapeHtml(ticket.status) +
              '</span>' +
            '</div>' +

            '<div>' +
              '<p class="text-[10px] font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted mb-1">Username</p>' +
              '<p class="text-sm font-medium text-ink truncate">' + escapeHtml(ticket.username) + '</p>' +
            '</div>' +

            '<div>' +
              '<p class="text-[10px] font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted mb-1">Department</p>' +
              '<p class="text-sm font-medium text-ink truncate">' + escapeHtml(ticket.department) + '</p>' +
            '</div>' +

          '</div>' +

          '<div class="w-8 h-8 rounded-lg flex items-center justify-center bg-canvas shrink-0">' +
            '<svg class="ticket-chevron w-4 h-4 text-inkmuted transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">' +
              '<path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />' +
            '</svg>' +
          '</div>' +

        '</button>' +

        '<div class="ticket-panel hidden bg-canvas border-t border-hairline px-5 py-5">' +

          '<div class="ticket-panel-body">' +
            '<div class="grid grid-cols-1 lg:grid-cols-2 gap-4">' +

              '<div class="bg-surface rounded-xl border border-hairline p-4">' +
                '<div class="flex items-center gap-2 mb-3">' +
                  '<div class="w-7 h-7 rounded-md bg-pinetint text-pine flex items-center justify-center">' +
                    '<i class="fa-solid fa-heading text-xs"></i>' +
                  '</div>' +
                  '<p class="text-[10px] font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted">Subject</p>' +
                '</div>' +
                '<p class="ticket-subject-text text-sm font-medium text-ink">' + escapeHtml(ticket.subject) + '</p>' +
              '</div>' +

              '<div class="bg-surface rounded-xl border border-hairline p-4">' +
                '<div class="flex items-center gap-2 mb-3">' +
                  '<div class="w-7 h-7 rounded-md bg-canvas text-inkmuted flex items-center justify-center">' +
                    '<i class="fa-solid fa-align-left text-xs"></i>' +
                  '</div>' +
                  '<p class="text-[10px] font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted">Description</p>' +
                '</div>' +
                '<p class="ticket-description-text text-sm text-inkmuted leading-relaxed">' + escapeHtml(ticket.description) + '</p>' +
              '</div>' +

            '</div>' +

            '<p class="text-[10px] font-mono uppercase tracking-[0.06em] text-inkmuted mt-3">' +
              'Created: ' + escapeHtml(formatDateTime(ticket.created_at)) +
              (ticket.resolve_at ? ' &middot; Resolved: ' + escapeHtml(formatDateTime(ticket.resolve_at)) : '') +
            '</p>' +

            '<div class="ticket-resolution-slot">' + resolutionBlock + '</div>' +

            '<div class="mt-4 bg-surface rounded-xl border border-hairline p-4">' +
              '<div class="flex items-center gap-2 mb-3">' +
                '<div class="w-7 h-7 rounded-md bg-canvas text-inkmuted flex items-center justify-center">' +
                  '<i class="fa-solid fa-reply text-xs"></i>' +
                '</div>' +
                '<p class="text-[10px] font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted">Response</p>' +
                '<button type="button" class="ml-2 inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-canvas border border-hairline text-inkmuted text-[10px] font-semibold uppercase tracking-[0.05em] hover:bg-pinetint hover:text-pine hover:border-pine/30 transition-colors">' +
                  '<i class="fa-solid fa-paperclip text-xs"></i> View Attachment' +
                '</button>' +
              '</div>' +

              '<textarea class="ticket-reply-input w-full rounded-xl border border-hairline p-4 text-sm text-ink placeholder:text-[#A7B3A1] outline-none transition-colors duration-150 resize-none hover:border-[#C6D1C4] focus:border-pine focus:bg-pinetint focus:shadow-[0_0_0_4px_rgba(14,91,69,0.12)]" rows="4" placeholder="Type your response here..."></textarea>' +

              '<div class="mt-3 flex justify-start">' +
                '<button type="button" class="ticket-submit-btn inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-pine hover:bg-pinedark text-white text-sm font-semibold shadow-sm transition-colors">' +
                  '<i class="fa-solid fa-paper-plane text-xs"></i> Submit' +
                '</button>' +
              '</div>' +
            '</div>' +
          '</div>' +

        '</div>' +

      '</div>'
    );
  }


  /* =============================================================
     RENDER FULL LIST (ginagamit sa initial load / page switch)
  ============================================================== */
  function renderTicketList(tickets) {
    // alisin muna lahat maliban sa loading/empty placeholders
    Array.prototype.slice.call(list.querySelectorAll('.ticket-item')).forEach(function (el) {
      el.remove();
    });

    state.knownIds = {};

    if (!tickets || tickets.length === 0) {
      if (emptyEl) {
        emptyEl.classList.remove('hidden');
        emptyEl.classList.add('flex');
      }
      return;
    }

    if (emptyEl) {
      emptyEl.classList.add('hidden');
      emptyEl.classList.remove('flex');
    }

    var html = '';
    tickets.forEach(function (ticket) {
      state.knownIds[ticket.ticket_id] = true;
      html += buildTicketItemHtml(ticket);
    });

    list.insertAdjacentHTML('beforeend', html);
  }


  /* =============================================================
     PREPEND NEW TICKETS (REALTIME) — dinadagdag sa TAAS ng
     listahan nang walang pag-reload/pag-refresh ng buong page.
     Tinatawag ito ng polling loop kapag may bagong ticket na
     natukoy mula sa server.
  ============================================================== */
  function prependNewTickets(tickets) {
    if (!tickets || tickets.length === 0) return;

    if (emptyEl && !emptyEl.classList.contains('hidden')) {
      emptyEl.classList.add('hidden');
      emptyEl.classList.remove('flex');
    }

    // baliktarin para pinaka-bago ang nasa pinaka-taas
    var ordered = tickets.slice().sort(function (a, b) {
      return Number(a.ticket_id) - Number(b.ticket_id);
    });

    ordered.forEach(function (ticket) {
      if (state.knownIds[ticket.ticket_id]) return; // iwas duplicate
      state.knownIds[ticket.ticket_id] = true;

      var wrapper = document.createElement('div');
      wrapper.innerHTML = buildTicketItemHtml(ticket);
      var newItemEl = wrapper.firstElementChild;

      // subtle "new" highlight na nawawala pagkalipas ng ilang saglit
      newItemEl.classList.add('ring-2', 'ring-pine/40');
      list.insertBefore(newItemEl, list.firstChild);

      setTimeout(function () {
        newItemEl.classList.remove('ring-2', 'ring-pine/40');
      }, 2500);
    });

    updateCountBadge();
  }


  function updateCountBadge(totalOverride) {
    if (!countTextEl) return;
    var count = typeof totalOverride === 'number'
      ? totalOverride
      : list.querySelectorAll('.ticket-item').length;
    countTextEl.textContent = count + (count === 1 ? ' Ticket' : ' Tickets');
  }

  /* =============================================================
     REMOVE TICKET FROM LIST (realtime) — ginagamit pag na-resolve
     na ang isang ticket (matapos i-submit ang response). Fade-out
     lang bago tanggalin sa DOM, walang page reload/refresh.
  ============================================================== */
  function removeTicketFromList(ticketItem, ticketId) {
    if (!ticketItem || !ticketItem.parentNode) return;

    delete state.knownIds[ticketId];

    ticketItem.style.transition = 'opacity 200ms ease, transform 200ms ease';
    ticketItem.style.opacity = '0';
    ticketItem.style.transform = 'scale(0.98)';

    setTimeout(function () {
      if (ticketItem.parentNode) ticketItem.parentNode.removeChild(ticketItem);
      updateCountBadge();

      if (list.querySelectorAll('.ticket-item').length === 0 && emptyEl) {
        emptyEl.classList.remove('hidden');
        emptyEl.classList.add('flex');
      }
    }, 200);
  }


  /* =============================================================
     PAGINATION RENDER
  ============================================================== */
  function renderPagination(totalPages, currentPage) {
    if (!pagination) return;
    pagination.innerHTML = '';

    if (totalPages <= 1) return;

    for (var p = 1; p <= totalPages; p++) {
      var btn = document.createElement('button');
      btn.type = 'button';
      btn.dataset.page = String(p);
      btn.textContent = String(p);

      var isActive = p === currentPage;
      btn.className = isActive
        ? 'page-btn w-9 h-9 rounded-lg bg-pine text-white text-sm font-semibold shadow-sm hover:bg-pinedark transition-colors'
        : 'page-btn w-9 h-9 rounded-lg bg-surface border border-hairline text-inkmuted text-sm font-medium hover:bg-canvas hover:border-[#C6D1C4] transition-colors';
      btn.setAttribute('aria-current', isActive ? 'true' : 'false');

      pagination.appendChild(btn);
    }
  }


  /* =============================================================
     API HELPERS
  ============================================================== */
  function apiGet(params) {
    var url = TICKET_API_URL + '?' + new URLSearchParams(params).toString();
    return fetch(url, {
      method: 'GET',
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    }).then(function (res) { return res.json(); });
  }

  function apiPost(payload) {
    return fetch(TICKET_API_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      },
      body: JSON.stringify(payload)
    }).then(function (res) { return res.json(); });
  }


  /* =============================================================
     LOAD A PAGE OF TICKETS (initial load + pagination click)
  ============================================================== */
  function loadPage(page) {
    if (loadingEl) loadingEl.classList.remove('hidden');

    apiGet({ action: 'list', page: page, per_page: TICKET_PER_PAGE })
      .then(function (res) {
        if (loadingEl) loadingEl.classList.add('hidden');

        if (!res || !res.success) {
          console.error('Failed to load tickets:', res && res.message);
          return;
        }

        state.currentPage = res.page;
        state.maxSeenId = Math.max(state.maxSeenId, res.max_id || 0);

        renderTicketList(res.data);
        renderPagination(res.total_pages, res.page);
        updateCountBadge(res.total);
      })
      .catch(function (err) {
        if (loadingEl) loadingEl.classList.add('hidden');
        console.error('Failed to load tickets:', err);
      });
  }


  /* =============================================================
     NOTIFICATION SOUND + POPUP (SweetAlert2 kung active ang tab,
     Notification API kung naka-ibang tab/naka-background)
     -------------------------------------------------------------
     Tinatawag ito kada bagong ticket na nakita ng polling loop,
     kahit gaano katagal naka-YouTube/Google Search ang admin sa
     ibang tab — basta't hindi pa sarado ang buong browser.
  ============================================================== */
  var ticketNotifSound = new Audio(TICKET_NOTIF_SOUND_URL);
  ticketNotifSound.volume = 1.0;

  function notifyNewTicket(ticket) {
    // ---------- 1. TUNOG (palaging sinusubukang i-play) ----------
    // Gagana ito basta't may naging user interaction na sa page
    // (click/keypress) — autoplay policy lang ng browser ang
    // makaka-block nito, hindi fatal error kung mabigo.
    try {
      ticketNotifSound.currentTime = 0;
      ticketNotifSound.play().catch(function () {
        // Naka-block dahil wala pang user interaction sa page.
      });
    } catch (e) {
      // ignore
    }

    // ---------- 2. VISUAL NOTIFICATION ----------
    if (document.hidden) {
      // Tab ay naka-background/naka-ibang tab (hal. YouTube,
      // Google search) — gamitin ang OS-level Notification API
      // para lumabas ito kahit anong tab ang tinitingnan.
      if ('Notification' in window && Notification.permission === 'granted') {
        var n = new Notification('New Ticket Received', {
          body: ticket.subject + ' — ' + ticket.username + ' (' + ticket.department + ')',
          icon: '/ticketing/assets/logo/logo.png',
          tag: 'ticket-' + ticket.ticket_id // iwas stacking ng paulit-ulit
        });

        n.onclick = function () {
          window.focus();
          n.close();
        };
      }
    } else {
      // Tab mismo ang naka-focus — SweetAlert2 modal sa gitna.
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          icon: 'info',
          title: 'New Ticket Received',
          html:
            '<b>' + escapeHtml(ticket.subject) + '</b><br>' +
            '<span class="text-sm text-gray-500">' +
            escapeHtml(ticket.username) + ' — ' + escapeHtml(ticket.department) +
            '</span>',
          toast: false,
          position: 'center',
          showConfirmButton: true,
          confirmButtonText: 'View Ticket',
          timer: 6000,
          timerProgressBar: true
        });
      }
    }
  }


  /* =========================================================================
     ============  AJAX REALTIME POLLING (PWESTO NG REALTIME LOGIC)  =========
     =========================================================================
     Dito nangyayari ang "realtime" na bahagi. Every TICKET_POLL_INTERVAL_MS
     (5 seconds), tinatanong natin ang backend (action=poll&since_id=X) kung
     may bagong ticket na dumating simula noong huling beses na nag-check
     tayo. Kung may bago, ipe-prepend natin sa taas ng listahan gamit ang
     prependNewTickets() — WALANG window.location.reload(), WALANG buong
     re-fetch ng listahan, JSON lang na maliit ang laman.

     Ito rin ang gagamitin mo kung gusto mo palitan ng WebSocket/SSE balang
     araw — palitan mo lang itong function, ang buong app logic sa itaas
     (renderTicketList, prependNewTickets, atbp.) ay hindi na kailangan
     galawin.
  ========================================================================== */
  function startRealtimePolling() {
    if (state.pollTimer) return; // huwag na mag-double start

    state.pollTimer = setInterval(function () {
      if (state.isPolling) return; // iwas overlapping requests
      state.isPolling = true;

      if (liveDot) liveDot.classList.add('animate-ping');

      apiGet({ action: 'poll', since_id: state.maxSeenId })
        .then(function (res) {
          state.isPolling = false;
          if (liveDot) liveDot.classList.remove('animate-ping');

          if (!res || !res.success) return;

          if (res.max_id) {
            state.maxSeenId = Math.max(state.maxSeenId, res.max_id);
          }

          // Ipakita lang agad ang mga bagong ticket kung nasa
          // unang page tayo ngayon (para hindi nakakalito yung
          // pagination kapag ibang page ang tinitingnan).
          if (state.currentPage === 1 && res.data && res.data.length > 0) {
            prependNewTickets(res.data);
          }

          // I-notify PARIN kahit anong page/tab state — kasi
          // kailangan malaman ng admin agad kahit naka-page 2
          // siya o naka-ibang tab (YouTube, Google, atbp.)
          if (res.data && res.data.length > 0) {
            res.data.forEach(function (ticket) {
              notifyNewTicket(ticket);
            });
          }

          if (liveLabel) liveLabel.textContent = 'Live';
        })
        .catch(function (err) {
          state.isPolling = false;
          if (liveDot) liveDot.classList.remove('animate-ping');
          if (liveLabel) liveLabel.textContent = 'Reconnecting...';
          console.error('Realtime poll failed:', err);
        });
    }, TICKET_POLL_INTERVAL_MS);
  }

  function stopRealtimePolling() {
    if (state.pollTimer) {
      clearInterval(state.pollTimer);
      state.pollTimer = null;
    }
  }

  /* -------------------------------------------------------------
     BAGO: HINDI na natin itinitigil ang polling kapag naka-ibang
     tab/naka-background (hal. naka-YouTube o Google Search ka).
     Layunin nito ay makakuha pa rin ng abiso/tunog kahit hindi
     naka-focus ang ticketing tab — importante ito dahil ikaw
     mismo ang nag-hahandle ng mga tickets buong araw.

     PAALALA: Ni-throttle ng mga modernong browser (lalo na
     Chrome) ang JS timers sa background tabs matapos ang ~5
     minuto ("intensive throttling") — posibleng maging mas
     mabagal (hal. minuto-minuto na lang) sa halip na eksaktong
     bawat 5 segundo habang naka-background. Hindi ito
     titigilan, magpapatuloy lang siyang tumatakbo sa background
     kahit gaano pa katagal.
  ---------------------------------------------------------------- */
  document.addEventListener('visibilitychange', function () {
    // Sadyang walang ginagawa dito ngayon — sinasadya na hindi
    // na itigil ang startRealtimePolling()/stopRealtimePolling()
    // sa pagbabago ng visibility state. Nandito lang ang listener
    // bilang reference kung sakaling gusto mo pang idagdag ulit
    // ang naunang behavior sa hinaharap.
  });
  // ========================================================================
  // ============  END OF AJAX REALTIME POLLING SECTION  ==================
  // ========================================================================


  /* =============================================================
     TOGGLE / DROPDOWN — REALTIME FETCH PAG NI-CLICK
     -------------------------------------------------------------
     Sa halip na ipakita lang yung datos na naka-cache na sa DOM,
     tumatawag tayo sa action=get&id=X bawat pag-click sa isang
     ticket para laging up-to-date ang lumalabas na Subject,
     Description, Status, at Resolution — kahit ibang tao pa ang
     huling nag-update sa ticket na iyon.
  ============================================================== */
  function renderTicketPanelData(ticketItem, ticket) {
    var s = statusStyles(ticket.status);

    // i-update yung Subject / Description sa panel
    var subjectEl = ticketItem.querySelector('.ticket-subject-text');
    var descEl = ticketItem.querySelector('.ticket-description-text');
    if (subjectEl) subjectEl.textContent = ticket.subject;
    if (descEl) descEl.textContent = ticket.description;

    // i-update yung status badge sa header row
    var badge = ticketItem.querySelector('.ticket-status-badge');
    if (badge) {
      badge.className = 'ticket-status-badge inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md ' + s.badgeBg + ' ' + s.badgeText + ' text-xs font-semibold';
      badge.innerHTML = '<span class="w-1.5 h-1.5 rounded-full ' + s.dot + '"></span>' + escapeHtml(ticket.status);
    }

    // i-update yung resolution block (kung meron na)
    var resSlot = ticketItem.querySelector('.ticket-resolution-slot');
    if (resSlot) {
      resSlot.innerHTML = ticket.resolution
        ? ('<div class="mt-4 bg-surface rounded-xl border border-hairline p-4">' +
            '<div class="flex items-center gap-2 mb-3">' +
              '<div class="w-7 h-7 rounded-md bg-emerald-100 text-emerald-700 flex items-center justify-center">' +
                '<i class="fa-solid fa-check text-xs"></i>' +
              '</div>' +
              '<p class="text-[10px] font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted">Resolution</p>' +
            '</div>' +
            '<p class="text-sm text-inkmuted leading-relaxed">' + escapeHtml(ticket.resolution) + '</p>' +
          '</div>')
        : '';
    }
  }

  function refreshTicketPanel(ticketItem, ticketId) {
    var panelBody = ticketItem.querySelector('.ticket-panel-body');
    if (!panelBody) return;

    apiGet({ action: 'get', id: ticketId })
      .then(function (res) {
        if (!res || !res.success) return;

        var ticket = res.data;

        // -----------------------------------------------------------
        // PENDING -> VIEWED (realtime) — sa sandaling i-expand ng
        // admin ang isang Pending na ticket, awtomatiko itong
        // mag-i-"Viewed" (green) at pababalikin agad sa DB (status
        // column) via update_status, walang paghihintay sa reload.
        // -----------------------------------------------------------
        if ((ticket.status || '').toLowerCase() === 'pending') {
          apiPost({ action: 'update_status', ticket_id: ticketId, status: 'Viewed' })
            .then(function (updRes) {
              if (updRes && updRes.success) {
                ticket.status = 'Viewed';
              }
              renderTicketPanelData(ticketItem, ticket);
            })
            .catch(function () {
              // kahit mabigo ang update, ipakita pa rin yung fresh data
              renderTicketPanelData(ticketItem, ticket);
            });
          return;
        }

        renderTicketPanelData(ticketItem, ticket);
      })
      .catch(function (err) {
        console.error('Failed to refresh ticket panel:', err);
      });
  }


  /* =============================================================
     EVENT DELEGATION — click handler ng buong #ticket-list
  ============================================================== */
  list.addEventListener('click', function (e) {

    // ---------- Toggle (expand/collapse) + realtime refresh ----------
    var toggleBtn = e.target.closest('.ticket-toggle');
    if (toggleBtn) {
      var item = toggleBtn.closest('.ticket-item');
      var panel = item.querySelector('.ticket-panel');
      var chevron = toggleBtn.querySelector('.ticket-chevron');
      var isOpen = !panel.classList.contains('hidden');

      if (EXCLUSIVE_MODE) {
        list.querySelectorAll('.ticket-item').forEach(function (other) {
          if (other === item) return;
          var otherPanel = other.querySelector('.ticket-panel');
          var otherChevron = other.querySelector('.ticket-chevron');
          if (otherPanel) otherPanel.classList.add('hidden');
          if (otherChevron) otherChevron.classList.remove('rotate-180');
        });
      }

      panel.classList.toggle('hidden', isOpen);
      chevron.classList.toggle('rotate-180', !isOpen);
      toggleBtn.setAttribute('aria-expanded', String(!isOpen));

      // Kapag binuksan (hindi isinasara), kumuha agad ng pinaka-
      // bagong datos ng ticket na ito mula sa server.
      if (!isOpen) {
        var ticketId = item.dataset.ticketId;
        refreshTicketPanel(item, ticketId);
      }
      return;
    }

    // ---------- Submit response ----------
    var submitBtn = e.target.closest('.ticket-submit-btn');
    if (submitBtn) {
      var ticketItem = submitBtn.closest('.ticket-item');
      var ticketId = ticketItem ? ticketItem.dataset.ticketId : null;
      var textarea = ticketItem
        ? ticketItem.querySelector('.ticket-reply-input')
        : null;
      var message = textarea ? textarea.value.trim() : '';

      if (!message) {
        if (textarea) textarea.focus();
        return;
      }

      submitTicketResponse(ticketId, message, submitBtn, textarea, ticketItem);
    }
  });


  // ---------- Pagination click handler ----------
  if (pagination && pagination.dataset.ticketPagBound !== 'true') {
    pagination.dataset.ticketPagBound = 'true';

    pagination.addEventListener('click', function (e) {
      var btn = e.target.closest('.page-btn');
      if (!btn) return;

      var page = parseInt(btn.getAttribute('data-page'), 10);
      loadPage(page);
    });
  }


  /**
   * Ipinadadala ang response ng isang ticket papunta sa backend
   * (ticket-tab-control.php -> action=submit_response), na sa
   * likod ay tumatawag sa Ticket::resolveTicket() mula sa
   * ticket-function.php.
   */
  function submitTicketResponse(ticketId, message, submitBtn, textarea, ticketItem) {
    var originalHtml = submitBtn.innerHTML;

    submitBtn.disabled = true;
    submitBtn.innerHTML =
      '<i class="fa-solid fa-spinner fa-spin text-xs"></i> Sending...';

    apiPost({
      action: 'submit_response',
      ticket_id: ticketId,
      message: message
    })
      .then(function (data) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalHtml;

        if (data && data.success) {
          if (textarea) textarea.value = '';

          // -----------------------------------------------------------
          // RESOLVED -> ALISIN SA LISTAHAN (realtime) — pag na-submit
          // na ang response, "tapos" na ang ticket (status Resolved),
          // kaya inaalis na ito agad sa ticket-tab.php nang walang
          // reload. Walang panel refresh na kailangan pa dahil
          // maaalis na rin ito sa DOM.
          // -----------------------------------------------------------
          if (ticketItem) removeTicketFromList(ticketItem, ticketId);

          if (typeof Swal !== 'undefined') {
            // Toast sa itaas-kanan (top-end) — check-mark na icon
            // animation kasama ang "Resolved" na label, hindi ito
            // naka-block sa pakikipag-interact ng admin sa page
            // (toast: true).
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              title: 'Resolved',
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true
            });
          }
        } else {
          if (typeof Swal !== 'undefined') {
            Swal.fire({
              icon: 'error',
              title: 'Failed to send response',
              text: (data && data.message) || 'Please try again.'
            });
          }
        }
      })
      .catch(function (error) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalHtml;
        console.error('Failed to submit ticket response:', error);

        if (typeof Swal !== 'undefined') {
          Swal.fire({
            icon: 'error',
            title: 'Something went wrong',
            text: 'Please check your connection and try again.'
          });
        }
      });
  }


  /* =============================================================
     INIT — unang pag-load ng page 1, saka simulan ang polling
  ============================================================== */
  loadPage(1);
  startRealtimePolling();
}
/* ==========================================================
   NOTIFICATION — centralized realtime notification controller
   -------------------------------------------------------------
   Dati ay nasa loob ito ng admin/script/ticket-tab.js, pero
   dahil ang ticket-tab.js ay TAB-SCOPED (na-inject/na-de-inject
   ng tab-manager.js paulit-ulit habang bukas ang admin panel —
   tingnan ang closeTab() sa script/tab-manager.js na nag-re-
   remove() sa buong #ticket-list container), bawat open/close
   ng Ticket Tab ay gumagawa ng BAGONG setInterval() polling loop
   nang hindi natitigil yung luma — resulta: doble/triple na
   notification sounds/popups bawat bagong ticket.

   Inilipat natin dito, sa script/notification.js, dahil ito ay
   naka-<script> sa dulo ng includes/dashboard.php — ang shell na
   naka-load nang ISANG BESES lang bawat buong page load/session
   (hindi tab-injection), kaya ISANG polling loop lang, forever,
   kahit ilang beses buksan/isara ang Ticket Tab.

   Ang script na ito ang NAG-IISANG "source of truth" para sa
   "may bagong ticket ba" sa buong admin panel. Hindi siya
   direktang nag-mamanipula ng Ticket Tab DOM — sa halip,
   nag-dispatch lang siya ng custom event
   ('ticketing:newTickets') sa document. Kung bukas ang Ticket
   Tab (tingnan ang admin/script/ticket-tab.js), makikinig ito sa
   event na yun para i-prepend sa listahan. Kung sarado ang tab,
   wala lang tumatanggap — safe, walang mangyayaring error.

   Layunin: ang notification.js ang nag-iisang bahagi ng system
   na "nakikinig" sa bagong ticket. Ang ticket-tab.js ay
   display/CRUD lang ang trabaho.
=========================================================== */

(function () {
  'use strict';

  // -----------------------------------------------------------
  // GLOBAL CONFIG
  // -----------------------------------------------------------
  var TICKET_API_URL = '/ticketing/admin/control/ticket-tab-control.php';
  var POLL_INTERVAL_MS = 5000; // 5 segundo bawat "realtime" check
  var NOTIF_SOUND_URL = '/ticketing/assets/sounds/notif.mp3';
  var NOTIF_ICON_URL = '/ticketing/assets/logo/logo.png';

  // -----------------------------------------------------------
  // STATE — module-level lang (isang beses lang na-load ito
  // bawat page load, kaya safe na hindi na kailangan pang
  // i-scope sa loob ng isang function/container tulad noon)
  // -----------------------------------------------------------
  var state = {
    maxSeenId: 0,
    pollTimer: null,
    isPolling: false,
    hasBaseline: false // true na pagkatapos ng unang poll — para
                        // hindi natin i-notify yung mga tickets na
                        // nauna nang nandoon bago pa man mag-poll
  };

  var notifSound = new Audio(NOTIF_SOUND_URL);
  notifSound.volume = 1.0;

  // -----------------------------------------------------------
  // NOTIFICATION PERMISSION — hingin nang ISANG BESES lang bawat
  // page load ng dashboard (hindi na paulit-ulit bawat pagbukas
  // ng Ticket Tab).
  // -----------------------------------------------------------
  if ('Notification' in window && Notification.permission === 'default') {
    Notification.requestPermission();
  }

  function escapeHtml(value) {
    var div = document.createElement('div');
    div.textContent = value == null ? '' : String(value);
    return div.innerHTML;
  }

  function apiGet(params) {
    var url = TICKET_API_URL + '?' + new URLSearchParams(params).toString();
    return fetch(url, {
      method: 'GET',
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    }).then(function (res) { return res.json(); });
  }

  /* =============================================================
     NOTIFICATION SOUND + POPUP (SweetAlert2 kung active ang tab,
     Notification API kung naka-ibang tab/naka-background)
  ============================================================== */
  function notifyNewTicket(ticket) {
    // ---------- 1. TUNOG (palaging sinusubukang i-play) ----------
    // Gagana ito basta't may naging user interaction na sa page
    // (click/keypress) — autoplay policy lang ng browser ang
    // makaka-block nito, hindi fatal error kung mabigo.
    try {
      notifSound.currentTime = 0;
      notifSound.play().catch(function () {
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
          icon: NOTIF_ICON_URL,
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
          confirmButtonText: 'OK',
          confirmButtonColor: '#16a34a',
          timer: 120000,
          timerProgressBar: true,
          allowOutsideClick: false,
          allowEscapeKey: true
        });
      }
    }
  }

  /* =========================================================================
     ============  AJAX REALTIME POLLING (PWESTO NG REALTIME LOGIC)  =========
     =========================================================================
     Every POLL_INTERVAL_MS (5 seconds), tinatanong natin ang backend
     (action=poll&since_id=X) kung may bagong ticket na dumating simula
     noong huling beses na nag-check tayo. Kung may bago:

       1. i-dispatch sa document ang 'ticketing:newTickets' event, para
          ma-prepend ito ng Ticket Tab KUNG bukas ito at nasa page 1 —
          tingnan ang admin/script/ticket-tab.js
       2. i-notify (tunog + popup) gamit ang notifyNewTicket() sa itaas

     Hiwalay ang dalawang gawaing ito: ang notification ay palaging
     tumatakbo kahit sarado ang Ticket Tab, samantalang ang pag-prepend
     sa listahan ay depende kung bukas ba talaga ang tab sa DOM ngayon.

     Ito rin ang gagamitin mo kung gusto mo palitan ng WebSocket/SSE
     balang araw — palitan mo lang itong function; ang buong app logic
     sa ticket-tab.js (renderTicketList, prependNewTickets, atbp.) ay
     hindi na kailangan galawin.
  ========================================================================== */
  function poll() {
    if (state.isPolling) return; // iwas overlapping requests
    state.isPolling = true;

    apiGet({ action: 'poll', since_id: state.maxSeenId })
      .then(function (res) {
        state.isPolling = false;

        if (!res || !res.success) return;

        if (res.max_id) {
          state.maxSeenId = Math.max(state.maxSeenId, res.max_id);
        }

        // Unang poll pagkatapos mag-load ng dashboard — itakda lang
        // ang baseline, huwag mag-notify. Kung hindi natin ito
        // gagawin, mag-nonotify tayo (kasama tunog) para sa LAHAT ng
        // existing na tickets sa bawat pag-login/refresh ng admin.
        if (!state.hasBaseline) {
          state.hasBaseline = true;
          return;
        }

        if (!res.data || res.data.length === 0) return;

        // Ipaalam sa Ticket Tab (kung bukas) na may bagong dumating.
        document.dispatchEvent(new CustomEvent('ticketing:newTickets', {
          detail: { tickets: res.data, maxId: state.maxSeenId }
        }));

        // I-notify PARIN kahit anong tab/page state — kasi kailangan
        // malaman ng admin agad kahit naka-ibang tab siya (YouTube,
        // Google, atbp.) o kahit sarado ang Ticket Tab.
        res.data.forEach(function (ticket) {
          notifyNewTicket(ticket);
        });
      })
      .catch(function (err) {
        state.isPolling = false;
        console.error('Realtime poll failed:', err);
      });
  }

  function startPolling() {
    if (state.pollTimer) return; // huwag na mag-double start
    poll(); // agad kumuha ng baseline sa unang tawag, hindi maghintay 5s
    state.pollTimer = setInterval(poll, POLL_INTERVAL_MS);
  }

  /* -------------------------------------------------------------
     Sadyang hindi natin itinitigil ang polling kapag naka-ibang
     tab/naka-background (hal. naka-YouTube o Google Search ka).
     Layunin nito ay makakuha pa rin ng abiso/tunog kahit hindi
     naka-focus ang browser tab — importante ito dahil ikaw mismo
     ang nag-hahandle ng mga tickets buong araw.

     PAALALA: Ni-throttle ng mga modernong browser (lalo na
     Chrome) ang JS timers sa background tabs matapos ang ~5
     minuto ("intensive throttling") — posibleng maging mas
     mabagal (hal. minuto-minuto na lang) sa halip na eksaktong
     bawat 5 segundo habang naka-background. Hindi ito titigilan,
     magpapatuloy lang siyang tumatakbo sa background kahit gaano
     pa katagal.
  ---------------------------------------------------------------- */

  // -----------------------------------------------------------
  // INIT — isang beses lang tumatakbo ito bawat buong page load
  // ng dashboard.php (hindi tab-injection), kaya isang polling
  // loop lang, forever.
  // -----------------------------------------------------------
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', startPolling);
  } else {
    startPolling();
  }
})();
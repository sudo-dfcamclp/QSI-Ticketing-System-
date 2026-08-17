/* ==========================================================
   PRINT REPORT TAB — frontend controller
   -------------------------------------------------------------
   Tinatawag ito ng script/tab-manager.js sa pamamagitan ng
   initPrintTab(container) pagkatapos ma-inject yung print.php
   HTML sa loob ng tab panel (dynamic load, kaya HINDI natin
   ginagamit ang 'DOMContentLoaded' dito).

   Hinati ang file na ito sa MALINAW na mga SEKSYON, bawat isa
   ay HIWALAY na function, tulad ng hiling:

     1) REALTIME TABLE (AJAX list + auto-refresh)
     2) DATE RANGE FILTER (From / To + pag-e-enable ng Print btn)
     3) PRINT BUTTON -> SweetAlert2 confirm -> PDF (dompdf) via
        admin/pdf.php (bagong tab/window, dahil file view/download
        ito, hindi JSON)

   Data source: admin/control/print-control.php (JSON AJAX)
   PDF source:  admin/pdf.php (dompdf, landscape)
=========================================================== */

// -----------------------------------------------------------
// 0) GLOBAL CONFIG
// -----------------------------------------------------------
var PRINT_API_URL = '/ticketing/admin/control/print-control.php';
var PRINT_PDF_URL = '/ticketing/admin/pdf.php';
var PRINT_REFRESH_INTERVAL_MS = 5000; // 5 segundo — "realtime" refresh ng table

function initPrintTab(container) {
  var root = container || document;

  var tableBody = root.querySelector('#print-ticket-table-body');
  if (!tableBody) return;

  // Iwasan ang double-binding/double-polling kapag na-open/na-close
  // /na-open ulit yung tab.
  if (tableBody.dataset.printTabBound === 'true') return;
  tableBody.dataset.printTabBound = 'true';

  var loadingEl  = root.querySelector('#print-ticket-loading');
  var emptyEl    = root.querySelector('#print-ticket-empty');
  var dateFromEl = root.querySelector('#print-date-from');
  var dateToEl   = root.querySelector('#print-date-to');
  var printBtn   = root.querySelector('#print-ticket-btn');

  var refreshTimer = null;


  /* =============================================================
     ============  1) REALTIME TABLE (AJAX + AUTO-REFRESH)  =======
     -------------------------------------------------------------
     Ito ang bahaging tumatawag sa print-control.php (action=list)
     na siya namang tumatawag sa Ticket::getAllTickets() galing sa
     ticket-function.php. Buong listahan ng ticket ang ipinapakita
     dito (kasama ang status), hindi lang Resolved — ang Resolved
     + date-range na filter ay para lang sa PDF (seksyon #3).
  ============================================================== */

  function statusBadgeClasses(status) {
    switch ((status || '').toLowerCase()) {
      case 'open':
        return 'bg-pinetint text-pine';
      case 'pending':
        return 'bg-amber/10 text-amber';
      case 'viewed':
        return 'bg-green-100 text-green-700';
      case 'resolved':
        return 'bg-emerald-100 text-emerald-700';
      default:
        return 'bg-gray-100 text-gray-600';
    }
  }

  function escapeHtml(value) {
    var div = document.createElement('div');
    div.textContent = value === null || value === undefined ? '' : String(value);
    return div.innerHTML;
  }

  function formatDateTime(value) {
    if (!value) return '—';
    var d = new Date(String(value).replace(' ', 'T'));
    if (isNaN(d.getTime())) return escapeHtml(value);
    return d.toLocaleString('en-PH', {
      year: 'numeric', month: 'short', day: '2-digit',
      hour: '2-digit', minute: '2-digit'
    });
  }

  function renderRows(tickets) {
    if (!tickets || tickets.length === 0) {
      tableBody.innerHTML = '';
      if (emptyEl) emptyEl.classList.remove('hidden');
      return;
    }

    if (emptyEl) emptyEl.classList.add('hidden');

    var html = tickets.map(function (t) {
      return (
        '<tr class="border-b border-hairline last:border-0 hover:bg-canvas/60">' +
          '<td class="px-4 py-3 text-sm text-ink whitespace-nowrap">#' + escapeHtml(t.ticket_id) + '</td>' +
          '<td class="px-4 py-3 whitespace-nowrap">' +
            '<span class="inline-flex px-2.5 py-1 rounded-full text-[11px] font-semibold ' + statusBadgeClasses(t.status) + '">' +
              escapeHtml(t.status) +
            '</span>' +
          '</td>' +
          '<td class="px-4 py-3 text-sm text-ink whitespace-nowrap">' + escapeHtml(t.username) + '</td>' +
          '<td class="px-4 py-3 text-sm text-ink whitespace-nowrap">' + escapeHtml(t.department) + '</td>' +
          '<td class="px-4 py-3 text-sm text-ink whitespace-nowrap">' + escapeHtml(t.subject) + '</td>' +
          '<td class="px-4 py-3 text-sm text-inkmuted">' + escapeHtml(t.description) + '</td>' +
          '<td class="px-4 py-3 text-sm text-ink whitespace-nowrap">' + escapeHtml(t.priority) + '</td>' +
          '<td class="px-4 py-3 text-sm text-inkmuted">' + escapeHtml(t.resolution || '—') + '</td>' +
          '<td class="px-4 py-3 text-sm text-inkmuted whitespace-nowrap">' + formatDateTime(t.created_at) + '</td>' +
          '<td class="px-4 py-3 text-sm text-inkmuted whitespace-nowrap">' + formatDateTime(t.resolve_at) + '</td>' +
        '</tr>'
      );
    }).join('');

    tableBody.innerHTML = html;
  }

  function fetchTicketList(showLoading) {
    if (showLoading && loadingEl) loadingEl.classList.remove('hidden');

    fetch(PRINT_API_URL + '?action=list', {
      method: 'GET',
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
      .then(function (res) { return res.json(); })
      .then(function (json) {
        if (json && json.success) {
          renderRows(json.data);
        }
      })
      .catch(function (err) {
        console.error('Failed to load ticket report:', err);
      })
      .finally(function () {
        if (loadingEl) loadingEl.classList.add('hidden');
      });
  }

  function startRealtimeRefresh() {
    // Unang load agad (may loading spinner)
    fetchTicketList(true);

    // Tapos mag-a-auto-refresh every few seconds nang walang
    // spinner/flicker, para "realtime" ang datos sa report.
    refreshTimer = setInterval(function () {
      fetchTicketList(false);
    }, PRINT_REFRESH_INTERVAL_MS);
  }


  /* =============================================================
     ============  2) DATE RANGE FILTER (From / To)  ==============
     -------------------------------------------------------------
     Ang mga <input type="date"> ay siya nang "column" na nagbubukas
     ng native na calendar ng browser pag ni-click/focus (default
     na behavior ng type="date", walang kailangan pang external
     na date-picker library). Pag napili na ang parehong From at
     To, saka lang mag-e-enable (green) ang Print button.
  ============================================================== */

  function isFilterComplete() {
    return !!(dateFromEl && dateToEl && dateFromEl.value && dateToEl.value);
  }

  function updatePrintButtonState() {
    if (!printBtn) return;

    if (isFilterComplete()) {
      // ENABLED — green
      printBtn.disabled = false;
      printBtn.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
      printBtn.classList.add('bg-pine', 'hover:bg-pinedark', 'text-white', 'cursor-pointer');
    } else {
      // DISABLED — gray
      printBtn.disabled = true;
      printBtn.classList.remove('bg-pine', 'hover:bg-pinedark', 'text-white', 'cursor-pointer');
      printBtn.classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed');
    }
  }

  function bindDateFilterEvents() {
    if (dateFromEl) {
      dateFromEl.addEventListener('change', function () {
        // Huwag payagan mag-simula ang "From" nang mas huli sa "To"
        if (dateToEl && dateToEl.value && dateFromEl.value > dateToEl.value) {
          dateToEl.value = '';
        }
        updatePrintButtonState();
      });
    }

    if (dateToEl) {
      dateToEl.addEventListener('change', function () {
        updatePrintButtonState();
      });
    }
  }


  /* =============================================================
     ======  3) PRINT BUTTON -> SWEETALERT2 -> PDF (dompdf)  =======
     -------------------------------------------------------------
     Pag-click ng Print (naka-enable na dahil kumpleto na ang
     From/To): magbubukas ng SweetAlert2 confirmation dialog na
     may GREEN na "Print" button at RED na "Close" button. Pag
     kinumpirma, bubuksan sa BAGONG TAB ang admin/pdf.php kasama
     ang from/to bilang query string — doon gagawin ni dompdf ang
     landscape PDF gamit ang Resolved tickets lang sa loob ng
     napiling date range.
  ============================================================== */

  function handlePrintClick() {
    if (!isFilterComplete()) return; // safety net (button disabled na naman)

    var from = dateFromEl.value;
    var to   = dateToEl.value;

    Swal.fire({
      icon: 'question',
      title: 'Generate Print Report?',
      html:
        'Mag-p-print ng <strong>Resolved</strong> tickets mula ' +
        '<strong>' + from + '</strong> hanggang <strong>' + to + '</strong>.',
      showCancelButton: true,
      confirmButtonText: '<i class="fa-solid fa-print"></i> Print',
      cancelButtonText: '<i class="fa-solid fa-xmark"></i> Close',
      confirmButtonColor: '#16a34a', // green
      cancelButtonColor: '#dc2626',  // red
      reverseButtons: true
    }).then(function (result) {
      if (result.isConfirmed) {
        var url =
          PRINT_PDF_URL +
          '?from=' + encodeURIComponent(from) +
          '&to=' + encodeURIComponent(to);

        // Bagong tab/window ang gagamitin (hindi fetch/AJAX) dahil
        // binary PDF stream ang isasagot ng pdf.php, hindi JSON.
        window.open(url, '_blank');
      }
    });
  }

  function bindPrintButtonEvents() {
    if (printBtn) {
      printBtn.addEventListener('click', handlePrintClick);
    }
  }


  /* =============================================================
     INIT — patakbuhin lahat ng seksyon sa itaas
  ============================================================== */
  bindDateFilterEvents();
  bindPrintButtonEvents();
  updatePrintButtonState(); // simula palang, naka-gray dapat
  startRealtimeRefresh();
}
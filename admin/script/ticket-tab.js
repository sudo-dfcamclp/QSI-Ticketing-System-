/* ==========================================================
   TICKET LIST - accordion toggle + response submit logic
   Tinatawag ito ng tab-manager.js sa pamamagitan ng
   initTicketTab(container) pagkatapos ma-inject yung
   ticket-tab.php HTML sa loob ng tab panel. HINDI natin
   ginagamit ang 'DOMContentLoaded' dito dahil na-lo-load ang
   script na ito nang dynamic (pagkatapos na pagkatapos ng
   DOMContentLoaded ng buong page), kaya hindi na ulit
   mag-fi-fire yung event na yun.
=========================================================== */

function initTicketTab(container) {
  var root = container || document;

  var list = root.querySelector('#ticket-list');
  if (!list) return;

  // Iwasan ang double-binding kapag na-open/na-close/na-open
  // ulit yung tab (para hindi dumoble ang click handler).
  if (list.dataset.ticketTabBound === 'true') return;
  list.dataset.ticketTabBound = 'true';

  // Kung gusto mong isa lang ang naka-open anytime, gawin itong true
  var EXCLUSIVE_MODE = false;

  list.addEventListener('click', function (e) {

    // ---------- Toggle (expand/collapse) ----------
    var toggleBtn = e.target.closest('.ticket-toggle');
    if (toggleBtn) {
      var item = toggleBtn.closest('.ticket-item');
      var panel = item.querySelector('.ticket-panel');
      var chevron = toggleBtn.querySelector('.ticket-chevron');
      var isOpen = !panel.classList.contains('hidden');

      if (EXCLUSIVE_MODE) {
        // isara muna lahat ng ibang naka-open na item
        list.querySelectorAll('.ticket-item').forEach(function (other) {
          if (other === item) return;
          var otherPanel = other.querySelector('.ticket-panel');
          var otherChevron = other.querySelector('.ticket-chevron');
          if (otherPanel) otherPanel.classList.add('hidden');
          if (otherChevron) otherChevron.classList.remove('rotate-180');
          var otherToggle = other.querySelector('.ticket-toggle');
          if (otherToggle) otherToggle.setAttribute('aria-expanded', 'false');
        });
      }

      // toggle current item
      panel.classList.toggle('hidden', isOpen);
      chevron.classList.toggle('rotate-180', !isOpen);
      toggleBtn.setAttribute('aria-expanded', String(!isOpen));
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

      submitTicketResponse(ticketId, message, submitBtn, textarea);
    }
  });

  // Optional: pagination click handler (palitan ng actual AJAX/PHP fetch)
  var pagination = root.querySelector('#ticket-pagination');
  if (pagination && pagination.dataset.ticketPagBound !== 'true') {
    pagination.dataset.ticketPagBound = 'true';

    pagination.addEventListener('click', function (e) {
      var btn = e.target.closest('.page-btn');
      if (!btn) return;

      pagination.querySelectorAll('.page-btn').forEach(function (b) {
        b.setAttribute('aria-current', 'false');
      });
      btn.setAttribute('aria-current', 'true');

      var page = btn.getAttribute('data-page');
      // TODO: dito mo ilagay ang fetch/AJAX call para mag-load ng
      // tickets ng napiling page, e.g.:
      // fetch('get_tickets.php?page=' + page)...
      console.log('Load tickets for page:', page);
    });
  }
}

/**
 * Ipinadadala ang response ng isang ticket papunta sa backend.
 * Palitan ang URL/payload base sa actual endpoint mo
 * (halimbawa: includes/functions/ticket-function.php).
 */
function submitTicketResponse(ticketId, message, submitBtn, textarea) {
  var originalHtml = submitBtn.innerHTML;

  submitBtn.disabled = true;
  submitBtn.innerHTML =
    '<i class="fa-solid fa-spinner fa-spin text-xs"></i> Sending...';

  fetch('/ticketing/includes/functions/ticket-function.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: JSON.stringify({
      action: 'submit_response',
      ticket_id: ticketId,
      message: message
    })
  })
    .then(function (res) {
      return res.json();
    })
    .then(function (data) {
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalHtml;

      if (data && data.success) {
        if (textarea) textarea.value = '';

        if (typeof Swal !== 'undefined') {
          Swal.fire({
            icon: 'success',
            title: 'Response sent',
            timer: 1500,
            showConfirmButton: false
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
var PRINT_API_URL = '/ticketing/admin/control/print-control.php';
var PRINT_PDF_URL = '/ticketing/admin/pdf.php';
var PRINT_REFRESH_INTERVAL_MS = 5000;

function initPrintTab(container) {
    var root = container || document;
    var tableBody = root.querySelector('#print-ticket-table-body');

    if (!tableBody) return;

    if (tableBody.dataset.printTabBound === 'true') return;

    tableBody.dataset.printTabBound = 'true';

    var loadingEl = root.querySelector('#print-ticket-loading');
    var emptyEl = root.querySelector('#print-ticket-empty');
    var dateFromEl = root.querySelector('#print-date-from');
    var dateToEl = root.querySelector('#print-date-to');
    var sortEl = root.querySelector('#print-sort');
    var printBtn = root.querySelector('#print-ticket-btn');

    var refreshTimer = null;

    /* =========================================================
       STATUS BADGE
    ========================================================== */

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

    /* =========================================================
       ESCAPE HTML
    ========================================================== */

    function escapeHtml(value) {
        var div = document.createElement('div');
        div.textContent = value === null || value === undefined ? '' : String(value);
        return div.innerHTML;
    }

    /* =========================================================
       FORMAT DATE TIME
    ========================================================== */

    function formatDateTime(value) {
        if (!value) return '—';

        var d = new Date(String(value).replace(' ', 'T'));

        if (isNaN(d.getTime())) return escapeHtml(value);

        return d.toLocaleString('en-PH', {
            year: 'numeric',
            month: 'short',
            day: '2-digit',
            hour: '2-digit',
            minute: '2-digit'
        });
    }

    /* =========================================================
       RENDER TABLE
    ========================================================== */

    function renderRows(tickets) {
        if (!tickets || tickets.length === 0) {
            tableBody.innerHTML = '';

            if (emptyEl) {
                emptyEl.classList.remove('hidden');
            }

            return;
        }

        if (emptyEl) {
            emptyEl.classList.add('hidden');
        }

        var html = tickets.map(function(t) {
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

    /* =========================================================
       FETCH ALL TICKETS
    ========================================================== */

    function fetchTicketList(showLoading) {
        if (showLoading && loadingEl) {
            loadingEl.classList.remove('hidden');
        }

        fetch(PRINT_API_URL + '?action=list', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(function(res) {
            return res.json();
        })
        .then(function(json) {
            if (json && json.success) {
                renderRows(json.data);
            }
        })
        .catch(function(err) {
            console.error('Failed to load ticket report:', err);
        })
        .finally(function() {
            if (loadingEl) {
                loadingEl.classList.add('hidden');
            }
        });
    }

    /* =========================================================
       REALTIME REFRESH
    ========================================================== */

    function startRealtimeRefresh() {
        fetchTicketList(true);

        refreshTimer = setInterval(function() {
            fetchTicketList(false);
        }, PRINT_REFRESH_INTERVAL_MS);
    }

    /* =========================================================
       FILTER VALIDATION
    ========================================================== */

    function isFilterComplete() {
        return !!(
            dateFromEl &&
            dateToEl &&
            dateFromEl.value &&
            dateToEl.value
        );
    }

    /* =========================================================
       PRINT BUTTON STATE
    ========================================================== */

    function updatePrintButtonState() {
        if (!printBtn) return;

        if (isFilterComplete()) {
            printBtn.disabled = false;
            printBtn.classList.remove(
                'bg-gray-300',
                'text-gray-500',
                'cursor-not-allowed'
            );
            printBtn.classList.add(
                'bg-pine',
                'hover:bg-pinedark',
                'text-white',
                'cursor-pointer'
            );
        } else {
            printBtn.disabled = true;
            printBtn.classList.remove(
                'bg-pine',
                'hover:bg-pinedark',
                'text-white',
                'cursor-pointer'
            );
            printBtn.classList.add(
                'bg-gray-300',
                'text-gray-500',
                'cursor-not-allowed'
            );
        }
    }

    /* =========================================================
       DATE FILTER EVENTS
    ========================================================== */

    function bindDateFilterEvents() {
        if (dateFromEl) {
            dateFromEl.addEventListener('change', function() {
                if (
                    dateToEl &&
                    dateToEl.value &&
                    dateFromEl.value > dateToEl.value
                ) {
                    dateToEl.value = '';
                }

                updatePrintButtonState();
            });
        }

        if (dateToEl) {
            dateToEl.addEventListener('change', function() {
                updatePrintButtonState();
            });
        }
    }

    /* =========================================================
       PRINT
    ========================================================== */

    function handlePrintClick() {
        if (!isFilterComplete()) return;

        var from = dateFromEl.value;
        var to = dateToEl.value;
        var sort = sortEl ? sortEl.value : 'latest';

        Swal.fire({
            icon: 'question',
            title: 'Generate Print Report?',
            html:
                'Print <strong>Resolved</strong> tickets from ' +
                '<strong>' + from + '</strong> to <strong>' + to + '</strong>.',
            showCancelButton: true,
            confirmButtonText: '<i class="fa-solid fa-print"></i> Print',
            cancelButtonText: '<i class="fa-solid fa-xmark"></i> Close',
            confirmButtonColor: '#16a34a',
            cancelButtonColor: '#dc2626',
            reverseButtons: true
        }).then(function(result) {
            if (result.isConfirmed) {
                var url =
                    PRINT_PDF_URL +
                    '?from=' + encodeURIComponent(from) +
                    '&to=' + encodeURIComponent(to) +
                    '&sort=' + encodeURIComponent(sort);

                window.open(url, '_blank');
            }
        });
    }

    /* =========================================================
       PRINT BUTTON EVENT
    ========================================================== */

    function bindPrintButtonEvents() {
        if (printBtn) {
            printBtn.addEventListener('click', handlePrintClick);
        }
    }

    /* =========================================================
       INIT
    ========================================================== */

    bindDateFilterEvents();
    bindPrintButtonEvents();
    updatePrintButtonState();
    startRealtimeRefresh();
}
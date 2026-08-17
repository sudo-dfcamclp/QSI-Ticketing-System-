// =========================================================
// DASHBOARD (AJAX FETCHER)
// -----------------------------------------------------------
// Ang file na ito ang in-charge sa pag-fetch ng live data mula
// sa /ticketing/includes/control/dashboard-control.php.
// Kapag dumating na yung data, tatawagin nito yung
// updateDashboardUI(data) na nasa dashboard-analytics.js.
// =========================================================

var DASHBOARD_API_URL =
    '/ticketing/includes/control/dashboard-control.php';

let dashboardPollInterval = null;

let currentDashboardRange =
    'week';

// =========================================================
// FETCH DASHBOARD DATA
// =========================================================

async function fetchDashboardData(
    range = currentDashboardRange
) {

    currentDashboardRange =
        range;

    try {

        const url =
            `${DASHBOARD_API_URL}?range=${encodeURIComponent(range)}`;

        const response =
            await fetch(
                url,
                {
                    method: 'GET',

                    headers: {
                        'X-Requested-With':
                            'XMLHttpRequest'
                    }
                }
            );

        if (!response.ok) {

            throw new Error(
                `HTTP Error: ${response.status}`
            );
        }

        const result =
            await response.json();

        if (!result.success) {

            throw new Error(
                result.message ||
                'Failed to fetch dashboard data'
            );
        }

        if (
            typeof updateDashboardUI ===
            'function'
        ) {

            updateDashboardUI(
                result.data
            );
        }

    } catch (error) {

        console.error(
            'Failed to load dashboard data:',
            error
        );
    }
}

// =========================================================
// DASHBOARD POLLING
// =========================================================

function startDashboardPolling(
    intervalMs = 30000
) {

    if (dashboardPollInterval) {

        clearInterval(
            dashboardPollInterval
        );
    }

    dashboardPollInterval =
        setInterval(
            () => {

                fetchDashboardData(
                    currentDashboardRange
                );

            },
            intervalMs
        );
}

// =========================================================
// RANGE SELECT
// =========================================================

function initDashboardRangeSelect() {

    const rangeSelect =
        document.getElementById(
            'ticketRangeSelect'
        );

    if (!rangeSelect) {
        return;
    }

    rangeSelect.addEventListener(
        'change',
        event => {

            fetchDashboardData(
                event.target.value
            );
        }
    );
}

// =========================================================
// INITIALIZE
// =========================================================

document.addEventListener(
    'DOMContentLoaded',
    () => {

        initDashboardRangeSelect();

        fetchDashboardData();

        startDashboardPolling();
    }
);
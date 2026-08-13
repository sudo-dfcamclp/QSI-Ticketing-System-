document.addEventListener('DOMContentLoaded', () => {

    // =========================================================
    // DASHBOARD SAMPLE DATA
    // =========================================================

    const dashboardData = {

        totalTickets: 248,
        pendingTickets: 42,
        totalAdminUsers: 8,

        priority: {
            high: 54,
            low: 86,
            critical: 18
        },

        departments: {
            Accounting: 32,
            'Human Resource': 45,
            Admin: 28,
            Executive: 18,
            Remote: 64,
            External: 61
        },

        peripherals: {
            'PC / Laptop': 82,
            Internet: 56,
            Printer: 39,
            Scanner: 21,
            Server: 18,
            Others: 32
        },

        ticketActivity: {
            labels: [
                'Mon',
                'Tue',
                'Wed',
                'Thu',
                'Fri',
                'Sat',
                'Sun'
            ],

            values: [
                28,
                42,
                35,
                51,
                44,
                29,
                39
            ]
        }
    };


    // =========================================================
    // UPDATE SUMMARY CARDS
    // =========================================================

    const totalTickets = document.getElementById('totalTickets');
    const pendingTickets = document.getElementById('pendingTickets');
    const totalAdminUsers = document.getElementById('totalAdminUsers');
    const highPriority = document.getElementById('highPriority');
    const lowPriority = document.getElementById('lowPriority');
    const criticalPriority = document.getElementById('criticalPriority');

    if (totalTickets) {
        totalTickets.textContent = dashboardData.totalTickets;
    }

    if (pendingTickets) {
        pendingTickets.textContent = dashboardData.pendingTickets;
    }

    if (totalAdminUsers) {
        totalAdminUsers.textContent = dashboardData.totalAdminUsers;
    }

    if (highPriority) {
        highPriority.textContent = dashboardData.priority.high;
    }

    if (lowPriority) {
        lowPriority.textContent = dashboardData.priority.low;
    }

    if (criticalPriority) {
        criticalPriority.textContent = dashboardData.priority.critical;
    }


    // =========================================================
    // UPDATE PERIPHERAL COUNTS
    // =========================================================

    const peripheralElements = {
        'pcLaptopCount': dashboardData.peripherals['PC / Laptop'],
        'internetCount': dashboardData.peripherals.Internet,
        'printerCount': dashboardData.peripherals.Printer,
        'scannerCount': dashboardData.peripherals.Scanner,
        'serverCount': dashboardData.peripherals.Server,
        'othersCount': dashboardData.peripherals.Others
    };

    Object.entries(peripheralElements).forEach(([id, value]) => {

        const element = document.getElementById(id);

        if (element) {
            element.textContent = value;
        }

    });


    // =========================================================
    // CHECK CHART.JS
    // =========================================================

    if (typeof Chart === 'undefined') {

        console.error('Chart.js is not loaded.');

        return;
    }


    // =========================================================
    // TICKET LINE CHART
    // =========================================================

    const ticketLineCanvas =
        document.getElementById('ticketLineChart');

    if (ticketLineCanvas) {

        new Chart(ticketLineCanvas, {

            type: 'line',

            data: {
                labels: dashboardData.ticketActivity.labels,

                datasets: [{
                    label: 'Tickets',

                    data: dashboardData.ticketActivity.values,

                    borderWidth: 3,

                    tension: 0.4,

                    fill: true,

                    pointRadius: 4,

                    pointHoverRadius: 6
                }]
            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    }
                },

                scales: {

                    y: {
                        beginAtZero: true,

                        ticks: {
                            precision: 0
                        }
                    },

                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }

        });

    }


    // =========================================================
    // DEPARTMENT PIE CHART
    // =========================================================

    const departmentPieCanvas =
        document.getElementById('departmentPieChart');

    if (departmentPieCanvas) {

        new Chart(departmentPieCanvas, {

            type: 'pie',

            data: {

                labels: Object.keys(
                    dashboardData.departments
                ),

                datasets: [{

                    data: Object.values(
                        dashboardData.departments
                    ),

                    borderWidth: 2
                }]
            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        position: 'right'
                    }
                }
            }

        });

    }


    // =========================================================
    // PRIORITY BAR CHART
    // =========================================================

    const ticketBarCanvas =
    document.getElementById('ticketBarChart');

    if (ticketBarCanvas) {

    new Chart(ticketBarCanvas, {

            type: 'bar',

            data: {

                labels: [
                    'Critical',
                    'High',
                    'Low'
                ],

                datasets: [{

                    label: 'Tickets',

                    data: [
                        dashboardData.priority.critical,
                        dashboardData.priority.high,
                        dashboardData.priority.low
                    ],

                    borderWidth: 1,

                    borderRadius: 8
                }]
            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    }
                },

                scales: {

                    y: {

                        beginAtZero: true,

                        ticks: {
                            precision: 0
                        }
                    },

                    x: {

                        grid: {
                            display: false
                        }
                    }
                }
            }

        });

    }

});
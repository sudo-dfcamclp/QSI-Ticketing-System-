// =========================================================
// DASHBOARD ANALYTICS
// ---------------------------------------------------------
// Chart.js initialization and UI updates
// =========================================================

let ticketLineChart = null;
let departmentPieChart = null;
let ticketBarChart = null;

// =========================================================
// DYNAMIC COLOR GENERATOR
// =========================================================

function generateChartColors(count) {

    const colors = [];

    for (let i = 0; i < count; i++) {

        const hue = Math.round(
            (360 / Math.max(count, 1)) * i
        );

        colors.push(
            `hsl(${hue}, 70%, 55%)`
        );
    }

    return colors;
}

// =========================================================
// COMMON CHART SETTINGS
// =========================================================

const modernChartAnimation = {
    duration: 700,
    easing: 'easeOutQuart'
};

const modernTooltip = {
    enabled: true,
    backgroundColor: 'rgba(17, 24, 39, 0.94)',
    titleColor: '#ffffff',
    bodyColor: '#e5e7eb',
    borderWidth: 0,
    cornerRadius: 10,
    padding: 12,
    displayColors: false,

    titleFont: {
        size: 13,
        weight: '600'
    },

    bodyFont: {
        size: 13,
        weight: '500'
    }
};

// =========================================================
// INITIALIZE DASHBOARD CHARTS
// =========================================================

function initDashboardCharts() {

    if (typeof Chart === 'undefined') {

        console.error(
            'Chart.js is not loaded.'
        );

        return;
    }

    // =====================================================
    // LINE CHART
    // =====================================================

    const ticketLineCanvas =
        document.getElementById(
            'ticketLineChart'
        );

    if (ticketLineCanvas) {

        ticketLineChart = new Chart(
            ticketLineCanvas,
            {
                type: 'line',

                data: {

                    labels: [],

                    datasets: []
                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    animation:
                        modernChartAnimation,

                    interaction: {
                        mode: 'index',
                        intersect: false
                    },

                    hover: {
                        mode: 'index',
                        intersect: false
                    },

                    plugins: {

                        legend: {

                            display: true,

                            position: 'bottom',

                            labels: {

                                usePointStyle: true,

                                pointStyle: 'circle',

                                padding: 14,

                                color: '#4b5563',

                                font: {
                                    size: 12,
                                    weight: '500'
                                }
                            }
                        },

                        tooltip:
                            modernTooltip
                    },

                    scales: {

                        y: {

                            beginAtZero: true,

                            border: {
                                display: false
                            },

                            grid: {

                                color:
                                    'rgba(156, 163, 175, 0.12)',

                                drawTicks: false
                            },

                            ticks: {

                                precision: 0,

                                padding: 10,

                                color: '#6b7280'
                            }
                        },

                        x: {

                            border: {
                                display: false
                            },

                            grid: {
                                display: false
                            },

                            ticks: {

                                padding: 10,

                                color: '#6b7280'
                            }
                        }
                    }
                }
            }
        );
    }

    // =====================================================
    // PIE CHART
    // =====================================================

    const departmentPieCanvas =
        document.getElementById(
            'departmentPieChart'
        );

    if (departmentPieCanvas) {

        departmentPieChart = new Chart(
            departmentPieCanvas,
            {
                type: 'pie',

                data: {

                    labels: [],

                    datasets: [{

                        data: [],

                        borderWidth: 3,

                        borderColor: '#ffffff',

                        hoverBorderWidth: 3,

                        hoverOffset: 4,

                        spacing: 1
                    }]
                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    animation:
                        modernChartAnimation,

                    interaction: {

                        mode: 'nearest',

                        intersect: true
                    },

                    plugins: {

                        legend: {

                            position: 'right',

                            labels: {

                                usePointStyle: true,

                                pointStyle: 'circle',

                                padding: 16,

                                color: '#4b5563',

                                font: {
                                    size: 12,
                                    weight: '500'
                                }
                            }
                        },

                        tooltip: {

                            ...modernTooltip,

                            displayColors: true,

                            callbacks: {

                                label:
                                    function(context) {

                                        const value =
                                            context.raw ?? 0;

                                        return `${value} tickets`;
                                    }
                            }
                        }
                    }
                }
            }
        );
    }

    // =====================================================
    // BAR CHART
    // =====================================================

    const ticketBarCanvas =
        document.getElementById(
            'ticketBarChart'
        );

    if (ticketBarCanvas) {

        ticketBarChart = new Chart(
            ticketBarCanvas,
            {
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
                            0,
                            0,
                            0
                        ],

                        borderWidth: 0,

                        borderRadius: 10,

                        borderSkipped: false,

                        backgroundColor: [

                            'rgba(239, 68, 68, 0.85)',

                            'rgba(245, 158, 11, 0.85)',

                            'rgba(59, 130, 246, 0.85)'
                        ],

                        hoverBackgroundColor: [

                            'rgb(220, 38, 38)',

                            'rgb(217, 119, 6)',

                            'rgb(37, 99, 235)'
                        ],

                        barPercentage: 0.55,

                        categoryPercentage: 0.65
                    }]
                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    animation:
                        modernChartAnimation,

                    interaction: {

                        mode: 'index',

                        intersect: false
                    },

                    plugins: {

                        legend: {
                            display: false
                        },

                        tooltip: {

                            ...modernTooltip,

                            callbacks: {

                                label:
                                    function(context) {

                                        return `${context.raw} tickets`;
                                    }
                            }
                        }
                    },

                    scales: {

                        y: {

                            beginAtZero: true,

                            border: {
                                display: false
                            },

                            grid: {

                                color:
                                    'rgba(156, 163, 175, 0.12)',

                                drawTicks: false
                            },

                            ticks: {

                                precision: 0,

                                padding: 10,

                                color: '#6b7280'
                            }
                        },

                        x: {

                            border: {
                                display: false
                            },

                            grid: {
                                display: false
                            },

                            ticks: {

                                color: '#6b7280',

                                padding: 10
                            }
                        }
                    }
                }
            }
        );
    }
}

// =========================================================
// UPDATE DASHBOARD UI
// =========================================================

function updateDashboardUI(data) {

    if (!data) {
        return;
    }

    // =====================================================
    // SUMMARY CARDS
    // =====================================================

    setText(
        'totalTickets',
        data.totalTickets
    );

    setText(
        'totalActive',
        data.totalActive
    );

    setText(
        'pendingTickets',
        data.pendingTickets
    );

    setText(
        'totalAdminUsers',
        data.totalAdminUsers
    );

    setText(
        'highPriority',
        data.priority?.high
    );

    setText(
        'lowPriority',
        data.priority?.low
    );

    setText(
        'criticalTickets',
        data.priority?.critical
    );

    // =====================================================
    // PERIPHERALS
    // =====================================================

    const peripherals =
        data.peripherals || {};

    const peripheralElements = {

        pcLaptopCount:
            peripherals['PC / Laptop'],

        internetCount:
            peripherals.Internet,

        printerCount:
            peripherals.Printer,

        scannerCount:
            peripherals.Scanner,

        serverCount:
            peripherals.Server,

        othersCount:
            peripherals.Others
    };

    let peripheralsTotal = 0;

    Object.entries(
        peripheralElements
    ).forEach(([id, value]) => {

        setText(
            id,
            value
        );

        peripheralsTotal +=
            Number(value) || 0;
    });

    setText(
        'peripheralsCount',
        peripheralsTotal
    );

    // =====================================================
    // LINE CHART
    // =====================================================

    if (
        ticketLineChart &&
        data.ticketActivity
    ) {

        const labels =
            data.ticketActivity.labels || [];

        const rawDatasets =
            data.ticketActivity.datasets || [];

        const colors =
            generateChartColors(
                rawDatasets.length
            );

        ticketLineChart.data.labels =
            labels;

        ticketLineChart.data.datasets =
            rawDatasets.map(
                (dataset, index) => ({

                    label: dataset.label,

                    data: dataset.data,

                    borderWidth: 2.5,

                    tension: 0.45,

                    fill: false,

                    pointRadius: 3,

                    pointHoverRadius: 5,

                    pointHitRadius: 12,

                    pointBorderWidth: 2,

                    pointHoverBorderWidth: 2,

                    borderColor:
                        colors[index],

                    backgroundColor:
                        colors[index],

                    pointBackgroundColor:
                        colors[index],

                    pointBorderColor:
                        '#ffffff',

                    pointHoverBackgroundColor:
                        colors[index],

                    pointHoverBorderColor:
                        '#ffffff'
                })
            );

        ticketLineChart.update();
    }

    // =====================================================
    // PIE CHART
    // =====================================================

    if (
        departmentPieChart &&
        data.departments
    ) {

        const labels =
            Object.keys(
                data.departments
            );

        departmentPieChart.data.labels =
            labels;

        departmentPieChart
            .data
            .datasets[0]
            .data =
            Object.values(
                data.departments
            );

        departmentPieChart
            .data
            .datasets[0]
            .backgroundColor =
            generateChartColors(
                labels.length
            );

        departmentPieChart.update();
    }

    // =====================================================
    // BAR CHART
    // =====================================================

    if (
        ticketBarChart &&
        data.priorityBarChart
    ) {

        ticketBarChart.data.labels =
            data.priorityBarChart.labels;

        ticketBarChart
            .data
            .datasets[0]
            .data =
            data.priorityBarChart.values;

        ticketBarChart.update();
    }
}

// =========================================================
// SET TEXT
// =========================================================

function setText(id, value) {

    const element =
        document.getElementById(id);

    if (element) {

        element.textContent =
            value ?? 0;
    }
}

// =========================================================
// INITIALIZE
// =========================================================

document.addEventListener(
    'DOMContentLoaded',
    () => {
        initDashboardCharts();
    }
);
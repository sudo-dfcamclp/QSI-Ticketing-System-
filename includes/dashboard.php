<?php
require_once __DIR__ . '/auth/auth.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QSI Ticketing</title>

    <link href="/ticketing/src/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <?php include __DIR__ . '/components/sidebar.php'; ?>

    <main id="mainContent" class="min-h-screen transition-all duration-300">

        <div id="tabSystem" class="min-h-screen">

            <!-- TAB HEADER -->
            <div id="tabHeader" class="sticky top-0 z-30 bg-white border-b border-gray-200 shadow-sm">
                <div id="tabList" class="flex items-center overflow-x-auto">

                    <button
                        type="button"
                        class="tab-item active flex items-center gap-3 px-5 py-4 text-base font-semibold text-green-600 border-b-2 border-green-600 whitespace-nowrap hover:bg-green-50 transition-colors"
                        data-tab-id="dashboard"
                        data-tab-title="Dashboard"
                        data-tab-icon="fa-solid fa-display"
                        data-page="/ticketing/includes/dashboard.php">

                        <i class="fa-solid fa-display text-lg"></i>
                        <span>Dashboard</span>
                    </button>

                </div>
            </div>

            <!-- TAB CONTENT -->
            <div id="tabContent" class="min-h-[calc(100vh-57px)]">

                                <!-- DASHBOARD TAB -->
                    <div id="tab-dashboard" class="tab-panel">

                        <div class="container mx-auto px-6 py-12 max-w-7xl">

                            <!-- PAGE HEADER -->
                            <div class="mt-8 mb-8 flex items-center justify-between">

                                <!-- LEFT SIDE: DASHBOARD TITLE -->
                                <div>
                                    <h1 class="text-3xl font-bold text-gray-800">
                                        Dashboard
                                    </h1>

                                    <p class="text-gray-500 mt-1">
                                        Welcome back! Here's your ticketing system overview.
                                    </p>
                                </div>

                                <!-- RIGHT SIDE: WELCOME + PROFILE -->
                                <div class="flex items-center gap-3 bg-gray-100 rounded-2xl px-4 py-2.5">

                                    <!-- WELCOME + NAME -->
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">
                                            Welcome
                                        </p>

                                        <p class="text-2xl font-semibold text-gray-800">
                                            Andrew
                                        </p>
                                    </div>
                                    <!-- PROFILE CIRCLE -->
                                    <div class="w-16 h-16 rounded-full bg-green-600 text-white flex items-center justify-center font-semibold text-sm">AN</div>

                                </div>

                            </div>

                        <!-- DASHBOARD GRID -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                            <!-- LEFT SIDE - STATISTIC CARDS -->
                                <div class="flex flex-col gap-4 h-full">

                                    <!-- Total Tickets -->
                                    <div class="flex-1 bg-white rounded-2xl shadow-sm hover:shadow-md transition p-5 border border-gray-100">
                                        <div class="flex items-center justify-between h-full">
                                            <div>
                                                <p class="text-sm text-gray-500">Total Tickets</p>
                                                <h2 id="totalTickets" class="text-3xl font-bold text-gray-800 mt-2">0</h2>
                                            </div>

                                            <div class="bg-blue-100 text-blue-600 p-3 rounded-xl">
                                                <i class="fa-solid fa-ticket text-xl"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Total Active -->
                                    <div class="flex-1 bg-white rounded-2xl shadow-sm hover:shadow-md transition p-5 border border-gray-100">
                                        <div class="flex items-center justify-between h-full">
                                            <div>
                                                <p class="text-sm text-gray-500">Total Active</p>
                                                <h2 id="totalActive" class="text-3xl font-bold text-gray-800 mt-2">0</h2>
                                            </div>

                                            <div class="bg-blue-100 text-blue-600 p-3 rounded-xl">
                                                <i class="fa-solid fa-ticket text-xl"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Pending Tickets -->
                                    <div class="flex-1 bg-white rounded-2xl shadow-sm hover:shadow-md transition p-5 border border-gray-100">
                                        <div class="flex items-center justify-between h-full">
                                            <div>
                                                <p class="text-sm text-gray-500">Pending Tickets</p>
                                                <h2 id="pendingTickets" class="text-3xl font-bold text-gray-800 mt-2">0</h2>
                                            </div>

                                            <div class="bg-orange-100 text-orange-600 p-3 rounded-xl">
                                                <i class="fa-solid fa-clock text-xl"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Total Admin Users -->
                                    <div class="flex-1 bg-white rounded-2xl shadow-sm hover:shadow-md transition p-5 border border-gray-100">
                                        <div class="flex items-center justify-between h-full">
                                            <div>
                                                <p class="text-sm text-gray-500">Total Admin Users</p>
                                                <h2 id="totalAdminUsers" class="text-3xl font-bold text-gray-800 mt-2">0</h2>
                                            </div>

                                            <div class="bg-green-100 text-green-600 p-3 rounded-xl">
                                                <i class="fa-solid fa-users-gear text-xl"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- High Priority -->
                                    <div class="flex-1 bg-white rounded-2xl shadow-sm hover:shadow-md transition p-5 border border-gray-100">
                                        <div class="flex items-center justify-between h-full">
                                            <div>
                                                <p class="text-sm text-gray-500">High Priority</p>
                                                <h2 id="highPriority" class="text-3xl font-bold text-gray-800 mt-2">0</h2>
                                            </div>

                                            <div class="bg-yellow-100 text-yellow-600 p-3 rounded-xl">
                                                <i class="fa-solid fa-arrow-up text-xl"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Low Priority -->
                                    <div class="flex-1 bg-white rounded-2xl shadow-sm hover:shadow-md transition p-5 border border-gray-100">
                                        <div class="flex items-center justify-between h-full">
                                            <div>
                                                <p class="text-sm text-gray-500">Low Priority</p>
                                                <h2 id="lowPriority" class="text-3xl font-bold text-gray-800 mt-2">0</h2>
                                            </div>

                                            <div class="bg-blue-100 text-blue-600 p-3 rounded-xl">
                                                <i class="fa-solid fa-arrow-down text-xl"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Critical -->
                                    <div class="flex-1 bg-white rounded-2xl shadow-sm hover:shadow-md transition p-5 border border-gray-100">
                                        <div class="flex items-center justify-between h-full">
                                            <div>
                                                <p class="text-sm text-gray-500">Critical</p>
                                                <h2 id="criticalTickets" class="text-3xl font-bold text-gray-800 mt-2">0</h2>
                                            </div>

                                            <div class="bg-red-100 text-red-600 p-3 rounded-xl">
                                                <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            <!-- RIGHT SIDE - ANALYTICS -->
                            <div class="lg:col-span-2 flex flex-col gap-6">

                                <!-- TICKET LINE GRAPH -->
                                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                    <div class="flex items-center justify-between mb-6">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-800">Ticket Overview</h3>
                                            <p class="text-sm text-gray-500 mt-1">Ticket activity over time</p>
                                        </div>
                                        <i class="fa-solid fa-chart-line text-green-600 text-xl"></i>
                                    </div>

                                    <div class="relative h-80">
                                        <canvas id="ticketLineChart"></canvas>
                                    </div>
                                </div>

                                <!-- DEPARTMENT PIE + CATEGORIES -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                    <!-- DEPARTMENT PIE GRAPH -->
                                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                        <div class="flex items-center justify-between mb-5">
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-800">Tickets Per Department</h3>
                                                <p class="text-sm text-gray-500 mt-1">Department distribution</p>
                                            </div>
                                            <i class="fa-solid fa-chart-pie text-green-600"></i>
                                        </div>

                                        <div class="relative h-72">
                                            <canvas id="departmentPieChart"></canvas>
                                        </div>
                                    </div>

                                    <!-- TICKET CATEGORIES -->
                                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                        <div class="flex items-center justify-between mb-5">
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-800">Ticket Categories</h3>
                                                <p class="text-sm text-gray-500 mt-1">Peripherals and issues</p>
                                            </div>
                                            <i class="fa-solid fa-toolbox text-green-600"></i>
                                        </div>

                                        <div class="space-y-4">

                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-700">Peripherals</span>
                                                <span id="peripheralsCount" class="font-semibold text-gray-800">0</span>
                                            </div>

                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-700">PC / Laptop</span>
                                                <span id="pcLaptopCount" class="font-semibold text-gray-800">0</span>
                                            </div>

                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-700">Internet</span>
                                                <span id="internetCount" class="font-semibold text-gray-800">0</span>
                                            </div>

                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-700">Printer</span>
                                                <span id="printerCount" class="font-semibold text-gray-800">0</span>
                                            </div>

                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-700">Scanner</span>
                                                <span id="scannerCount" class="font-semibold text-gray-800">0</span>
                                            </div>

                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-700">Server</span>
                                                <span id="serverCount" class="font-semibold text-gray-800">0</span>
                                            </div>

                                            <div class="flex items-center justify-between">
                                                <span class="text-sm text-gray-700">Others</span>
                                                <span id="othersCount" class="font-semibold text-gray-800">0</span>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                                <!-- BAR GRAPH -->
                                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                                    <div class="flex items-center justify-between mb-6">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-800">Ticket Issues</h3>
                                            <p class="text-sm text-gray-500 mt-1">Tickets by issue category</p>
                                        </div>
                                        <i class="fa-solid fa-chart-column text-green-600 text-xl"></i>
                                    </div>

                                    <div class="relative h-80">
                                        <canvas id="ticketBarChart"></canvas>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </main>

    <script src="/ticketing/script/sidebar.js"></script>
    <script src="/ticketing/script/tab-manager.js"></script>
    <script src="/ticketing/script/dashboard-analytics.js"></script>

</body>
</html>
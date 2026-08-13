<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QSI Ticketing</title>
    <link href="/ePayroll/src/output.css" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- =====================================================
         SIDEBAR
    ====================================================== -->
    <?php include __DIR__ . '/components/sidebar.php'; ?>

    <!-- =====================================================
         MAIN APPLICATION CONTENT
    ====================================================== -->
    <main id="mainContent" class="min-h-screen transition-all duration-300">

        <!-- =================================================
             TAB SYSTEM
        ================================================== -->
        <div id="tabSystem" class="min-h-screen">

            <!-- =================================================
                 TAB HEADER
            ================================================== -->
            <div id="tabHeader" class="sticky top-0 z-30 bg-white border-b border-gray-200 shadow-sm">
                <div id="tabList" class="flex items-center overflow-x-auto">

                    <!-- Dashboard Tab -->
                        <button type="button"
                            class="tab-item active flex items-center gap-3 px-5 py-4 text-base font-semibold text-green-600 border-b-2 border-green-600 whitespace-nowrap hover:bg-green-50 transition-colors"
                            data-tab-id="dashboard"
                            data-tab-title="Dashboard"
                            data-tab-icon="fa-solid fa-display"
                            data-page="/ePayroll/includes/dashboard.php">

                            <i class="fa-solid fa-display text-lg"></i>
                            <span>Dashboard</span>

                        </button>

                </div>
            </div>

            <!-- =================================================
                 TAB CONTENT
            ================================================== -->
            <div id="tabContent" class="min-h-[calc(100vh-57px)]">

                <!-- Dashboard is initially loaded -->
                <div id="tab-dashboard" class="tab-panel">

                    <div class="container mx-auto px-6 py-10 max-w-7xl">

                        <!-- Page Header -->
                        <div class="mb-8">
                            <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
                            <p class="text-gray-500 mt-1">Welcome back! Here's your overview.</p>
                        </div>

                        <!-- Dashboard Grid -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                            <!-- LEFT COLUMN -->
                            <div class="flex flex-col gap-6">

                                <!-- Total Employees -->
                                <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 p-6 border border-gray-100">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-gray-500">Total Employees</p>
                                            <h2 class="text-3xl font-bold text-gray-800 mt-2">1,248</h2>
                                        </div>
                                        <div class="bg-blue-100 text-blue-600 p-3 rounded-xl">
                                            <i class="fa-solid fa-users text-xl"></i>
                                        </div>
                                    </div>
                                    <p class="text-xs text-green-600 mt-4">↑ 12% from last month</p>
                                </div>

                                <!-- Payroll Processed -->
                                <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 p-6 border border-gray-100">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-gray-500">Payroll Processed</p>
                                            <h2 class="text-3xl font-bold text-gray-800 mt-2">$84,520</h2>
                                        </div>
                                        <div class="bg-green-100 text-green-600 p-3 rounded-xl">
                                            <i class="fa-solid fa-money-bill text-xl"></i>
                                        </div>
                                    </div>
                                    <p class="text-xs text-green-600 mt-4">↑ 8.2% from last month</p>
                                </div>

                                <!-- Pending Requests -->
                                <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 p-6 border border-gray-100">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm text-gray-500">Pending Requests</p>
                                            <h2 class="text-3xl font-bold text-gray-800 mt-2">27</h2>
                                        </div>
                                        <div class="bg-orange-100 text-orange-600 p-3 rounded-xl">
                                            <i class="fa-solid fa-clock text-xl"></i>
                                        </div>
                                    </div>
                                    <p class="text-xs text-red-500 mt-4">↓ 3 need attention</p>
                                </div>

                            </div>

                            <!-- RIGHT COLUMN -->
                            <div class="lg:col-span-2 flex flex-col gap-6">

                                <!-- Recent Activity -->
                                <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 p-6 border border-gray-100">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
                                        <button class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</button>
                                    </div>

                                    <div class="space-y-4">

                                        <div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-lg transition">
                                            <div class="bg-blue-100 text-blue-600 p-2 rounded-lg">
                                                <i class="fa-solid fa-check"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium text-gray-800">Payroll for July processed</p>
                                                <p class="text-xs text-gray-500">2 hours ago</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-lg transition">
                                            <div class="bg-green-100 text-green-600 p-2 rounded-lg">
                                                <i class="fa-solid fa-user-plus"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium text-gray-800">New employee onboarded</p>
                                                <p class="text-xs text-gray-500">5 hours ago</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-lg transition">
                                            <div class="bg-purple-100 text-purple-600 p-2 rounded-lg">
                                                <i class="fa-solid fa-file-lines"></i>
                                            </div>
                                            <div class="flex-1">
                                                <p class="font-medium text-gray-800">Leave request submitted</p>
                                                <p class="text-xs text-gray-500">Yesterday</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <!-- Department Overview -->
                                <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 p-6 border border-gray-100">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-lg font-semibold text-gray-800">Department Overview</h3>
                                        <button class="text-sm text-blue-600 hover:text-blue-700 font-medium">Details</button>
                                    </div>

                                    <div class="space-y-4">

                                        <div>
                                            <div class="flex justify-between mb-1">
                                                <span class="text-sm font-medium text-gray-700">Engineering</span>
                                                <span class="text-sm text-gray-500">78%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-blue-600 h-2 rounded-full" style="width: 78%"></div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="flex justify-between mb-1">
                                                <span class="text-sm font-medium text-gray-700">Marketing</span>
                                                <span class="text-sm text-gray-500">62%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-green-600 h-2 rounded-full" style="width: 62%"></div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="flex justify-between mb-1">
                                                <span class="text-sm font-medium text-gray-700">Finance</span>
                                                <span class="text-sm text-gray-500">91%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-purple-600 h-2 rounded-full" style="width: 91%"></div>
                                            </div>
                                        </div>

                                        <div>
                                            <div class="flex justify-between mb-1">
                                                <span class="text-sm font-medium text-gray-700">HR</span>
                                                <span class="text-sm text-gray-500">45%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2">
                                                <div class="bg-orange-500 h-2 rounded-full" style="width: 45%"></div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- =====================================================
         JAVASCRIPT
    ====================================================== -->
    <script src="/ePayroll/script/sidebar.js"></script>
    <script src="/ePayroll/script/tab-manager.js"></script>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ePayroll - Dashboard</title>

    <link href="../src/output.css" rel="stylesheet">

     <?php include '../includes/sidebar.php'; ?>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Main Outer Container -->
    <div class="container mx-auto px-6 py-10 max-w-7xl">

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-500 mt-1">Welcome back! Here's your overview.</p>
        </div>

        <!-- Inner Container: Grid Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- LEFT: 3 Small Boxes Stacked Vertically -->
            <div class="flex flex-col gap-6">

                <!-- Small Box 1 -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Employees</p>
                            <h2 class="text-3xl font-bold text-gray-800 mt-2">1,248</h2>
                        </div>
                        <div class="bg-blue-100 text-blue-600 p-3 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5a4 4 0 11-8 0 4 4 0 018 0zm6 3a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-green-600 mt-4">↑ 12% from last month</p>
                </div>

                <!-- Small Box 2 -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Payroll Processed</p>
                            <h2 class="text-3xl font-bold text-gray-800 mt-2">$84,520</h2>
                        </div>
                        <div class="bg-green-100 text-green-600 p-3 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-green-600 mt-4">↑ 8.2% from last month</p>
                </div>

                <!-- Small Box 3 -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Pending Requests</p>
                            <h2 class="text-3xl font-bold text-gray-800 mt-2">27</h2>
                        </div>
                        <div class="bg-orange-100 text-orange-600 p-3 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-red-500 mt-4">↓ 3 need attention</p>
                </div>

            </div>

            <!-- RIGHT: 2 Long Boxes Stacked Vertically -->
            <div class="lg:col-span-2 flex flex-col gap-6">

                <!-- Long Box 1 -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 p-6 border border-gray-100">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
                        <button class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</button>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-lg transition">
                            <div class="bg-blue-100 text-blue-600 p-2 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-800">Payroll for July processed</p>
                                <p class="text-xs text-gray-500">2 hours ago</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-lg transition">
                            <div class="bg-green-100 text-green-600 p-2 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-800">New employee onboarded</p>
                                <p class="text-xs text-gray-500">5 hours ago</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-lg transition">
                            <div class="bg-purple-100 text-purple-600 p-2 rounded-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-gray-800">Leave request submitted</p>
                                <p class="text-xs text-gray-500">Yesterday</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Long Box 2 -->
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

</body>
</html>
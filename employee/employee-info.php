<!-- employee_information.php | Content fragment ONLY -->
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10 max-w-7xl">

   <!-- 1. LONG THIN BOX (Page Header) -->
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-4 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Employee Master</h1>
            <p class="text-sm text-gray-500 mt-0.5">Employee: Juan Dela Cruz</p>
        </div>
    </div>
</div>

<!-- 2. TOOLBAR BOX (No Shadow, No Title) -->
<div class="bg-white rounded-2xl border border-gray-200 px-6 py-3 mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <!-- Left: Action Buttons -->
        <div class="flex items-center gap-2">
            <button type="button" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                <i class="fa-solid fa-pen mr-1"></i>Edit
            </button>
            <button type="button" class="px-3 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                <i class="fa-solid fa-plus mr-1"></i>New
            </button>
            <button type="button" class="px-3 py-1.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm font-medium">
                <i class="fa-solid fa-floppy-disk mr-1"></i>Save
            </button>
        </div>
        <!-- Center: Search -->
        <div class="relative flex-1 max-w-xs mx-2">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
            <input type="text" placeholder="Search..." class="pl-9 pr-4 py-1.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent w-full">
        </div>
        <!-- Right: Navigation -->
        <div class="flex items-center gap-2">
            <button type="button" class="px-2.5 py-1.5 border border-gray-300 rounded-lg hover:bg-gray-100 transition text-gray-600 text-sm">
                <i class="fa-solid fa-angles-left"></i>
            </button>
            <span class="text-sm text-gray-600 px-2 font-medium whitespace-nowrap">1 of 1,248</span>
            <button type="button" class="px-2.5 py-1.5 border border-gray-300 rounded-lg hover:bg-gray-100 transition text-gray-600 text-sm">
                <i class="fa-solid fa-angles-right"></i>
            </button>
        </div>
    </div>
</div>

    <!-- 2. BIG MODERN BOX (Employees Directory) -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Employees Directory</h2>
                <p class="text-sm text-gray-500 mt-1">Complete list of registered employees in the system.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input type="text" placeholder="Search employees..." class="pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent w-full sm:w-64">
                </div>
                <button type="button" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                    <i class="fa-solid fa-plus mr-1"></i>Add Employee
                </button>
            </div>
        </div>
        <!-- Employee Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-4 py-3 font-semibold rounded-tl-lg">Employee ID</th>
                        <th class="px-4 py-3 font-semibold">Name</th>
                        <th class="px-4 py-3 font-semibold">Department</th>
                        <th class="px-4 py-3 font-semibold">Position</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                        <th class="px-4 py-3 font-semibold rounded-tr-lg">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4">EMP-001</td>
                        <td class="px-4 py-4 font-medium text-gray-800">Juan Dela Cruz</td>
                        <td class="px-4 py-4">IT</td>
                        <td class="px-4 py-4">Software Developer</td>
                        <td class="px-4 py-4"><span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Active</span></td>
                        <td class="px-4 py-4"><button class="text-blue-600 hover:text-blue-800 font-medium text-sm">View</button></td>
                    </tr>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4">EMP-002</td>
                        <td class="px-4 py-4 font-medium text-gray-800">Maria Santos</td>
                        <td class="px-4 py-4">HR</td>
                        <td class="px-4 py-4">HR Manager</td>
                        <td class="px-4 py-4"><span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">Active</span></td>
                        <td class="px-4 py-4"><button class="text-blue-600 hover:text-blue-800 font-medium text-sm">View</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 3. TWO MODERN BOXES (Side by Side) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- 3A. Employee Statistics -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800"><i class="fa-solid fa-users text-blue-600 mr-2"></i>Employee Statistics</h3>
                <button class="text-sm text-blue-600 hover:text-blue-700 font-medium">Details</button>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-blue-50 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-blue-600">1,248</p>
                    <p class="text-xs text-gray-500 mt-1">Total Employees</p>
                </div>
                <div class="bg-green-50 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-green-600">1,180</p>
                    <p class="text-xs text-gray-500 mt-1">Active</p>
                </div>
                <div class="bg-orange-50 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-orange-600">42</p>
                    <p class="text-xs text-gray-500 mt-1">On Leave</p>
                </div>
                <div class="bg-red-50 rounded-xl p-4 text-center">
                    <p class="text-2xl font-bold text-red-600">26</p>
                    <p class="text-xs text-gray-500 mt-1">Inactive</p>
                </div>
            </div>
        </div>
        <!-- 3B. Department Breakdown -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800"><i class="fa-solid fa-building text-purple-600 mr-2"></i>Department Breakdown</h3>
                <button class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</button>
            </div>
            <div class="space-y-3">
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Engineering</span>
                        <span class="text-sm text-gray-500">420</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-blue-600 h-2 rounded-full" style="width:78%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Marketing</span>
                        <span class="text-sm text-gray-500">280</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-green-600 h-2 rounded-full" style="width:62%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">Finance</span>
                        <span class="text-sm text-gray-500">350</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-purple-600 h-2 rounded-full" style="width:91%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between mb-1">
                        <span class="text-sm font-medium text-gray-700">HR</span>
                        <span class="text-sm text-gray-500">198</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2"><div class="bg-orange-500 h-2 rounded-full" style="width:45%"></div></div>
                </div>
            </div>
        </div>
    </div>

    <!-- 4. BIG MODERN BOX (Recent Updates) -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800"><i class="fa-solid fa-clock-rotate-left text-orange-500 mr-2"></i>Recent Employee Updates</h3>
            <button class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</button>
        </div>
        <div class="space-y-4">
            <div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-lg transition">
                <div class="bg-green-100 text-green-600 p-2 rounded-lg"><i class="fa-solid fa-user-plus"></i></div>
                <div class="flex-1">
                    <p class="font-medium text-gray-800">New employee onboarded - Maria Santos</p>
                    <p class="text-xs text-gray-500">2 hours ago</p>
                </div>
                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">New</span>
            </div>
            <div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-lg transition">
                <div class="bg-blue-100 text-blue-600 p-2 rounded-lg"><i class="fa-solid fa-arrow-up"></i></div>
                <div class="flex-1">
                    <p class="font-medium text-gray-800">Promotion - Juan Dela Cruz to Senior Developer</p>
                    <p class="text-xs text-gray-500">5 hours ago</p>
                </div>
                <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">Promotion</span>
            </div>
            <div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-lg transition">
                <div class="bg-orange-100 text-orange-600 p-2 rounded-lg"><i class="fa-solid fa-file-pen"></i></div>
                <div class="flex-1">
                    <p class="font-medium text-gray-800">Record update - Contact info for EMP-005</p>
                    <p class="text-xs text-gray-500">Yesterday</p>
                </div>
                <span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-700 rounded-full">Update</span>
            </div>
        </div>
    </div>

    <!-- 5. BIG MODERN BOX (Upcoming Schedule) -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800"><i class="fa-solid fa-calendar-check text-green-600 mr-2"></i>Upcoming Schedule</h3>
            <button class="text-sm text-blue-600 hover:text-blue-700 font-medium">Calendar</button>
        </div>
        <div class="space-y-3">
            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                <div class="bg-green-100 text-green-600 px-3 py-2 rounded-lg text-center min-w-[60px]">
                    <p class="text-lg font-bold leading-none">15</p>
                    <p class="text-xs">AUG</p>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-800">Team Building - Engineering Dept</p>
                    <p class="text-xs text-gray-500">All day event</p>
                </div>
            </div>
            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                <div class="bg-blue-100 text-blue-600 px-3 py-2 rounded-lg text-center min-w-[60px]">
                    <p class="text-lg font-bold leading-none">20</p>
                    <p class="text-xs">AUG</p>
                </div>
                <div class="flex-1">
                    <p class="font-medium text-gray-800">Payroll Cut-off Period</p>
                    <p class="text-xs text-gray-500">Deadline: 5:00 PM</p>
                </div>
            </div>
        </div>
    </div>

    <!-- 6. BIG MODERN BOX (Documents & Compliance) -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800"><i class="fa-solid fa-file-invoice text-purple-600 mr-2"></i>Documents & Compliance</h3>
            <button class="text-sm text-blue-600 hover:text-blue-700 font-medium">Manage</button>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="border border-gray-200 rounded-xl p-4 hover:border-green-300 transition">
                <div class="flex items-center gap-3">
                    <div class="bg-purple-100 text-purple-600 p-2 rounded-lg"><i class="fa-solid fa-file-pdf"></i></div>
                    <div>
                        <p class="font-medium text-gray-800 text-sm">Employment Contracts</p>
                        <p class="text-xs text-gray-500">1,248 files</p>
                    </div>
                </div>
            </div>
            <div class="border border-gray-200 rounded-xl p-4 hover:border-green-300 transition">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-100 text-blue-600 p-2 rounded-lg"><i class="fa-solid fa-id-card"></i></div>
                    <div>
                        <p class="font-medium text-gray-800 text-sm">Government IDs</p>
                        <p class="text-xs text-gray-500">1,180 verified</p>
                    </div>
                </div>
            </div>
            <div class="border border-gray-200 rounded-xl p-4 hover:border-green-300 transition">
                <div class="flex items-center gap-3">
                    <div class="bg-green-100 text-green-600 p-2 rounded-lg"><i class="fa-solid fa-certificate"></i></div>
                    <div>
                        <p class="font-medium text-gray-800 text-sm">Certifications</p>
                        <p class="text-xs text-gray-500">856 records</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 7. BIG MODERN BOX (Attendance Overview) -->
    <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800"><i class="fa-solid fa-chart-line text-red-500 mr-2"></i>Attendance Overview</h3>
            <button class="text-sm text-blue-600 hover:text-blue-700 font-medium">Full Report</button>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-gray-50 rounded-xl">
                <p class="text-3xl font-bold text-gray-800">96.2%</p>
                <p class="text-xs text-gray-500 mt-1">Attendance Rate</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-xl">
                <p class="text-3xl font-bold text-green-600">1,180</p>
                <p class="text-xs text-gray-500 mt-1">Present Today</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-xl">
                <p class="text-3xl font-bold text-orange-500">42</p>
                <p class="text-xs text-gray-500 mt-1">On Leave</p>
            </div>
            <div class="text-center p-4 bg-gray-50 rounded-xl">
                <p class="text-3xl font-bold text-red-500">26</p>
                <p class="text-xs text-gray-500 mt-1">Absent</p>
            </div>
        </div>
    </div>

    <!-- 8. TWO BOXES (Side by Side) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- 8A. Notifications -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800"><i class="fa-solid fa-bell text-yellow-500 mr-2"></i>Notifications</h3>
                <span class="px-2 py-1 text-xs font-medium bg-red-100 text-red-600 rounded-full">3 New</span>
            </div>
            <div class="space-y-3">
                <div class="flex items-center gap-3 p-3 bg-yellow-50 rounded-lg">
                    <i class="fa-solid fa-triangle-exclamation text-yellow-500"></i>
                    <p class="text-sm text-gray-700">5 employees have pending document renewals</p>
                </div>
                <div class="flex items-center gap-3 p-3 bg-blue-50 rounded-lg">
                    <i class="fa-solid fa-info-circle text-blue-500"></i>
                    <p class="text-sm text-gray-700">Payroll processing scheduled for Aug 15</p>
                </div>
                <div class="flex items-center gap-3 p-3 bg-green-50 rounded-lg">
                    <i class="fa-solid fa-check-circle text-green-500"></i>
                    <p class="text-sm text-gray-700">Monthly compliance report submitted</p>
                </div>
            </div>
        </div>
        <!-- 8B. Quick Actions -->
        <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-800"><i class="fa-solid fa-gear text-gray-500 mr-2"></i>Quick Actions</h3>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <button class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg hover:border-green-300 hover:bg-green-50 transition text-sm font-medium text-gray-700">
                    <i class="fa-solid fa-user-plus text-green-600"></i>Add Employee
                </button>
                <button class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg hover:border-blue-300 hover:bg-blue-50 transition text-sm font-medium text-gray-700">
                    <i class="fa-solid fa-file-export text-blue-600"></i>Export Data
                </button>
                <button class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition text-sm font-medium text-gray-700">
                    <i class="fa-solid fa-print text-purple-600"></i>Print Report
                </button>
                <button class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg hover:border-orange-300 hover:bg-orange-50 transition text-sm font-medium text-gray-700">
                    <i class="fa-solid fa-sliders text-orange-600"></i>Settings
                </button>
            </div>
        </div>
    </div>

</div>
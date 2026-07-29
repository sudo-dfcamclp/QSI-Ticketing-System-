<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


<title>ePayroll - Employee Information</title>

<!-- Tailwind CSS -->
<link href="../src/output.css" rel="stylesheet">


</head>

<body class="bg-gray-100 min-h-screen">

<?php include '../includes/sidebar.php'; ?>


<!-- RESPONSIVE CONTENT LAYOUT: Keeps the page content working alongside the sidebar -->
<main id="mainContent" class="min-h-screen transition-all duration-300">

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10 max-w-7xl">

        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                Employee Information
            </h1>

            <p class="text-gray-500 mt-1">
                Manage and view employee information.
            </p>
        </div>


        <!-- Employee Information Content -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

                <div>
                    <h2 class="text-xl font-semibold text-gray-800">
                        Employees
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        List of registered employees.
                    </p>
                </div>

                <button
                    type="button"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
                >
                    Add Employee
                </button>

            </div>


            <!-- Employee Table -->
            <div class="overflow-x-auto">

                <table class="w-full text-sm text-left">

                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-4 py-3 font-semibold">Employee ID</th>
                            <th class="px-4 py-3 font-semibold">Name</th>
                            <th class="px-4 py-3 font-semibold">Department</th>
                            <th class="px-4 py-3 font-semibold">Position</th>
                            <th class="px-4 py-3 font-semibold">Status</th>
                            <th class="px-4 py-3 font-semibold">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        <tr class="hover:bg-gray-50">

                            <td class="px-4 py-4">
                                EMP-001
                            </td>

                            <td class="px-4 py-4 font-medium text-gray-800">
                                Juan Dela Cruz
                            </td>

                            <td class="px-4 py-4">
                                IT
                            </td>

                            <td class="px-4 py-4">
                                Software Developer
                            </td>

                            <td class="px-4 py-4">
                                <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">
                                    Active
                                </span>
                            </td>

                            <td class="px-4 py-4">
                                <button class="text-blue-600 hover:text-blue-800 font-medium">
                                    View
                                </button>
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</main>
```

</body>
</html>

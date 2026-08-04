<?php
/**
 * Reusable ePayroll Sidebar
 *
 * Works with:
 * /ePayroll/script/sidebar.js
 * /ePayroll/script/tab-manager.js
 *
 * Feature links use:
 * .tab-link
 * data-page
 * data-tab-id
 * data-tab-title
 */
?>

<!-- CSS -->

<link href="/ePayroll/src/output.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- MOBILE HAMBURGER -->

<button id="mobileMenuButton" type="button" onclick="toggleMobileSidebar()"
 class="fixed top-4 left-4 z-[60] hidden w-11 h-11 items-center justify-center rounded-lg bg-white text-gray-600 shadow-md border border-gray-200 hover:bg-gray-50"> <i class="fa-solid fa-bars text-lg"></i> </button>

<!-- MOBILE OVERLAY -->

<div id="sidebarOverlay" onclick="closeMobileSidebar()"
    class="fixed inset-0 z-40 hidden bg-black/40 md:hidden"></div>

<!-- SIDEBAR -->

<aside id="sidebar"
    class="fixed left-0 top-0 h-full w-[280px] bg-white border-r border-gray-200 flex flex-col z-50 shadow-lg overflow-hidden font-['Inter'] transition-all duration-300 ease-in-out">
<!-- HEADER -->
<div class="p-5 flex items-center gap-3 border-b border-gray-100 min-h-[72px] shrink-0">

    <!-- Logo -->
    <button type="button" onclick="handleLogoClick()"
        class="sidebar-logo w-10 h-10 rounded-xl flex items-center justify-center shrink-0 hover:bg-gray-100 transition-colors cursor-pointer">
        <img src="/ePayroll/assets/logo/logo.png" alt="QSI Logo" class="w-10 h-10 object-contain">
    </button>

    <!-- Title -->
    <h1 class="sidebar-text whitespace-nowrap text-xl font-bold text-gray-800 tracking-tight">
        QSI ePayroll
    </h1>

    <!-- Desktop Collapse -->
    <button id="desktopCollapseButton" type="button" onclick="toggleSidebar()"
        class="sidebar-text ml-auto p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-all shrink-0">
        <i id="collapseIcon" class="fa-solid fa-chevron-left text-lg"></i>
    </button>

    <!-- Mobile Close -->
    <button id="mobileCloseButton" type="button" onclick="closeMobileSidebar()"
        class="hidden ml-auto p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-all shrink-0">
        <i class="fa-solid fa-xmark text-xl"></i>
    </button>

</div>

<!-- SEARCH -->
<div id="sidebarSearch" class="px-5 py-3 shrink-0">

    <!-- Expanded Search -->
    <div id="searchExpanded" class="relative">
        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
            <i class="fa-solid fa-magnifying-glass text-sm"></i>
        </span>

        <input type="text" placeholder="Search..."
            class="w-full pl-9 pr-3 py-2 bg-gray-100 border-none rounded-lg text-sm text-gray-700 focus:ring-2 focus:ring-green-500 focus:bg-white transition-all outline-none">
    </div>

    <!-- Mini Search -->
    <button id="searchMini" type="button" onclick="expandFromSearch()"
        class="hidden w-10 h-10 mx-auto items-center justify-center text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors">
        <i class="fa-solid fa-magnifying-glass text-lg"></i>
    </button>

</div>

<!-- NAVIGATION -->
<nav class="flex-1 overflow-y-auto overflow-x-hidden px-3 pb-3 space-y-1">
    <div class="sidebar-separator my-2 border-t border-gray-200 mx-2"></div>

    <!-- HUMAN RESOURCE -->
    <div class="dropdown-container relative">

        <button type="button" onclick="handleMenuClick(this)"
            class="w-full flex items-center gap-3 px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors group">
            <i class="fa-regular fa-user text-gray-500 group-hover:text-green-600 text-lg shrink-0 w-5 text-center"></i>
            <span class="sidebar-text whitespace-nowrap font-medium">Human Resource</span>
            <i class="dropdown-chevron fa-solid fa-chevron-down text-gray-400 ml-auto text-sm shrink-0 transition-transform duration-300"></i>
        </button>

        <div class="dropdown-menu max-h-0 overflow-hidden opacity-0 transition-all duration-300 ease-in-out">

            <!-- Employee Info -->
            <a href="#" class="tab-link block px-3 py-2 text-sm text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-md"
                data-page="/ePayroll/employee/employee-info.php"
                data-tab-id="employee-info"
                data-tab-title="Employee Info"
                data-tab-icon="fa-regular fa-user">
                Employee Info
            </a>

        </div>
    </div>

    <!-- ADMINISTRATIVE -->
    <div class="dropdown-container relative">

        <button type="button" onclick="handleMenuClick(this)"
            class="w-full flex items-center gap-3 px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors group">
            <i class="fa-solid fa-shield text-gray-500 group-hover:text-green-600 text-lg shrink-0 w-5 text-center"></i>
            <span class="sidebar-text whitespace-nowrap font-medium">Administrative</span>
            <i class="dropdown-chevron fa-solid fa-chevron-down text-gray-400 ml-auto text-sm shrink-0 transition-transform duration-300"></i>
        </button>

        <div class="dropdown-menu max-h-0 overflow-hidden opacity-0 transition-all duration-300 ease-in-out">

            <a href="#" class="tab-link block px-3 py-2 text-sm text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-md"
                data-page="/ePayroll/employee/deduction-type.php"
                data-tab-id="deduction-type"
                data-tab-title="Deduction Type"
                data-tab-icon="fa-solid fa-shield">
                Deduction Type
            </a>

            <a href="#" class="tab-link block px-3 py-2 text-sm text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-md"
                data-page="/ePayroll/employee/employee-deduction.php"
                data-tab-id="employee-deduction"
                data-tab-title="Employee Deduction"
                data-tab-icon="fa-solid fa-user-minus">
                Employee Deduction
            </a>

            <a href="#" class="tab-link block px-3 py-2 text-sm text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-md"
                data-page="/ePayroll/employee/client-master.php"
                data-tab-id="client-master"
                data-tab-title="Client Master"
                data-tab-icon="fa-solid fa-building">
                Client Master
            </a>

        </div>
    </div>

    <!-- PAYROLL -->
    <div class="dropdown-container relative">

        <button type="button" onclick="handleMenuClick(this)"
            class="w-full flex items-center gap-3 px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors group">
            <i class="fa-regular fa-calendar text-gray-500 group-hover:text-green-600 text-lg shrink-0 w-5 text-center"></i>
            <span class="sidebar-text whitespace-nowrap font-medium">Payroll</span>
            <i class="dropdown-chevron fa-solid fa-chevron-down text-gray-400 ml-auto text-sm shrink-0 transition-transform duration-300"></i>
        </button>

        <div class="dropdown-menu max-h-0 overflow-hidden opacity-0 transition-all duration-300 ease-in-out">

            <a href="#" class="tab-link block px-3 py-2 text-sm text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-md"
                data-page="/ePayroll/employee/employee-payroll.php"
                data-tab-id="employee-payroll"
                data-tab-title="Payroll Transaction"
                data-tab-icon="fa-regular fa-calendar">
                Payroll Transaction
            </a>

            <a href="#" class="tab-link block px-3 py-2 text-sm text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-md"
                data-page="/ePayroll/employee/first-last-cutoff.php"
                data-tab-id="first-last-cutoff"
                data-tab-title="First / Last Cut-Off"
                data-tab-icon="fa-solid fa-calendar-days">
                First / Last Cut-Off
            </a>

        </div>
    </div>

    <!-- MAINTENANCE -->
    <div class="dropdown-container relative">

        <button type="button" onclick="handleMenuClick(this)"
            class="w-full flex items-center gap-3 px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors group">
            <i class="fa-solid fa-screwdriver-wrench text-gray-500 group-hover:text-green-600 text-lg shrink-0 w-5 text-center"></i>
            <span class="sidebar-text whitespace-nowrap font-medium">Maintenance</span>
            <i class="dropdown-chevron fa-solid fa-chevron-down text-gray-400 ml-auto text-sm shrink-0 transition-transform duration-300"></i>
        </button>

        <div class="dropdown-menu max-h-0 overflow-hidden opacity-0 transition-all duration-300 ease-in-out">

            <a href="#" class="tab-link block px-3 py-2 text-sm text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-md"
                data-page="/ePayroll/employee/branch.php"
                data-tab-id="branch"
                data-tab-title="Branch"
                data-tab-icon="fa-solid fa-code-branch">
                Branch
            </a>

            <a href="#" class="tab-link block px-3 py-2 text-sm text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-md"
                data-page="/ePayroll/employee/department.php"
                data-tab-id="department"
                data-tab-title="Department"
                data-tab-icon="fa-solid fa-building">
                Department
            </a>

            <a href="#" class="tab-link block px-3 py-2 text-sm text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-md"
                data-page="/ePayroll/employee/position.php"
                data-tab-id="position"
                data-tab-title="Position"
                data-tab-icon="fa-solid fa-briefcase">
                Position
            </a>

            <a href="#" class="tab-link block px-3 py-2 text-sm text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-md"
                data-page="/ePayroll/employee/tax-table.php"
                data-tab-id="tax-table"
                data-tab-title="Tax Table"
                data-tab-icon="fa-solid fa-table">
                Tax Table
            </a>

            <a href="#" class="tab-link block px-3 py-2 text-sm text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-md"
                data-page="/ePayroll/employee/pagibig-table.php"
                data-tab-id="pagibig-table"
                data-tab-title="Pagibig Table"
                data-tab-icon="fa-solid fa-table">
                Pagibig Table
            </a>

            <a href="#" class="tab-link block px-3 py-2 text-sm text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-md"
                data-page="/ePayroll/employee/phealth-table.php"
                data-tab-id="phealth-table"
                data-tab-title="P-Health Table"
                data-tab-icon="fa-solid fa-table">
                P-Health Table
            </a>

            <a href="#" class="tab-link block px-3 py-2 text-sm text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-md"
                data-page="/ePayroll/employee/sss-table.php"
                data-tab-id="sss-table"
                data-tab-title="SSS Table"
                data-tab-icon="fa-solid fa-table">
                SSS Table
            </a>

        </div>
    </div>

    <!-- BILLING -->
    <div class="dropdown-container relative">

        <button type="button" onclick="handleMenuClick(this)"
            class="w-full flex items-center gap-3 px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors group">
            <i class="fa-solid fa-file-invoice text-gray-500 group-hover:text-green-600 text-lg shrink-0 w-5 text-center"></i>
            <span class="sidebar-text whitespace-nowrap font-medium">Billing</span>
            <i class="dropdown-chevron fa-solid fa-chevron-down text-gray-400 ml-auto text-sm shrink-0 transition-transform duration-300"></i>
        </button>

        <div class="dropdown-menu max-h-0 overflow-hidden opacity-0 transition-all duration-300 ease-in-out">

            <a href="#" class="tab-link block px-3 py-2 text-sm text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-md"
                data-page="/ePayroll/employee/billing-transaction.php"
                data-tab-id="billing-transaction"
                data-tab-title="Billing Transaction"
                data-tab-icon="fa-solid fa-file-invoice">
                Billing Transaction
            </a>

        </div>
    </div>

    <!-- BENEFITS -->
    <div class="dropdown-container relative">

        <button type="button" onclick="handleMenuClick(this)"
            class="w-full flex items-center gap-3 px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors group">
            <i class="fa-regular fa-handshake text-gray-500 group-hover:text-green-600 text-lg shrink-0 w-5 text-center"></i>
            <span class="sidebar-text whitespace-nowrap font-medium">Benefits</span>
            <i class="dropdown-chevron fa-solid fa-chevron-down text-gray-400 ml-auto text-sm shrink-0 transition-transform duration-300"></i>
        </button>

        <div class="dropdown-menu max-h-0 overflow-hidden opacity-0 transition-all duration-300 ease-in-out">

            <a href="#" class="tab-link block px-3 py-2 text-sm text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-md"
                data-page="/ePayroll/employee/old-deduction.php"
                data-tab-id="old-deduction"
                data-tab-title="Old Deduction"
                data-tab-icon="fa-solid fa-money-bill-transfer">
                Old Deduction
            </a>

            <a href="#" class="tab-link block px-3 py-2 text-sm text-gray-600 hover:text-green-600 hover:bg-green-50 rounded-md"
                data-page="/ePayroll/employee/mandatory.php"
                data-tab-id="mandatory"
                data-tab-title="Mandatory"
                data-tab-icon="fa-solid fa-handshake">
                Mandatory
            </a>

        </div>
    </div>

</nav>

<!-- FOOTER -->
<div class="p-3 border-t border-gray-200 bg-gray-50 shrink-0">

    <!-- Settings -->
    <a href="#"
        class="tab-link flex items-center gap-3 px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors mb-1"
        data-page="/ePayroll/includes/settings.php"
        data-tab-id="settings"
        data-tab-title="Settings"
        data-tab-icon="fa-solid fa-gear">
        <i class="fa-solid fa-gear text-gray-500 text-lg shrink-0 w-5 text-center"></i>
        <span class="sidebar-text whitespace-nowrap font-medium text-sm">Settings</span>
    </a>

    <!-- Logout -->
    <a href="#"
        class="flex items-center gap-3 px-3 py-2.5 text-red-600 rounded-lg hover:bg-red-50 transition-colors">
        <i class="fa-solid fa-right-from-bracket text-lg shrink-0 w-5 text-center"></i>
        <span class="sidebar-text whitespace-nowrap font-medium text-sm">Logout</span>
    </a>

</div>

</aside>

<!-- MINI SIDEBAR CHEVRON HIDDEN -->

<style>
    #sidebar.sidebar-mini .dropdown-chevron {
        display: none !important;
    }
</style>


<link href="/ePayroll/src/output.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- MOBILE HAMBURGER -->
<button id="mobileMenuButton"
    type="button"
    onclick="toggleMobileSidebar()"
    class="fixed top-4 left-4 z-[60] hidden w-11 h-11 items-center justify-center rounded-lg bg-white text-gray-600 shadow-md border border-gray-200 hover:bg-gray-50">

    <i class="fa-solid fa-bars text-lg"></i>

</button>

<!-- MOBILE OVERLAY -->
<div id="sidebarOverlay"
    onclick="closeMobileSidebar()"
    class="fixed inset-0 z-40 hidden bg-black/40 md:hidden">
</div>

<!-- SIDEBAR -->
<aside id="sidebar"
    class="fixed left-0 top-0 h-full w-[280px] bg-white border-r border-gray-200 flex flex-col z-50 shadow-lg overflow-hidden font-['Inter'] transition-all duration-300 ease-in-out">

    <!-- =====================================================
         HEADER
    ====================================================== -->
    <div class="p-5 flex items-center gap-3 border-b border-gray-100 min-h-[72px] shrink-0">

        <!-- LOGO -->
        <button type="button"
            onclick="handleLogoClick()"
            class="sidebar-logo w-10 h-10 rounded-xl flex items-center justify-center shrink-0 hover:bg-gray-100 transition-colors cursor-pointer">

            <img src="/ePayroll/assets/logo/logo.png"
                alt="QSI Logo"
                class="w-10 h-10 object-contain">

        </button>

        <!-- TITLE -->
        <h1 class="sidebar-text whitespace-nowrap text-xl font-bold text-gray-800 tracking-tight">
            QSI Ticketing
        </h1>

        <!-- DESKTOP COLLAPSE -->
        <button id="desktopCollapseButton"
            type="button"
            onclick="toggleSidebar()"
            class="sidebar-text ml-auto p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-all shrink-0">

            <i id="collapseIcon"
                class="fa-solid fa-chevron-left text-lg">
            </i>

        </button>

        <!-- MOBILE CLOSE -->
        <button id="mobileCloseButton"
            type="button"
            onclick="closeMobileSidebar()"
            class="hidden ml-auto p-2 rounded-full hover:bg-gray-100 text-gray-500 transition-all shrink-0">

            <i class="fa-solid fa-xmark text-xl"></i>

        </button>

    </div>


    <!-- =====================================================
         SEARCH
    ====================================================== -->
    <div id="sidebarSearch"
        class="px-5 py-3 shrink-0">

        <!-- EXPANDED SEARCH -->
        <div id="searchExpanded"
            class="relative">

            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </span>

            <input type="text"
                placeholder="Search..."
                class="w-full pl-9 pr-3 py-2 bg-gray-100 border-none rounded-lg text-sm text-gray-700 focus:ring-2 focus:ring-green-500 focus:bg-white transition-all outline-none">

        </div>

        <!-- MINI SEARCH -->
        <button id="searchMini"
            type="button"
            onclick="expandFromSearch()"
            class="hidden w-10 h-10 mx-auto items-center justify-center text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors">

            <i class="fa-solid fa-magnifying-glass text-lg"></i>

        </button>

    </div>


    <!-- =====================================================
         NAVIGATION
    ====================================================== -->
    <nav class="flex-1 overflow-y-auto overflow-x-hidden px-3 pb-3">

        <div class="sidebar-separator my-2 border-t border-gray-200 mx-2"></div>


        <!-- =================================================
             TICKET TAB
        ================================================== -->
        <a href="/admin/ticket-tab.php"
            class="tab-link sidebar-nav-link flex items-center gap-3 px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors group"
            data-page="/ticketing/admin/ticket-tab.php"
            data-tab-id="ticket"
            data-tab-title="Ticket Tab"
            data-tab-icon="fa-solid fa-ticket">

            <i class="fa-solid fa-ticket text-gray-500 group-hover:text-green-600 text-lg shrink-0 w-5 text-center"></i>

            <span class="sidebar-text whitespace-nowrap font-medium">
                Ticket Tab
            </span>

        </a>


        <!-- =================================================
             MANAGE USERS
        ================================================== -->
        <a href="/admin/manage-user.php"
            class="tab-link sidebar-nav-link flex items-center gap-3 px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors group"
            data-page="/ticketing/admin/Manage-user.php"
            data-tab-id="manage-users"
            data-tab-title="Manage Users"
            data-tab-icon="fa-solid fa-users">

            <i class="fa-solid fa-users text-gray-500 group-hover:text-green-600 text-lg shrink-0 w-5 text-center"></i>

            <span class="sidebar-text whitespace-nowrap font-medium">
                Manage Users
            </span>

        </a>


        <!-- =================================================
             PRINT
        ================================================== -->
        <a href="/admin/print.php"
            class="tab-link sidebar-nav-link flex items-center gap-3 px-3 py-3 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors group"
            data-page="/ticketing/admin/print.php"
            data-tab-id="print"
            data-tab-title="Print"
            data-tab-icon="fa-solid fa-print">

            <i class="fa-solid fa-print text-gray-500 group-hover:text-green-600 text-lg shrink-0 w-5 text-center"></i>

            <span class="sidebar-text whitespace-nowrap font-medium">
                Print
            </span>

        </a>

    </nav>


    <!-- =====================================================
         FOOTER
    ====================================================== -->
    <div class="p-3 border-t border-gray-200 bg-gray-50 shrink-0">

        <!-- SETTINGS -->
        <a href="settings.php"
            class="tab-link sidebar-nav-link flex items-center gap-3 px-3 py-2.5 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors mb-1"
            data-page="/ticketing/includes/settings.php"
            data-tab-id="settings"
            data-tab-title="Settings"
            data-tab-icon="fa-solid fa-gear">

            <i class="fa-solid fa-gear text-gray-500 text-lg shrink-0 w-5 text-center"></i>

            <span class="sidebar-text whitespace-nowrap font-medium text-sm">
                Settings
            </span>

        </a>


        <!-- LOGOUT -->
        <a href="logout.php"
            class="sidebar-nav-link flex items-center gap-3 px-3 py-2.5 text-red-600 rounded-lg hover:bg-red-50 transition-colors">

            <i class="fa-solid fa-right-from-bracket text-lg shrink-0 w-5 text-center"></i>

            <span class="sidebar-text whitespace-nowrap font-medium text-sm">
                Logout
            </span>

        </a>

    </div>

</aside>


<!-- =====================================================
     MINI SIDEBAR
====================================================== -->
<style>
    #sidebar.sidebar-mini .sidebar-nav-link {
        justify-content: center !important;
    }

    #sidebar.sidebar-mini .sidebar-nav-link i:first-child {
        margin-left: auto;
        margin-right: auto;
    }
</style>
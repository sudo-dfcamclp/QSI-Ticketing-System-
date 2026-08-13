document.addEventListener('DOMContentLoaded', () => {

    // =========================================================
    // ELEMENTS
    // =========================================================

    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    const collapseIcon = document.getElementById('collapseIcon');
    const searchExpanded = document.getElementById('searchExpanded');
    const searchMini = document.getElementById('searchMini');

    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileCloseButton = document.getElementById('mobileCloseButton');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    const desktopCollapseButton = document.getElementById('desktopCollapseButton');


    // =========================================================
    // SIDEBAR STATE
    // =========================================================

    let isMini = false;
    let isMobileOpen = true;


    // =========================================================
    // CHECK IF MOBILE
    // =========================================================

    const isMobile = () => window.innerWidth < 768;


    // =========================================================
    // RESPONSIVE CONTENT LAYOUT
    // =========================================================

    function updateMainContent() {

        if (!mainContent) return;


        // MOBILE
        // Sidebar becomes overlay
        if (isMobile()) {

            mainContent.style.marginLeft = '0px';

            return;
        }


        // DESKTOP - MINI
        if (isMini) {

            mainContent.style.marginLeft = '80px';

            return;
        }


        // DESKTOP - EXPANDED
        mainContent.style.marginLeft = '280px';
    }


    // =========================================================
    // DESKTOP SIDEBAR TOGGLE
    // =========================================================

    window.toggleSidebar = function () {

        if (!sidebar || isMobile()) return;


        isMini = !isMini;


        // =====================================================
        // MINI SIDEBAR
        // =====================================================

        if (isMini) {

            sidebar.style.width = '80px';

            sidebar.classList.add('sidebar-mini');


            // Hide text
            document.querySelectorAll('.sidebar-text').forEach(el => {
                el.classList.add('hidden');
            });


            // Center navigation items
            document.querySelectorAll(
                '.sidebar-nav-link'
            ).forEach(el => {

                el.classList.remove('gap-3');

                el.classList.add('justify-center');
            });


            // Center navigation icons
            document.querySelectorAll(
                '.sidebar-nav-link i:first-child'
            ).forEach(icon => {

                icon.classList.add('mx-auto');
            });


            // Center separators
            document.querySelectorAll(
                '.sidebar-separator'
            ).forEach(el => {

                el.classList.add('mx-3');
            });


            // Mini search
            searchExpanded.classList.add('hidden');

            searchMini.classList.remove('hidden');

            searchMini.classList.add('flex');


            // Change collapse icon
            collapseIcon.classList.remove('fa-chevron-left');

            collapseIcon.classList.add('fa-chevron-right');


            // Update main content
            updateMainContent();

        }

        // =====================================================
        // EXPANDED SIDEBAR
        // =====================================================

        else {

            expandDesktopSidebar();
        }
    };


    // =========================================================
    // EXPAND DESKTOP SIDEBAR
    // =========================================================

    function expandDesktopSidebar() {

        if (!sidebar) return;


        sidebar.style.width = '280px';

        sidebar.classList.remove('sidebar-mini');


        // Show text
        document.querySelectorAll('.sidebar-text').forEach(el => {

            el.classList.remove('hidden');
        });


        // Restore navigation spacing
        document.querySelectorAll(
            '.sidebar-nav-link'
        ).forEach(el => {

            el.classList.add('gap-3');

            el.classList.remove('justify-center');
        });


        // Restore icon positioning
        document.querySelectorAll(
            '.sidebar-nav-link i:first-child'
        ).forEach(icon => {

            icon.classList.remove('mx-auto');
        });


        // Restore separators
        document.querySelectorAll(
            '.sidebar-separator'
        ).forEach(el => {

            el.classList.remove('mx-3');
        });


        // Restore expanded search
        searchExpanded.classList.remove('hidden');

        searchMini.classList.add('hidden');

        searchMini.classList.remove('flex');


        // Change collapse icon
        collapseIcon.classList.remove('fa-chevron-right');

        collapseIcon.classList.add('fa-chevron-left');


        isMini = false;


        // Update content position
        updateMainContent();
    }


    // =========================================================
    // MOBILE SIDEBAR OPEN
    // =========================================================

    window.openMobileSidebar = function () {

        if (!isMobile()) return;


        sidebar.classList.remove('-translate-x-full');

        sidebar.classList.add('translate-x-0');


        sidebarOverlay.classList.remove('hidden');


        mobileMenuButton.classList.add('hidden');


        mobileCloseButton.classList.remove('hidden');

        mobileCloseButton.classList.add('flex');


        isMobileOpen = true;


        updateMainContent();
    };


    // =========================================================
    // MOBILE SIDEBAR CLOSE
    // =========================================================

    window.closeMobileSidebar = function () {

        if (!isMobile()) return;


        sidebar.classList.remove('translate-x-0');

        sidebar.classList.add('-translate-x-full');


        sidebarOverlay.classList.add('hidden');


        mobileMenuButton.classList.remove('hidden');

        mobileMenuButton.classList.add('flex');


        mobileCloseButton.classList.add('hidden');

        mobileCloseButton.classList.remove('flex');


        isMobileOpen = false;


        updateMainContent();
    };


    // =========================================================
    // MOBILE SIDEBAR TOGGLE
    // =========================================================

    window.toggleMobileSidebar = function () {

        if (isMobileOpen) {

            closeMobileSidebar();

        } else {

            openMobileSidebar();
        }
    };


    // =========================================================
    // SEARCH CLICK
    // =========================================================

    window.expandFromSearch = function () {

        // On mobile
        if (isMobile()) {

            openMobileSidebar();

            return;
        }


        // Mini desktop
        if (isMini) {

            expandDesktopSidebar();


            setTimeout(() => {

                const input =
                    searchExpanded.querySelector('input');


                if (input) {

                    input.focus();
                }

            }, 350);
        }
    };


    // =========================================================
    // LOGO CLICK
    // =========================================================

    window.handleLogoClick = function () {

        if (isMobile()) return;


        if (isMini) {

            expandDesktopSidebar();
        }
    };


    // =========================================================
    // RESPONSIVE INITIALIZATION
    // =========================================================

    function handleResponsiveLayout() {

        if (isMobile()) {

            // =================================================
            // MOBILE
            // =================================================

            sidebar.style.width = '280px';

            sidebar.classList.remove('sidebar-mini');


            // Show text
            document.querySelectorAll('.sidebar-text').forEach(el => {

                el.classList.remove('hidden');
            });


            // Show expanded search
            searchExpanded.classList.remove('hidden');

            searchMini.classList.add('hidden');

            searchMini.classList.remove('flex');


            // Hide desktop collapse
            desktopCollapseButton.classList.add('hidden');


            // Show mobile close
            mobileCloseButton.classList.remove('hidden');

            mobileCloseButton.classList.add('flex');


            // Hide hamburger initially
            mobileMenuButton.classList.add('hidden');

            mobileMenuButton.classList.remove('flex');


            // Show sidebar
            sidebar.classList.remove('-translate-x-full');

            sidebar.classList.add('translate-x-0');


            // Show overlay
            sidebarOverlay.classList.remove('hidden');


            isMobileOpen = true;

            isMini = false;

        }

        else {

            // =================================================
            // DESKTOP
            // =================================================

            sidebar.style.width =
                isMini ? '80px' : '280px';


            sidebar.classList.remove('-translate-x-full');

            sidebar.classList.add('translate-x-0');


            // Hide overlay
            sidebarOverlay.classList.add('hidden');


            // Hide mobile controls
            mobileMenuButton.classList.add('hidden');

            mobileCloseButton.classList.add('hidden');


            // Show desktop collapse
            desktopCollapseButton.classList.remove('hidden');


            // Apply mini state
            if (isMini) {

                sidebar.classList.add('sidebar-mini');

            } else {

                sidebar.classList.remove('sidebar-mini');
            }


            isMobileOpen = true;
        }


        // =====================================================
        // UPDATE MAIN CONTENT
        // =====================================================

        updateMainContent();
    };


    // =========================================================
    // RESIZE
    // =========================================================

    window.addEventListener(
        'resize',
        handleResponsiveLayout
    );


    // =========================================================
    // INITIALIZE
    // =========================================================

    handleResponsiveLayout();

});
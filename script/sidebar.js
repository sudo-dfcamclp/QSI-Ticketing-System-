document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.getElementById('sidebar');
    const collapseIcon = document.getElementById('collapseIcon');
    const searchExpanded = document.getElementById('searchExpanded');
    const searchMini = document.getElementById('searchMini');
    const mobileMenuButton = document.getElementById('mobileMenuButton');
    const mobileCloseButton = document.getElementById('mobileCloseButton');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    let isMini = false;
    let isMobileOpen = true;

    const isMobile = () => window.innerWidth < 768;

    // ==========================================
    // DESKTOP SIDEBAR TOGGLE
    // ==========================================
    window.toggleSidebar = function () {
        if (!sidebar || isMobile()) return;

        isMini = !isMini;

        if (isMini) {
            sidebar.style.width = '80px';
            sidebar.classList.add('sidebar-mini');

            document.querySelectorAll('.sidebar-text').forEach(el => {
                el.classList.add('hidden');
            });

            document.querySelectorAll(
                '.sidebar-nav-link, .dropdown-container > button'
            ).forEach(el => {
                el.classList.remove('gap-3');
                el.classList.add('justify-center');
            });

            document.querySelectorAll(
                '.sidebar-nav-link i:first-child, .dropdown-container > button > i:first-child'
            ).forEach(icon => {
                icon.classList.add('mx-auto');
            });

            document.querySelectorAll('.sidebar-separator').forEach(el => {
                el.classList.add('mx-3');
            });

            searchExpanded.classList.add('hidden');
            searchMini.classList.remove('hidden');
            searchMini.classList.add('flex');

            closeAllDropdowns();

            collapseIcon.classList.remove('fa-chevron-left');
            collapseIcon.classList.add('fa-chevron-right');

        } else {
            expandDesktopSidebar();
        }
    };

    // ==========================================
    // EXPAND DESKTOP SIDEBAR
    // ==========================================
    function expandDesktopSidebar() {
        sidebar.style.width = '280px';
        sidebar.classList.remove('sidebar-mini');

        document.querySelectorAll('.sidebar-text').forEach(el => {
            el.classList.remove('hidden');
        });

        document.querySelectorAll(
            '.sidebar-nav-link, .dropdown-container > button'
        ).forEach(el => {
            el.classList.add('gap-3');
            el.classList.remove('justify-center');
        });

        document.querySelectorAll(
            '.sidebar-nav-link i:first-child, .dropdown-container > button > i:first-child'
        ).forEach(icon => {
            icon.classList.remove('mx-auto');
        });

        document.querySelectorAll('.sidebar-separator').forEach(el => {
            el.classList.remove('mx-3');
        });

        searchExpanded.classList.remove('hidden');
        searchMini.classList.add('hidden');
        searchMini.classList.remove('flex');

        collapseIcon.classList.remove('fa-chevron-right');
        collapseIcon.classList.add('fa-chevron-left');

        isMini = false;
    }

    // ==========================================
    // MOBILE SIDEBAR OPEN
    // ==========================================
    window.openMobileSidebar = function () {
        if (!isMobile()) return;

        sidebar.classList.remove('-translate-x-full');
        sidebar.classList.add('translate-x-0');

        sidebarOverlay.classList.remove('hidden');
        mobileMenuButton.classList.add('hidden');

        mobileCloseButton.classList.remove('hidden');
        mobileCloseButton.classList.add('flex');

        isMobileOpen = true;
    };

    // ==========================================
    // MOBILE SIDEBAR CLOSE
    // ==========================================
    window.closeMobileSidebar = function () {
        if (!isMobile()) return;

        sidebar.classList.remove('translate-x-0');
        sidebar.classList.add('-translate-x-full');

        sidebarOverlay.classList.add('hidden');
        mobileMenuButton.classList.remove('hidden');
        mobileMenuButton.classList.add('flex');

        mobileCloseButton.classList.add('hidden');
        mobileCloseButton.classList.remove('flex');

        closeAllDropdowns();

        isMobileOpen = false;
    };

    // ==========================================
    // MOBILE SIDEBAR TOGGLE
    // ==========================================
    window.toggleMobileSidebar = function () {
        if (isMobileOpen) {
            closeMobileSidebar();
        } else {
            openMobileSidebar();
        }
    };

    // ==========================================
    // SEARCH CLICK
    // ==========================================
    window.expandFromSearch = function () {
        if (isMobile()) {
            openMobileSidebar();
            return;
        }

        if (isMini) {
            expandDesktopSidebar();

            setTimeout(() => {
                const input = searchExpanded.querySelector('input');
                if (input) input.focus();
            }, 350);
        }
    };

    // ==========================================
    // MENU CLICK
    // ==========================================
    window.handleMenuClick = function (button) {
        if (!button) return;

        if (isMobile()) {
            toggleDropdown(button);
            return;
        }

        if (isMini) {
            expandDesktopSidebar();

            setTimeout(() => {
                toggleDropdown(button);
            }, 350);

            return;
        }

        toggleDropdown(button);
    };

    // ==========================================
    // LOGO CLICK
    // ==========================================
    window.handleLogoClick = function () {
        if (isMobile()) return;

        if (isMini) {
            expandDesktopSidebar();
        }
    };

    // ==========================================
    // DROPDOWN TOGGLE
    // ==========================================
    window.toggleDropdown = function (button) {
        if (!button) return;

        const container = button.closest('.dropdown-container');
        if (!container) return;

        const menu = container.querySelector('.dropdown-menu');
        const chevron = button.querySelector('.dropdown-chevron');

        if (!menu) return;

        document.querySelectorAll('.dropdown-container').forEach(item => {
            if (item !== container) {
                const otherMenu = item.querySelector('.dropdown-menu');
                const otherChevron = item.querySelector('.dropdown-chevron');

                if (otherMenu) {
                    otherMenu.classList.remove('open');
                    otherMenu.style.maxHeight = '0px';
                    otherMenu.style.opacity = '0';
                }

                if (otherChevron) {
                    otherChevron.classList.remove('rotate-180');
                }
            }
        });

        const isOpen = menu.classList.contains('open');

        if (isOpen) {
            menu.classList.remove('open');
            menu.style.maxHeight = '0px';
            menu.style.opacity = '0';

            if (chevron) {
                chevron.classList.remove('rotate-180');
            }
        } else {
            menu.classList.add('open');
            menu.style.maxHeight = menu.scrollHeight + 'px';
            menu.style.opacity = '1';

            if (chevron) {
                chevron.classList.add('rotate-180');
            }
        }
    };

    // ==========================================
    // CLOSE ALL DROPDOWNS
    // ==========================================
    function closeAllDropdowns() {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.remove('open');
            menu.style.maxHeight = '0px';
            menu.style.opacity = '0';
        });

        document.querySelectorAll('.dropdown-chevron').forEach(chevron => {
            chevron.classList.remove('rotate-180');
        });
    }

    // ==========================================
    // RESPONSIVE INITIALIZATION
    // ==========================================
    function handleResponsiveLayout() {
        if (isMobile()) {
            // Mobile: Expanded sidebar by default
            sidebar.style.width = '280px';
            sidebar.classList.remove('sidebar-mini');

            document.querySelectorAll('.sidebar-text').forEach(el => {
                el.classList.remove('hidden');
            });

            searchExpanded.classList.remove('hidden');
            searchMini.classList.add('hidden');
            searchMini.classList.remove('flex');

            // Hide desktop collapse button
            document.getElementById('desktopCollapseButton').classList.add('hidden');

            // Show mobile close button
            mobileCloseButton.classList.remove('hidden');
            mobileCloseButton.classList.add('flex');

            // Hide hamburger
            mobileMenuButton.classList.add('hidden');
            mobileMenuButton.classList.remove('flex');

            // Sidebar visible
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');

            // Show overlay
            sidebarOverlay.classList.remove('hidden');

            isMobileOpen = true;
            isMini = false;

        } else {
            // Desktop
            sidebar.style.width = isMini ? '80px' : '280px';

            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');

            sidebarOverlay.classList.add('hidden');

            mobileMenuButton.classList.add('hidden');
            mobileCloseButton.classList.add('hidden');

            document.getElementById('desktopCollapseButton').classList.remove('hidden');

            if (isMini) {
                sidebar.classList.add('sidebar-mini');
            } else {
                sidebar.classList.remove('sidebar-mini');
            }

            isMobileOpen = true;
        }
    }

    // ==========================================
    // RESIZE
    // ==========================================
    window.addEventListener('resize', handleResponsiveLayout);

    // ==========================================
    // INITIALIZE
    // ==========================================
    handleResponsiveLayout();
});
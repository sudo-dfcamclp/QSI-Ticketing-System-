document.addEventListener('DOMContentLoaded', () => {
const sidebar = document.getElementById('sidebar');
const mainContent = document.getElementById('mainContent');

const collapseIcon = document.getElementById('collapseIcon');
const searchExpanded = document.getElementById('searchExpanded');
const searchMini = document.getElementById('searchMini');

const mobileMenuButton = document.getElementById('mobileMenuButton');
const mobileCloseButton = document.getElementById('mobileCloseButton');
const sidebarOverlay = document.getElementById('sidebarOverlay');

const desktopCollapseButton = document.getElementById('desktopCollapseButton');


// ==========================================
// SIDEBAR STATE
// ==========================================

let isMini = false;
let isMobileOpen = true;


// ==========================================
// CHECK IF MOBILE
// ==========================================

const isMobile = () => window.innerWidth < 768;


// ==========================================
// RESPONSIVE CONTENT LAYOUT
// Keeps page content aligned with the sidebar
// ==========================================

function updateMainContent() {

    // Stop if the page does not have mainContent
    if (!mainContent) return;


    // MOBILE
    // Sidebar becomes an overlay
    // Main content uses the full screen
    if (isMobile()) {

        mainContent.style.marginLeft = '0px';

        return;
    }


    // DESKTOP - MINI SIDEBAR
    // Sidebar width = 80px
    if (isMini) {

        mainContent.style.marginLeft = '80px';

        return;
    }


    // DESKTOP - EXPANDED SIDEBAR
    // Sidebar width = 280px
    mainContent.style.marginLeft = '280px';
}


// ==========================================
// DESKTOP SIDEBAR TOGGLE
// ==========================================

window.toggleSidebar = function () {

    if (!sidebar || isMobile()) return;


    isMini = !isMini;


    // ==========================================
    // MINI SIDEBAR
    // ==========================================

    if (isMini) {

        sidebar.style.width = '80px';

        sidebar.classList.add('sidebar-mini');


        // Hide sidebar text
        document.querySelectorAll('.sidebar-text').forEach(el => {

            el.classList.add('hidden');

        });


        // Center navigation items
        document.querySelectorAll(
            '.sidebar-nav-link, .dropdown-container > button'
        ).forEach(el => {

            el.classList.remove('gap-3');

            el.classList.add('justify-center');

        });


        // Center icons
        document.querySelectorAll(
            '.sidebar-nav-link i:first-child, .dropdown-container > button > i:first-child'
        ).forEach(icon => {

            icon.classList.add('mx-auto');

        });


        // Adjust separators
        document.querySelectorAll('.sidebar-separator').forEach(el => {

            el.classList.add('mx-3');

        });


        // Switch search to mini version
        searchExpanded.classList.add('hidden');

        searchMini.classList.remove('hidden');

        searchMini.classList.add('flex');


        // Close dropdowns
        closeAllDropdowns();


        // Change collapse icon
        collapseIcon.classList.remove('fa-chevron-left');

        collapseIcon.classList.add('fa-chevron-right');


        // Update page content position
        updateMainContent();


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


    // Show sidebar text
    document.querySelectorAll('.sidebar-text').forEach(el => {

        el.classList.remove('hidden');

    });


    // Restore navigation spacing
    document.querySelectorAll(
        '.sidebar-nav-link, .dropdown-container > button'
    ).forEach(el => {

        el.classList.add('gap-3');

        el.classList.remove('justify-center');

    });


    // Restore icon positioning
    document.querySelectorAll(
        '.sidebar-nav-link i:first-child, .dropdown-container > button > i:first-child'
    ).forEach(icon => {

        icon.classList.remove('mx-auto');

    });


    // Restore separators
    document.querySelectorAll('.sidebar-separator').forEach(el => {

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


    // Update page content position
    updateMainContent();

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


    // Mobile content uses full width
    updateMainContent();

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


    // Mobile content remains full width
    updateMainContent();

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

            if (input) {

                input.focus();

            }

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


    // Close all other dropdowns
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


    // CLOSE DROPDOWN
    if (isOpen) {

        menu.classList.remove('open');

        menu.style.maxHeight = '0px';

        menu.style.opacity = '0';


        if (chevron) {

            chevron.classList.remove('rotate-180');

        }

    }


    // OPEN DROPDOWN
    else {

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

        // ==========================================
        // MOBILE
        // ==========================================

        sidebar.style.width = '280px';

        sidebar.classList.remove('sidebar-mini');


        // Show sidebar text
        document.querySelectorAll('.sidebar-text').forEach(el => {

            el.classList.remove('hidden');

        });


        // Show expanded search
        searchExpanded.classList.remove('hidden');

        searchMini.classList.add('hidden');

        searchMini.classList.remove('flex');


        // Hide desktop collapse button
        desktopCollapseButton.classList.add('hidden');


        // Show mobile close button
        mobileCloseButton.classList.remove('hidden');

        mobileCloseButton.classList.add('flex');


        // Hide hamburger
        mobileMenuButton.classList.add('hidden');

        mobileMenuButton.classList.remove('flex');


        // Show sidebar
        sidebar.classList.remove('-translate-x-full');

        sidebar.classList.add('translate-x-0');


        // Show overlay
        sidebarOverlay.classList.remove('hidden');


        isMobileOpen = true;

        isMini = false;


    } else {

        // ==========================================
        // DESKTOP
        // ==========================================

        sidebar.style.width = isMini ? '80px' : '280px';


        sidebar.classList.remove('-translate-x-full');

        sidebar.classList.add('translate-x-0');


        sidebarOverlay.classList.add('hidden');


        mobileMenuButton.classList.add('hidden');

        mobileCloseButton.classList.add('hidden');


        desktopCollapseButton.classList.remove('hidden');


        if (isMini) {

            sidebar.classList.add('sidebar-mini');

        } else {

            sidebar.classList.remove('sidebar-mini');

        }


        isMobileOpen = true;

    }


    // ==========================================
    // UPDATE MAIN CONTENT POSITION
    // ==========================================

    updateMainContent();

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

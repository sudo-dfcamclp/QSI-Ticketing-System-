document.addEventListener('DOMContentLoaded', () => {
    // =========================================================
    // LOCAL STORAGE KEY
    // =========================================================
    const STORAGE_KEY = 'epayroll_open_tabs';

    // =========================================================
    // ELEMENTS
    // =========================================================

    const tabList = document.getElementById('tabList');
    const tabContent = document.getElementById('tabContent');

    if (!tabList || !tabContent) {
        return;
    }

    // =========================================================
    // RESTORE TABS FROM LOCAL STORAGE
    // =========================================================

    async function restoreSavedTabs() {
        const savedTabs = getSavedTabs();

        if (savedTabs.length === 0) {
            return;
        }

        // Create ALL tabs first WITHOUT activating any
        const loadPromises = [];

        for (const tab of savedTabs) {
            const { tabId, tabTitle, tabIcon, page } = tab;

            // Skip if tab already exists (e.g., dashboard from HTML)
            const existingTab = document.querySelector(
                `.tab-item[data-tab-id="${tabId}"]`
            );

            if (!existingTab && tabId !== 'dashboard') {
                loadPromises.push(
                    createTabWithoutActivating(tabId, tabTitle, tabIcon, page)
                );
            }
        }

        // Wait for all tabs to finish loading
        await Promise.all(loadPromises);

        // NOW activate the last active tab
        const lastActiveTabId = localStorage.getItem('epayroll_active_tab');

        if (lastActiveTabId) {
            const activeTab = document.querySelector(
                `.tab-item[data-tab-id="${lastActiveTabId}"]`
            );

            if (activeTab) {
                activateTab(lastActiveTabId);
            } else {
                // Fallback: activate first available tab
                const firstTab = document.querySelector('.tab-item');
                if (firstTab) {
                    activateTab(firstTab.dataset.tabId);
                }
            }
        }
    }

    // =========================================================
    // CREATE TAB WITHOUT ACTIVATING (for restore only)
    // =========================================================

    async function createTabWithoutActivating(tabId, tabTitle, tabIcon, page) {
        // Check again to avoid duplicates
        const existingTab = document.querySelector(
            `.tab-item[data-tab-id="${tabId}"]`
        );

        if (existingTab) {
            return;
        }

        // Create tab button
        const tabButton = createTabButton(tabId, tabTitle, tabIcon, page);
        tabList.appendChild(tabButton);

        // Create content panel
        const panel = document.createElement('div');
        panel.id = `tab-${tabId}`;
        panel.className = 'tab-panel hidden';

        panel.innerHTML = `
            <div class="flex items-center justify-center min-h-[300px]">
                <div class="text-center">
                    <i class="fa-solid fa-spinner fa-spin text-3xl text-green-600 mb-4"></i>
                    <p class="text-gray-500">
                        Loading ${escapeHtml(tabTitle)}...
                    </p>
                </div>
            </div>
        `;

        tabContent.appendChild(panel);

        // Load content WITHOUT activating
        await loadTabContent(panel, page, tabTitle);
    }

    // =========================================================
    // HELPER: Get saved tabs from localStorage
    // =========================================================

    function getSavedTabs() {
        try {
            const data = localStorage.getItem(STORAGE_KEY);
            return data ? JSON.parse(data) : [];
        } catch (error) {
            console.error('Error reading saved tabs:', error);
            return [];
        }
    }

    // =========================================================
    // HELPER: Save tabs to localStorage
    // =========================================================

    function saveTabs() {
        const tabs = [];

        document.querySelectorAll('.tab-item').forEach(tabButton => {
            const tabId = tabButton.dataset.tabId;

            // Skip dashboard since it's always in HTML
            if (tabId === 'dashboard') {
                return;
            }

            tabs.push({
                tabId: tabId,
                tabTitle: tabButton.dataset.tabTitle || tabButton.querySelector('span')?.textContent,
                tabIcon: tabButton.dataset.tabIcon || 'fa-solid fa-file',
                page: tabButton.dataset.page
            });
        });

        localStorage.setItem(STORAGE_KEY, JSON.stringify(tabs));
    }

    // =========================================================
    // HELPER: Save active tab to localStorage
    // =========================================================

    function saveActiveTab(tabId) {
        localStorage.setItem('epayroll_active_tab', tabId);
    }

    // =========================================================
    // DELEGATED CLICK HANDLER
    // Handles sidebar links AND tab bar buttons (including dashboard)
    // =========================================================

    document.addEventListener('click', (event) => {
        // Handle sidebar .tab-link clicks
        const link = event.target.closest('.tab-link');

        if (link) {
            event.preventDefault();

            const page = link.dataset.page;
            const tabId = link.dataset.tabId;
            const tabTitle = link.dataset.tabTitle;
            const tabIcon = link.dataset.tabIcon || 'fa-solid fa-file';

            if (!page || !tabId || !tabTitle) {
                console.error('Missing tab data attributes.', link);
                return;
            }

            openTab(tabId, tabTitle, tabIcon, page, true);
            return;
        }

        // Handle tab bar button clicks (including dashboard)
        const tabButton = event.target.closest('.tab-item');

        if (tabButton) {
            // If clicking close button
            if (event.target.closest('.tab-close')) {
                event.stopPropagation();
                const tabId = tabButton.dataset.tabId;
                if (tabId) {
                    closeTab(tabId);
                }
                return;
            }

            // Otherwise activate tab
            const tabId = tabButton.dataset.tabId;
            if (tabId) {
                activateTab(tabId);
            }
        }
    });

    // =========================================================
    // OPEN TAB
    // =========================================================

    async function openTab(tabId, tabTitle, tabIcon, page, saveToStorage = true) {
        // Check if tab already exists
        let existingTab = document.querySelector(
            `.tab-item[data-tab-id="${tabId}"]`
        );

        // If tab already exists, simply activate it
        if (existingTab) {
            activateTab(tabId);
            return;
        }

        // Create new tab
        const tabButton = createTabButton(tabId, tabTitle, tabIcon, page);
        tabList.appendChild(tabButton);

        // Create content panel
        const panel = document.createElement('div');
        panel.id = `tab-${tabId}`;
        panel.className = 'tab-panel hidden';

        panel.innerHTML = `
            <div class="flex items-center justify-center min-h-[300px]">
                <div class="text-center">
                    <i class="fa-solid fa-spinner fa-spin text-3xl text-green-600 mb-4"></i>
                    <p class="text-gray-500">
                        Loading ${escapeHtml(tabTitle)}...
                    </p>
                </div>
            </div>
        `;

        tabContent.appendChild(panel);

        // Activate immediately
        activateTab(tabId);

        // Load PHP page
        await loadTabContent(panel, page, tabTitle);

        // Save to localStorage
        if (saveToStorage) {
            saveTabs();
        }
    }

    // =========================================================
    // CREATE TAB BUTTON
    // =========================================================

    function createTabButton(tabId, tabTitle, tabIcon, page) {
        const button = document.createElement('button');

        button.type = 'button';

        button.className =
            'tab-item flex items-center gap-3 px-5 py-4 text-base font-semibold text-gray-500 border-b-2 border-transparent hover:text-green-600 whitespace-nowrap transition-colors';

        button.dataset.tabId = tabId;
        button.dataset.tabTitle = tabTitle;
        button.dataset.tabIcon = tabIcon;
        button.dataset.page = page;

        button.innerHTML = `
            <i class="${escapeHtml(tabIcon)} text-lg"></i>
            <span>${escapeHtml(tabTitle)}</span>
            <span
                class="tab-close ml-2 w-5 h-5 flex items-center justify-center rounded-full hover:bg-gray-200 text-gray-400 hover:text-red-500"
                title="Close tab"
            >
                <i class="fa-solid fa-xmark text-xs"></i>
            </span>
        `;

        // No individual addEventListener needed here
        // All clicks handled by delegated click listener above

        return button;
    }

    // =========================================================
    // ACTIVATE TAB
    // =========================================================

    function activateTab(tabId) {
        // Remove active state from all tabs
        document.querySelectorAll('.tab-item').forEach(tab => {
            tab.classList.remove(
                'active',
                'text-green-600',
                'border-green-600'
            );

            tab.classList.add(
                'text-gray-500',
                'border-transparent'
            );
        });

        // Hide all panels
        document.querySelectorAll('.tab-panel').forEach(panel => {
            panel.classList.add('hidden');
        });

        // Activate selected tab
        const selectedTab = document.querySelector(
            `.tab-item[data-tab-id="${tabId}"]`
        );

        const selectedPanel = document.getElementById(
            `tab-${tabId}`
        );

        if (selectedTab) {
            selectedTab.classList.remove(
                'text-gray-500',
                'border-transparent'
            );

            selectedTab.classList.add(
                'active',
                'text-green-600',
                'border-green-600'
            );
        }

        if (selectedPanel) {
            selectedPanel.classList.remove('hidden');
        }

        // Scroll active tab into view
        if (selectedTab) {
            selectedTab.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest',
                inline: 'center'
            });
        }

        // Save active tab to localStorage
        saveActiveTab(tabId);
    }

    // =========================================================
    // LOAD TAB CONTENT
    // =========================================================

    async function loadTabContent(panel, page, tabTitle) {
        try {
            const response = await fetch(page, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) {
                throw new Error(
                    `HTTP Error: ${response.status}`
                );
            }

            const html = await response.text();

            panel.innerHTML = html;

            // Execute scripts found in loaded content
            executeScripts(panel);
        } catch (error) {
            console.error('Failed to load tab:', error);

            panel.innerHTML = `
                <div class="container mx-auto px-6 py-10">
                    <div class="bg-white border border-red-200 rounded-xl p-8 text-center">
                        <div class="text-red-500 text-4xl mb-4">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>

                        <h2 class="text-xl font-semibold text-gray-800 mb-2">
                            Unable to Load Page
                        </h2>

                        <p class="text-gray-500 mb-4">
                            The ${escapeHtml(tabTitle)} page could not be loaded.
                        </p>

                        <button
                            type="button"
                            onclick="location.reload()"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700"
                        >
                            Reload Page
                        </button>
                    </div>
                </div>
            `;
        }
    }

    // =========================================================
    // CLOSE TAB
    // =========================================================

    function closeTab(tabId) {
        // Dashboard cannot be closed
        if (tabId === 'dashboard') {
            return;
        }

        const tab = document.querySelector(
            `.tab-item[data-tab-id="${tabId}"]`
        );

        const panel = document.getElementById(
            `tab-${tabId}`
        );

        if (!tab || !panel) {
            return;
        }

        // Check if currently active
        const isActive = tab.classList.contains('active');

        // Remove tab
        tab.remove();

        // Remove content
        panel.remove();

        // Update localStorage
        saveTabs();

        // If closed tab was active
        if (isActive) {
            // Find last available tab
            const remainingTabs = document.querySelectorAll(
                '.tab-item'
            );

            if (remainingTabs.length > 0) {
                const lastTab =
                    remainingTabs[remainingTabs.length - 1];

                activateTab(lastTab.dataset.tabId);
            }
        }
    }

    // =========================================================
    // EXECUTE SCRIPTS FROM LOADED PAGE
    // =========================================================

    function executeScripts(container) {
        const scripts = container.querySelectorAll('script');

        scripts.forEach(oldScript => {
            const newScript = document.createElement('script');

            // Copy attributes
            Array.from(oldScript.attributes).forEach(attribute => {
                newScript.setAttribute(
                    attribute.name,
                    attribute.value
                );
            });

            // Copy inline script
            newScript.textContent = oldScript.textContent;

            oldScript.replaceWith(newScript);
        });
    }

    // =========================================================
    // ESCAPE HTML
    // Prevents HTML injection in tab titles
    // =========================================================

    function escapeHtml(value) {
        const div = document.createElement('div');

        div.textContent = value;

        return div.innerHTML;
    }

    // =========================================================
    // RESTORE TABS ON PAGE LOAD
    // =========================================================

    restoreSavedTabs();
});
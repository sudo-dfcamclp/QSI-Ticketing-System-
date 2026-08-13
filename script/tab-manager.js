document.addEventListener('DOMContentLoaded', () => {
    const STORAGE_KEY = 'epayroll_open_tabs';
    const tabList = document.getElementById('tabList');
    const tabContent = document.getElementById('tabContent');

    if (!tabList || !tabContent) {
        return;
    }

    const PAGE_SCRIPTS = {
        'ticket-tab.php': '/ticketing/admin/script/ticket-tab.js'
    };

    async function restoreSavedTabs() {
        const savedTabs = getSavedTabs();

        if (savedTabs.length === 0) {
            return;
        }

        const loadPromises = [];

        for (const tab of savedTabs) {
            const { tabId, tabTitle, tabIcon, page } = tab;

            const existingTab = document.querySelector(
                `.tab-item[data-tab-id="${tabId}"]`
            );

            if (!existingTab && tabId !== 'dashboard') {
                loadPromises.push(
                    createTabWithoutActivating(
                        tabId,
                        tabTitle,
                        tabIcon,
                        page
                    )
                );
            }
        }

        await Promise.all(loadPromises);

        const lastActiveTabId = localStorage.getItem(
            'epayroll_active_tab'
        );

        if (lastActiveTabId) {
            const activeTab = document.querySelector(
                `.tab-item[data-tab-id="${lastActiveTabId}"]`
            );

            if (activeTab) {
                activateTab(lastActiveTabId);
            } else {
                const firstTab = document.querySelector('.tab-item');

                if (firstTab) {
                    activateTab(firstTab.dataset.tabId);
                }
            }
        }
    }

    async function createTabWithoutActivating(
        tabId,
        tabTitle,
        tabIcon,
        page
    ) {
        const existingTab = document.querySelector(
            `.tab-item[data-tab-id="${tabId}"]`
        );

        if (existingTab) {
            return;
        }

        const tabButton = createTabButton(
            tabId,
            tabTitle,
            tabIcon,
            page
        );

        tabList.appendChild(tabButton);

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

        await loadTabContent(panel, page, tabTitle);
    }

    function getSavedTabs() {
        try {
            const data = localStorage.getItem(STORAGE_KEY);
            return data ? JSON.parse(data) : [];
        } catch (error) {
            console.error('Error reading saved tabs:', error);
            return [];
        }
    }

    function saveTabs() {
        const tabs = [];

        document.querySelectorAll('.tab-item').forEach(tabButton => {
            const tabId = tabButton.dataset.tabId;

            if (tabId === 'dashboard') {
                return;
            }

            tabs.push({
                tabId: tabId,
                tabTitle:
                    tabButton.dataset.tabTitle ||
                    tabButton.querySelector('span')?.textContent,
                tabIcon:
                    tabButton.dataset.tabIcon ||
                    'fa-solid fa-file',
                page: tabButton.dataset.page
            });
        });

        localStorage.setItem(
            STORAGE_KEY,
            JSON.stringify(tabs)
        );
    }

    function saveActiveTab(tabId) {
        localStorage.setItem(
            'epayroll_active_tab',
            tabId
        );
    }

    document.addEventListener('click', event => {
        const link = event.target.closest('.tab-link');

        if (link) {
            event.preventDefault();

            const page = link.dataset.page;
            const tabId = link.dataset.tabId;
            const tabTitle = link.dataset.tabTitle;
            const tabIcon =
                link.dataset.tabIcon ||
                'fa-solid fa-file';

            if (!page || !tabId || !tabTitle) {
                console.error(
                    'Missing tab data attributes.',
                    link
                );
                return;
            }

            openTab(
                tabId,
                tabTitle,
                tabIcon,
                page,
                true
            );

            return;
        }

        const tabButton = event.target.closest('.tab-item');

        if (tabButton) {
            if (event.target.closest('.tab-close')) {
                event.stopPropagation();

                const tabId = tabButton.dataset.tabId;

                if (tabId) {
                    closeTab(tabId);
                }

                return;
            }

            const tabId = tabButton.dataset.tabId;

            if (tabId) {
                activateTab(tabId);
            }
        }
    });

    async function openTab(
        tabId,
        tabTitle,
        tabIcon,
        page,
        saveToStorage = true
    ) {
        const existingTab = document.querySelector(
            `.tab-item[data-tab-id="${tabId}"]`
        );

        if (existingTab) {
            activateTab(tabId);
            return;
        }

        const tabButton = createTabButton(
            tabId,
            tabTitle,
            tabIcon,
            page
        );

        tabList.appendChild(tabButton);

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

        activateTab(tabId);

        await loadTabContent(
            panel,
            page,
            tabTitle
        );

        if (saveToStorage) {
            saveTabs();
        }
    }

    function createTabButton(
        tabId,
        tabTitle,
        tabIcon,
        page
    ) {
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

        return button;
    }

    function activateTab(tabId) {
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

        document.querySelectorAll('.tab-panel').forEach(panel => {
            panel.classList.add('hidden');
        });

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

        if (selectedTab) {
            selectedTab.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest',
                inline: 'center'
            });
        }

        saveActiveTab(tabId);
    }

    async function loadTabContent(
        panel,
        page,
        tabTitle
    ) {
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

            await loadPageScript(
                panel,
                page
            );
        } catch (error) {
            console.error(
                'Failed to load tab:',
                error
            );

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

    async function loadPageScript(
        container,
        page
    ) {
        const pageName = page
            .split('/')
            .pop()
            .split('?')[0];

        const scriptPath =
            PAGE_SCRIPTS[pageName];

        if (!scriptPath) {
            return;
        }

        try {
            const script = document.createElement('script');

            script.src = scriptPath;
            script.dataset.pageScript = pageName;

            await new Promise((resolve, reject) => {
                script.onload = resolve;
                script.onerror = reject;

                document.body.appendChild(script);
            });

            if (
                pageName === 'ticket-tab.php' &&
                typeof initTicketTab === 'function'
            ) {
                initTicketTab(container);
            }
        } catch (error) {
            console.error(
                `Failed to load page script: ${scriptPath}`,
                error
            );
        }
    }

    function closeTab(tabId) {
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

        const isActive =
            tab.classList.contains('active');

        tab.remove();
        panel.remove();

        saveTabs();

        if (isActive) {
            const remainingTabs =
                document.querySelectorAll(
                    '.tab-item'
                );

            if (remainingTabs.length > 0) {
                const lastTab =
                    remainingTabs[
                        remainingTabs.length - 1
                    ];

                activateTab(
                    lastTab.dataset.tabId
                );
            }
        }
    }

    function escapeHtml(value) {
        const div =
            document.createElement('div');

        div.textContent = value;

        return div.innerHTML;
    }

    restoreSavedTabs();
});
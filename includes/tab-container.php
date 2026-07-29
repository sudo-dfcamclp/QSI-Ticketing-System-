<!-- TAB SYSTEM -->

<div id="tabSystem" class="min-h-screen">

    <!-- TAB HEADER -->
    <div
        id="tabHeader"
        class="sticky top-0 z-30 bg-white border-b border-gray-200 shadow-sm"
    >

        <div class="flex items-center overflow-x-auto">

            <!-- DEFAULT DASHBOARD TAB -->
            <button
                type="button"
                class="tab-item active flex items-center gap-2 px-5 py-4 text-sm font-medium text-green-600 border-b-2 border-green-600 whitespace-nowrap"
                data-tab-id="dashboard"
            >
                <i class="fa-solid fa-display"></i>

                <span>Dashboard</span>
            </button>

        </div>

    </div>


    <!-- TAB CONTENT -->
    <div
        id="tabContent"
        class="min-h-[calc(100vh-57px)]"
    >

        <!-- DEFAULT DASHBOARD CONTENT -->
        <div
            id="tab-dashboard"
            class="tab-panel"
        >

            <?php include '../pages/admin/dashboard-content.php'; ?>

        </div>

    </div>

</div>
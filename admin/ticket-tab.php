<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10 max-w-7xl">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-pinetint text-pine flex items-center justify-center">
                    <i class="fa-solid fa-ticket text-lg"></i>
                </div>
                <h1 class="text-3xl font-bold text-ink tracking-tight">
                    Tickets
                </h1>
            </div>

            <p class="text-sm text-inkmuted">
                Manage and view support tickets
            </p>
        </div>

        <!-- REALTIME STATUS PILL -->
        <div class="flex items-center gap-2 text-sm text-inkmuted font-mono text-xs uppercase tracking-[0.08em]">
            <span id="ticket-live-dot" class="w-2 h-2 rounded-full bg-pine animate-pulse"></span>
            <span id="ticket-live-label">Live</span>
        </div>
    </div>

    <!-- Tickets Content -->
    <div class="bg-surface rounded-2xl shadow-sm border border-hairline overflow-hidden">

        <!-- Section Header -->
        <div class="px-6 py-5 border-b border-hairline">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>
                    <h2 class="text-lg font-semibold text-ink">
                        Ticket List
                    </h2>

                    <p class="text-sm text-inkmuted mt-1">
                        Click a ticket to view its subject and description.
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <span id="ticket-count-badge" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-canvas border border-hairline text-xs font-mono uppercase tracking-[0.06em] font-medium text-inkmuted">
                        <i class="fa-solid fa-list text-inkmuted"></i>
                        <span id="ticket-count-text">Loading...</span>
                    </span>
                </div>

            </div>
        </div>

        <!-- Ticket Content -->
        <div class="p-6 flex flex-col">

            <!-- =========================================================
                 TICKET LIST (dynamic — pinopopulate ito ng ticket-tab.js
                 galing sa ticket-tab-control.php via AJAX). Walang
                 hardcoded na tickets dito, JS template lang ang bahala.
            ========================================================== -->
            <div id="ticket-list" class="flex flex-col gap-3">

                <!-- INITIAL LOADING STATE -->
                <div id="ticket-list-loading" class="flex items-center justify-center py-16">
                    <div class="text-center">
                        <i class="fa-solid fa-spinner fa-spin text-2xl text-pine mb-3"></i>
                        <p class="text-sm text-inkmuted">Loading tickets...</p>
                    </div>
                </div>

            </div>

            <!-- EMPTY STATE (hidden by default, ipapakita ng JS kung wala talagang laman) -->
            <div id="ticket-list-empty" class="hidden flex-col items-center justify-center py-16">
                <div class="w-14 h-14 mx-auto rounded-xl bg-canvas text-inkmuted flex items-center justify-center mb-4">
                    <i class="fa-solid fa-inbox text-xl"></i>
                </div>
                <h3 class="text-base font-semibold text-ink text-center">No tickets yet</h3>
                <p class="text-sm text-inkmuted mt-1 text-center">New tickets will appear here automatically.</p>
            </div>

            <!-- =========================================================
                 PAGINATION (dynamic — pinopopulate din ito ng JS
                 base sa total_pages na ibinabalik ng controller)
            ========================================================== -->

            <div class="flex items-center justify-center gap-2 mt-7" id="ticket-pagination">
                <!-- JS-rendered page buttons -->
            </div>

        </div>

    </div>

</div>
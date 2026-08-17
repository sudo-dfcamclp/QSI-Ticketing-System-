<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10 max-w-7xl">

        <!-- PAGE HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">

            <div>

                <div class="flex items-center gap-3 mb-2">

                    <div class="w-10 h-10 rounded-xl bg-pinetint text-pine flex items-center justify-center">
                        <i class="fa-solid fa-print text-lg"></i>
                    </div>

                    <h1 class="text-3xl font-bold text-ink tracking-tight">
                        Ticket Reports
                    </h1>

                </div>

                <p class="text-sm text-inkmuted">
                    View and print ticket records
                </p>

            </div>

        </div>


        <!-- REPORT CONTAINER -->
        <div class="bg-surface rounded-2xl shadow-sm border border-hairline overflow-hidden">


            <!-- REPORT HEADER -->
            <div class="px-6 py-5 border-b border-hairline">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

                    <!-- TITLE -->
                    <div>

                        <h2 class="text-lg font-semibold text-ink">
                            Ticket Report
                        </h2>

                        <p class="text-sm text-inkmuted mt-1">
                            Generated ticket records and resolutions
                        </p>

                    </div>


                    <!-- =========================================
                         DATE RANGE FILTER (From / To)
                         -------------------------------------------
                         "From" at "To" na date columns. Pag-click
                         sa alinman dito ay nagbubukas ng native
                         browser date picker (calendar). Pag napili
                         na ang dalawa, mag-e-enable (green) ang
                         Print button — hangga't hindi kumpleto,
                         naka-gray-out ito (see print.js).
                    ========================================== -->
                    <div class="flex flex-wrap items-center gap-3">

                        <div class="flex items-center gap-2 bg-canvas border border-hairline rounded-xl px-3 py-2">

                            <label for="print-date-from" class="text-[10px] font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted">
                                From
                            </label>

                            <input
                                type="date"
                                id="print-date-from"
                                name="date_from"
                                class="bg-transparent text-sm text-ink outline-none cursor-pointer"
                            >

                        </div>

                        <div class="flex items-center gap-2 bg-canvas border border-hairline rounded-xl px-3 py-2">

                            <label for="print-date-to" class="text-[10px] font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted">
                                To
                            </label>

                            <input
                                type="date"
                                id="print-date-to"
                                name="date_to"
                                class="bg-transparent text-sm text-ink outline-none cursor-pointer"
                            >

                        </div>


                        <!-- PRINT BUTTON -->
                        <!-- Naka-disable/gray by default; pag kumpleto na
                             ang From at To, ito ay ge-green at ma-e-enable
                             (print.js ang bahalang mag-toggle ng state). -->
                        <button
                            type="button"
                            id="print-ticket-btn"
                            disabled
                            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gray-300 text-gray-500 text-sm font-semibold shadow-sm transition-colors cursor-not-allowed"
                        >

                            <i class="fa-solid fa-print text-xs"></i>

                            Print

                        </button>

                    </div>

                </div>

            </div>


            <!-- TABLE CONTENT -->
            <div class="p-6">

                <!-- LOADING STATE -->
                <div id="print-ticket-loading" class="flex items-center justify-center py-10 hidden">
                    <i class="fa-solid fa-spinner fa-spin text-2xl text-pine"></i>
                </div>

                <!-- TABLE WRAPPER -->
                <div class="w-full overflow-x-auto rounded-xl border border-hairline">

                    <table class="w-full min-w-[1400px] border-collapse">

                        <!-- TABLE HEADER -->
                        <thead>

                            <tr class="bg-canvas border-b border-hairline">

                                <th class="px-4 py-3.5 text-left text-[10px] font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted whitespace-nowrap">
                                    Ticket ID
                                </th>

                                <th class="px-4 py-3.5 text-left text-[10px] font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted whitespace-nowrap">
                                    Status
                                </th>

                                <th class="px-4 py-3.5 text-left text-[10px] font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted whitespace-nowrap">
                                    Name
                                </th>

                                <th class="px-4 py-3.5 text-left text-[10px] font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted whitespace-nowrap">
                                    Department
                                </th>

                                <th class="px-4 py-3.5 text-left text-[10px] font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted whitespace-nowrap">
                                    Issue Subject
                                </th>

                                <th class="px-4 py-3.5 text-left text-[10px] font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted min-w-[220px]">
                                    Issue Details
                                </th>

                                <th class="px-4 py-3.5 text-left text-[10px] font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted whitespace-nowrap">
                                    Priority
                                </th>

                                <th class="px-4 py-3.5 text-left text-[10px] font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted min-w-[220px]">
                                    Resolution
                                </th>

                                <th class="px-4 py-3.5 text-left text-[10px] font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted whitespace-nowrap">
                                    Ticket At
                                </th>

                                <th class="px-4 py-3.5 text-left text-[10px] font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted whitespace-nowrap">
                                    Resolve At
                                </th>

                            </tr>

                        </thead>


                        <!-- TABLE BODY -->
                        <!-- Dito ipupuno ng print.js ang mga <tr> galing
                             sa AJAX response ng print-control.php (action=list) -->
                        <tbody id="print-ticket-table-body">

                            <!--
                                DATA WILL BE INSERTED HERE VIA AJAX (print.js)
                            -->

                        </tbody>

                    </table>

                </div>


                <!-- EMPTY STATE -->
                <div
                    id="print-ticket-empty"
                    class="flex flex-col items-center justify-center py-16 text-center hidden"
                >

                    <div class="w-14 h-14 rounded-2xl bg-canvas text-inkmuted flex items-center justify-center mb-4">

                        <i class="fa-solid fa-table-list text-xl"></i>

                    </div>

                    <h3 class="text-sm font-semibold text-ink">
                        No ticket records
                    </h3>

                    <p class="text-sm text-inkmuted mt-1">
                        Ticket data will appear here once records are available.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10 max-w-7xl">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                    <i class="fa-solid fa-ticket text-lg"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 tracking-tight">
                    Tickets
                </h1>
            </div>

            <p class="text-sm text-gray-500">
                Manage and view support tickets
            </p>
        </div>

        <div class="flex items-center gap-2 text-sm text-gray-500">
            <span class="w-2 h-2 rounded-full bg-green-500"></span>
            Support Center
        </div>
    </div>

    <!-- Tickets Content -->
    <div class="bg-white  rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        <!-- Section Header -->
        <div class="px-6 py-5 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>
                    <h2 class="text-lg font-semibold text-gray-800">
                        Ticket List
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Click a ticket to view its subject and description.
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-gray-50 border border-gray-100 text-xs font-medium text-gray-500">
                        <i class="fa-solid fa-list text-gray-400"></i>
                        All Tickets
                    </span>
                </div>

            </div>
        </div>

        <!-- Ticket Content -->
        <div class="p-6 flex flex-col">

            <!-- Ticket List -->
            <div id="ticket-list" class="flex flex-col gap-3">

                <!-- =========================================================
                     TICKET 1
                ========================================================== -->

                <div class="ticket-item rounded-xl border border-gray-200 overflow-hidden bg-white hover:border-gray-300 hover:shadow-sm transition-all duration-200" data-ticket-id="TCK-1001">

                    <!-- Ticket Toggle -->
                    <button type="button" class="ticket-toggle w-full flex items-center gap-4 px-5 py-4 text-left hover:bg-gray-50 transition-colors">

                        <!-- Ticket Icon -->
                        <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-ticket"></i>
                        </div>

                        <!-- Ticket Information -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-x-6 gap-y-3 flex-1 min-w-0">

                            <!-- Ticket ID -->
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-1">
                                    Ticket ID
                                </p>

                                <p class="text-sm font-semibold text-gray-800">
                                    TCK-1001
                                </p>
                            </div>

                            <!-- Status -->
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-1">
                                    Status
                                </p>

                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-green-50 text-green-700 text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Open
                                </span>
                            </div>

                            <!-- Username -->
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-1">
                                    Username
                                </p>

                                <p class="text-sm font-medium text-gray-700 truncate">
                                    juan.delacruz
                                </p>
                            </div>

                            <!-- Department -->
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-1">
                                    Department
                                </p>

                                <p class="text-sm font-medium text-gray-700 truncate">
                                    IT Support
                                </p>
                            </div>

                        </div>

                        <!-- Chevron -->
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-gray-50 shrink-0">
                            <svg class="ticket-chevron w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                    </button>

                    <!-- Expandable Panel -->
                    <div class="ticket-panel hidden bg-gray-50 border-t border-gray-100 px-5 py-5">

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                            <!-- Subject -->
                            <div class="bg-white rounded-xl border border-gray-100 p-4">

                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-7 h-7 rounded-md bg-green-50 text-green-600 flex items-center justify-center">
                                        <i class="fa-solid fa-heading text-xs"></i>
                                    </div>

                                    <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400">
                                        Subject
                                    </p>
                                </div>

                                <p class="text-sm font-medium text-gray-800">
                                    Cannot access payroll module
                                </p>

                            </div>

                            <!-- Description -->
                            <div class="bg-white rounded-xl border border-gray-100 p-4">

                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-7 h-7 rounded-md bg-blue-50 text-blue-600 flex items-center justify-center">
                                        <i class="fa-solid fa-align-left text-xs"></i>
                                    </div>

                                    <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400">
                                        Description
                                    </p>
                                </div>

                                <p class="text-sm text-gray-600 leading-relaxed">
                                    Nag-e-error po ang system pag pinipindot ko yung payroll tab, laging nagre-reload lang.
                                </p>

                            </div>

                        </div>

                        <!-- =============================================
                             RESPONSE INPUT (kapantay ng Subject/Description)
                        ============================================== -->
                        <div class="mt-4 bg-white rounded-xl border border-gray-100 p-4">

                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-7 h-7 rounded-md bg-gray-100 text-gray-500 flex items-center justify-center">
                                    <i class="fa-solid fa-reply text-xs"></i>
                                </div>

                                <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400">
                                    Response
                                </p>
                            </div>

                            <textarea
                                class="ticket-reply-input w-full rounded-xl border border-gray-200 p-4 text-sm text-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition resize-none"
                                rows="4"
                                placeholder="Type your response here..."
                            ></textarea>

                            <div class="mt-3 flex justify-start">
                                <button
                                    type="button"
                                    class="ticket-submit-btn inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-green-600 hover:bg-green-700 text-white text-sm font-semibold shadow-sm transition-colors"
                                >
                                    <i class="fa-solid fa-paper-plane text-xs"></i>
                                    Submit
                                </button>
                            </div>

                        </div>

                    </div>

                </div>

                <!-- =========================================================
                     TICKET 2
                ========================================================== -->

                <div class="ticket-item rounded-xl border border-gray-200 overflow-hidden bg-white hover:border-gray-300 hover:shadow-sm transition-all duration-200" data-ticket-id="TCK-1002">

                    <!-- Ticket Toggle -->
                    <button type="button" class="ticket-toggle w-full flex items-center gap-4 px-5 py-4 text-left hover:bg-gray-50 transition-colors">

                        <!-- Ticket Icon -->
                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-ticket"></i>
                        </div>

                        <!-- Ticket Information -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-x-6 gap-y-3 flex-1 min-w-0">

                            <!-- Ticket ID -->
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-1">
                                    Ticket ID
                                </p>

                                <p class="text-sm font-semibold text-gray-800">
                                    TCK-1002
                                </p>
                            </div>

                            <!-- Status -->
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-1">
                                    Status
                                </p>

                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-yellow-50 text-yellow-700 text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                    Pending
                                </span>
                            </div>

                            <!-- Username -->
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-1">
                                    Username
                                </p>

                                <p class="text-sm font-medium text-gray-700 truncate">
                                    maria.santos
                                </p>
                            </div>

                            <!-- Department -->
                            <div>
                                <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-1">
                                    Department
                                </p>

                                <p class="text-sm font-medium text-gray-700 truncate">
                                    HR
                                </p>
                            </div>

                        </div>

                        <!-- Chevron -->
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-gray-50 shrink-0">
                            <svg class="ticket-chevron w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                    </button>

                    <!-- Expandable Panel -->
                    <div class="ticket-panel hidden bg-gray-50 border-t border-gray-100 px-5 py-5">

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                            <!-- Subject -->
                            <div class="bg-white rounded-xl border border-gray-100 p-4">

                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-7 h-7 rounded-md bg-green-50 text-green-600 flex items-center justify-center">
                                        <i class="fa-solid fa-heading text-xs"></i>
                                    </div>

                                    <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400">
                                        Subject
                                    </p>
                                </div>

                                <p class="text-sm font-medium text-gray-800">
                                    Request for leave credit correction
                                </p>

                            </div>

                            <!-- Description -->
                            <div class="bg-white rounded-xl border border-gray-100 p-4">

                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-7 h-7 rounded-md bg-blue-50 text-blue-600 flex items-center justify-center">
                                        <i class="fa-solid fa-align-left text-xs"></i>
                                    </div>

                                    <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400">
                                        Description
                                    </p>
                                </div>

                                <p class="text-sm text-gray-600 leading-relaxed">
                                    Mali po yung nakalagay na leave credits ko sa profile, pwede po ba i-adjust.
                                </p>

                            </div>

                        </div>

                        <!-- =============================================
                             RESPONSE INPUT (kapantay ng Subject/Description)
                        ============================================== -->
                        <div class="mt-4 bg-white rounded-xl border border-gray-100 p-4">

                            <div class="flex items-center gap-2 mb-3">
                                <div class="w-7 h-7 rounded-md bg-gray-100 text-gray-500 flex items-center justify-center">
                                    <i class="fa-solid fa-reply text-xs"></i>
                                </div>

                                <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400">
                                    Response
                                </p>
                            </div>

                            <textarea
                                class="ticket-reply-input w-full rounded-xl border border-gray-200 p-4 text-sm text-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-green-500 focus:border-green-500 outline-none transition resize-none"
                                rows="4"
                                placeholder="Type your response here..."
                            ></textarea>

                            <div class="mt-3 flex justify-start">
                                <button
                                    type="button"
                                    class="ticket-submit-btn inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-green-600 hover:bg-green-700 text-white text-sm font-semibold shadow-sm transition-colors"
                                >
                                    <i class="fa-solid fa-paper-plane text-xs"></i>
                                    Submit
                                </button>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- =========================================================
                 PAGINATION
            ========================================================== -->

            <div class="flex items-center justify-center gap-2 mt-7" id="ticket-pagination">

                <button type="button" class="page-btn w-9 h-9 rounded-lg bg-gray-800 text-white text-sm font-semibold shadow-sm hover:bg-gray-700 transition-colors" data-page="1" aria-current="true">
                    1
                </button>

                <button type="button" class="page-btn w-9 h-9 rounded-lg bg-white border border-gray-200 text-gray-600 text-sm font-medium hover:bg-gray-50 hover:border-gray-300 transition-colors" data-page="2">
                    2
                </button>

            </div>

        </div>

    </div>

</div>
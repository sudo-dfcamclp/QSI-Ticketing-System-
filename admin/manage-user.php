<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10 max-w-7xl">

    <!-- PAGE HEADER -->
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">

        <div>
            <div class="flex items-center gap-3 mb-2">

                <div class="w-10 h-10 rounded-xl bg-pinetint text-pine flex items-center justify-center">
                    <i class="fa-solid fa-users text-lg"></i>
                </div>

                <h1 class="text-3xl font-bold text-ink tracking-tight">
                    Manage Users
                </h1>

            </div>

            <p class="text-sm text-inkmuted">
                Manage and maintain system user accounts
            </p>
        </div>

        <!-- USER COUNT -->
        <div class="flex items-center gap-2 text-sm text-inkmuted font-mono text-xs uppercase tracking-[0.08em]">
            <span class="w-2 h-2 rounded-full bg-pine"></span>
            User Management
        </div>

    </div>


    <!-- USERS CONTENT -->
    <div class="bg-surface rounded-2xl shadow-sm border border-hairline overflow-hidden">


        <!-- SECTION HEADER -->
        <div class="px-6 py-5 border-b border-hairline">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                <div>
                    <h2 class="text-lg font-semibold text-ink">
                        User Accounts
                    </h2>

                    <p class="text-sm text-inkmuted mt-1">
                        Manage registered users and their account information.
                    </p>
                </div>

                <!-- ADD USER BUTTON -->
                <button
                    type="button"
                    class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-pine hover:bg-pinedark text-white text-sm font-semibold shadow-sm transition-colors"
                >
                    <i class="fa-solid fa-user-plus text-xs"></i>
                    Add User
                </button>

            </div>

        </div>


        <!-- USER LIST -->
        <div class="p-6">

            <div id="user-list" class="flex flex-col gap-3">


                <!-- =====================================================
                     USER 1
                ====================================================== -->

                <div
                    class="user-item flex items-center gap-4 p-4 bg-surface border border-hairline rounded-xl hover:border-pine/40 hover:shadow-sm transition-all duration-200"
                    data-user-id="1"
                >

                    <!-- PROFILE PICTURE -->
                    <div class="w-12 h-12 rounded-full bg-pinetint text-pine flex items-center justify-center font-semibold text-sm shrink-0">
                        JD
                    </div>


                    <!-- USER INFORMATION -->
                    <div class="flex-1 min-w-0">

                        <p class="text-sm font-semibold text-ink truncate">
                            Juan Dela Cruz
                        </p>

                        <p class="text-sm text-inkmuted truncate">
                            juan.delacruz@gmail.com
                        </p>

                    </div>


                    <!-- EDIT BUTTON -->
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-canvas border border-hairline text-inkmuted text-sm font-medium hover:bg-pinetint hover:text-pine hover:border-pine/30 transition-colors"
                    >
                        <i class="fa-solid fa-pen text-xs"></i>
                        Edit
                    </button>

                </div>


                <!-- =====================================================
                     USER 2
                ====================================================== -->

                <div
                    class="user-item flex items-center gap-4 p-4 bg-surface border border-hairline rounded-xl hover:border-pine/40 hover:shadow-sm transition-all duration-200"
                    data-user-id="2"
                >

                    <!-- PROFILE PICTURE -->
                    <div class="w-12 h-12 rounded-full bg-amber/10 text-amber flex items-center justify-center font-semibold text-sm shrink-0">
                        MS
                    </div>


                    <!-- USER INFORMATION -->
                    <div class="flex-1 min-w-0">

                        <p class="text-sm font-semibold text-ink truncate">
                            Maria Santos
                        </p>

                        <p class="text-sm text-inkmuted truncate">
                            maria.santos@gmail.com
                        </p>

                    </div>


                    <!-- EDIT BUTTON -->
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-canvas border border-hairline text-inkmuted text-sm font-medium hover:bg-pinetint hover:text-pine hover:border-pine/30 transition-colors"
                    >
                        <i class="fa-solid fa-pen text-xs"></i>
                        Edit
                    </button>

                </div>


                <!-- =====================================================
                     USER 3
                ====================================================== -->

                <div
                    class="user-item flex items-center gap-4 p-4 bg-surface border border-hairline rounded-xl hover:border-pine/40 hover:shadow-sm transition-all duration-200"
                    data-user-id="3"
                >

                    <!-- PROFILE PICTURE -->
                    <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-semibold text-sm shrink-0">
                        RA
                    </div>


                    <!-- USER INFORMATION -->
                    <div class="flex-1 min-w-0">

                        <p class="text-sm font-semibold text-ink truncate">
                            Robert Aquino
                        </p>

                        <p class="text-sm text-inkmuted truncate">
                            robert.aquino@gmail.com
                        </p>

                    </div>


                    <!-- EDIT BUTTON -->
                    <button
                        type="button"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-canvas border border-hairline text-inkmuted text-sm font-medium hover:bg-pinetint hover:text-pine hover:border-pine/30 transition-colors"
                    >
                        <i class="fa-solid fa-pen text-xs"></i>
                        Edit
                    </button>

                </div>


            </div>


            <!-- PAGINATION -->
            <div
                class="flex items-center justify-center gap-2 mt-7"
                id="user-pagination"
            >

                <button
                    type="button"
                    class="page-btn w-9 h-9 rounded-lg bg-pine text-white text-sm font-semibold shadow-sm hover:bg-pinedark transition-colors"
                    data-page="1"
                    aria-current="true"
                >
                    1
                </button>

                <button
                    type="button"
                    class="page-btn w-9 h-9 rounded-lg bg-surface border border-hairline text-inkmuted text-sm font-medium hover:bg-canvas hover:border-[#C6D1C4] transition-colors"
                    data-page="2"
                >
                    2
                </button>

            </div>

        </div>

    </div>

</div>
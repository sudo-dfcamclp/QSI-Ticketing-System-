<?php
require_once __DIR__ . '/../includes/auth/auth.php';
require_once __DIR__ . '/../includes/functions/user-function.php';

$currentUser  = $users->getById((int) ($_SESSION['user_id'] ?? 0));
$isSuperAdmin = ($currentUser['user_type'] ?? '') === 'super_admin';
?>
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10 max-w-7xl"
    id="manage-user-root"
    data-is-super-admin="<?php echo $isSuperAdmin ? '1' : '0'; ?>"
    data-current-user-id="<?php echo (int) ($currentUser['user_id'] ?? 0); ?>">

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

        <!-- REALTIME STATUS PILL -->
        <div class="flex items-center gap-2 text-sm text-inkmuted font-mono text-xs uppercase tracking-[0.08em]">
            <span id="user-live-dot" class="w-2 h-2 rounded-full bg-pine animate-pulse"></span>
            <span id="user-live-label">Live</span>
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

            </div>

        </div>


        <!-- USER LIST -->
        <div class="p-6">

            <!-- LOADING STATE -->
            <div id="user-list-loading" class="flex items-center justify-center py-16">
                <div class="text-center">
                    <i class="fa-solid fa-spinner fa-spin text-2xl text-pine mb-3"></i>
                    <p class="text-sm text-inkmuted">Loading users...</p>
                </div>
            </div>

            <!-- EMPTY STATE -->
            <div id="user-list-empty" class="hidden items-center justify-center py-16 text-center flex-col">
                <i class="fa-solid fa-user-slash text-3xl text-inkmuted mb-3"></i>
                <p class="text-sm text-inkmuted">No users found.</p>
            </div>

            <div id="user-list" class="hidden flex flex-col gap-3"></div>

            <!-- PAGINATION -->
            <div
                class="flex items-center justify-center gap-2 mt-7"
                id="user-pagination"
            ></div>

        </div>

    </div>

</div>

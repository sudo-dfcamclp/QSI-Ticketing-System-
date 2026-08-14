<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10 max-w-5xl">

    <!-- PAGE HEADER -->
    <div class="mb-8">

        <div class="flex items-center gap-3 mb-2">

            <div class="w-10 h-10 rounded-xl bg-pinetint text-pine flex items-center justify-center">
                <i class="fa-solid fa-gear text-lg"></i>
            </div>

            <h1 class="text-3xl font-bold text-ink tracking-tight">
                Settings
            </h1>

        </div>

        <p class="text-sm text-inkmuted">
            Manage your profile and account settings
        </p>

    </div>


    <!-- PROFILE INFORMATION -->
    <div class="bg-surface rounded-2xl shadow-sm border border-hairline overflow-hidden mb-6">

        <!-- CARD HEADER -->
        <div class="px-6 py-5 border-b border-hairline">

            <div class="flex items-center gap-3">

                <div class="w-9 h-9 rounded-lg bg-pinetint text-pine flex items-center justify-center">
                    <i class="fa-solid fa-user text-sm"></i>
                </div>

                <div>

                    <h2 class="text-lg font-semibold text-ink">
                        Profile Information
                    </h2>

                    <p class="text-sm text-inkmuted mt-0.5">
                        View and manage your account information
                    </p>

                </div>

            </div>

        </div>


        <!-- PROFILE CONTENT -->
        <div class="p-6">

            <div class="flex flex-col sm:flex-row sm:items-center gap-6 mb-8">

                <!-- PROFILE PICTURE / ACRONYM -->
                <div class="shrink-0">

                    <div class="w-24 h-24 rounded-full bg-pine text-white flex items-center justify-center shadow-sm">

                        <span class="text-2xl font-bold tracking-wide">
                            AN
                        </span>

                    </div>

                </div>


                <!-- PROFILE NAME -->
                <div>

                    <h3 class="text-xl font-semibold text-ink">
                        Andrew Name
                    </h3>

                    <p class="text-sm text-inkmuted mt-1">
                        Administrator
                    </p>

                </div>

            </div>


            <!-- PROFILE FIELDS -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <!-- FIRST NAME -->
                <div>

                    <label class="block text-xs font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted mb-2">
                        First Name
                    </label>

                    <input
                        type="text"
                        value="Andrew"
                        class="w-full rounded-xl border border-hairline bg-canvas px-4 py-3 text-sm text-ink outline-none transition-colors duration-150 focus:border-pine focus:bg-surface focus:shadow-[0_0_0_4px_rgba(14,91,69,0.10)]"
                    >

                </div>


                <!-- LAST NAME -->
                <div>

                    <label class="block text-xs font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted mb-2">
                        Last Name
                    </label>

                    <input
                        type="text"
                        value="Name"
                        class="w-full rounded-xl border border-hairline bg-canvas px-4 py-3 text-sm text-ink outline-none transition-colors duration-150 focus:border-pine focus:bg-surface focus:shadow-[0_0_0_4px_rgba(14,91,69,0.10)]"
                    >

                </div>


                <!-- USERNAME -->
                <div>

                    <label class="block text-xs font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted mb-2">
                        Username
                    </label>

                    <input
                        type="text"
                        value="andrew"
                        class="w-full rounded-xl border border-hairline bg-canvas px-4 py-3 text-sm text-ink outline-none transition-colors duration-150 focus:border-pine focus:bg-surface focus:shadow-[0_0_0_4px_rgba(14,91,69,0.10)]"
                    >

                </div>


                <!-- GMAIL -->
                <div>

                    <label class="block text-xs font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted mb-2">
                        Gmail
                    </label>

                    <input
                        type="email"
                        value="andrew@gmail.com"
                        class="w-full rounded-xl border border-hairline bg-canvas px-4 py-3 text-sm text-ink outline-none transition-colors duration-150 focus:border-pine focus:bg-surface focus:shadow-[0_0_0_4px_rgba(14,91,69,0.10)]"
                    >

                </div>

            </div>


            <!-- SAVE BUTTON -->
            <div class="flex justify-end mt-6 pt-5 border-t border-hairline">

                <button
                    type="button"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-pine hover:bg-pinedark text-white text-sm font-semibold shadow-sm transition-colors"
                >

                    <i class="fa-solid fa-floppy-disk text-xs"></i>

                    Save Changes

                </button>

            </div>

        </div>

    </div>


    <!-- CHANGE PASSWORD -->
    <div class="bg-surface rounded-2xl shadow-sm border border-hairline overflow-hidden">

        <!-- CARD HEADER -->
        <div class="px-6 py-5 border-b border-hairline">

            <div class="flex items-center gap-3">

                <div class="w-9 h-9 rounded-lg bg-pinetint text-pine flex items-center justify-center">
                    <i class="fa-solid fa-lock text-sm"></i>
                </div>

                <div>

                    <h2 class="text-lg font-semibold text-ink">
                        Change Password
                    </h2>

                    <p class="text-sm text-inkmuted mt-0.5">
                        Update your password to keep your account secure
                    </p>

                </div>

            </div>

        </div>


        <!-- PASSWORD CONTENT -->
        <div class="p-6">

            <div class="max-w-2xl space-y-5">

                <!-- CURRENT PASSWORD -->
                <div>

                    <label class="block text-xs font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted mb-2">
                        Current Password
                    </label>

                    <div class="relative">

                        <input
                            type="password"
                            id="current-password"
                            placeholder="Enter your current password"
                            class="w-full rounded-xl border border-hairline bg-canvas px-4 py-3 pr-12 text-sm text-ink placeholder:text-inkmuted outline-none transition-colors duration-150 focus:border-pine focus:bg-surface focus:shadow-[0_0_0_4px_rgba(14,91,69,0.10)]"
                        >

                        <button
                            type="button"
                            class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-lg text-inkmuted hover:bg-pinetint hover:text-pine transition-colors"
                            onclick="togglePassword('current-password', this)"
                        >
                            <i class="fa-solid fa-eye text-xs"></i>
                        </button>

                    </div>

                </div>


                <!-- NEW PASSWORD -->
                <div>

                    <label class="block text-xs font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted mb-2">
                        New Password
                    </label>

                    <div class="relative">

                        <input
                            type="password"
                            id="new-password"
                            placeholder="Enter your new password"
                            class="w-full rounded-xl border border-hairline bg-canvas px-4 py-3 pr-12 text-sm text-ink placeholder:text-inkmuted outline-none transition-colors duration-150 focus:border-pine focus:bg-surface focus:shadow-[0_0_0_4px_rgba(14,91,69,0.10)]"
                        >

                        <button
                            type="button"
                            class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-lg text-inkmuted hover:bg-pinetint hover:text-pine transition-colors"
                            onclick="togglePassword('new-password', this)"
                        >
                            <i class="fa-solid fa-eye text-xs"></i>
                        </button>

                    </div>

                </div>


                <!-- CONFIRM PASSWORD -->
                <div>

                    <label class="block text-xs font-mono font-semibold uppercase tracking-[0.08em] text-inkmuted mb-2">
                        Confirm Password
                    </label>

                    <div class="relative">

                        <input
                            type="password"
                            id="confirm-password"
                            placeholder="Confirm your new password"
                            class="w-full rounded-xl border border-hairline bg-canvas px-4 py-3 pr-12 text-sm text-ink placeholder:text-inkmuted outline-none transition-colors duration-150 focus:border-pine focus:bg-surface focus:shadow-[0_0_0_4px_rgba(14,91,69,0.10)]"
                        >

                        <button
                            type="button"
                            class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-lg text-inkmuted hover:bg-pinetint hover:text-pine transition-colors"
                            onclick="togglePassword('confirm-password', this)"
                        >
                            <i class="fa-solid fa-eye text-xs"></i>
                        </button>

                    </div>

                </div>

            </div>


            <!-- PASSWORD BUTTON -->
            <div class="flex justify-end mt-6 pt-5 border-t border-hairline">

                <button
                    type="button"
                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-pine hover:bg-pinedark text-white text-sm font-semibold shadow-sm transition-colors"
                >

                    <i class="fa-solid fa-key text-xs"></i>

                    Update Password

                </button>

            </div>

        </div>

    </div>

</div>


<script>

function togglePassword(inputId, button) {

    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');

    if (input.type === 'password') {

        input.type = 'text';

        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');

    } else {

        input.type = 'password';

        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');

    }

}

</script>
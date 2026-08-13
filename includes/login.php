<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QSI | Login</title>
    <link rel="stylesheet" href="../src/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Main Container -->
    <div class="flex items-center justify-center min-h-screen px-4">
        <!-- Login Card -->
        <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-[#0a5d3c] to-[#0d9488] p-8 text-center">
                <div class="w-20 h-20 mx-auto rounded-full bg-white flex items-center justify-center shadow-lg">
                    <img src="../assets/logo/logo.png" alt="QSI Logo" class="w-16 h-16 rounded-full object-contain">
                </div>
                <h1 class="text-3xl font-bold text-white mt-5">Welcome Back</h1>
                <p class="text-blue-100 mt-2">Sign in to continue to your account.</p>
            </div>

            <!-- Form -->
            <form id="loginForm" method="POST" class="p-8 space-y-6">
                <!-- Username -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Username</label>
                    <div class="relative">
                        <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" id="username" name="username" placeholder="Enter your username" autocomplete="username" required
                            class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="current-password" required
                            class="w-full pl-12 pr-12 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
                        <button type="button" class="toggle-password absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-blue-600">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600">
                        Remember Me
                    </label>
                    <a href="forgot-password.php" class="text-sm font-medium text-[#0a5d3c] hover:underline">Forgot Password?</a>
                </div>

                <!-- Login Button -->
                <button type="submit" class="w-full bg-[#0a5d3c] hover:bg-[#0d9488] text-white font-semibold py-3 rounded-xl transition duration-300 shadow-lg hover:shadow-xl">
                    <i class="fa-solid fa-right-to-bracket mr-2"></i>
                    Login
                </button>
            </form>

            <!-- Footer -->
            <div class="border-t border-slate-200 px-8 py-5 text-center bg-slate-50">
                <p class="text-sm text-slate-500">© 2026 QSI Inc. All Rights Reserved.</p>
            </div>
        </div>
    </div>

<script src="../script/login.js"></script>
</body>
</html>
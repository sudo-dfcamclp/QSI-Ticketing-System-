<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QSI | Admin Register</title>

    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="../src/output.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body class="min-h-screen bg-gradient-to-br from-slate-100 via-blue-50 to-indigo-100 py-10">

    <!-- Main Container -->
    <div class="flex items-start justify-center min-h-screen px-4 pt-10">

        <!-- Register Card (Slightly wider for extra fields) -->
        <div class="w-full max-w-lg bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-[#0a5d3c] to-[#0d9488] p-8 text-center">

                <div class="w-20 h-20 mx-auto rounded-full bg-white flex items-center justify-center shadow-lg">
                    <img 
                        src="../assets/logo/logo.png" 
                        alt="QSI Logo" 
                        class="w-16 h-16 rounded-full object-contain"
                    >
                </div>

                <h1 class="text-3xl font-bold text-white mt-5">
                    Create  Account
                </h1>

                <p class="text-blue-100 mt-2">
                    Register a new account to the system.
                </p>

            </div>

            <!-- Form -->
            <form id="registerForm" class="p-8 space-y-5">

                <!-- First & Last Name (Side by Side) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- First Name -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">First Name</label>
                        <div class="relative">
                            <i class="fa-solid fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="f_name" placeholder="Mark" required
                                class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#0a5d3c] focus:border-[#0a5d3c] outline-none transition">
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Last Name</label>
                        <div class="relative">
                            <i class="fa-solid fa-user-tag absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                            <input type="text" name="l_name" placeholder="Porras" required
                                class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#0a5d3c] focus:border-[#0a5d3c] outline-none transition">
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                    <div class="relative">
                        <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="email" name="email" placeholder="mark@gmail.com" required
                            class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#0a5d3c] focus:border-[#0a5d3c] outline-none transition">
                    </div>
                </div>

                <!-- Contact -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Contact Number</label>
                    <div class="relative">
                        <i class="fa-solid fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="text" name="contact" placeholder="09943938045" required
                            class="w-full pl-12 pr-4 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#0a5d3c] focus:border-[#0a5d3c] outline-none transition">
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="password" name="password" id="password" placeholder="Enter password" required
                            class="w-full pl-12 pr-12 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#0a5d3c] focus:border-[#0a5d3c] outline-none transition">
                        <button type="button" onclick="togglePassword('password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-[#0a5d3c]">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Confirm Password</label>
                    <div class="relative">
                        <i class="fa-solid fa-shield-halved absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                        <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password" required
                            class="w-full pl-12 pr-12 py-3 border border-slate-300 rounded-xl focus:ring-2 focus:ring-[#0a5d3c] focus:border-[#0a5d3c] outline-none transition">
                        <button type="button" onclick="togglePassword('confirm_password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-[#0a5d3c]">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Register Button -->
                <button type="submit" id="submitBtn"
                    class="w-full bg-[#0a5d3c] hover:bg-[#084a30] text-white font-semibold py-3 rounded-xl transition duration-300 shadow-lg hover:shadow-xl mt-4">
                    <i class="fa-solid fa-user-plus mr-2"></i>
                    Register Admin
                </button>

                <!-- Back to Login -->
                <div class="text-center mt-4">
                    <p class="text-sm text-slate-600">
                        Already have an account? 
                        <a href="index.php" class="font-medium text-[#0a5d3c] hover:underline">
                            Sign in here
                        </a>
                    </p>
                </div>

            </form>

            <!-- Footer -->
            <div class="border-t border-slate-200 px-8 py-5 text-center bg-slate-50">
                <p class="text-sm text-slate-500">
                    © 2026 QSI Inc. All Rights Reserved.
                </p>
            </div>

        </div>

    </div>

    <!-- Register Script -->
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QSI | Submit a Ticket</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="../src/output.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body class="min-h-screen bg-gray-100 text-gray-800 font-sans flex justify-center items-start px-5 py-6 sm:py-16">

    <div class="w-full max-w-[540px]">

        <!-- Eyebrow -->
        <div class="font-mono text-xs tracking-[0.14em] uppercase text-inkmuted flex items-center gap-2.5 mb-3.5 pl-1">
            <span class="w-1.5 h-1.5 rounded-full bg-pine shrink-0"></span>
            QSI Internal Support
        </div>

        <!-- Ticket card -->
        <div class="bg-surface border border-hairline rounded-[20px] relative
                    shadow-[0_1px_2px_rgba(20,33,26,0.04),0_16px_40px_-20px_rgba(20,33,26,0.25)]">

            <!-- Header stub -->
            <div class="relative overflow-hidden rounded-t-[20px] text-white
                        bg-gradient-to-br from-pine to-pinedark
                        px-[22px] pt-7 pb-[26px] sm:px-9 sm:pt-[34px] sm:pb-[30px]
                        before:content-[''] before:absolute before:inset-0 before:pointer-events-none
                        before:bg-[radial-gradient(circle_at_88%_-10%,rgba(255,255,255,0.14),transparent_55%)]">

                <div class="relative flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-[42px] h-[42px] rounded-full bg-white flex items-center justify-center shrink-0
                                    shadow-[0_2px_8px_rgba(0,0,0,0.18)]">
                            <img src="../assets/logo/logo.png" alt="QSI Logo" class="w-[30px] h-[30px] object-contain rounded-full">
                        </div>
                        <span class="font-mono text-xs tracking-[0.12em] uppercase opacity-85">QSI Inc.</span>
                    </div>

                    <span class="font-mono text-[11px] tracking-[0.08em] uppercase whitespace-nowrap
                                 bg-white/[0.14] border border-white/[0.28] px-2.5 py-1.5 rounded-full">
                        <i class="fa-solid fa-ticket mr-1.5"></i>New Ticket
                    </span>
                </div>

                <h1 class="relative text-[22px] sm:text-[26px] font-bold mt-[22px] mb-1.5 tracking-[-0.01em]">
                    Submit a support ticket
                </h1>
                <p class="relative text-sm text-white/[0.78] max-w-[40ch] m-0">
                    Tell IT what's going on — we'll route it to the right queue.
                </p>
            </div>

            <!-- Perforation divider -->
            <div class="relative h-0 border-t-2 border-dashed border-hairline
                        before:content-[''] before:absolute before:top-1/2 before:-translate-y-1/2 before:-left-[11px]
                        before:w-[22px] before:h-[22px] before:rounded-full before:bg-canvas
                        before:shadow-[inset_0_0_0_1px_#DEE5DF]
                        after:content-[''] after:absolute after:top-1/2 after:-translate-y-1/2 after:-right-[11px]
                        after:w-[22px] after:h-[22px] after:rounded-full after:bg-canvas
                        after:shadow-[inset_0_0_0_1px_#DEE5DF]">
            </div>

            <!-- Form -->
            <form id="registerForm" class="px-[22px] pt-[26px] pb-[30px] sm:px-9 sm:pt-8 sm:pb-9">

                <!-- Username -->
                <div class="mb-6">
                    <div class="flex items-baseline gap-2 mb-2.5">
                        <span class="font-mono text-[11px] text-pine font-semibold tracking-[0.04em]">01</span>
                        <span class="text-[13px] font-semibold text-ink">Requester</span>
                    </div>

                    <div class="relative">
                        <i class="fa-solid fa-user-tag absolute left-[15px] top-4 text-inkmuted text-sm pointer-events-none"></i>
                        <input
                            type="text"
                            name="username"
                            placeholder="Enter username"
                            autocomplete="username"
                            required
                            class="w-full text-[14.5px] text-ink bg-surface border-[1.5px] border-hairline rounded-xl
                                   py-3.5 pr-4 pl-[42px] outline-none appearance-none
                                   placeholder:text-[#A7B3A1]
                                   hover:border-[#C6D1C4]
                                   focus:border-pine focus:bg-pinetint focus:shadow-[0_0_0_4px_rgba(14,91,69,0.12)]
                                   focus-visible:outline focus-visible:outline-2 focus-visible:outline-amber focus-visible:outline-offset-2
                                   transition-colors duration-150 motion-reduce:transition-none"
                        >
                    </div>
                </div>

                <!-- Department -->
                <div class="mb-6">
                    <div class="flex items-baseline gap-2 mb-2.5">
                        <span class="font-mono text-[11px] text-pine font-semibold tracking-[0.04em]">02</span>
                        <span class="text-[13px] font-semibold text-ink">Department</span>
                    </div>

                    <div class="relative">
                        <i class="fa-solid fa-building absolute left-[15px] top-4 text-inkmuted text-sm pointer-events-none"></i>
                        <select
                            name="department"
                            id="department"
                            required
                            class="w-full text-[14.5px] text-ink bg-surface border-[1.5px] border-hairline rounded-xl
                                   py-3.5 pr-4 pl-[42px] outline-none appearance-none cursor-pointer
                                   hover:border-[#C6D1C4]
                                   focus:border-pine focus:bg-pinetint focus:shadow-[0_0_0_4px_rgba(14,91,69,0.12)]
                                   focus-visible:outline focus-visible:outline-2 focus-visible:outline-amber focus-visible:outline-offset-2
                                   transition-colors duration-150 motion-reduce:transition-none"
                        >
                            <option value="" disabled selected>Select department</option>
                            <option value="Executive">Executive</option>
                            <option value="Accounting">Accounting</option>
                            <option value="Admin">Admin</option>
                            <option value="Human Resource">Human Resource</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-inkmuted text-xs pointer-events-none"></i>
                    </div>
                </div>

                <!-- Subject -->
                <div class="mb-6">
                    <div class="flex items-baseline gap-2 mb-2.5">
                        <span class="font-mono text-[11px] text-pine font-semibold tracking-[0.04em]">03</span>
                        <span class="text-[13px] font-semibold text-ink">Category</span>
                    </div>

                    <div class="relative">
                        <i class="fa-solid fa-list-check absolute left-[15px] top-4 text-inkmuted text-sm pointer-events-none"></i>
                        <select
                            name="subject"
                            id="subject"
                            required
                            class="w-full text-[14.5px] text-ink bg-surface border-[1.5px] border-hairline rounded-xl
                                   py-3.5 pr-4 pl-[42px] outline-none appearance-none cursor-pointer
                                   hover:border-[#C6D1C4]
                                   focus:border-pine focus:bg-pinetint focus:shadow-[0_0_0_4px_rgba(14,91,69,0.12)]
                                   focus-visible:outline focus-visible:outline-2 focus-visible:outline-amber focus-visible:outline-offset-2
                                   transition-colors duration-150 motion-reduce:transition-none"
                        >
                            <option value="" disabled selected>Select subject</option>
                            <option value="Pc/Laptop">Pc/Laptop</option>
                            <option value="Server">Server</option>
                            <option value="Internet / Network">Internet / Network</option>
                            <option value="Printer">Printer</option>
                            <option value="Scanner">Scanner</option>
                            <option value="Others">Others</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-inkmuted text-xs pointer-events-none"></i>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-2">
                    <div class="flex items-baseline gap-2 mb-2.5">
                        <span class="font-mono text-[11px] text-pine font-semibold tracking-[0.04em]">04</span>
                        <span class="text-[13px] font-semibold text-ink">Details</span>
                        <span class="font-mono text-xs text-inkmuted ml-auto">be specific</span>
                    </div>

                    <div class="relative">
                        <textarea
                            name="description"
                            id="description"
                            rows="4"
                            placeholder="Describe the issue in detail — what happened, when it started, anything you've already tried."
                            required
                            class="w-full text-[14.5px] text-ink bg-surface border-[1.5px] border-hairline rounded-xl
                                   pt-3.5 pb-3.5 px-4 outline-none appearance-none resize-y min-h-[96px] leading-relaxed
                                   placeholder:text-[#A7B3A1]
                                   hover:border-[#C6D1C4]
                                   focus:border-pine focus:bg-pinetint focus:shadow-[0_0_0_4px_rgba(14,91,69,0.12)]
                                   focus-visible:outline focus-visible:outline-2 focus-visible:outline-amber focus-visible:outline-offset-2
                                   transition-colors duration-150 motion-reduce:transition-none"
                        ></textarea>
                    </div>
                </div>

                <button
                    type="submit"
                    id="submitBtn"
                    class="w-full font-semibold text-[15px] text-white bg-pine border-none rounded-xl
                           py-[15px] px-5 cursor-pointer flex items-center justify-center gap-2.5 mt-4
                           hover:bg-pinedark active:translate-y-px
                           disabled:opacity-75 disabled:cursor-not-allowed
                           focus-visible:outline focus-visible:outline-2 focus-visible:outline-amber focus-visible:outline-offset-2
                           transition-colors duration-150 motion-reduce:transition-none"
                >
                    <i class="fa-solid fa-paper-plane"></i>
                    Submit ticket
                </button>

                <p class="text-center text-xs text-inkmuted mt-3.5 font-mono tracking-wide">
                    A ticket ID will be assigned once submitted
                </p>

            </form>

            <div class="border-t border-hairline px-[22px] py-4 sm:px-9 sm:py-[18px] text-center bg-[#FBFCFB] rounded-b-[20px]">
                <p class="font-mono text-[11px] tracking-[0.06em] uppercase text-[#9DAB98] m-0">
                    © 2026 QSI Inc. — All Rights Reserved
                </p>
            </div>

        </div>

    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="script/forms.js"></script>

</body>
</html>
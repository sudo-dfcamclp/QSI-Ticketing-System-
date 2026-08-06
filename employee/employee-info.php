            <!-- employee_information.php | Content fragment ONLY -->
            <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-10 max-w-7xl">

            <!-- 1. LONG THIN BOX (Page Header) -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-4 mb-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Employee Master</h1>
                        <p class="text-sm text-gray-500 mt-0.5">Employee: Juan Dela Cruz</p>
                    </div>
                </div>
            </div>

                <!-- 2. TOOLBAR BOX (No Shadow, No Title) -->
                <div class="bg-white rounded-2xl border border-gray-200 px-6 py-3 mb-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <!-- Left: Action Buttons -->
                        <div class="flex items-center gap-2">
                            <button type="button" class="px-3 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition text-sm font-medium">
                                <i class="fa-solid fa-pen mr-1"></i>Edit
                            </button>
                            <button type="button" class="px-3 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition text-sm font-medium">
                                <i class="fa-solid fa-plus mr-1"></i>New
                            </button>
                            <button type="button" class="px-3 py-1.5 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition text-sm font-medium">
                                <i class="fa-solid fa-floppy-disk mr-1"></i>Save
                            </button>
                        </div>
                        <!-- Center: Search -->
                        <div class="relative flex-1 max-w-xs mx-2">
                            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                            <input type="text" placeholder="Search..." class="pl-9 pr-4 py-1.5 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent w-full">
                        </div>
                        <!-- Right: Navigation -->
                        <div class="flex items-center gap-2">
                            <button type="button" class="px-2.5 py-1.5 border border-gray-300 rounded-lg hover:bg-gray-100 transition text-gray-600 text-sm">
                                <i class="fa-solid fa-angles-left"></i>
                            </button>
                            <span class="text-sm text-gray-600 px-2 font-medium whitespace-nowrap">1 of 1,248</span>
                            <button type="button" class="px-2.5 py-1.5 border border-gray-300 rounded-lg hover:bg-gray-100 transition text-gray-600 text-sm">
                                <i class="fa-solid fa-angles-right"></i>
                            </button>
                        </div>
                    </div>
                </div>

                        <!-- 2. BIG MODERN BOX (Employees Directory / Profile Form) -->
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 p-6 mb-6">
                            
                            <!-- Header Section -->
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-800">Basic Information</h2>
                                    <p class="text-sm text-gray-500 mt-1">Complete list of registered employees in the system.</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <!-- Search and Add buttons can go here if needed -->
                                </div>
                            </div>

                        <!-- Form Content -->
                        <form>
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                            
                            <!-- Left Column: Profile Picture -->
                            <!-- CHANGED: Added h-full to make it stretch vertically -->
                            <div class="lg:col-span-3 flex flex-col items-center lg:items-stretch">
                                <!-- CHANGED: Replaced aspect-square with h-full and min-h to match form height -->
                                <div class="w-full h-full min-h-[220px] bg-gray-200 rounded-2xl flex flex-col items-center justify-center overflow-hidden border-2 border-dashed border-gray-300 hover:border-green-500 transition-colors cursor-pointer group relative">
                                    <!-- Placeholder Icon -->
                                    <div class="text-center p-4">
                                        <i class="fa-solid fa-camera text-4xl text-gray-400 group-hover:text-green-500 transition-colors mb-2"></i>
                                        <p class="text-xs text-gray-500 font-medium">Upload Photo</p>
                                    </div>
                                    <!-- Hidden Input for functionality -->
                                    <input type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                </div>
                            </div>

                                        <!-- Right Column: Form Fields -->
                        <div class="lg:col-span-9 flex flex-col gap-6">

                            <!-- Employee & Name Section -->
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                            <!-- LEFT COLUMN -->
                            <div class="space-y-4">

                                <!-- Employee No -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                        Employee No
                                    </label>
                                    <input type="text" class="w-full flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="...">
                                </div>

                                <!-- Contact No -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                        Contact No
                                    </label>
                                     <input type="text" class="w-full flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="...">
                                </div>

                                <!-- Badge No -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                        Badge No
                                    </label>
                                    <input type="text" class="w-full flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="...">
                                </div>

                                <!-- Nick Name -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                        Nick Name
                                    </label>
                                    <input type="text" class="w-full flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="...">
                                </div>

                            </div>

                            <!-- RIGHT COLUMN -->
                            <div class="space-y-4">

                                <!-- Last Name -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                        Last Name
                                    </label>
                                    <input type="text" class="w-full flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="...">
                                </div>

                                <!-- First Name -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                        First Name
                                    </label>
                                     <input type="text" class="w-full flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="...">
                                </div>

                                <!-- Middle Name -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                        Middle Name
                                    </label>
                                     <input type="text" class="w-full flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="...">
                                </div>

                                <!-- Suffix Name -->
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">
                                        Suffix Name
                                    </label>
                                    <input type="text" class="w-full flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="...">
                                </div>

                            </div>

                        </div>

                    </div> 

                </div> 

            </form>

            </div>


                        
                <!-- 3. BIG MODERN BOX (Personal Information) -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 p-6 mb-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">
                            <i class="fa-solid fa-user-pen text-blue-500 mr-2"></i>Personal Information
                        </h3>
                    </div>

                    <form>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">
                            
                            <!-- LEFT COLUMN -->
                            <div class="space-y-5">
                                <!-- Birthday -->
                                <div class="flex items-center gap-4">
                                    <label class="w-32 text-sm font-bold text-gray-700 shrink-0">Birthday:</label>
                                    <div class="flex gap-2 flex-1">
                                        <!-- Age Input (Small) -->
                                        <input type="number" class="w-16 px-3 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-center" placeholder="34">
                                        <!-- Date Input -->
                                        <input type="date" class="flex-1 px-3 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-gray-600">
                                    </div>
                                </div>

                                <!-- Birth Place -->
                                <div class="flex items-center gap-4">
                                    <label class="w-32 text-sm font-bold text-gray-700 shrink-0">Birth Place:</label>
                                    <input type="text" class="flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="STA. ANA MANILA">
                                </div>

                                <!-- Citizenship -->
                                <div class="flex items-center gap-4">
                                    <label class="w-32 text-sm font-bold text-gray-700 shrink-0">Citizenship:</label>
                                    <input type="text" class="flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="FILIPINO">
                                </div>

                                <!-- Gender -->
                                <div class="flex items-center gap-4">
                                    <label class="w-32 text-sm font-bold text-gray-700 shrink-0">Gender:</label>
                                    <select class="flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-gray-600 appearance-none cursor-pointer">
                                        <option value="">Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>

                                <!-- Civil Status -->
                                <div class="flex items-center gap-4">
                                    <label class="w-32 text-sm font-bold text-gray-700 shrink-0">Civil Status:</label>
                                    <select class="flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-gray-600 appearance-none cursor-pointer">
                                        <option value="single">SINGLE</option>
                                        <option value="married">MARRIED</option>
                                        <option value="widowed">WIDOWED</option>
                                        <option value="divorced">DIVORCED</option>
                                    </select>
                                </div>

                                <!-- Weight -->
                                <div class="flex items-center gap-4">
                                    <label class="w-32 text-sm font-bold text-gray-700 shrink-0">Weight:</label>
                                    <div class="relative flex-1">
                                        <input type="text" class="w-full px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all pr-12" placeholder="108">
                                        <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-500 font-medium">LBS.</span>
                                    </div>
                                </div>

                                <!-- Height -->
                                <div class="flex items-center gap-4">
                                    <label class="w-32 text-sm font-bold text-gray-700 shrink-0">Height:</label>
                                    <input type="text" class="flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="52">
                                </div>

                                <!-- Religion -->
                                <div class="flex items-center gap-4">
                                    <label class="w-32 text-sm font-bold text-gray-700 shrink-0">Religion:</label>
                                    <input type="text" class="flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="CATHOLIC">
                                </div>
                            </div>

                            <!-- RIGHT COLUMN -->
                            <div class="space-y-5">
                                <!-- House No -->
                                <div class="flex items-center gap-4">
                                    <label class="w-32 text-sm font-bold text-gray-700 shrink-0">House No:</label>
                                    <input type="text" class="flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="356">
                                </div>

                                <!-- Street -->
                                <div class="flex items-center gap-4">
                                    <label class="w-32 text-sm font-bold text-gray-700 shrink-0">Street:</label>
                                    <input type="text" class="flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="D. EDANG STS.">
                                </div>

                                <!-- Barangay -->
                                <div class="flex items-center gap-4">
                                    <label class="w-32 text-sm font-bold text-gray-700 shrink-0">Barangay:</label>
                                    <input type="text" class="flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="BRGY. 149 ZONE">
                                </div>

                                <!-- District -->
                                <div class="flex items-center gap-4">
                                    <label class="w-32 text-sm font-bold text-gray-700 shrink-0">District:</label>
                                    <input type="text" class="flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="">
                                </div>

                                <!-- City -->
                                <div class="flex items-center gap-4">
                                    <label class="w-32 text-sm font-bold text-gray-700 shrink-0">City:</label>
                                    <input type="text" class="flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="PASAY CITY">
                                </div>

                                <!-- Town -->
                                <div class="flex items-center gap-4">
                                    <label class="w-32 text-sm font-bold text-gray-700 shrink-0">Town:</label>
                                    <input type="text" class="flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="">
                                </div>

                                <!-- Contact -->
                                <div class="flex items-center gap-4">
                                    <label class="w-32 text-sm font-bold text-gray-700 shrink-0">Contact:</label>
                                    <input type="text" class="flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="">
                                </div>

                                <!-- Cphone -->
                                <div class="flex items-center gap-4">
                                    <label class="w-32 text-sm font-bold text-gray-700 shrink-0">phone:</label>
                                    <input type="text" class="flex-1 px-4 py-2 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="$EA237126">
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                    <!-- 3. TWO MODERN BOXES (Side by Side) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- 3B. Education -->
                <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">
                            <i class="fa-solid fa-graduation-cap text-purple-600 mr-2"></i>Education
                        </h3>
                    </div>
                    <form>
                        <!-- Header for School / Year Grad -->
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-24 shrink-0"></div> <!-- Spacer for label alignment -->
                            <div class="flex-1 grid grid-cols-3 gap-3">
                                <span class="col-span-2 text-xs font-bold text-gray-500 uppercase tracking-wider pl-3">School</span>
                                <span class="col-span-1 text-xs font-bold text-gray-500 uppercase tracking-wider pl-3">Year Grad</span>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <!-- Primary -->
                            <div class="flex items-center gap-4">
                                <label class="w-24 text-sm font-bold text-gray-700 shrink-0">Primary:</label>
                                <div class="flex-1 grid grid-cols-3 gap-3">
                                    <input type="text" class="col-span-2 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                    <input type="text" class="col-span-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                </div>
                            </div>
                            <!-- Secondary -->
                            <div class="flex items-center gap-4">
                                <label class="w-24 text-sm font-bold text-gray-700 shrink-0">Secondary:</label>
                                <div class="flex-1 grid grid-cols-3 gap-3">
                                    <input type="text" class="col-span-2 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                    <input type="text" class="col-span-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                </div>
                            </div>
                            <!-- College -->
                            <div class="flex items-center gap-4">
                                <label class="w-24 text-sm font-bold text-gray-700 shrink-0">College:</label>
                                <div class="flex-1 grid grid-cols-3 gap-3">
                                    <input type="text" class="col-span-2 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                    <input type="text" class="col-span-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                </div>
                            </div>
                            <!-- Degree (Full width input based on image layout logic) -->
                            <div class="flex items-center gap-4">
                                <label class="w-24 text-sm font-bold text-gray-700 shrink-0">Degree:</label>
                                <input type="text" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                            </div>
                            <!-- Major -->
                            <div class="flex items-center gap-4">
                                <label class="w-24 text-sm font-bold text-gray-700 shrink-0">Major:</label>
                                <input type="text" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                            </div>
                            <!-- Post Grad -->
                            <div class="flex items-center gap-4">
                                <label class="w-24 text-sm font-bold text-gray-700 shrink-0">Post Grad:</label>
                                <div class="flex-1 grid grid-cols-3 gap-3">
                                    <input type="text" class="col-span-2 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                    <input type="text" class="col-span-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                                </div>
                            </div>
                            <!-- Course -->
                            <div class="flex items-center gap-4">
                                <label class="w-24 text-sm font-bold text-gray-700 shrink-0">Course:</label>
                                <input type="text" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                            </div>
                        </div>
                    </form>
                </div>

            <!-- 3A. Mandatory Numbers -->
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fa-solid fa-id-card text-blue-600 mr-2"></i>Mandatory Numbers
                    </h3>
                </div>
                <form>
                    <div class="space-y-4">
                        <!-- Header for School / Year Grad -->
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-24 shrink-0"></div> <!-- Spacer for label alignment -->
                        <div class="flex-1 grid grid-cols-3 gap-3">
                            <span class="col-span-2 text-xs font-bold text-gray-500 uppercase tracking-wider pl-3">INFORMATION</span>
                        </div>
                    </div>
                        <!-- SSS -->
                        <div class="flex items-center gap-4">
                            <label class="w-24 text-sm font-bold text-gray-700 shrink-0">SSS:</label>
                            <input type="text" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="3462492091">
                        </div>
                        <!-- PhilHealth -->
                        <div class="flex items-center gap-4">
                            <label class="w-24 text-sm font-bold text-gray-700 shrink-0">PhilHealth:</label>
                            <input type="text" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="620267885789">
                        </div>
                        <!-- Pag-ibig -->
                        <div class="flex items-center gap-4">
                            <label class="w-24 text-sm font-bold text-gray-700 shrink-0">Pag-ibig:</label>
                            <input type="text" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="121181838232">
                        </div>
                        <!-- TIN -->
                        <div class="flex items-center gap-4">
                            <label class="w-24 text-sm font-bold text-gray-700 shrink-0">TIN:</label>
                            <input type="text" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="761594402">
                        </div>
                    </div>
                </form>
            </div>
        </div>

            <!-- 4. BIG MODERN BOX (Recent Updates) -->
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800"><i class="fa-solid fa-clock-rotate-left text-orange-500 mr-2"></i>Recent Employee Updates</h3>
                    <button class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</button>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-lg transition">
                        <div class="bg-green-100 text-green-600 p-2 rounded-lg"><i class="fa-solid fa-user-plus"></i></div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">New employee onboarded - Maria Santos</p>
                            <p class="text-xs text-gray-500">2 hours ago</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-700 rounded-full">New</span>
                    </div>
                    <div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-lg transition">
                        <div class="bg-blue-100 text-blue-600 p-2 rounded-lg"><i class="fa-solid fa-arrow-up"></i></div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">Promotion - Juan Dela Cruz to Senior Developer</p>
                            <p class="text-xs text-gray-500">5 hours ago</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">Promotion</span>
                    </div>
                    <div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-lg transition">
                        <div class="bg-orange-100 text-orange-600 p-2 rounded-lg"><i class="fa-solid fa-file-pen"></i></div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">Record update - Contact info for EMP-005</p>
                            <p class="text-xs text-gray-500">Yesterday</p>
                        </div>
                        <span class="px-2 py-1 text-xs font-medium bg-orange-100 text-orange-700 rounded-full">Update</span>
                    </div>
                </div>
            </div>

            <!-- 5. BIG MODERN BOX (Upcoming Schedule) -->
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800"><i class="fa-solid fa-calendar-check text-green-600 mr-2"></i>Upcoming Schedule</h3>
                    <button class="text-sm text-blue-600 hover:text-blue-700 font-medium">Calendar</button>
                </div>
                <div class="space-y-3">
                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                        <div class="bg-green-100 text-green-600 px-3 py-2 rounded-lg text-center min-w-[60px]">
                            <p class="text-lg font-bold leading-none">15</p>
                            <p class="text-xs">AUG</p>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">Team Building - Engineering Dept</p>
                            <p class="text-xs text-gray-500">All day event</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                        <div class="bg-blue-100 text-blue-600 px-3 py-2 rounded-lg text-center min-w-[60px]">
                            <p class="text-lg font-bold leading-none">20</p>
                            <p class="text-xs">AUG</p>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800">Payroll Cut-off Period</p>
                            <p class="text-xs text-gray-500">Deadline: 5:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 6. BIG MODERN BOX (Documents & Compliance) -->
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-800"><i class="fa-solid fa-file-invoice text-purple-600 mr-2"></i>Documents & Compliance</h3>
                    <button class="text-sm text-blue-600 hover:text-blue-700 font-medium">Manage</button>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="border border-gray-200 rounded-xl p-4 hover:border-green-300 transition">
                        <div class="flex items-center gap-3">
                            <div class="bg-purple-100 text-purple-600 p-2 rounded-lg"><i class="fa-solid fa-file-pdf"></i></div>
                            <div>
                                <p class="font-medium text-gray-800 text-sm">Employment Contracts</p>
                                <p class="text-xs text-gray-500">1,248 files</p>
                            </div>
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-xl p-4 hover:border-green-300 transition">
                        <div class="flex items-center gap-3">
                            <div class="bg-blue-100 text-blue-600 p-2 rounded-lg"><i class="fa-solid fa-id-card"></i></div>
                            <div>
                                <p class="font-medium text-gray-800 text-sm">Government IDs</p>
                                <p class="text-xs text-gray-500">1,180 verified</p>
                            </div>
                        </div>
                    </div>
                    <div class="border border-gray-200 rounded-xl p-4 hover:border-green-300 transition">
                        <div class="flex items-center gap-3">
                            <div class="bg-green-100 text-green-600 p-2 rounded-lg"><i class="fa-solid fa-certificate"></i></div>
                            <div>
                                <p class="font-medium text-gray-800 text-sm">Certifications</p>
                                <p class="text-xs text-gray-500">856 records</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

  
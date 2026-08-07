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



            <!-- 4. BIG MODERN BOX (Employment Information) -->
            <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fa-solid fa-briefcase text-indigo-600 mr-2"></i>Employment Information
                    </h3>
                </div>

                <form>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-5">
                        
                        <!-- COLUMN 1 -->
                        <div class="space-y-5">
                            <!-- Status -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Status:</label>
                                <select class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all text-gray-600 appearance-none cursor-pointer">
                                    <option value="regular">R-Regular</option>
                                    <option value="probationary">Probationary</option>
                                    <option value="contractual">Contractual</option>
                                </select>
                            </div>

                            <!-- Remarks -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Remarks:</label>
                                <input type="text" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" placeholder="09-1-0152">
                            </div>

                            <!-- Position -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Position:</label>
                                <select class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all text-gray-600 appearance-none cursor-pointer">
                                    <option value="supervisor">SUPERVISOR</option>
                                    <option value="manager">MANAGER</option>
                                    <option value="staff">STAFF</option>
                                </select>
                            </div>

                            <!-- Company Connected -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Company:</label>
                                <input type="text" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" placeholder="W GLOBAL REALTY, INC - HOUSEKEEPING">
                            </div>

                            <!-- Branch -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Branch:</label>
                                <select class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all text-gray-600 appearance-none cursor-pointer">
                                    <option value="">>> Select branch</option>
                                    <option value="main">Main Branch</option>
                                    <option value="north">North Branch</option>
                                </select>
                            </div>

                            <!-- Department -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Department:</label>
                                <select class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all text-gray-600 appearance-none cursor-pointer">
                                    <option value="ladies">Ladies accessories</option>
                                    <option value="mens">Mens wear</option>
                                    <option value="electronics">Electronics</option>
                                </select>
                            </div>

                            <!-- Contract Information (Header) -->
                            <div class="pt-4 border-t border-gray-200">
                                <h4 class="text-sm font-bold text-indigo-600 uppercase tracking-wider mb-4">Contract Information</h4>
                            </div>

                            <!-- Date Hired -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Date Hired:</label>
                                <input type="date" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all text-gray-600">
                            </div>

                            <!-- Date Resigned -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Date Resigned:</label>
                                <input type="date" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all text-gray-600">
                            </div>
                        </div>

                        <!-- COLUMN 2 -->
                        <div class="space-y-5">
                            <!-- Start Contract -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Start Contract:</label>
                                <input type="date" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all text-gray-600">
                            </div>

                            <!-- End Contract -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">End Contract:</label>
                                <input type="date" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all text-gray-600">
                            </div>

                            <!-- Rate Basis -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Rate Basis:</label>
                                <select class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all text-gray-600 appearance-none cursor-pointer">
                                    <option value="daily">Daily</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="hourly">Hourly</option>
                                </select>
                            </div>

                            <!-- Month No -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Month No:</label>
                                <input type="number" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" placeholder="6">
                            </div>

                            <!-- Hourly Rate -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Hourly Rate:</label>
                                <input type="number" step="0.01" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" placeholder="86.63">
                            </div>

                            <!-- Daily Rate -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Daily Rate:</label>
                                <input type="number" step="0.01" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" placeholder="645">
                            </div>

                            <!-- Monthly Rate -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Monthly Rate:</label>
                                <input type="number" step="0.01" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" placeholder="14821.6">
                            </div>

                            <!-- Date Reg -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Date Reg:</label>
                                <input type="date" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all text-gray-600">
                            </div>

                            <!-- Date Prob -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Date Prob:</label>
                                <input type="date" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all text-gray-600">
                            </div>
                        </div>

                        <!-- COLUMN 3 -->
                        <div class="space-y-5">
                            <!-- Insurance No -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Insurance No:</label>
                                <input type="text" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" placeholder="">
                            </div>

                            <!-- Agency Fee -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Agency Fee:</label>
                                <input type="number" step="0.01" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" placeholder="12">
                            </div>

                            <!-- Agency -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Agency:</label>
                                <select class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all text-gray-600 appearance-none cursor-pointer">
                                    <option value="SPAI">SPAI</option>
                                    <option value="none">None</option>
                                </select>
                            </div>

                            <!-- Account No -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Account No:</label>
                                <input type="text" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" placeholder="109661898696">
                            </div>

                            <!-- Expanded Tax -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Expanded Tax:</label>
                                <input type="text" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" placeholder="">
                            </div>

                            <!-- Allowance -->
                            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                                <label class="sm:w-32 text-sm font-bold text-gray-700 shrink-0">Allowance:</label>
                                <input type="number" step="0.01" class="flex-1 px-4 py-2.5 bg-gray-100 border-transparent rounded-lg text-sm focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all" placeholder="0">
                            </div>

                            <!-- With Ecol Checkbox -->
                            <div class="flex items-center gap-3 pt-2">
                                <input type="checkbox" id="withEcol" class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 focus:ring-2 cursor-pointer">
                                <label for="withEcol" class="text-sm font-bold text-gray-700 cursor-pointer">With Ecol</label>
                            </div>
                        </div>

                    </div>
                </form>
            </div>



           <!-- 5. BIG MODERN BOX (Employment History) -->
<div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-shadow duration-300 border border-gray-100 p-6 mb-6">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold text-gray-800">
            <i class="fa-solid fa-clock-rotate-left text-indigo-600 mr-2"></i>Employment History
        </h3>
    </div>

    <!-- Table Container (Responsive) -->
    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-200">
                <tr>
                    <th scope="col" class="px-6 py-3 font-bold">Agency</th>
                    <th scope="col" class="px-6 py-3 font-bold">ControlNo</th>
                    <th scope="col" class="px-6 py-3 font-bold">ClientName</th>
                    <th scope="col" class="px-6 py-3 font-bold">StartContract</th>
                    <th scope="col" class="px-6 py-3 font-bold">EndContract</th>
                    <th scope="col" class="px-6 py-3 font-bold text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <!-- Empty State Row -->
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fa-solid fa-inbox text-4xl text-gray-300 mb-3"></i>
                            <p class="text-sm font-medium text-gray-500">No employment history records found.</p>
                            <p class="text-xs text-gray-400 mt-1">Click "Add Record" to create a new entry.</p>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
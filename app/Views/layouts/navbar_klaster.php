<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<nav x-data="{ open: false, dropdownOpen: false }" 
     class="bg-gradient-to-r from-blue-700 via-blue-800 to-blue-900 px-6 py-4 shadow-2xl fixed w-full top-0 z-50 backdrop-blur-md border-b border-blue-600/30 mb-24">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <!-- Logo/Brand Section - Enlarged -->
        <div class="flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-white/15 backdrop-blur-md flex items-center justify-center shadow-lg border border-blue-500/20">
                <img src="<?= base_url('assets/img/LogoKKLA.png') ?>" alt="Logo" class="w-10 h-10 object-contain">
            </div>
            <div>
                <h1 class="text-xl md:text-2xl font-bold tracking-tight text-white">Evaluasi SIPANDAKABULAN</h1>
                <p class="text-sm text-blue-200/90 hidden md:block">Kabupaten Tasikmalaya</p>
            </div>
        </div>

        <!-- Desktop Menu - Enlarged -->
        <div class="hidden md:flex items-center space-x-6">
            <a href="<?= site_url('dashboard/operator') ?>"
                class="relative px-4 py-3 text-blue-100 hover:text-white transition-all duration-200 group">
                <span class="flex items-center text-base font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Dashboard
                </span>
                <span class="absolute bottom-2 left-4 right-4 h-1 bg-sky-400 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left rounded-full"></span>
            </a>
            
            <a href="<?= site_url('dashboard/pengumuman_user') ?>"
                class="relative px-4 py-3 text-blue-100 hover:text-white transition-all duration-200 group">
                <span class="flex items-center text-base font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    Pengumuman
                </span>
                <span class="absolute bottom-2 left-4 right-4 h-1 bg-sky-400 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left rounded-full"></span>
            </a>
            
            <a href="<?= site_url('dashboard/tutorial') ?>"
                class="relative px-4 py-3 text-blue-100 hover:text-white transition-all duration-200 group">
                <span class="flex items-center text-base font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    Tutorial
                </span>
                <span class="absolute bottom-2 left-4 right-4 h-1 bg-sky-400 scale-x-0 group-hover:scale-x-100 transition-transform duration-300 origin-left rounded-full"></span>
            </a>

            <!-- Akun Dropdown - Enlarged -->
            <div class="relative">
                <button @click="dropdownOpen = !dropdownOpen"
                    class="flex items-center space-x-2 px-4 py-2.5 rounded-xl bg-blue-800/40 hover:bg-blue-700/60 transition-colors duration-200 border border-blue-600/30">
                    <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-lg shadow-sm">
                        <?= strtoupper(substr(session()->get('email'), 0, 1)) ?>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-200 transition-transform duration-200"
                        :class="{'rotate-180': dropdownOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="dropdownOpen" @click.outside="dropdownOpen = false"
                    x-transition:enter="transition ease-out duration-200" 
                    x-transition:enter-start="opacity-0 translate-y-1" 
                    x-transition:enter-end="opacity-100 translate-y-0" 
                    x-transition:leave="transition ease-in duration-150" 
                    x-transition:leave-start="opacity-100 translate-y-0" 
                    x-transition:leave-end="opacity-0 translate-y-1"
                    class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-2xl overflow-hidden z-50 border border-gray-200">
                    <div class="px-5 py-4 border-b bg-gray-50">
                        <p class="text-base font-semibold text-gray-900 truncate"><?= esc(session()->get('email')) ?></p>
                        <p class="text-sm text-blue-600 font-medium mt-1"><?= esc(session()->get('role')) ?></p>
                    </div>
                    
            

                    <form method="POST" action="<?= site_url('logout') ?>">
                        <?= csrf_field() ?>
                        <button type="submit"
                            class="block w-full text-left px-5 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-colors flex items-center border-t border-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="text-red-500 font-semibold">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Button - Enlarged -->
        <button @click="open = !open"
            class="md:hidden p-3 rounded-xl text-blue-200 hover:text-white hover:bg-blue-700/40 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-blue-900">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    :d="open ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'" />
            </svg>
        </button>
    </div>

    <!-- Mobile Menu Dropdown - Enlarged -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="md:hidden bg-blue-800/95 px-5 pt-3 pb-5 space-y-3 mt-3 rounded-b-2xl shadow-xl backdrop-blur-sm">

        <a href="<?= site_url('dashboard/operator') ?>"
            class="flex items-center px-4 py-3 rounded-xl text-blue-100 hover:bg-blue-700/60 hover:text-white transition-colors text-base">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
            </svg>
            Dashboard
        </a>

        <a href="<?= site_url('dashboard/pengumuman_user') ?>"
            class="flex items-center px-4 py-3 rounded-xl text-blue-100 hover:bg-blue-700/60 hover:text-white transition-colors text-base">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            Pengumuman
        </a>

        <a href="<?= site_url('dashboard/tutorial') ?>"
            class="flex items-center px-4 py-3 rounded-xl text-blue-100 hover:bg-blue-700/60 hover:text-white transition-colors text-base">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
            </svg>
            Tutorial
        </a>

        <div class="pt-3 border-t border-blue-700/50 mt-3">
            <div class="px-4 py-3 text-base text-blue-100">
                <p class="font-semibold truncate"><?= esc(session()->get('email')) ?></p>
                <p class="text-sm text-blue-300 font-medium mt-1"><?= esc(session()->get('role')) ?></p>
            </div>
            <form method="POST" action="<?= site_url('logout') ?>">
                <?= csrf_field() ?>
                <button type="submit"
                    class="w-full flex items-center px-4 py-3 text-base text-red-300 hover:bg-blue-700/60 hover:text-white rounded-xl transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>
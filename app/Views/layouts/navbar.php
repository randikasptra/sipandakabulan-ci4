<!-- Pastikan Alpine.js disertakan -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<nav x-data="{ open: false, dropdownOpen: false }"
    class="bg-gradient-to-r from-blue-700 to-blue-900 px-4 py-3 shadow-lg sticky top-0 z-50">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <!-- Logo/Brand Section -->
        <div class="flex items-center space-x-3">
            <img src="<?= base_url('assets/img/LogoKKLA.png') ?>" alt="Logo" class="w-10 h-10 rounded-lg shadow-sm">
            <div>
                <h1 class="text-lg md:text-xl font-bold tracking-tight text-white">Evaluasi SIPANDAKABULAN</h1>
                <p class="text-xs text-blue-200 hidden md:block">Kabupaten Tasikmalaya</p>
            </div>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex items-center space-x-6">
            <a href="<?= site_url('dashboard/operator') ?>"
                class="relative px-2 py-1 text-blue-100 hover:text-white transition-colors duration-200 group">
                Dashboard
                <span
                    class="absolute bottom-0 left-0 w-0 h-0.5 bg-sky-300 transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="<?= site_url('dashboard/operator') ?>"
                class="relative px-2 py-1 text-blue-100 hover:text-white transition-colors duration-200 group">
                Pengumuman
                <span
                    class="absolute bottom-0 left-0 w-0 h-0.5 bg-sky-300 transition-all duration-300 group-hover:w-full"></span>
            </a>
            <a href="<?= site_url('dashboard/tutorial') ?>"
                class="text-blue-100 hover:text-white transition-colors duration-200 font-medium px-3 py-2 rounded-lg hover:bg-blue-600/30">
                Tutorial
            </a>

            <!-- Akun Dropdown -->
            <div class="relative">
                <button @click="dropdownOpen = !dropdownOpen"
                    class="flex items-center text-blue-100 hover:text-white px-2 py-1 transition-colors duration-200">
                    Akun
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transition-transform duration-200"
                        :class="{'rotate-180': dropdownOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="dropdownOpen" @click.outside="dropdownOpen = false"
                    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                    <div class="px-4 py-2 text-sm text-gray-700 border-b">
                        <p class="font-medium"><?= esc($user_email) ?></p>
                        <p class="text-xs text-blue-600"><?= esc($user_role) ?></p>
                    </div>
                    <form method="POST" action="<?= site_url('logout') ?>">
                        <?= csrf_field() ?>
                        <button type="submit"
                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-red-600 transition-colors">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </div>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Button -->
        <button @click="open = !open"
            class="md:hidden p-2 rounded-md text-blue-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    :d="open ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'" />
            </svg>
        </button>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div x-show="open" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="md:hidden bg-blue-800 px-4 pt-2 pb-4 space-y-2 mt-2 rounded-b-lg shadow-inner">

        <a href="<?= site_url('dashboard/operator') ?>"
            class="block px-3 py-2 rounded-md text-blue-100 hover:bg-blue-700 hover:text-white transition-colors">
            Dashboard
        </a>

        <a href="<?= site_url('dashboard/tutorial') ?>"
            class="block px-3 py-2 rounded-md text-blue-100 hover:bg-blue-700 hover:text-white transition-colors">
            Tutorial
        </a>

        <div class="pt-2 border-t border-blue-700 mt-2">
            <div class="px-3 py-2 text-sm text-blue-200">
                <p><?= esc($user_email) ?></p>
                <p class="text-xs text-blue-300"><?= esc($user_role) ?></p>
            </div>
            <form method="POST" action="<?= site_url('logout') ?>">
                <?= csrf_field() ?>
                <button type="submit"
                    class="w-full flex items-center px-3 py-2 text-sm text-red-200 hover:bg-blue-700 hover:text-white rounded-md transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
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
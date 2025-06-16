<aside class="fixed left-0 w-72 bg-gradient-to-b from-blue-800 to-blue-900 text-white flex flex-col min-h-screen shadow-2xl z-10">
  <!-- App Header with Glass Effect -->
  <div class="px-6 py-5 border-b border-blue-700 bg-blue-800/50 backdrop-blur-md">
    <div class="flex flex-col items-center text-center">
      <!-- Logo with Neumorphism Effect -->
      <div class="relative">
        <div
          class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center shadow-md">
          <i class="fas fa-user-shield text-xl text-white"></i>
        </div>
        <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 rounded-full border-2 border-blue-800"></span>
      </div>

      <h1 class="text-2xl font-bold text-white">
        SIPANDAKABULAN
      </h1>
      <p class="text-xs text-blue-200 mt-1">Administration Panel</p>
    </div>
  </div>


  <!-- Navigation Menu -->
  <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
    <!-- Dashboard -->
    <a href="/dashboard/admin"
      class="flex items-center py-3 px-4 rounded-xl hover:bg-blue-700/50 transition-all duration-200 group">
      <div
        class="w-8 h-8 rounded-lg bg-blue-700/70 group-hover:bg-blue-600 flex items-center justify-center mr-3 transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
          class="w-5 h-5 text-blue-300 group-hover:text-white">
          <path
            d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" />
          <path
            d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
        </svg>
      </div>
      <span class="text-blue-100 group-hover:text-white">Dashboard</span>
    </a>

    <!-- Data User -->
    <a href="/dashboard/users"
      class="flex items-center py-3 px-4 rounded-xl hover:bg-blue-700/50 transition-all duration-200 group">
      <div
        class="w-8 h-8 rounded-lg bg-blue-700/70 group-hover:bg-blue-600 flex items-center justify-center mr-3 transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
          class="w-5 h-5 text-blue-300 group-hover:text-white">
          <path fill-rule="evenodd"
            d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z"
            clip-rule="evenodd" />
          <path
            d="M5.082 14.254a8.287 8.287 0 00-1.308 5.135 9.687 9.687 0 01-1.764-.44l-.115-.04a.563.563 0 01-.373-.487l-.01-.121a3.75 3.75 0 013.57-4.047zM20.226 19.389a8.287 8.287 0 00-1.308-5.135 3.75 3.75 0 013.57 4.047l-.01.121a.563.563 0 01-.373.486l-.115.04c-.567.2-1.156.349-1.764.441z" />
        </svg>
      </div>
      <span class="text-blue-100 group-hover:text-white">Data User</span>
    </a>

    <!-- Approve Data -->
    <a href="/dashboard/approve_list"
      class="flex items-center py-3 px-4 rounded-xl hover:bg-blue-700/50 transition-all duration-200 group">
      <div
        class="w-8 h-8 rounded-lg bg-blue-700/70 group-hover:bg-blue-600 flex items-center justify-center mr-3 transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
          class="w-5 h-5 text-blue-300 group-hover:text-white">
          <path fill-rule="evenodd"
            d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z"
            clip-rule="evenodd" />
        </svg>
      </div>
      <span class="text-blue-100 group-hover:text-white">Approve Data</span>
    </a>

    <!-- Pengumuman -->
    <a href="/dashboard/pengumuman_list"
      class="flex items-center py-3 px-4 rounded-xl hover:bg-blue-700/50 transition-all duration-200 group">
      <div
        class="w-8 h-8 rounded-lg bg-blue-700/70 group-hover:bg-blue-600 flex items-center justify-center mr-3 transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
          class="w-5 h-5 text-blue-300 group-hover:text-white">
          <path
            d="M5.85 3.5a.75.75 0 00-1.117-1 9.719 9.719 0 00-2.348 4.876.75.75 0 001.479.248A8.219 8.219 0 015.85 3.5zM19.267 2.5a.75.75 0 10-1.118 1 8.22 8.22 0 011.987 4.124.75.75 0 001.48-.248A9.72 9.72 0 0019.266 2.5z" />
          <path fill-rule="evenodd"
            d="M12 2.25A6.75 6.75 0 005.25 9v.75a8.217 8.217 0 01-2.119 5.52.75.75 0 00.298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 107.48 0 24.583 24.583 0 004.83-1.244.75.75 0 00.298-1.205 8.217 8.217 0 01-2.118-5.52V9A6.75 6.75 0 0012 2.25zM9.75 18c0-.034 0-.067.002-.1a25.05 25.05 0 004.496 0l.002.1a2.25 2.25 0 11-4.5 0z"
            clip-rule="evenodd" />
        </svg>
      </div>
      <span class="text-blue-100 group-hover:text-white">Pengumuman</span>
    </a>

    <!-- Pengaturan -->
    <!-- <a href="/dashboard/settings" class="flex items-center py-3 px-4 rounded-xl hover:bg-blue-700/50 transition-all duration-200 group">
      <div class="w-8 h-8 rounded-lg bg-blue-700/70 group-hover:bg-blue-600 flex items-center justify-center mr-3 transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-blue-300 group-hover:text-white">
          <path fill-rule="evenodd" d="M11.078 2.25c-.917 0-1.699.663-1.85 1.567L9.05 4.889c-.02.12-.115.26-.297.348a7.493 7.493 0 00-.986.57c-.166.115-.334.126-.45.083L6.3 5.508a1.875 1.875 0 00-2.282.819l-.922 1.597a1.875 1.875 0 00.432 2.385l.84.692c.095.078.17.229.154.43a7.598 7.598 0 000 1.139c.015.2-.059.352-.153.43l-.841.692a1.875 1.875 0 00-.432 2.385l.922 1.597a1.875 1.875 0 002.282.818l1.019-.382c.115-.043.283-.031.45.082.312.214.641.405.985.57.182.088.277.228.297.35l.178 1.071c.151.904.933 1.567 1.85 1.567h1.844c.916 0 1.699-.663 1.85-1.567l.178-1.072c.02-.12.114-.26.297-.349.344-.165.673-.356.985-.57.167-.114.335-.125.45-.082l1.02.382a1.875 1.875 0 002.28-.819l.923-1.597a1.875 1.875 0 00-.432-2.385l-.84-.692c-.095-.078-.17-.229-.154-.43a7.614 7.614 0 000-1.139c-.016-.2.059-.352.153-.43l.84-.692c.708-.582.891-1.59.433-2.385l-.922-1.597a1.875 1.875 0 00-2.282-.818l-1.02.382c-.114.043-.282.031-.449-.083a7.49 7.49 0 00-.985-.57c-.183-.087-.277-.227-.297-.348l-.179-1.072a1.875 1.875 0 00-1.85-1.567h-1.843z" clip-rule="evenodd" />
          <path d="M12 15.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5z" />
        </svg>
      </div>
      <span class="text-blue-100 group-hover:text-white">Pengaturan</span>
    </a> -->

    <!-- Logout Section -->
    <div class="pt-6 mt-6 border-t border-blue-700/50">
      <form method="POST" action="<?= site_url('logout') ?>" class="w-full">
        <?= csrf_field() ?>
        <button type="submit"
          class="flex items-center w-full py-3 px-4 rounded-xl hover:bg-red-600/20 transition-all duration-200 group">
          <div
            class="w-8 h-8 rounded-lg bg-blue-700/70 group-hover:bg-red-500/20 flex items-center justify-center mr-3 transition-all duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
              class="w-5 h-5 text-blue-300 group-hover:text-red-400">
              <path fill-rule="evenodd"
                d="M7.5 3.75A1.5 1.5 0 006 5.25v13.5a1.5 1.5 0 001.5 1.5h6a1.5 1.5 0 001.5-1.5V15a.75.75 0 011.5 0v3.75a3 3 0 01-3 3h-6a3 3 0 01-3-3V5.25a3 3 0 013-3h6a3 3 0 013 3V9A.75.75 0 0115 9V5.25a1.5 1.5 0 00-1.5-1.5h-6zm10.72 4.72a.75.75 0 011.06 0l3 3a.75.75 0 010 1.06l-3 3a.75.75 0 11-1.06-1.06l1.72-1.72H9a.75.75 0 010-1.5h10.94l-1.72-1.72a.75.75 0 010-1.06z"
                clip-rule="evenodd" />
            </svg>
          </div>
          <span class="text-blue-100 group-hover:text-red-300">Logout</span>
        </button>
      </form>
    </div>
  </nav>
</aside>
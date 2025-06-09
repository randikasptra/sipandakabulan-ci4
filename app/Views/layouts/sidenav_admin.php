<aside class="w-64 bg-blue-900 text-white flex flex-col min-h-screen">
  <div class="px-6 py-4 text-2xl font-bold border-b border-blue-700">
    SIPANDAKABULAN
  </div>
  <nav class="flex-1 px-4 py-6 space-y-4">

    <!-- Dashboard -->
    <a href="/dashboard/admin" class="flex items-center py-2 px-4 rounded hover:bg-blue-700">
      <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m4-8h8v8a2 2 0 01-2 2H5a2 2 0 01-2-2v-8h8z" />
      </svg>
      Dashboard
    </a>

    <!-- Data User -->
    <a href="/dashboard/users" class="flex items-center py-2 px-4 rounded hover:bg-blue-700">
      <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 20h14a2 2 0 002-2v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2a2 2 0 002 2z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg>
      Data User
    </a>


    <!-- Klaster -->
    <!-- <a href="/dashboard/klaster" class="flex items-center py-2 px-4 rounded hover:bg-blue-700">
      <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h10" />
      </svg>
      Klaster
    </a> -->

    <!-- Approve Data -->
    <a href="/dashboard/approval" class="flex items-center py-2 px-4 rounded hover:bg-blue-700">
      <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
      </svg>
      Approve Data
    </a>

    <!-- Laporan -->
    <a href="/dashboard/laporan" class="flex items-center py-2 px-4 rounded hover:bg-blue-700">
      <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6h6v6M9 7V4h6v3M4 6h16M4 20h16" />
      </svg>
      Laporan
    </a>

    <!-- Pengaturan -->
    <a href="/dashboard/settings" class="flex items-center py-2 px-4 rounded hover:bg-blue-700">
      <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M11 3h2m-1 0v4m-4.243 1.757l2.829-2.828M12 12a3 3 0 100-6 3 3 0 000 6zM3 12h4m13 0h-4m1.757 4.243l-2.829 2.828M13 21v-4m-6.243-1.757l2.829-2.828" />
      </svg>
      Pengaturan
    </a>

    <!-- Logout -->
    <a href="/logout" class="flex items-center py-2 px-4 rounded hover:bg-blue-700">
      <svg class="h-5 w-5 mr-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a1 1 0 01-1 1H5a1 1 0 01-1-1V7a1 1 0 011-1h7a1 1 0 011 1v1" />
      </svg>
      Logout
    </a>
    <form method="POST" action="<?= site_url('logout') ?>" class="inline my-auto">
      <?= csrf_field() ?>
      <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-4 rounded-full text-sm">
        Logout
      </button>
    </form>

  </nav>
</aside>
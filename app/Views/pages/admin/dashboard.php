<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - SIPANDAKABULAN</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
  <!-- Sidebar -->
  <div class="flex min-h-screen">
   <aside class="w-64 bg-blue-900 text-white flex flex-col min-h-screen">
  <div class="px-6 py-4 text-2xl font-bold border-b border-blue-700">
    SIPANDAKABULAN
  </div>
  <nav class="flex-1 px-4 py-6 space-y-4">
    <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-blue-700">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m4-8h8v8a2 2 0 01-2 2H5a2 2 0 01-2-2v-8h8z" />
      </svg>
      Dashboard
    </a>
    
    <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-blue-700">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-3-3h-2.586a1 1 0 00-.707.293l-1.414 1.414A1 1 0 0114.586 17H13" />
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20H2v-2a3 3 0 013-3h2.586a1 1 0 01.707.293l1.414 1.414A1 1 0 0110.414 17H12" />
      </svg>
      Kelembagaan
    </a>

    <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-blue-700">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h10" />
      </svg>
      Klaster
    </a>

    <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-blue-700">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6h6v6M9 7V4h6v3M4 6h16M4 20h16" />
      </svg>
      Berkas
    </a>

    <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-blue-700">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A9 9 0 0112 3v0a9 9 0 016.879 14.804M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
      </svg>
      Pengguna
    </a>

    <a href="#" class="flex items-center py-2 px-4 rounded hover:bg-blue-700">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a1 1 0 01-1 1H5a1 1 0 01-1-1V7a1 1 0 011-1h7a1 1 0 011 1v1" />
      </svg>
      Logout
    </a>
  </nav>
</aside>


    <!-- Main Content -->
    <main class="flex-1 p-8">
      <!-- Header -->
      <div class="bg-white p-6 rounded-lg shadow-md flex flex-col md:flex-row justify-between items-center mb-8">
        <div>
          <h2 class="text-2xl font-bold mb-2">Selamat Datang, Admin SIPANDAKABULAN!</h2>
          <p class="text-gray-600">
            Anda login sebagai <span class="font-semibold text-blue-800">Administrator</span>
          </p>
        </div>
        <div class="mt-4 md:mt-0 text-center">
          <p class="text-gray-700">Pantau progres pengisian data kelembagaan setiap kabupaten.</p>
        </div>
      </div>

      <!-- Statistik atau Ringkasan -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-md">
          <p class="text-gray-500">Total Kabupaten</p>
          <p class="text-3xl font-bold">34</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
          <p class="text-gray-500">Sudah Submit</p>
          <p class="text-3xl font-bold text-green-600">28</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
          <p class="text-gray-500">Belum Submit</p>
          <p class="text-3xl font-bold text-red-500">6</p>
        </div>
      </div>

      <!-- Tabel Placeholder -->
      <div class="mt-8">
        <h3 class="text-xl font-bold mb-4">Status Pengisian Kabupaten</h3>
        <div class="bg-white p-4 rounded-lg shadow-md overflow-x-auto">
          <table class="min-w-full table-auto">
            <thead class="bg-blue-800 text-white">
              <tr>
                <th class="px-4 py-2 text-left">No</th>
                <th class="px-4 py-2 text-left">Kabupaten</th>
                <th class="px-4 py-2 text-left">Status</th>
                <th class="px-4 py-2 text-left">Nilai EM</th>
                <th class="px-4 py-2 text-left">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <tr class="border-b">
                <td class="px-4 py-2">1</td>
                <td class="px-4 py-2">Kab. Tasikmalaya</td>
                <td class="px-4 py-2 text-green-600 font-semibold">Sudah Submit</td>
                <td class="px-4 py-2">805.2</td>
                <td class="px-4 py-2">
                  <button class="text-blue-600 hover:underline">Lihat Detail</button>
                </td>
              </tr>
              <tr class="border-b">
                <td class="px-4 py-2">2</td>
                <td class="px-4 py-2">Kab. Bandung</td>
                <td class="px-4 py-2 text-red-500 font-semibold">Belum Submit</td>
                <td class="px-4 py-2">-</td>
                <td class="px-4 py-2">
                  <button class="text-blue-600 hover:underline">Hubungi</button>
                </td>
              </tr>
              <!-- Add more rows as needed -->
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</body>

</html>
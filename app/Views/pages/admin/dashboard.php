<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- Wrapper Flex untuk sidebar dan konten utama -->
    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <?= $this->include('layouts/sidenav_admin') ?>

        <!-- Konten Utama -->
        <div class="flex-1 flex flex-col">

            <!-- Header -->
            <?= $this->include('layouts/header_admin') ?>

            <!-- Main Content -->
            <main class="flex-1 p-8">
                <!-- Welcome Section -->
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

                <!-- Statistik -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
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

                <!-- Tabel -->
                <div>
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
                                <!-- Tambahkan data lainnya -->
                            </tbody>
                        </table>
                    </div>
                </div>

            </main>
        </div>
    </div>
</body>

</html>

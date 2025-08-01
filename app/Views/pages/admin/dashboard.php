<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= esc($title ?? 'Dashboard') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/LogoKKLA.png') ?>">
</head>

<body class="bg-gray-100">
    <div class="flex min-h-screen ml-72">

        <!-- Sidebar -->
        <?= $this->include('layouts/sidenav_admin') ?>

        <!-- Main Content -->
        <?= $this->include('layouts/header_admin') ?>
        <div class="flex-1 flex flex-col">

            <main class="flex-1 p-8 mt-24">

                <!-- Welcome -->
                <h2 class="text-2xl font-bold mb-2">
                    Selamat Datang, <?= esc(session()->get('username') ?? 'Admin SIPANDAKABULAN'); ?>!
                </h2>
                <p class="text-gray-600">
                    Anda login sebagai
                    <span class="font-semibold text-blue-800">
                        <?= ucfirst(esc(session()->get('role') ?? 'admin')); ?>
                    </span>
                </p>

                <!-- Statistik Dashboard -->
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-8">
                    <!-- Total Desa Card -->
                    <div class="bg-white p-5 rounded-lg shadow">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Desa</p>
                                <p class="text-2xl font-bold"><?= esc($totalDesa) ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Total Input Card -->
                    <div class="bg-white p-5 rounded-lg shadow">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Total Input</p>
                                <p class="text-2xl font-bold text-green-600"><?= esc($sudahInput) ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Approved Card -->
                    <div class="bg-white p-5 rounded-lg shadow">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-700 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Disetujui</p>
                                <p class="text-2xl font-bold text-green-700"><?= esc($totalApproved) ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Rejected Card -->
                    <div class="bg-white p-5 rounded-lg shadow">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Ditolak</p>
                                <p class="text-2xl font-bold text-red-700"><?= esc($totalRejected) ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Perlu Approve Card -->
                    <div class="bg-white p-5 rounded-lg shadow">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Perlu Disetujui</p>
                                <p class="text-2xl font-bold text-yellow-600"><?= esc($perluApprove) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Data Terbaru Gabungan -->
                <div class="mt-10">
                    <h3 class="text-lg font-bold mb-4 text-blue-800">5 Data Terbaru dari Semua Klaster</h3>
                    <div class="bg-white p-4 rounded-lg shadow overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-blue-700 text-white">
                                <tr>
                                    <th class="px-4 py-2 text-left">No</th>
                                    <th class="px-4 py-2 text-left">Nama Desa</th>
                                    <th class="px-4 py-2 text-left">Nama Klaster</th>
                                    <th class="px-4 py-2 text-left">Tahun</th>
                                    <th class="px-4 py-2 text-left">Bulan</th>
                                    <th class="px-4 py-2 text-left">Status</th>
                                    <th class="px-4 py-2 text-left">Waktu Input</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($latestCombined)): ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($latestCombined as $row): ?>
                                        <tr class="<?= $no % 2 === 0 ? 'bg-gray-50' : 'bg-white' ?>">
                                            <td class="px-4 py-2"><?= $no++ ?></td>
                                            <td class="px-4 py-2"><?= esc($row['nama_desa']) ?></td>
                                            <td class="px-4 py-2"><?= esc($row['nama_klaster']) ?></td>
                                            <td class="px-4 py-2"><?= esc($row['tahun']) ?></td>
                                            <td class="px-4 py-2"><?= esc($row['bulan']) ?></td>
                                            <td class="px-4 py-2">
                                                <?php
                                                $warna = match (strtolower($row['status'])) {
                                                    'approved' => 'bg-green-100 text-green-700',
                                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                                    'rejected' => 'bg-red-100 text-red-600',
                                                    default => 'bg-gray-100 text-gray-600',
                                                };

                                                $statusLabel = match (strtolower($row['status'])) {
                                                    'approved' => 'Disetujui',
                                                    'pending'  => 'Menunggu',
                                                    'rejected' => 'Ditolak',
                                                    default    => ucfirst($row['status']),
                                                };
                                                ?>
                                                <span class="px-2 py-1 rounded-full text-xs font-semibold <?= $warna ?>">
                                                    <?= $statusLabel ?>
                                                </span>
                                            </td>
                                            <td class="px-4 py-2">
                                                <?= date('d M Y, H:i', strtotime($row['created_at'])) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="px-4 py-4 text-center text-gray-500 italic">Belum ada data terbaru</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>

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
                    <span
                        class="font-semibold text-blue-800"><?= ucfirst(esc(session()->get('role') ?? 'admin')); ?></span>
                </p>


                <!-- Statistik Dashboard -->
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-8">
                    <div class="bg-white p-5 rounded-lg shadow text-center">
                        <p class="text-sm text-gray-500">Total Desa</p>
                        <p class="text-3xl font-bold"><?= esc($totalDesa) ?></p>
                    </div>
                    <div class="bg-white p-5 rounded-lg shadow text-center">
                        <p class="text-sm text-gray-500">Total Input</p>
                        <p class="text-3xl font-bold text-green-600"><?= esc($sudahInput) ?></p>
                    </div>

                    <div class="bg-white p-5 rounded-lg shadow text-center">
                        <p class="text-sm text-gray-500">Approved</p>
                        <p class="text-3xl font-bold text-green-700"><?= esc($totalApproved) ?></p>
                    </div>
                    <div class="bg-white p-5 rounded-lg shadow text-center">
                        <p class="text-sm text-gray-500">Rejected</p>
                        <p class="text-3xl font-bold text-red-700"><?= esc($totalRejected) ?></p>
                    </div>
                    <div class="bg-white p-5 rounded-lg shadow text-center">
                        <p class="text-sm text-gray-500">Perlu Approve</p>
                        <p class="text-3xl font-bold text-yellow-600"><?= esc($perluApprove) ?></p>
                    </div>
                </div>


                <!-- Tabel Status Desa -->
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
                                $warna = match ($row['status']) {
                                    'approved' => 'bg-green-100 text-green-700',
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'rejected' => 'bg-red-100 text-red-600',
                                    default => 'bg-gray-100 text-gray-600',
                                };
                                ?>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold <?= $warna ?>">
                                    <?= ucfirst($row['status']) ?>
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
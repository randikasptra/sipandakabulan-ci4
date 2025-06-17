<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= esc($title ?? 'Dashboard') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                <div class="bg-white p-6 rounded-lg shadow-md flex flex-col md:flex-row justify-between items-center mb-8">
                    <div>
                        <h2 class="text-2xl font-bold mb-2">Selamat Datang, Admin SIPANDAKABULAN!</h2>
                        <p class="text-gray-600">
                            Anda login sebagai <span class="font-semibold text-blue-800">Administrator</span>
                        </p>
                    </div>
                    <div class="mt-4 md:mt-0 text-center">
                        <p class="text-gray-700">Pantau progres pengisian data kelembagaan setiap desa.</p>
                    </div>
                </div>

                <!-- Statistik -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-500">Total Desa</p>
                        <p class="text-3xl font-bold"><?= esc($totalDesa) ?></p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-500">Sudah Input</p>
                        <p class="text-3xl font-bold text-green-600"><?= esc($sudahInput) ?></p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-500">Belum Input</p>
                        <p class="text-3xl font-bold text-red-500"><?= esc($belumInput) ?></p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <p class="text-gray-500">Perlu Approve</p>
                        <p class="text-3xl font-bold text-yellow-500"><?= esc($perluApprove) ?></p>
                    </div>
                </div>

                <!-- Tabel Status Desa -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Status Pengisian Desa</h3>
                    <div class="bg-white p-4 rounded-lg shadow-md overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead class="bg-blue-800 text-white">
                                <tr>
                                    <th class="px-4 py-2 text-left">No</th>
                                    <th class="px-4 py-2 text-left">Nama Desa</th>
                                    <th class="px-4 py-2 text-left">Status Input</th>
                                    <th class="px-4 py-2 text-left">Status Approve</th>
                                    <th class="px-4 py-2 text-left">Terakhir Diinput Oleh</th>
                                    <th class="px-4 py-2 text-left">Waktu Input</th>
                                    <th class="px-4 py-2 text-left">Klaster Terisi</th>
                                    <th class="px-4 py-2 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($desaList) && is_array($desaList)) : ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($desaList as $desa) : ?>
                                        <tr class="border-b">
                                            <td class="px-4 py-2"><?= $no++ ?></td>
                                            <td class="px-4 py-2"><?= esc($desa['desa']) ?></td>
                                            <td class="px-4 py-2">
                                                <?php if ($desa['status_input'] === 'sudah') : ?>
                                                    <span class="text-green-600 font-semibold">Sudah Input</span>
                                                <?php else : ?>
                                                    <span class="text-red-500 font-semibold">Belum Input</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-4 py-2">
                                                <?php if ($desa['status_approve'] === 'approved') : ?>
                                                    <span class="text-green-600 font-semibold">Disetujui</span>
                                                <?php elseif ($desa['status_approve'] === 'pending') : ?>
                                                    <span class="text-yellow-500 font-semibold">Menunggu Approve</span>
                                                <?php else : ?>
                                                    <span class="text-red-500 font-semibold">Ditolak</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-4 py-2">
                                                <?= esc($desa['input_by'] ?? '-') ?>
                                            </td>
                                            <td class="px-4 py-2">
                                                <?= !empty($desa['created_at']) ? date('d M Y H:i', strtotime($desa['created_at'])) : '-' ?>
                                            </td>
                                            <td class="px-4 py-2">
                                                <?= !empty($desa['klaster_isi']) ? esc($desa['klaster_isi']) : '<span class="text-gray-400 italic">Belum ada</span>' ?>
                                            </td>
                                            <td class="px-4 py-2">
                                                <a href="<?= base_url('dashboard/admin/review_kelembagaan/' . $desa['id']) ?>" class="text-blue-600 hover:underline">Lihat Detail</a>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-gray-500">Data desa belum tersedia</td>
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

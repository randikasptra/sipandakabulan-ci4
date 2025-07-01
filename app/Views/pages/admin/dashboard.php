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
                <div
                    class="bg-white p-6 rounded-lg shadow-md flex flex-col md:flex-row justify-between items-center mb-8">
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

                <!-- Statistik Dashboard -->
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-8">
                    <div class="bg-white p-5 rounded-lg shadow text-center">
                        <p class="text-sm text-gray-500">Total Desa</p>
                        <p class="text-3xl font-bold"><?= esc($totalDesa) ?></p>
                    </div>
                    <div class="bg-white p-5 rounded-lg shadow text-center">
                        <p class="text-sm text-gray-500">Sudah Input</p>
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
                            <tbody class="text-sm text-gray-700">
                                <?php if (!empty($desaList) && is_array($desaList)): ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($desaList as $desa): ?>
                                        <tr
                                            class="<?= $no % 2 === 0 ? 'bg-gray-50' : 'bg-white' ?> hover:bg-blue-50 transition">
                                            <td class="px-4 py-3 font-medium"><?= $no++ ?></td>
                                            <td class="px-4 py-3"><?= esc($desa['desa']) ?></td>
                                            <td class="px-4 py-3">
                                                <span
                                                    class="px-2 py-1 rounded-full text-xs font-semibold
                        <?= $desa['status_input'] === 'sudah' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' ?>">
                                                    <?= $desa['status_input'] === 'sudah' ? 'Sudah Input' : 'Belum Input' ?>
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                <?php
                                                $status = $desa['status_approve'];
                                                $statusLabel = [
                                                    'approved' => ['label' => 'Disetujui', 'color' => 'bg-green-100 text-green-700'],
                                                    'pending' => ['label' => 'Menunggu Approve', 'color' => 'bg-yellow-100 text-yellow-700'],
                                                    'rejected' => ['label' => 'Ditolak', 'color' => 'bg-red-100 text-red-600']
                                                ];
                                                ?>
                                                <span
                                                    class="px-2 py-1 rounded-full text-xs font-semibold <?= $statusLabel[$status]['color'] ?>">
                                                    <?= $statusLabel[$status]['label'] ?>
                                                </span>
                                            </td>
                                            <td class="px-4 py-3"><?= esc($desa['input_by'] ?? '-') ?></td>
                                            <td class="px-4 py-3">
                                                <?= !empty($desa['created_at']) ? date('d M Y, H:i', strtotime($desa['created_at'])) : '<span class="text-gray-400 italic">Belum ada</span>' ?>
                                            </td>
                                            <td class="px-4 py-3">
                                                <?= $desa['klaster_isi'] !== '-' ? esc($desa['klaster_isi']) : '<span class="text-gray-400 italic">Belum ada</span>' ?>
                                            </td>
                                            <td class="px-4 py-3">
                                                <a href="<?= base_url('dashboard/admin/approve/' . $desa['id']) ?>"
                                                    class="text-blue-600 hover:underline text-sm">Lihat Detail</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-6 text-gray-500 italic">Data desa belum
                                            tersedia</td>
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
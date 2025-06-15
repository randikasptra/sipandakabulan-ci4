<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Kelola User') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">

        <!-- Sidebar Admin -->
        <?= $this->include('layouts/sidenav_admin') ?>

        <!-- Konten Utama -->
        <div class="flex-1 flex flex-col">

            <!-- Header Admin -->
            <?= $this->include('layouts/header_admin') ?>

            <!-- Konten -->
            <main class="flex-1 p-8">
                <div class="p-6 bg-white rounded shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold">Daftar Pengumuman</h2>
                        <a href="<?= site_url('/pengumuman/create') ?>"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                            + Buat Pengumuman
                        </a>
                    </div>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-left border">
                            <thead>
                                <tr class="bg-blue-900 text-white">
                                    <th class="py-2 px-4 border">#</th>
                                    <th class="py-2 px-4 border">Judul</th>
                                    <th class="py-2 px-4 border">Isi</th>
                                    <th class="py-2 px-4 border">Tujuan Desa</th>
                                    <th class="py-2 px-4 border">Tanggal</th>
                                    <th class="py-2 px-4 border">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($announcements as $i => $item): ?>
                                    <tr class="border-b hover:bg-gray-100">
                                        <td class="py-2 px-4 border"><?= $i + 1 ?></td>
                                        <td class="py-2 px-4 border"><?= esc($item['judul']) ?></td>
                                        <td class="py-2 px-4 border"><?= esc($item['isi']) ?></td>
                                        <td class="py-2 px-4 border">
                                            <?= $item['tujuan_desa'] ? esc($item['tujuan_desa']) : '<span class="italic text-gray-500">Semua Desa</span>' ?>
                                        </td>
                                        <td class="py-2 px-4 border">
                                            <?= date('d M Y H:i', strtotime($item['created_at'])) ?></td>
                                        <td class="py-2 px-4 border">
                                            <a href="<?= site_url('/pengumuman/delete/' . $item['id']) ?>"
                                                class="text-red-600 hover:underline"
                                                onclick="return confirm('Yakin ingin menghapus pengumuman ini?')">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (empty($announcements)): ?>
                                    <tr>
                                        <td colspan="6" class="py-4 text-center text-gray-500">Belum ada pengumuman</td>
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
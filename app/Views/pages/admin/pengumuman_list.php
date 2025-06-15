<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengumuman</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?= $this->include('layouts/sidenav_admin') ?>

        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <?= $this->include('layouts/header_admin') ?>

            <!-- Main Content -->
            <main class="flex-1 p-8">
                <div class="bg-white p-6 rounded shadow">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold">Daftar Pengumuman</h2>
                        <button onclick="document.getElementById('modal-pengumuman').classList.remove('hidden')"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">+ Buat
                            Pengumuman</button>
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
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-2 px-4 border"><?= $i + 1 ?></td>
                                        <td class="py-2 px-4 border"><?= esc($item['judul']) ?></td>
                                        <td class="py-2 px-4 border"><?= esc($item['isi']) ?></td>
                                        <td class="py-2 px-4 border">
                                            <?= $item['tujuan_desa'] ? esc($item['tujuan_desa']) : '<span class="italic text-gray-500">Semua Desa</span>' ?>
                                        </td>
                                        <td class="py-2 px-4 border">
                                            <?= date('d M Y H:i', strtotime($item['created_at'])) ?></td>
                                        <td class="py-2 px-4 border">
                                            <a href="<?= site_url('/dashboard/pengumuman/delete/' . $item['id']) ?>"
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

    <!-- Modal Buat Pengumuman -->
    <div id="modal-pengumuman"
        class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
            <h3 class="text-xl font-bold mb-4">Buat Pengumuman</h3>

            <form action="<?= site_url('dashboard/pengumuman_list/store') ?>" method="post">
                <div class="mb-4">
                    <label for="judul" class="block mb-1 font-semibold">Judul</label>
                    <input type="text" name="judul" required
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300">
                </div>

                <div class="mb-4">
                    <label for="isi" class="block mb-1 font-semibold">Isi</label>
                    <textarea name="isi" rows="4" required
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-300"></textarea>
                </div>

                <div class="mb-4">
                    <label for="tujuan_desa" class="block mb-1 font-semibold">Kirim ke Desa</label>
                    <select name="tujuan_desa" class="w-full border rounded px-3 py-2">
                        <option value="">-- Semua Desa --</option>
                        <?php foreach ($desa_list as $desa): ?>
                            <option value="<?= esc($desa['desa']) ?>"><?= esc($desa['desa']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="flex justify-end">
                    <button type="button" onclick="document.getElementById('modal-pengumuman').classList.add('hidden')"
                        class="bg-gray-300 text-gray-800 px-4 py-2 rounded mr-2">Batal</button>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Kirim</button>
                </div>
            </form>

            <button onclick="document.getElementById('modal-pengumuman').classList.add('hidden')"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
        </div>
    </div>
</body>

</html>
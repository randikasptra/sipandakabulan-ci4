<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= esc($title ?? 'Approval Data Desa') ?></title>
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

                <!-- Judul & Deskripsi -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                    <h2 class="text-2xl font-bold mb-2">Approval Data Desa</h2>
                    <p class="text-gray-600">Daftar desa yang sudah submit semua klaster dan menunggu approval admin.</p>
                </div>

                <?php if (session()->getFlashdata('success')) : ?>
                    <div class="bg-green-200 text-green-800 p-4 rounded mb-6">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <!-- Tabel Approval Desa -->
                <div class="bg-white p-4 rounded-lg shadow-md overflow-x-auto">
                    <table class="min-w-full table-auto">
    <thead class="bg-blue-800 text-white">
        <tr>
            <th class="px-4 py-2 text-left">No</th>
            <th class="px-4 py-2 text-left">Nama Desa</th>
            <th class="px-4 py-2 text-left">Email Operator</th>
            <th class="px-4 py-2 text-left">Status Input</th>
            <th class="px-4 py-2 text-left">Status Approval</th>
            <th class="px-4 py-2 text-left">Tanggal Submit</th>
            <th class="px-4 py-2 text-left">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($desas)) : ?>
            <?php foreach ($desas as $index => $desa) : ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2"><?= $index + 1 ?></td>
                    <td class="px-4 py-2"><?= esc($desa['username']) ?></td>
                    <td class="px-4 py-2"><?= esc($desa['email']) ?></td>
                    <td class="px-4 py-2 capitalize"><?= esc($desa['status_input']) ?></td>
                    <td class="px-4 py-2">
                        <?php if ($desa['status_approve'] === 'pending') : ?>
                            <span class="text-yellow-600 font-semibold capitalize">Pending</span>
                        <?php elseif ($desa['status_approve'] === 'approved') : ?>
                            <span class="text-green-600 font-semibold capitalize">Approved</span>
                        <?php elseif ($desa['status_approve'] === 'rejected') : ?>
                            <span class="text-red-600 font-semibold capitalize">Rejected</span>
                        <?php else : ?>
                            <span class="text-gray-600 capitalize"><?= esc($desa['status_approve']) ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-2"><?= date('d M Y', strtotime($desa['submit_date'] ?? '')) ?></td>
                   <td class="px-4 py-2 space-x-2">
    <a href="<?= site_url('/admin/approval/proses/' . $desa['id']) ?>" 
       class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">
        Proses
    </a>
</td>

                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="7" class="text-center text-gray-500 py-4">Tidak ada data desa yang perlu di-approve.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

                </div>

            </main>
        </div>
    </div>

</body>

</html>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Kelembagaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800">

    <div class="p-8">
        <h1 class="text-2xl font-bold mb-6">Laporan Data Kelembagaan</h1>

        <?php if (!empty($data)): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white shadow rounded-lg">
                    <thead>
                        <tr class="bg-primary-600 text-white text-left">
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">User ID</th>
                            <th class="py-3 px-4">Total Nilai</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $index => $row): ?>
                            <tr class="border-b">
                                <td class="py-2 px-4"><?= $index + 1 ?></td>
                                <td class="py-2 px-4"><?= esc($row['user_id']) ?></td>
                                <td class="py-2 px-4"><?= esc($row['total_nilai']) ?></td>
                                <td class="py-2 px-4 text-green-600 font-medium"><?= ucfirst($row['status']) ?></td>
                                <td class="py-2 px-4">
                                    <a href="<?= base_url('dashboard/admin/review_kelembagaan/' . $row['user_id']) ?>"
                                        class="text-blue-600 hover:underline">Lihat Detail</a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-gray-500 italic">Belum ada data kelembagaan yang disetujui.</p>
        <?php endif; ?>
    </div>

</body>

</html>
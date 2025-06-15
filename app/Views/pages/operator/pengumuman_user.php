<?= $this->include('layouts/navbar') ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pengumuman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }

        .announcement-card {
            border-left: 4px solid transparent;
            transition: all 0.2s ease;
        }

        .announcement-card:hover {
            border-left-color: #2563eb;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="max-w-4xl mx-auto py-8 px-4 pt-24">
        <!-- Header Section -->
        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                <i class="ph ph-megaphone text-blue-600 text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Pengumuman Resmi</h1>
            <p class="mt-2 text-gray-600">Informasi penting dari Kabupaten untuk Operator Desa</p>
        </div>

        <!-- Announcement Content -->
        <div class="space-y-4">
            <?php if (empty($pengumuman)): ?>
                <div class="bg-white p-8 rounded-xl shadow-sm text-center">
                    <i class="ph ph-newspaper text-4xl text-gray-300 mb-3"></i>
                    <h3 class="text-lg font-medium text-gray-700">Belum ada pengumuman</h3>
                    <p class="text-gray-500 mt-1">Tidak ada pengumuman untuk desa Anda saat ini</p>
                </div>
            <?php else: ?>
                <?php foreach ($pengumuman as $p): ?>
                    <div class="announcement-card bg-white p-6 rounded-xl shadow-sm">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-blue-50 p-3 rounded-lg mr-4">
                                <i class="ph ph-info text-blue-600 text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h3 class="text-lg font-semibold text-gray-800"><?= esc($p['judul']) ?></h3>
                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full">
                                        <?= esc($p['tujuan_desa'] ?? 'Semua Desa') ?>
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">
                                    <i class="ph ph-clock mr-1"></i>
                                    <?= date('d M Y H:i', strtotime($p['created_at'])) ?>
                                </p>
                                <div class="mt-4 text-gray-700">
                                    <?= esc($p['isi']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
</body>

</html>
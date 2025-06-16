<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Kelola User') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .table-row-hover:hover {
            background-color: #f8fafc;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .action-btn {
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .modal-enter {
            animation: modalEnter 0.3s ease-out;
        }

        @keyframes modalEnter {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <div class="flex min-h-screen">

        <!-- Sidebar Admin -->
        <?= $this->include('layouts/sidenav_admin') ?>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Header Admin -->
            <?= $this->include('layouts/header_admin') ?>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6">
                <h1 class="text-3xl font-bold mb-6 text-center">Data yang Menunggu Persetujuan</h1>

                <?php
                // Data klaster yang tersedia saat ini
                $klasterData = [
                    'Kelembagaan' => $kelembagaan ?? [],
                    'Klaster 1' => $klaster1 ?? [],
                    // Tambahkan nanti jika klaster lain sudah tersedia:
                    // 'Klaster 2' => $klaster2 ?? [],
                    // 'Klaster 3' => $klaster3 ?? [],
                    // 'Klaster 4' => $klaster4 ?? [],
                    // 'Klaster 5' => $klaster5 ?? [],
                ];
                ?>

                <?php foreach ($klasterData as $klaster => $items): ?>
                    <div class="mb-10">
                        <h2 class="text-2xl font-semibold mb-4 text-blue-700"><?= esc($klaster) ?></h2>

                        <?php if (!empty($items)): ?>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <?php foreach ($items as $item): ?>
                                    <div class="bg-white rounded-xl shadow-md p-4 border border-gray-200">
                                        <h3 class="font-semibold text-lg text-gray-800">ID: <?= esc($item['id']) ?></h3>

                                        <?php if ($klaster === 'Kelembagaan'): ?>
                                            <p class="text-gray-600 mb-2">Nama Lembaga: <?= esc($item['nama_lembaga'] ?? '-') ?></p>
                                        <?php else: ?>
                                            <p class="text-gray-600 mb-2">User ID: <?= esc($item['user_id']) ?></p>
                                        <?php endif ?>

                                        <a href="<?= site_url('dashboard/admin/review_kelembagaan/' . $item['user_id']) ?>"
                                            class="inline-block mt-2 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm transition">
                                            Lihat Detail
                                        </a>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        <?php else: ?>
                            <p class="text-gray-500">Tidak ada data pending untuk <?= esc($klaster) ?>.</p>
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
        </div>
    </div>
</body>

</html>
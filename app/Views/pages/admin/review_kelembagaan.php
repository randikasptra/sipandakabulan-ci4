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
                <div class="max-w-4xl mx-auto p-6">
                    <h1 class="text-2xl font-bold mb-6 text-blue-700">Review Data Kelembagaan</h1>

                    <?php
                    $fields = [
                        'peraturan' => 'Peraturan',
                        'anggaran' => 'Anggaran',
                        'forum_anak' => 'Forum Anak',
                        'data_terpilah' => 'Data Terpilah',
                        'dunia_usaha' => 'Dunia Usaha',
                    ];
                    ?>

                    <div class="space-y-4">
                        <?php foreach ($fields as $key => $label): ?>
                            <div class="bg-white p-4 rounded shadow border border-gray-200">
                                <h2 class="text-lg font-semibold mb-2"><?= $label ?></h2>
                                <p>Nilai: <span class="font-medium"><?= esc($kelembagaan[$key . '_value']) ?></span></p>
                                <?php if (!empty($kelembagaan[$key . '_file'])): ?>
                                    <div class="flex gap-3 mt-2">
                                        <a href="<?= base_url('dashboard/admin/download_file?file=' . urlencode($kelembagaan[$key . '_file'])) ?>"
                                            class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                            ⬇ Download File
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <p class="text-sm text-gray-500 italic">Belum ada file</p>
                                <?php endif ?>
                            </div>
                        <?php endforeach ?>
                    </div>

                    <div class="mt-6 p-4 bg-gray-100 rounded">
                        <p><strong>Total Nilai:</strong> <?= esc($kelembagaan['total_nilai']) ?></p>
                        <p><strong>Status Saat Ini:</strong> <?= ucfirst($kelembagaan['status']) ?></p>
                    </div>


                    <?php if (!empty($id)): ?>
                        <?php
                        $zipPath = 'uploads/kelembagaan/' . $id . '.zip';
                        ?>
                        <?php if (file_exists(FCPATH . $zipPath)): ?>
                            <a href="<?= base_url($zipPath) ?>"
                                class="inline-block mt-6 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 transition">
                                ⬇ Download Semua File (ZIP)
                            </a>
                        <?php else: ?>
                            <p class="mt-6 text-sm text-gray-500 italic">File ZIP belum tersedia untuk user ini.</p>
                        <?php endif; ?>
                    <?php endif; ?>


                    <form method="post" action="<?= base_url('dashboard/admin/kelembagaan/approve') ?>"
                        class="mt-6 flex gap-3">
                        <?= csrf_field() ?>
                        <input type="hidden" name="user_id" value="<?= $user_id ?>">

                        <button type="submit" name="status" value="approved"
                            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            ✅ Approve
                        </button>
                        <button type="submit" name="status" value="rejected"
                            class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                            ❌ Reject
                        </button>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
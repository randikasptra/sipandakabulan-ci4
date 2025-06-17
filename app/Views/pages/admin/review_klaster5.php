<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Review Klaster 5') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 600: '#0284c7', 700: '#0369a1' },
                        success: { 500: '#10b981' },
                        warning: { 500: '#f59e0b' },
                        danger: { 500: '#ef4444' }
                    },
                    boxShadow: {
                        card: '0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.1)',
                        'card-hover': '0 4px 6px rgba(0,0,0,0.05), 0 1px 3px rgba(0,0,0,0.1)'
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--tw-shadow) !important;
        }
    </style>
</head>

<body class=>
    <div class="flex min-h-screen ml-24">
        <?= $this->include('layouts/sidenav_admin') ?>
        <div class="flex-1 flex flex-col mt-24">
            <?= $this->include('layouts/header_admin') ?>

            <main class="p-6 overflow-y-auto flex-1">
                <div class="max-w-5xl mx-auto">
                    <div class="mb-8">
                        <h1 class="text-2xl font-bold text-gray-800">Review Data Klaster 5</h1>
                        <p class="text-gray-600">Tinjau dan verifikasi data perlindungan anak dan penanggulangan
                            kekerasan</p>
                        <div class="mt-2">
                            <span
                                class="inline-block px-3 py-1 text-sm rounded-full 
                            <?= $klaster5['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' :
                                ($klaster5['status'] === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') ?>">
                                <?= ucfirst($klaster5['status']) ?>
                            </span>
                        </div>
                        <div class="border-b border-gray-200 mt-4"></div>
                    </div>

                    <?php
                    $fields = [
                        'laporanKekerasanAnak' => 'Laporan Kekerasan Anak',
                        'mekanismePenanggulanganBencana' => 'Mekanisme Penanggulangan Bencana',
                        'programPencegahanKekerasan' => 'Program Pencegahan Kekerasan Anak',
                        'programPencegahanPekerjaanAnak' => 'Program Pencegahan Pekerjaan Anak',
                    ];
                    ?>

                    <div class="space-y-4 mb-8">
                        <?php foreach ($fields as $key => $label): ?>
                            <div
                                class="card bg-white p-5 rounded-lg shadow-card border border-gray-100 transition hover:shadow-card-hover">
                                <div class="flex items-start">
                                    <div class="bg-blue-50 p-3 rounded-lg mr-4">
                                        <i class="fas fa-shield-alt text-blue-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h2 class="text-lg font-semibold text-gray-800 mb-1"><?= $label ?></h2>
                                        <p class="text-gray-600 mb-2">Nilai:
                                            <span
                                                class="font-medium text-gray-900"><?= esc($klaster5[$key]) ?? '0' ?></span>
                                        </p>
                                        <?php if (!empty($klaster5[$key . '_file'])): ?>
                                            <a href="<?= base_url('dashboard/admin/download_file?file=' . urlencode($klaster5[$key . '_file'])) ?>"
                                                class="inline-flex items-center text-sm bg-green-100 text-green-800 px-3 py-1 rounded hover:bg-green-200">
                                                <i class="fas fa-download mr-2"></i> Download File
                                            </a>
                                        <?php else: ?>
                                            <span class="text-sm text-gray-400 italic">Tidak ada file</span>
                                        <?php endif ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-card border border-gray-100 mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Umum</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500">Tahun / Bulan</p>
                                <p class="text-xl font-semibold text-gray-800"><?= esc($klaster5['tahun']) ?> /
                                    <?= esc($klaster5['bulan']) ?></p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500">Status</p>
                                <p
                                    class="text-lg font-medium <?= $klaster5['status'] === 'pending' ? 'text-yellow-600' : ($klaster5['status'] === 'approved' ? 'text-green-600' : 'text-red-600') ?>">
                                    <?= ucfirst($klaster5['status']) ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($id)): ?>
                        <?php $zipPath = 'uploads/klaster5/' . $id . '.zip'; ?>
                        <div class="bg-white p-6 rounded-lg shadow-card border border-gray-100 mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Download Semua File</h3>
                            <?php if (file_exists(FCPATH . $zipPath)): ?>
                                <a href="<?= base_url($zipPath) ?>"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                    <i class="fas fa-file-archive mr-2"></i> Download ZIP
                                </a>
                            <?php else: ?>
                                <p class="text-sm text-gray-500 italic">Tidak ada file ZIP tersedia.</p>
                            <?php endif ?>
                        </div>
                    <?php endif ?>

                    <form method="post" action="<?= base_url('dashboard/admin/klaster5/approve') ?>" class="mt-8">
                        <?= csrf_field() ?>
                        <input type="hidden" name="user_id" value="<?= $user_id ?>">
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="submit" name="status" value="approved"
                                class="flex-1 flex items-center justify-center gap-2 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                                <i class="fas fa-check-circle"></i> Approve
                            </button>
                            <button type="submit" name="status" value="rejected"
                                class="flex-1 flex items-center justify-center gap-2 bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                                <i class="fas fa-times-circle"></i> Reject
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
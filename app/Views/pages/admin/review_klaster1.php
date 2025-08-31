<?php $user_id = $klaster1['user_id'] ?? $id ?? null; ?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Review Klaster 1') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 600: '#0284c7', 700: '#0369a1', 800: '#075985' },
                        success: { 500: '#10b981', 600: '#059669' },
                        warning: { 500: '#f59e0b', 600: '#d97706' },
                        danger: { 500: '#ef4444', 600: '#dc2626' }
                    },
                    boxShadow: {
                        'card': '0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.1)',
                        'card-hover': '0 4px 6px rgba(0,0,0,0.05), 0 1px 3px rgba(0,0,0,0.1)'
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--tw-shadow) !important;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 600;
            border-radius: 0.375rem;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased ml-24">
    <div class="flex min-h-screen">
        <?= $this->include('layouts/sidenav_admin') ?>
        <div class="flex-1 flex flex-col overflow-hidden mt-24">
            <?= $this->include('layouts/header_admin') ?>
            <main class="flex-1 overflow-y-auto p-6">
                <div class="max-w-4xl mx-auto">
                    <div class="mb-8">
                        <div class="flex items-center justify-between">
                            <div>
                                <h1 class="text-2xl font-bold text-gray-900">Review Data Klaster 1</h1>
                                <p class="mt-2 text-gray-600">Review dan verifikasi data indikator pada klaster 1</p>
                            </div>
                            <div>
                                <span class="badge <?= $klaster1['status'] === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($klaster1['status'] === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') ?>">
                                    <?= ucfirst($klaster1['status']) ?>
                                </span>
                            </div>
                        </div>
                        <div class="mt-4 border-b border-gray-200"></div>
                    </div>

                    <?php
                    $fields = [
                        'AnakAktaKelahiran' => ['label' => 'Anak Akta Kelahiran (%)', 'icon' => 'fa-user-check'],
                        'anggaran' => ['label' => 'Anggaran', 'icon' => 'fa-money-bill-wave'],
                    ];
                    ?>

                    <div class="space-y-4 mb-8">
                        <?php foreach ($fields as $key => $field): ?>
                            <div class="card bg-white p-5 rounded-lg shadow-card border border-gray-100 hover:shadow-card-hover">
                                <div class="flex items-start">
                                    <div class="bg-blue-50 p-3 rounded-lg mr-4">
                                        <i class="fas <?= $field['icon'] ?> text-blue-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h2 class="text-lg font-semibold text-gray-800 mb-1"><?= $field['label'] ?></h2>
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-gray-600 mb-2">
                                                    Nilai:
                                                    <span class="font-medium text-gray-800">
                                                        <?= esc($klaster1[$key] ?? '-') ?>
                                                    </span>
                                                </p>
                                                <?php if (!empty($klaster1[$key . '_file'] ?? null)): ?>
                                                    <a href="<?= base_url('dashboard/admin/download_file?file=' . urlencode($klaster1[$key . '_file']) . '&folder=klaster1') ?>"
                                                        class="inline-flex items-center text-sm bg-green-50 text-green-700 px-3 py-1 rounded hover:bg-green-100 transition-colors">
                                                        <i class="fas fa-download mr-2"></i> Download File
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-sm text-gray-400 italic">No file uploaded</span>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow-card border border-gray-100 mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi & Summary</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 mb-1">Tahun / Bulan</p>
                                <p class="text-xl font-semibold text-gray-800">
                                    <?= esc($klaster1['tahun']) ?> / <?= bulanIndo($klaster1['bulan']) ?>

                                </p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-500 mb-1">Total Nilai</p>
                                <p class="text-2xl font-bold text-gray-800">
                                    <?= esc($klaster1['total_nilai']) ?>
                                </p>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg md:col-span-2">
                                <p class="text-sm text-gray-500 mb-1">Status</p>
                                <p class="text-lg font-medium <?= $klaster1['status'] === 'pending' ? 'text-yellow-600' : ($klaster1['status'] === 'approved' ? 'text-green-600' : 'text-red-600') ?>">
                                    <?= $klaster1['status'] === 'pending' 
                                        ? 'Menunggu' 
                                        : ($klaster1['status'] === 'approved' 
                                            ? 'Disetujui' 
                                            : 'Ditolak') ?>
                                </p>
                            </div>

                        </div>
                    </div>

                    <?php if ($klaster1['status'] === 'rejected'): ?>
                        <!-- Jika Rejected, tampilkan hanya tombol hapus -->
                        <form action="<?= base_url('dashboard/admin/klaster1/delete') ?>" method="post" class="mt-8">
                            <?= csrf_field() ?>
                            <input type="hidden" name="user_id" value="<?= $user_id ?>">
                            <input type="hidden" name="tahun" value="<?= esc($klaster1['tahun']) ?>">
                            <input type="hidden" name="bulan" value="<?= esc($klaster1['bulan']) ?>">

                            <button type="submit"
                                onclick="return confirm('Yakin ingin menghapus data Klaster 1 ini? Data akan hilang permanen.')"
                                class="flex items-center justify-center gap-2 bg-gray-200 text-red-700 px-6 py-3 rounded-lg hover:bg-red-100 transition-colors font-medium w-full sm:w-auto">
                                <i class="fas fa-trash"></i> Hapus Form
                            </button>
                        </form>
                    <?php else: ?>
                                               
                        <?php if ($klaster1['status'] === 'approved'): ?>
                            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6">
                                <i class="fas fa-check-circle mr-2"></i> Data ini telah <strong>diverifikasi</strong> dan disetujui.
                            </div>
                             <form action="<?= base_url('dashboard/admin/delete-approve-klaster1') ?>" method="post" class="mt-4">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                    
                                </form>
                        <?php endif; ?>

                        
                        <?php if ($klaster1['status'] === 'pending'): ?>
                            <form method="post" action="<?= base_url('dashboard/admin/klaster1/approve') ?>" class="mt-8">
                                <?= csrf_field() ?>
                                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                <input type="hidden" name="klaster" value="klaster1">
                                <input type="hidden" name="tahun" value="<?= esc($klaster1['tahun']) ?>">
                                <input type="hidden" name="bulan" value="<?= esc($klaster1['bulan']) ?>">
                                <input type="hidden" name="total_nilai" value="<?= esc($klaster1['total_nilai']) ?>">
                                <input type="hidden" name="catatan" value="">

                                <div class="flex flex-col sm:flex-row gap-3">
                                    <button type="submit" name="status" value="approved"
                                        class="flex-1 flex items-center justify-center gap-2 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition-colors font-medium">
                                        <i class="fas fa-check-circle"></i> Terima
                                    </button>
                                    <button type="submit" name="status" value="rejected"
                                        class="flex-1 flex items-center justify-center gap-2 bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition-colors font-medium">
                                        <i class="fas fa-times-circle"></i> Tolak
                                    </button>
                                </div>
                            </form>
                        <?php endif; ?>

                        <!-- ✅ Jika status rejected: tampilkan tombol hapus -->
                        <?php if ($klaster1['status'] === 'rejected'): ?>
                            <form action="<?= base_url('dashboard/admin/klaster1/delete') ?>" method="post" class="mt-8">
                                <?= csrf_field() ?>
                                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                <input type="hidden" name="tahun" value="<?= esc($klaster1['tahun']) ?>">
                                <input type="hidden" name="bulan" value="<?= esc($klaster1['bulan']) ?>">

                                <button type="submit"
                                    onclick="return confirm('Yakin ingin menghapus data Klaster 1 ini? Data akan hilang permanen.')"
                                    class="flex items-center justify-center gap-2 bg-gray-200 text-red-700 px-6 py-3 rounded-lg hover:bg-red-100 transition-colors font-medium w-full sm:w-auto">
                                    <i class="fas fa-trash"></i> Hapus Form
                                </button>
                            </form>
                        <?php endif; ?>

                    <?php endif; ?>

                </div>
            </main>
        </div>
    </div>
</body>

</html>

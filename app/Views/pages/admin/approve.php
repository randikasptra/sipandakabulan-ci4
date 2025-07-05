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
                        },
                        secondary: {
                            500: '#6b7280',
                            600: '#4b5563',
                        },
                        success: {
                            500: '#10b981',
                            600: '#059669',
                        }
                    },
                    boxShadow: {
                        'card': '0 4px 20px rgba(0, 0, 0, 0.05)',
                        'card-hover': '0 8px 25px rgba(0, 0, 0, 0.08)'
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
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 600;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            border-radius: 0.375rem;
        }

        .skeleton {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .5;
            }
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

<body class="bg-gray-50 text-gray-800 antialiased">
    <div class="flex min-h-screen lg:ml-72">

        <!-- Sidebar Admin -->
        <?= $this->include('layouts/sidenav_admin') ?>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden mt-24">

            <!-- Header Admin -->
            <?= $this->include('layouts/header_admin') ?>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6 md:p-8">
                <div class="max-w-7xl mx-auto">

                    <!-- Page Header with Filter -->
                    <div
                        class="flex flex-col space-y-4 md:space-y-0 md:flex-row md:items-center md:justify-between mb-8">
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Pending Approvals</h1>
                            <p class="mt-1 text-sm md:text-base text-gray-600">Review and approve pending submissions
                            </p>
                        </div>
                        
                    </div>

                    <?php
                    $klasterData = [
                        'Kelembagaan' => $kelembagaan ?? [],
                        'Klaster 1' => $klaster1 ?? [],
                        'Klaster 2' => $klaster2 ?? [],
                        'Klaster 3' => $klaster3 ?? [],
                        'Klaster 4' => $klaster4 ?? [],
                        'Klaster 5' => $klaster5 ?? [],
                    ];
                    ?>

                    <!-- Tab Navigation -->
           <div class="mb-6 border-b border-gray-200">
    <!-- Filter Tabs & Status -->
    <div class="flex flex-wrap gap-3 overflow-x-auto pb-4">
        <!-- Tab Filter by Klaster -->
        <button class="tab-button px-4 py-2 text-sm font-medium rounded-md bg-gray-200 text-gray-700 hover:bg-gray-300" data-tab="all">
            Semua Klaster
        </button>
        <?php foreach (array_keys($klasterData) as $klaster): ?>
            <button class="tab-button px-4 py-2 text-sm font-medium rounded-md bg-gray-100 text-gray-600 hover:bg-gray-200" data-tab="<?= strtolower(str_replace(' ', '-', $klaster)) ?>">
                <?= esc($klaster) ?>
            </button>
        <?php endforeach; ?>

   
    </div>
</div>

<!-- Main Grid Layout -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    <?php foreach ($klasterData as $klaster => $items): ?>
        <?php foreach ($items as $item): ?>
            <div class="card bg-white rounded-xl shadow-card p-5 border border-gray-100 hover:shadow-card-hover transition-all duration-300 klaster-item"
                data-klaster="<?= strtolower(str_replace(' ', '-', $klaster)) ?>"
                data-status="<?= strtolower($item['status'] ?? '') ?>">
                <div class="flex items-start justify-between">
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-800 truncate mb-1">
                            <?= $klaster === 'Kelembagaan'
                                ? esc($item['nama_lembaga'] ?? 'Lembaga Baru')
                                : esc($klaster) ?>
                        </h3>
                        <p class="text-sm text-gray-500 mb-2 truncate">
                            <?= $klaster === 'Kelembagaan'
                                ? 'Lembaga Registration'
                                : 'Pengguna: ' . esc($item['username'] ?? 'User') ?>
                        </p>

                        <!-- Badge Info -->
                        <div class="flex flex-wrap items-center gap-2 text-xs">
                            <span class="badge bg-gray-100 text-gray-600">
                                Tahun: <?= esc($item['tahun'] ?? '-') ?>
                            </span>
                            <span class="badge bg-gray-100 text-gray-600">
                                Bulan: <?= esc($item['bulan'] ?? '-') ?>
                            </span>
                            <span class="badge <?= 
                                ($item['status'] ?? '') === 'approved' ? 'bg-green-100 text-green-700' :
                                (($item['status'] ?? '') === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')
                            ?>">
                                Status: <?= ucfirst(esc($item['status'] ?? '-')) ?>
                            </span>
                            <span class="badge bg-blue-50 text-blue-600">
                                <?= date('d M Y', strtotime($item['created_at'] ?? 'now')) ?>
                            </span>
                            <span class="badge bg-gray-100 text-gray-600">
                                <?= esc($klaster) ?>
                            </span>
                        </div>
                    </div>
                    <div class="bg-blue-100 p-2 rounded-lg flex-shrink-0 ml-3">
                        <i class="fas fa-file-alt text-blue-600"></i>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end">
                    <?php $slug = strtolower(str_replace(' ', '_', $klaster)); ?>
                    <a href="<?= site_url('dashboard/admin/review_' . $slug . '/' . $item['user_id']) ?>"
                        class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors text-sm font-medium">
                        <i class="fas fa-eye mr-2"></i>
                        Review
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endforeach; ?>
</div>

<!-- Empty State -->
<div id="empty-state" class="hidden text-center py-12">
    <div class="mx-auto w-24 h-24 text-gray-300 mb-4">
        <i class="fas fa-inbox text-5xl"></i>
    </div>
    <h3 class="text-lg font-medium text-gray-500">Tidak ada data ditemukan</h3>
    <p class="mt-1 text-sm text-gray-400">Coba ubah filter klaster atau status</p>
</div>

<script>
    // State global
    let currentTab = 'all';
    let currentStatus = 'all';

    // Klik Tab (Klaster)
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', function () {
            currentTab = this.getAttribute('data-tab');
            filterCards();

            // Update styling tab aktif
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('ring-2', 'ring-offset-2', 'ring-blue-500', 'bg-blue-100', 'text-blue-700');
            });
            this.classList.add('ring-2', 'ring-offset-2', 'ring-blue-500', 'bg-blue-100', 'text-blue-700');
        });
    });

    // Klik Status Filter
    document.querySelectorAll('.status-filter').forEach(button => {
        button.addEventListener('click', function () {
            currentStatus = this.getAttribute('data-status');
            filterCards();

            // Update styling status aktif
            document.querySelectorAll('.status-filter').forEach(btn => {
                btn.classList.remove('ring-2', 'ring-offset-2', 'ring-blue-500', 'bg-blue-100', 'text-blue-700');
            });
            this.classList.add('ring-2', 'ring-offset-2', 'ring-blue-500', 'bg-blue-100', 'text-blue-700');
        });
    });

    // Fungsi Filter
    function filterCards() {
        const allItems = document.querySelectorAll('.klaster-item');
        let visibleItems = 0;

        allItems.forEach(item => {
            const klaster = item.getAttribute('data-klaster');
            const status = item.getAttribute('data-status');

            const matchTab = (currentTab === 'all' || klaster === currentTab);
            const matchStatus = (currentStatus === 'all' || status === currentStatus);

            if (matchTab && matchStatus) {
                item.classList.remove('hidden');
                visibleItems++;
            } else {
                item.classList.add('hidden');
            }
        });

        // Empty State
        const emptyState = document.getElementById('empty-state');
        if (emptyState) {
            emptyState.classList.toggle('hidden', visibleItems > 0);
        }
    }

    // Inisialisasi awal saat halaman dimuat
    window.addEventListener('DOMContentLoaded', () => {
        // Trigger tab pertama (Semua Klaster)
        document.querySelector('.tab-button[data-tab="all"]')?.click();
        // Trigger status pertama (Semua Status)
        document.querySelector('.status-filter[data-status="all"]')?.click();
    });
</script>

</body>

</html>
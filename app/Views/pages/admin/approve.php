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
                        <!-- <div class="w-full md:w-auto">
                            <label for="filterKlaster" class="sr-only">Filter Klaster</label>
                            <select id="filterKlaster"
                                class="w-full md:w-48 p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-100 focus:border-blue-500 text-sm">
                                <option value="all">Semua Klaster</option>
                                <option value="Kelembagaan">Kelembagaan</option>
                                <option value="Klaster 1">Klaster 1</option>
                                <option value="Klaster 2">Klaster 2</option>
                                <option value="Klaster 3">Klaster 3</option>
                                <option value="Klaster 4">Klaster 4</option>
                                <option value="Klaster 5">Klaster 5</option>
                            </select>
                        </div> -->
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
                        <div class="flex space-x-4 overflow-x-auto pb-2">
                            <button class="tab-button px-4 py-2 text-sm font-medium rounded-t-lg whitespace-nowrap"
                                data-tab="all">All Pending</button>
                            <?php foreach ($klasterData as $klaster => $items): ?>
                                <?php if (!empty($items)): ?>
                                    <button class="tab-button px-4 py-2 text-sm font-medium rounded-t-lg whitespace-nowrap"
                                        data-tab="<?= strtolower(str_replace(' ', '-', $klaster)) ?>">
                                        <?= esc($klaster) ?>
                                        <span
                                            class="ml-2 bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-0.5 rounded-full">
                                            <?= count(array_filter($items, fn($item) => ($item['status'] ?? '') === 'pending')) ?>
                                        </span>
                                    </button>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <!-- Main Grid Layout -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        <?php foreach ($klasterData as $klaster => $items): ?>
                            <?php foreach ($items as $item): ?>
                                <?php if (($item['status'] ?? '') === 'pending'): ?>
                                    <div class="card bg-white rounded-xl shadow-card p-5 border border-gray-100 hover:shadow-card-hover transition-all duration-300 klaster-item"
                                        data-klaster="<?= strtolower(str_replace(' ', '-', $klaster)) ?>">
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
                                                <div class="flex items-center space-x-2">
                                                    <span class="badge bg-blue-50 text-blue-600 text-xs">
                                                        <?= date('d M Y', strtotime($item['created_at'] ?? 'now')) ?>
                                                    </span>
                                                    <span class="badge bg-gray-100 text-gray-600 text-xs">
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

                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </div>

                    <!-- Empty State -->
                    <div id="empty-state" class="hidden text-center py-12">
                        <div class="mx-auto w-24 h-24 text-gray-300 mb-4">
                            <i class="fas fa-inbox text-5xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-500">No pending approvals</h3>
                        <p class="mt-1 text-sm text-gray-400">All submissions have been processed</p>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Tab Filter Functionality
        document.querySelectorAll('.tab-button').forEach(button => {
            button.addEventListener('click', function () {
                const tab = this.getAttribute('data-tab');

                // Update active tab style
                document.querySelectorAll('.tab-button').forEach(btn => {
                    btn.classList.remove('text-blue-600', 'border-blue-600');
                    btn.classList.add('text-gray-500', 'hover:text-gray-700');
                });
                this.classList.add('text-blue-600', 'border-blue-600');
                this.classList.remove('text-gray-500', 'hover:text-gray-700');

                // Filter items
                const allItems = document.querySelectorAll('.klaster-item');
                let visibleItems = 0;

                allItems.forEach(item => {
                    if (tab === 'all' || item.getAttribute('data-klaster') === tab) {
                        item.classList.remove('hidden');
                        visibleItems++;
                    } else {
                        item.classList.add('hidden');
                    }
                });

                // Show/hide empty state
                const emptyState = document.getElementById('empty-state');
                if (visibleItems === 0) {
                    emptyState.classList.remove('hidden');
                } else {
                    emptyState.classList.add('hidden');
                }
            });
        });

        // Initialize first tab as active
        document.querySelector('.tab-button').click();

        // Select filter functionality
        document.getElementById('filterKlaster').addEventListener('change', function () {
            const filterValue = this.value.toLowerCase().replace(' ', '-');
            const tabButtons = document.querySelectorAll('.tab-button');

            // Find matching tab and click it
            let found = false;
            tabButtons.forEach(button => {
                if (button.getAttribute('data-tab') === filterValue ||
                    (this.value === 'all' && button.getAttribute('data-tab') === 'all')) {
                    button.click();
                    found = true;
                }
            });

            if (!found && this.value !== 'all') {
                document.querySelector('[data-tab="all"]').click();
            }
        });
    </script>
</body>

</html>
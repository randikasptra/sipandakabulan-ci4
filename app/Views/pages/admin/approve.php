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

                    <!-- Page Header -->
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">Pending Approvals</h1>
                            <p class="mt-2 text-gray-600">Review and approve pending submissions</p>
                        </div>
                    </div>

                    <!-- Filter Dropdown -->
                    <div class="mb-6">
                        <label for="filterKlaster" class="block mb-2 text-sm font-medium text-gray-700">Filter
                            Klaster:</label>
                        <select id="filterKlaster"
                            class="block w-full max-w-xs p-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-100 focus:border-blue-500 text-sm">
                            <option value="all">Semua Klaster</option>
                            <option value="Kelembagaan">Kelembagaan</option>
                            <option value="Klaster 1">Klaster 1</option>
                            <option value="Klaster 2">Klaster 2</option>
                            <option value="Klaster 3">Klaster 3</option>
                            <option value="Klaster 4">Klaster 4</option>
                            <option value="Klaster 5">Klaster 5</option>
                        </select>
                    </div>

                    <?php
                    // Semua klaster
                    $klasterData = [
                        'Kelembagaan' => $kelembagaan ?? [],
                        'Klaster 1' => $klaster1 ?? [],
                        'Klaster 2' => $klaster2 ?? [],
                        'Klaster 3' => $klaster3 ?? [],
                        'Klaster 4' => $klaster4 ?? [],
                        'Klaster 5' => $klaster5 ?? [],
                    ];
                    ?>

                    <!-- Approval Cards -->
                    <div class="space-y-8">
                        <?php foreach ($klasterData as $klaster => $items): ?>
                            <section class="bg-white rounded-xl shadow-sm p-6 klaster-section"
                                data-klaster="<?= $klaster ?>">
                                <div class="flex items-center justify-between mb-6">
                                    <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                                        <span class="w-2 h-6 bg-blue-600 rounded-full mr-3"></span>
                                        <?= esc($klaster) ?>
                                    </h2>
                                    <?php
                                    $pendingCount = array_filter($items, fn($item) => ($item['status'] ?? '') === 'pending');
                                    ?>
                                    <span class="badge bg-blue-100 text-blue-800">
                                        <?= count($pendingCount) ?> Pending
                                    </span>

                                </div>

                                <?php if (!empty($items)): ?>
                                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                                        <?php foreach ($items as $item): ?>
                                            <div
                                                class="card bg-white rounded-xl shadow-card p-5 border border-gray-100 hover:shadow-card-hover">
                                                <div class="flex items-start justify-between">
                                                    <div>
                                                        <h3 class="font-semibold text-gray-800 mb-1">
                                                            <?= $klaster === 'Kelembagaan' ? esc($item['nama_lembaga'] ?? 'Lembaga Baru') : 'Submission #' . esc($item['id']) ?>
                                                        </h3>
                                                        <p class="text-sm text-gray-500 mb-2">
                                                            <?= $klaster === 'Kelembagaan' ? 'Lembaga Registration' : 'User ID: ' . esc($item['user_id']) ?>
                                                        </p>
                                                        <span class="badge bg-blue-50 text-blue-600 text-xs">
                                                            <?= date('d M Y', strtotime($item['created_at'] ?? 'now')) ?>
                                                        </span>
                                                    </div>
                                                    <div class="bg-blue-100 p-2 rounded-lg">
                                                        <i class="fas fa-file-alt text-blue-600"></i>
                                                    </div>
                                                </div>

                                                <div class="mt-4 pt-4 border-t border-gray-100 flex justify-end">
                                                    <?php
                                                    $slug = strtolower(str_replace(' ', '_', $klaster));
                                                    ?>
                                                    <a href="<?= site_url('dashboard/admin/review_' . $slug . '/' . $item['user_id']) ?>"
                                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                                                        <i class="fas fa-eye mr-2"></i>
                                                        Review Details
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    </div>
                                <?php else: ?>
                                    <div class="text-center py-8">
                                        <div class="mx-auto w-24 h-24 text-gray-300 mb-4">
                                            <i class="fas fa-inbox text-5xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-500">No pending approvals</h3>
                                        <p class="mt-1 text-sm text-gray-400">All <?= esc($klaster) ?> submissions have been
                                            processed</p>
                                    </div>
                                <?php endif ?>
                            </section>
                        <?php endforeach ?>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Script Filter Klaster -->
    <script>
        document.getElementById('filterKlaster').addEventListener('change', function () {
            const selected = this.value;
            document.querySelectorAll('.klaster-section').forEach(section => {
                const klaster = section.getAttribute('data-klaster');
                if (selected === 'all' || selected === klaster) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });
        });
    </script>

</body>

</html>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Kelola User') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- ✅ Tambah Chart.js -->
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
    <div class="flex min-h-screen ml-72">

        <!-- Sidebar Admin -->
        <?= $this->include('layouts/sidenav_admin') ?>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden mt-24">

            <!-- Header Admin -->
            <?= $this->include('layouts/header_admin') ?>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Laporan Berkas Disetujui</h1>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php elseif (session()->getFlashdata('error')): ?>
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <!-- ✅ Chart Section -->
                <div class="bg-white p-4 rounded shadow mb-6">
                    <h2 class="text-lg font-semibold mb-2 text-gray-700">Distribusi Jumlah Laporan per Klaster</h2>
                    <canvas id="klasterChart" height="100"></canvas>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded shadow-sm text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 border-b text-left">No</th>
                                <th class="px-4 py-2 border-b text-left">Nama Desa</th>
                                <th class="px-4 py-2 border-b text-left">Nama Klaster</th>
                                <th class="px-4 py-2 border-b text-left">Berkas</th>
                                <th class="px-4 py-2 border-b text-left">Nilai Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($berkas as $b): ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2 align-top"><?= $no++ ?></td>
                                    <td class="px-4 py-2 align-top"><?= esc($b['desa']) ?></td>
                                    <td class="px-4 py-2 align-top"><?= esc($b['nama_klaster']) ?></td>
                                    <td class="px-4 py-2 align-top">
                                        <a href="<?= base_url('uploads/' . $b['file_path']) ?>" target="_blank"
                                            class="text-blue-600 underline hover:text-blue-800 transition">
                                            Download
                                        </a>
                                    </td>
                                    <td class="px-4 py-2 align-top"><?= esc($b['total_nilai']) ?></td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- ✅ Chart.js Script -->
    <script>
    const chartData = <?= $chart_data ?>;
    const labels = Object.keys(chartData);
    const jumlahLaporan = labels.map(label => chartData[label].jumlah_laporan);
    const totalNilai = labels.map(label => chartData[label].total_nilai);

    const ctx = document.getElementById('klasterChart').getContext('2d');
    const klasterChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Jumlah Laporan',
                    data: jumlahLaporan,
                    backgroundColor: 'rgba(59, 130, 246, 0.7)',
                    borderColor: 'rgba(37, 99, 235, 1)',
                    borderWidth: 1,
                    borderRadius: 6
                },
                {
                    label: 'Total Nilai',
                    data: totalNilai,
                    backgroundColor: 'rgba(16, 185, 129, 0.7)',
                    borderColor: 'rgba(5, 150, 105, 1)',
                    borderWidth: 1,
                    borderRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            if (context.dataset.label === 'Jumlah Laporan') {
                                return `${context.raw} laporan`;
                            } else {
                                return `Total Nilai: ${context.raw}`;
                            }
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Nilai / Laporan'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Nama Klaster'
                    }
                }
            }
        }
    });
</script>

</body>

</html>

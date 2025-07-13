<?php
// Daftar indikator per klaster yang ditampilkan (ubah sesuai kebutuhan)
$indikatorList = [
    'AnakAktaKelahiran' => 'Akta Kelahiran Anak',
    'anggaran' => 'Anggaran Desa'
];
?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Kelola User') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">
    <div class="flex min-h-screen ml-72">
        <?= $this->include('layouts/sidenav_admin') ?>

        <div class="flex-1 flex flex-col overflow-hidden mt-24">
            <?= $this->include('layouts/header_admin') ?>

            <main class="flex-1 overflow-y-auto p-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-6">Laporan Berkas Disetujui</h1>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4"><?= session()->getFlashdata('success') ?></div>
                <?php elseif (session()->getFlashdata('error')): ?>
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <!-- Filter dan Search -->
                <form method="get" class="flex flex-wrap gap-4 mb-6">
                    <div>
                        <label for="desa" class="block text-sm font-medium text-gray-700 mb-1">Filter Desa</label>
                        <select name="desa" id="desa" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary-500">
                            <option value="">Semua Desa</option>
                            <?php foreach ($list_desa as $d): ?>
                                <option value="<?= esc($d) ?>" <?= ($d == $desa_filter) ? 'selected' : '' ?>><?= esc($d) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div>
                        <label for="klaster" class="block text-sm font-medium text-gray-700 mb-1">Filter Klaster</label>
                        <select name="klaster" id="klaster" class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary-500">
                            <option value="">Semua Klaster</option>
                            <?php foreach ($list_klaster as $k): ?>
                                <option value="<?= esc($k) ?>" <?= ($k == $klaster_filter) ? 'selected' : '' ?>><?= esc($k) ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div>
                        <label for="search_desa" class="block text-sm font-medium text-gray-700 mb-1">Cari Nama Desa</label>
                        <input type="text" name="search_desa" id="search_desa" placeholder="Cari desa..."
                            value="<?= esc($_GET['search_desa'] ?? '') ?>"
                            class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-primary-500">
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                            class="bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-md text-sm shadow inline-flex items-center gap-2 mt-1.5">
                            <i class="fas fa-magnifying-glass"></i> Cari
                        </button>
                    </div>
                </form>

                <!-- Ringkasan -->
                <div class="flex gap-6 mb-4 text-sm text-gray-700">
                    <div><strong>Total Berkas:</strong> <?= count($berkas) ?></div>
                    <div><strong>Rata-rata Nilai:</strong> <?= number_format(array_sum(array_column($berkas, 'total_nilai')) / (count($berkas) ?: 1), 2) ?></div>
                </div>

                <!-- Chart -->
                <div class="bg-white p-4 rounded shadow mb-6">
                    <h2 class="text-lg font-semibold mb-2 text-gray-700">Distribusi Jumlah Laporan per Klaster</h2>
                    <canvas id="klasterChart" height="100"></canvas>
                </div>

                <!-- Tabel -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded shadow-sm text-sm">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="px-4 py-2 border-b text-left">No</th>
                                <th class="px-4 py-2 border-b text-left">Nama Desa</th>
                                <th class="px-4 py-2 border-b text-left">Nama Klaster</th>
                                <th class="px-4 py-2 border-b text-left">Berkas</th>
                                <th class="px-4 py-2 border-b text-left">Nilai Total</th>
                                <th class="px-4 py-2 border-b text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($berkas as $b): 
                                $folder = strtolower(str_replace(' ', '', $b['nama_klaster'])); // e.g., Klaster 1 -> klaster1
                            ?>
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2"><?= $no++ ?></td>
                                    <td class="px-4 py-2"><?= esc($b['desa']) ?></td>
                                    <td class="px-4 py-2"><?= esc($b['nama_klaster']) ?></td>
                                    <td class="px-4 py-2 space-y-1">
                                        <?php foreach ($indikatorList as $key => $label): ?>
                                            <?php $file = $b[$key . '_file'] ?? null; ?>
                                            <?php if ($file): ?>
                                                <div class="flex items-center gap-1">
                                                    <i class="fas fa-file-archive text-blue-500"></i>
                                                    <a href="<?= base_url('uploads/' . $folder . '/' . $file) ?>" target="_blank"
                                                        class="text-blue-600 hover:text-blue-800 text-sm underline">
                                                        <?= esc($label) ?>
                                                    </a>
                                                </div>
                                            <?php else: ?>
                                                <div class="text-gray-400 text-sm italic"><?= esc($label) ?>: Tidak ada file</div>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    </td>
                                    <td class="px-4 py-2"><?= esc($b['total_nilai']) ?></td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full font-semibold">Terverifikasi</span>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Chart.js Logic -->
    <script>
        const chartData = <?= $chart_data ?>;
        const labels = Object.keys(chartData);
        const jumlahLaporan = labels.map(label => chartData[label].jumlah_laporan);
        const totalNilai = labels.map(label => chartData[label].total_nilai);
        const jumlahDesa = labels.map(label => chartData[label].jumlah_desa);

        const ctx = document.getElementById('klasterChart').getContext('2d');
        new Chart(ctx, {
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
                                const index = context.dataIndex;
                                const desa = jumlahDesa[index];
                                if (context.dataset.label === 'Jumlah Laporan') {
                                    return [`📝 ${context.raw} laporan`, `📍 dari ${desa} desa`];
                                } else {
                                    return [`📊 Total Nilai: ${context.raw}`, `📍 dari ${desa} desa`];
                                }
                            }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'Nilai / Laporan' } },
                    x: { title: { display: true, text: 'Nama Klaster' } }
                }
            }
        });
    </script>
</body>
</html>

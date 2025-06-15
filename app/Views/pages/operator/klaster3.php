<?= $this->include('layouts/navbar') ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Klaster - 3</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root {
            --primary: #1e3a8a;
            --primary-light: #3b82f6;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">

    <!-- Header -->
    <div
        class="bg-white p-6 rounded-xl shadow-md flex flex-col md:flex-row justify-between items-center mb-8 mx-6 mt-6">
        <div>
            <h2 class="text-2xl font-bold mb-2">Form Klaster III</h2>
            <p class="text-gray-600">Silakan isi data sesuai kondisi lapangan dan unggah dokumen pendukung.</p>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-6 py-10 mt-6 bg-white shadow-xl rounded-3xl space-y-12">
        <div class="border-b pb-6 mb-6">
            <h1 class="text-3xl font-bold text-[color:var(--primary)] flex items-center gap-2">
                <i class="ph ph-list-check"></i> Penilaian Klaster III
            </h1>
            <p class="text-sm text-gray-500 mt-1">Isi semua poin dengan cermat dan unggah file pendukung jika tersedia.
            </p>
        </div>

        <form action="/submit-klaster3" method="POST" enctype="multipart/form-data" class="space-y-10">

            <?php
            $klaster3 = [
                [
                    'judul' => '1. Kematian Bayi AKB (Total Nilai 30)',
                    'nama' => 'kematianBayi',
                    'nilai' => 30,
                    'opsi' => [
                        30 => 'Di bawah rata-rata nasional',
                        15 => 'Sama dengan rata-rata nasional',
                        0 => 'Di atas rata-rata nasional',
                    ],
                    'file' => 'KematianBayi.xlsx'
                ],
                [
                    'judul' => '2. Prevalensi Kekurangan Gizi pada Balita (Total Nilai 30)',
                    'nama' => 'giziBalita',
                    'nilai' => 30,
                    'opsi' => [
                        30 => 'Di bawah rata-rata nasional',
                        15 => 'Sama dengan rata-rata nasional',
                        0 => 'Di atas rata-rata nasional',
                    ],
                    'file' => 'GiziBalita.xlsx'
                ],
                [
                    'judul' => '3. ASI Eksklusif (Total Nilai 15)',
                    'nama' => 'asiEksklusif',
                    'nilai' => 15,
                    'opsi' => [
                        0 => '0% ≤ 10%',
                        5 => '≥ 25%',
                        10 => '≥ 50%',
                        15 => '100%',
                    ],
                    'file' => ''
                ],
                [
                    'judul' => '4. Pojok ASI pada Fasilitas Umum Desa (Total Nilai 15)',
                    'nama' => 'pojokAsi',
                    'nilai' => 15,
                    'opsi' => [
                        15 => 'Ada',
                        10 => 'Sedikit',
                        0 => 'Tidak ada',
                    ],
                    'file' => ''
                ],
                [
                    'judul' => '5. Pusat Kesehatan Reproduksi Remaja (Total Nilai 30)',
                    'nama' => 'pusatKespro',
                    'nilai' => 30,
                    'opsi' => [
                        30 => 'Ada',
                        15 => 'Sedikit',
                        0 => 'Tidak ada',
                    ],
                    'file' => ''
                ],
                [
                    'judul' => '6. Imunisasi Dasar Lengkap Bagi Anak (Total Nilai 20)',
                    'nama' => 'imunisasiAnak',
                    'nilai' => 20,
                    'opsi' => [
                        0 => '≤ 10% dari jumlah anak keluarga miskin',
                        10 => '≤ 25% dari jumlah anak keluarga miskin',
                        20 => '100% dari jumlah anak keluarga miskin',
                    ],
                    'file' => ''
                ],
                [
                    'judul' => '7. Anak Keluarga Miskin Dapat Layanan Pengentasan Kemiskinan (Total Nilai 20)',
                    'nama' => 'layananAnakMiskin',
                    'nilai' => 20,
                    'opsi' => [
                        0 => '≤ 10% dari jumlah anak keluarga miskin',
                        10 => '≤ 25% dari jumlah anak keluarga miskin',
                        20 => '100% dari jumlah anak keluarga miskin',
                    ],
                    'file' => ''
                ],
                [
                    'judul' => '8. Kawasan Tanpa Rokok (Total Nilai 20)',
                    'nama' => 'kawasanTanpaRokok',
                    'nilai' => 20,
                    'opsi' => [
                        0 => 'Tidak ada',
                        10 => 'Ada pada kawasan pendidikan dan fasilitas kesehatan',
                        20 => 'Ada pada semua fasilitas layanan umum',
                    ],
                    'file' => ''
                ],
            ];

            foreach ($klaster3 as $k):
                ?>
                <div class="space-y-4 bg-gray-50 p-6 rounded-xl border border-gray-200">
                    <label class="block text-lg font-semibold text-gray-800">
                        <?= $k['judul'] ?>
                        <span class="text-sm text-gray-500">(Total Nilai: <?= $k['nilai'] ?>)</span>
                    </label>

                    <div class="grid gap-2 sm:grid-cols-2 md:grid-cols-3">
                        <?php foreach ($k['opsi'] as $val => $label): ?>
                            <label
                                class="flex items-center gap-2 bg-white border border-gray-300 rounded-lg px-4 py-2 hover:border-[color:var(--primary-light)] cursor-pointer transition">
                                <input type="radio" name="<?= $k['nama'] ?>" value="<?= $val ?>"
                                    class="accent-[color:var(--primary)]" />
                                <span class="text-sm"><?= $label ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <?php if (!empty($k['file'])): ?>
                        <a href="<?= site_url('download?file=' . $k['file']) ?>" target="_blank" download
                            class="inline-flex items-center gap-2 mt-3 px-4 py-2 border border-[color:var(--primary-light)] text-[color:var(--primary-light)] text-sm font-medium rounded-full transition duration-200 hover:bg-[color:var(--primary-light)] hover:text-white">
                            <i class="ph ph-download-simple text-lg"></i>
                            Download Template Excel
                        </a>
                    <?php endif; ?>

                    <label class="flex flex-col gap-2 mt-2">
                        <span class="text-sm font-medium text-gray-600 flex items-center gap-1"><i
                                class="ph ph-upload-simple"></i> Unggah File</span>
                        <input type="file" name="<?= $k['nama'] ?>_file" accept=".pdf,.docx,.xlsx,.jpg,.png"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-[color:var(--primary)] file:text-white file:cursor-pointer" />
                    </label>
                </div>
            <?php endforeach; ?>

            <div class="text-center pt-6">
                <button type="submit"
                    class="bg-[color:var(--primary)] hover:bg-[color:var(--primary-light)] text-white px-8 py-4 rounded-xl font-semibold shadow transition-all duration-300 flex items-center gap-2 justify-center">
                    <i class="ph ph-paper-plane-right"></i> Submit Klaster III
                </button>
            </div>
        </form>
    </div>

</body>

</html>
<?= $this->include('layouts/navbar') ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Klaster - 2</title>
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

    <!-- Header Card -->
    <div
        class="bg-white p-6 rounded-xl shadow-md flex flex-col md:flex-row justify-between items-center mb-8 mx-6 mt-6">
        <div>
            <h2 class="text-2xl font-bold mb-2">Form Klaster II</h2>
            <p class="text-gray-600">Silakan isi data berikut sesuai kondisi di lapangan.</p>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-6 py-10 mt-6 bg-white shadow-xl rounded-3xl space-y-12">
        <div class="border-b pb-6 mb-6">
            <h1 class="text-3xl font-bold text-[color:var(--primary)] flex items-center gap-2">
                <i class="ph ph-list-check"></i> Penilaian Klaster II
            </h1>
            <p class="text-sm text-gray-500 mt-1">Silakan pilih opsi dan unggah file pendukung jika ada.</p>
        </div>

        <form action="/submit-klaster2" method="POST" enctype="multipart/form-data" class="space-y-10">

            <?php
            $klaster2 = [
                [
                    'judul' => '1. Apakah Ada Perkawinan Anak (Total Nilai 25)',
                    'nama' => 'perkawinanAnak',
                    'nilai' => 25,
                    'opsi' => [
                        0 => 'Tidak Ada',
                        10 => '≤ 10%',
                        15 => '10% – 20%',
                        25 => '50%',
                    ],
                    'file' => 'PerkawinanAnak.xlsx'
                ],
                [
                    'judul' => '2. Upaya Yang Dilakukan Untuk Pencegahan Pernikahan Anak (Total Nilai 45)',
                    'nama' => 'pencegahanPernikahan',
                    'nilai' => 45,
                    'opsi' => [
                        0 => 'Tidak Ada',
                        15 => '1 – 3 Program',
                        45 => '≥ 4 Program',
                    ],
                    'file' => '' // tidak ada template excel
                ],
                [
                    'judul' => '3. Tersedia Lembaga Konsultasi Bagi Keluarga (Total Nilai 30)',
                    'nama' => 'lembagaKonsultasi',
                    'nilai' => 30,
                    'opsi' => [
                        15 => 'Tersedia 1 Lembaga',
                        25 => '> 3 Lembaga',
                        30 => '≤ 5 Lembaga',
                    ],
                    'file' => 'LembagaKonsultasi.xlsx'
                ],
            ];

            foreach ($klaster2 as $k):
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
                    <i class="ph ph-paper-plane-right"></i> Submit Klaster II
                </button>
            </div>
        </form>
    </div>
</body>

</html>
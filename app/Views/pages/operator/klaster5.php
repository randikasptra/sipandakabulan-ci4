<?= $this->include('layouts/navbar') ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Klaster - 5</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root {
            --primary: #1e3a8a;
            --primary-light: #3b82f6;
        }
    </style>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        .header-card {
            background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
            box-shadow: 0 10px 15px -3px rgba(30, 58, 138, 0.3), 0 4px 6px -2px rgba(30, 58, 138, 0.1);
        }

        .form-container {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        }

        .radio-option:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2), 0 2px 4px -1px rgba(59, 130, 246, 0.06);
        }

        .file-upload:hover {
            background-color: #f8fafc;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">

    <div
        class="bg-white p-6 rounded-xl shadow-md flex flex-col md:flex-row justify-between items-center mb-8 mx-6 mt-6">
        <div>
            <h2 class="text-2xl font-bold mb-2">Form Klaster IV</h2>
            <p class="text-gray-600">Silakan isi data dan unggah file dalam format chip-style jika tersedia.</p>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-6 py-10 mt-6 bg-white shadow-xl rounded-3xl space-y-12">
        <div class="border-b pb-6 mb-6">
            <h1 class="text-3xl font-bold text-[color:var(--primary)] flex items-center gap-2">
                <i class="ph ph-list-check"></i> Penilaian Klaster V
            </h1>
            <p class="text-sm text-gray-500 mt-1">Pilih jawaban dan unggah file sesuai sub poin.</p>
        </div>

        <form action="/submit-klaster5" method="POST" enctype="multipart/form-data" class="space-y-10">

            <?php
            $klaster5 = [
                [
                    'judul' => '1. Laporan Kekerasan Terhadap Anak yang Dilayani dan Diselesaikan (Total Nilai 40)',
                    'nama' => 'laporanKekerasanAnak',
                    'nilai' => 40,
                    'opsi' => [
                        10 => '0 – 10%',
                        25 => '> 25%',
                        40 => '> 50%',
                    ],
                    'file' => 'LaporanKekerasanAnak.xlsx'
                ],
                [
                    'judul' => '2. Apakah Ada Mekanisme Penanggulangan Bencana (Total Nilai 20)',
                    'nama' => 'mekanismePenanggulanganBencana',
                    'nilai' => 20,
                    'opsi' => [
                        0 => 'Tidak Ada',
                        20 => 'Ada dan Disosialisasikan',
                    ],
                    'file' => ''
                ],
                [
                    'judul' => '3. Adakah Program Pencegahan Kekerasan pada Anak yang Dilaksanakan (Total Nilai 30)',
                    'nama' => 'programPencegahanKekerasan',
                    'nilai' => 30,
                    'opsi' => [
                        0 => 'Tidak Ada',
                        30 => 'Ada dan Disosialisasikan',
                    ],
                    'file' => ''
                ],
                [
                    'judul' => '4. Apakah Ada Program Pencegahan Pekerjaan Anak (Total Nilai 40)',
                    'nama' => 'programPencegahanPekerjaanAnak',
                    'nilai' => 40,
                    'opsi' => [
                        0 => 'Tidak Ada',
                        20 => '≤ 3 Program',
                        40 => '4 – 5 Program',
                    ],
                    'file' => ''
                ],
            ];


            foreach ($klaster5 as $k):
                ?>
                <div class="space-y-5 bg-gray-50 p-6 rounded-xl border border-gray-200 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-primary-500"></div>

                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900"><?= $k['judul'] ?></h3>
                            <p class="text-sm text-gray-500 mt-1">Total Nilai: <span
                                    class="font-medium text-primary-700"><?= $k['nilai'] ?></span></p>
                        </div>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                            <?= $k['nama'] ?>
                        </span>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                        <?php foreach ($k['opsi'] as $val => $label): ?>
                            <label
                                class="radio-option flex items-center gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3 hover:border-primary-500 cursor-pointer transition-all duration-200">
                                <input type="radio" name="<?= $k['nama'] ?>" value="<?= $val ?>"
                                    class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300" />
                                <div class="flex-1">
                                    <span class="block text-sm font-medium text-gray-700"><?= $label ?></span>
                                    <span class="block text-xs text-primary-600 font-semibold mt-1"><?= $val ?> poin</span>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <div class="bg-blue-50 border border-blue-100 rounded-lg px-4 py-2">
                        <p class="text-sm font-medium text-primary-800 flex items-center gap-2">
                            <i class="ph ph-info text-lg"></i>
                            <span>Pilih salah satu opsi di atas</span>
                        </p>
                    </div>

                    <?php if (!empty($k['file'])): ?>
                        <a href="<?= site_url('download?file=' . $k['file']) ?>" target="_blank" download
                            class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-primary-500 text-primary-600 text-sm font-medium rounded-lg transition duration-200 hover:bg-primary-50">
                            <i class="ph ph-download-simple text-lg"></i>
                            Download Template Excel
                        </a>
                    <?php endif; ?>

                    <div class="mt-2">
                        <label class="block">
                            <span class="text-sm font-medium text-gray-700 flex items-center gap-2 mb-1">
                                <i class="ph ph-paperclip"></i>
                                Unggah Dokumen Pendukung
                            </span>
                            <div class="mt-1 flex items-center">
                                <label
                                    class="flex flex-col items-center justify-center w-full border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition file-upload">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 px-4">
                                        <i class="ph ph-cloud-arrow-up text-3xl text-gray-400 mb-2"></i>
                                        <p class="mb-2 text-sm text-gray-500">
                                            <span class="font-semibold">Klik untuk upload</span> atau drag & drop
                                        </p>
                                        <p class="text-xs text-gray-400">Format .PDF, .DOCX, .XLSX, .JPG, .PNG (MAX. 10MB)
                                        </p>
                                    </div>
                                    <input type="file" name="<?= $k['nama'] ?>_file" accept=".pdf,.docx,.xlsx,.jpg,.png"
                                        class="hidden" />
                                </label>
                            </div>
                            <p class="text-xs mt-2 text-gray-500 file-name-preview"></p>
                        </label>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="text-center pt-6">
                <button type="submit"
                    class="bg-[color:var(--primary)] hover:bg-[color:var(--primary-light)] text-white px-8 py-4 rounded-xl font-semibold shadow transition-all duration-300 flex items-center gap-2 justify-center">
                    <i class="ph ph-paper-plane-right"></i> Submit Klaster V
                </button>
            </div>

        </form>
    </div>

</body>

</html>
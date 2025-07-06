<?= $this->include('layouts/navbar_klaster') ?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Klaster - 2</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
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

<body class="bg-gray-50 font-sans text-gray-800 antialiased">

    <!-- Modern Header Card -->
 <div class="mx-28 my-24">
    <div class="bg-gradient-to-br from-blue-900 to-blue-700 p-6 rounded-2xl text-white shadow-lg flex flex-col lg:flex-row gap-5 items-start">
        <!-- User Info -->
        <div class="flex-1 space-y-1.5">
            <h2 class="text-xl font-bold truncate">
                Selamat Datang, <?= esc($user_name ?? 'Pengguna'); ?>!
            </h2>
            <div class="flex flex-wrap gap-x-6 gap-y-2 text-sm text-blue-100">
                <span class="flex items-center gap-1.5">
                    <i class="ph ph-envelope-simple text-blue-200"></i>
                    <?= esc($user_email ?? 'email@example.com'); ?>
                </span>
                <span class="flex items-center gap-1.5">
                    <i class="ph ph-user text-blue-200"></i>
                    Tipe: <span class="font-medium text-white"><?= esc(ucfirst($user_role ?? 'User')); ?></span>
                </span>
            </div>
        </div>

        <!-- Evaluation Status -->
        <div class="bg-white/10 backdrop-blur-sm border border-white/15 rounded-lg p-4 w-full lg:w-64 space-y-2.5">
            <p class="<?= ($status ?? '') === 'approved' ? 'text-green-300' : 'text-yellow-300' ?> font-medium flex items-center justify-center gap-1.5">
                <i class="ph <?= ($status ?? '') === 'approved' ? 'ph-check-circle' : 'ph-clock' ?>"></i>
                <?= ($status ?? '') === 'approved' ? 'Evaluasi Disetujui' : 'Menunggu Persetujuan' ?>
            </p>

            <?php
                $nilaiEm = $nilai_em ?? 0;
                $maks = $nilai_maksimal ?? 100;
                $presentase = ($maks > 0) ? min(100, round(($nilaiEm / $maks) * 100)) : 0;
            ?>

            <div class="space-y-1 text-center">
                <p class="text-xs text-blue-100">
                    Nilai EM: <span class="font-semibold text-white"><?= esc($nilaiEm); ?></span>/<?= esc($maks); ?>
                </p>
                <div class="w-full h-2 bg-white/20 rounded-full overflow-hidden">
                    <div class="bg-green-300 h-full transition-all duration-500" style="width: <?= $presentase ?>%"></div>
                </div>
                <p class="text-xs text-blue-100"><?= $presentase ?>% Complete</p>
            </div>
        </div>
    </div>
</div>

<!-- Flashdata -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="mx-6 mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="mx-6 mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<!-- Form Container -->
<div class="max-w-5xl mx-auto px-6 py-10 bg-white rounded-2xl form-container mb-16">
    <div class="text-center mb-10">
       <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-50 rounded-full mb-4">
        <!-- Ikon Form/Clipboard (Tailwind CSS Heroicons) -->
        <svg class="inline-flex w-8 h-8 text-primary-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
    </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            Penilaian Klaster II
        </h1>
        <p class="text-gray-500 max-w-2xl mx-auto">Silakan pilih opsi dan unggah file pendukung jika ada untuk memastikan penilaian yang akurat.</p>
    </div>

    <form action="<?= site_url('/submit-klaster2') ?>" method="POST" enctype="multipart/form-data" class="space-y-8">
        <?php
        $formReadonly = ($status === 'pending' || $status === 'approved');

        $klaster = [
            [
                'judul' => '1. Apakah Ada Perkawinan Anak (Total Nilai 25)',
                'nama' => 'perkawinanAnak',
                'nilai' => 25,
                'opsi' => [
                    0 => 'Tidak Ada',
                    10 => '≤ 10%',
                    15 => '10% – 20%',
                    25 => '> 20%',
                ],
                'file' => 'PerkawinanAnak.xlsx'
            ],
            [
                'judul' => '2. Upaya Untuk Pencegahan Pernikahan Anak (Total Nilai 45)',
                'nama' => 'pencegahanPernikahan',
                'nilai' => 45,
                'opsi' => [
                    0 => 'Tidak Ada',
                    15 => '1 – 3 Program',
                    45 => '≥ 4 Program',
                ],
                'file' => ''
            ],
            [
                'judul' => '3. Tersedia Lembaga Konsultasi Bagi Keluarga (Total Nilai 30)',
                'nama' => 'lembagaKonsultasi',
                'nilai' => 30,
                'opsi' => [
                    15 => 'Tersedia 1 Lembaga',
                    25 => '≤ 3 Lembaga',
                    30 => '≥ 5 Lembaga',
                ],
                'file' => 'LembagaKonsultasi.xlsx'
            ],
        ];

        foreach ($klaster as $k):
            $selected = $existing[$k['nama']] ?? old($k['nama']);
            $readonly = $formReadonly ? 'disabled' : '';
            $fileUploaded = $existing[$k['nama'] . '_file'] ?? null;
        ?>
        <div class="space-y-5 bg-gray-50 p-6 rounded-xl border border-gray-200 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-1.5 h-full bg-primary-500"></div>
            <div class="flex justify-between items-start">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900"><?= $k['judul'] ?></h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Total Nilai: <span class="font-medium text-primary-700"><?= $k['nilai'] ?></span>
                    </p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800"><?= $k['nama'] ?></span>
            </div>

            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-5">
                <?php foreach ($k['opsi'] as $val => $label): ?>
                    <label class="radio-option flex items-center gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3 <?= $readonly ? 'cursor-not-allowed' : 'cursor-pointer' ?>">
                        <input type="radio" name="<?= $k['nama'] ?>" value="<?= $val ?>" <?= ($selected == $val) ? 'checked' : '' ?> <?= $readonly ?>
                               class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300" />
                        <div class="flex-1">
                            <span class="block text-sm font-medium text-gray-700"><?= $label ?></span>
                            <span class="block text-xs text-primary-600 font-semibold mt-1"><?= $val ?> poin</span>
                        </div>
                    </label>
                <?php endforeach; ?>
            </div>

            <?php if (!$formReadonly): ?>
                <div class="bg-blue-50 border border-blue-100 rounded-lg px-4 py-2">
                    <p class="text-sm font-medium text-primary-800 flex items-center gap-2">
                        <i class="ph ph-info text-lg"></i>
                        <?= is_numeric($selected) ? "Nilai terpilih: $selected poin" : 'Belum memilih nilai' ?>
                    </p>
                </div>
            <?php else: ?>
                <div class="bg-green-50 border border-green-100 rounded-lg px-4 py-2 text-green-800">
                    <p class="text-sm font-medium flex items-center gap-2">
                        <i class="ph ph-check-circle"></i>
                        <?= is_numeric($selected) ? "Nilai yang dipilih: $selected poin" : "Belum memilih nilai" ?>
                    </p>
                </div>
            <?php endif; ?>

            <?php if ($k['file']): ?>
                <a href="<?= site_url('download?file=' . $k['file']) ?>" target="_blank" download
                   class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-primary-500 text-primary-600 text-sm font-medium rounded-lg hover:bg-primary-50 transition">
                    <i class="ph ph-download-simple text-lg"></i>
                    Download Template Excel
                </a>
            <?php endif; ?>

            <?php if ($formReadonly): ?>
                <p class="text-sm mt-2 text-gray-600">
                    <i class="ph ph-paperclip"></i> File yang diunggah: <strong><?= $fileUploaded ?: 'Tidak ada file' ?></strong>
                </p>
            <?php else: ?>
                <div class="mt-2">
                    <label class="block">
                        <span class="text-sm font-medium text-gray-700 flex items-center gap-2 mb-1">
                            <i class="ph ph-paperclip"></i>
                            Unggah Dokumen Pendukung
                        </span>
                        <div class="mt-1 flex items-center">
                            <label class="upload-wrapper flex flex-col items-center justify-center w-full border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                                <div class="upload-instruction flex flex-col items-center justify-center pt-5 pb-6 px-4">
                                    <i class="ph ph-cloud-arrow-up text-3xl text-gray-400 mb-2"></i>
                                    <p class="mb-2 text-sm text-gray-500">
                                        <span class="font-semibold">Klik untuk upload</span> atau drag & drop
                                    </p>
                                    <p class="text-xs text-gray-400">Format .ZIP (MAX. 10MB)</p>
                                </div>
                                <div class="file-preview hidden flex-col items-center justify-center text-center p-5">
                                    <i class="ph ph-file-zip text-3xl text-primary-600 mb-2"></i>
                                    <p class="text-sm font-medium text-primary-700 filename-preview"></p>
                                </div>
                                <input type="file" name="<?= $k['nama'] ?>_file" accept=".zip" class="hidden" />
                            </label>
                        </div>
                    </label>
                </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>

        <?php if (!$formReadonly): ?>
            <div class="pt-8 border-t border-gray-200 flex flex-col sm:flex-row justify-center gap-4">
                <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-primary-700 to-primary-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition duration-300 flex items-center justify-center gap-2">
                    <i class="ph ph-paper-plane-tilt"></i>
                    Submit Data
                </button>
                <button type="reset"
                        class="px-8 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition duration-300 flex items-center justify-center gap-2">
                    <i class="ph ph-arrow-counter-clockwise"></i>
                    Reset Form
                </button>
            </div>
        <?php else: ?>
            <div class="pt-8 border-t border-gray-200 text-center text-sm text-gray-500">
                Form sudah dikirim
            </div>
        <?php endif; ?>
    </form>

    <?php if ($formReadonly): ?>
        <div class="pt-8 border-t border-gray-200 flex flex-col sm:flex-row justify-center gap-4">
            <form action="<?= site_url('klaster2/batal') ?>" method="post" onsubmit="return confirm('Yakin ingin membatalkan pengiriman data ini?');">
                <?= csrf_field() ?>
                <button type="submit"
                        <?= $status !== 'pending' ? 'disabled class="cursor-not-allowed opacity-50 px-8 py-3 bg-gray-100 border border-gray-300 text-gray-500 font-semibold rounded-lg"' : 'class="px-8 py-3 bg-red-100 border border-red-300 text-red-700 font-semibold rounded-lg hover:bg-red-200 transition duration-300 flex items-center justify-center gap-2"' ?>>
                    <i class="ph ph-x-circle"></i>
                    Batal Kirim
                </button>
            </form>
        </div>
    <?php endif; ?>
</div>


    <script>
        // Show uploaded file name with better UI
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', e => {
                const parent = input.closest('label');
                const preview = parent.querySelector('.file-name-preview');
                if (input.files.length > 0) {
                    preview.innerHTML = `<span class="text-green-600 font-medium"><i class="ph ph-check-circle"></i> File dipilih:</span> ${input.files[0].name}`;
                    
                    // Change upload box style
                    const uploadBox = input.previousElementSibling;
                    uploadBox.classList.remove('border-gray-300', 'bg-gray-50');
                    uploadBox.classList.add('border-green-300', 'bg-green-50');
                } else {
                    preview.textContent = '';
                }
            });
        });

        // Update radio selection feedback
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const parentSection = this.closest('div[class*="space-y-5 bg-gray-50"]');
                const infoBox = parentSection.querySelector('[class*="bg-blue-50"]');
                const labelText = this.parentElement.querySelector('span:first-child').textContent;
                const value = this.value;
                
                infoBox.innerHTML = `
                    <p class="text-sm font-medium text-primary-800 flex items-center gap-2">
                        <i class="ph ph-check-circle text-lg text-green-500"></i>
                        <span>Terpilih: ${labelText} (${value} poin)</span>
                    </p>
                `;
                infoBox.classList.remove('bg-blue-50', 'border-blue-100');
                infoBox.classList.add('bg-green-50', 'border-green-100');
            });
        });

            // Menampilkan nama file ZIP yang diupload secara real-time
    document.querySelectorAll('.upload-wrapper').forEach(wrapper => {
    const input = wrapper.querySelector('input[type="file"]');
    const instruction = wrapper.querySelector('.upload-instruction');
    const preview = wrapper.querySelector('.file-preview');
    const filename = wrapper.querySelector('.filename-preview');

    input.addEventListener('change', () => {
        if (input.files.length > 0) {
            instruction.classList.add('hidden');
            preview.classList.remove('hidden');
            filename.textContent = input.files[0].name;
        } else {
            instruction.classList.remove('hidden');
            preview.classList.add('hidden');
            filename.textContent = '';
        }
    });
});
    </script>

</body>

</html>
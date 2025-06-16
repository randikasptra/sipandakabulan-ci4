<?= $this->include('layouts/navbar') ?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Klaster - 1</title>
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
        
        .progress-bar {
            transition: width 1s ease-in-out;
        }
        
        .file-upload:hover {
            background-color: #f8fafc;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans text-gray-800 antialiased">

    <!-- Header Card -->
    <div class="mt-24 header-card p-8 rounded-2xl text-white mx-6 mt-6 mb-10">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center">
            <div class="mb-6 md:mb-0">
                <h2 class="text-2xl md:text-3xl font-bold mb-2">Selamat Datang, <?= esc($user_name ?? 'Nama Pengguna'); ?>!</h2>
                <p class="text-primary-100 flex flex-wrap gap-3 items-center text-sm md:text-base">
                    <span class="flex items-center gap-1"><i class="ph ph-envelope-simple"></i> <?= esc($user_email ?? 'email@example.com'); ?></span>
                    <span class="flex items-center gap-1"><i class="ph ph-user"></i> Tipe: <span class="font-semibold text-white"><?= esc(ucfirst($user_role ?? 'User')); ?></span></span>
                </p>
            </div>
            <div class="text-center bg-white/10 backdrop-blur-sm p-4 rounded-xl border border-white/20">
                <?php if (($status ?? '') === 'approved'): ?>
                    <p class="text-green-300 font-bold text-lg flex items-center gap-2 justify-center">
                        <i class="ph ph-check-circle"></i> Evaluasi Disetujui
                    </p>
                <?php else: ?>
                    <p class="text-yellow-300 font-bold text-lg flex items-center gap-2 justify-center">
                        <i class="ph ph-clock"></i> Menunggu Persetujuan
                    </p>
                <?php endif; ?>

                <div class="mt-3">
                    <p class="text-primary-100">
                        Nilai EM: <span class="font-bold text-white"><?= esc($nilai_em ?? '0'); ?></span> | 
                        Maks: <?= esc($nilai_maksimal ?? '1000'); ?>
                    </p>

                    <?php
                    $presentase = 0;
                    if (!empty($nilai_em) && !empty($nilai_maksimal) && $nilai_maksimal != 0) {
                        $presentase = min(100, round(($nilai_em / $nilai_maksimal) * 100));
                    }
                    ?>
                    <div class="w-48 bg-white/20 rounded-full h-2.5 mt-2 mx-auto">
                        <div class="bg-green-300 h-2.5 rounded-full progress-bar"
                            style="width: <?= $presentase ?>%"></div>
                    </div>
                    <p class="text-xs text-primary-100 mt-1"><?= $presentase ?>% Complete</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-5xl mx-auto px-6 py-10 bg-white rounded-2xl form-container mb-16">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary-50 rounded-full mb-4">
                <i class="ph ph-list-check text-3xl text-primary-700"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                Form Penilaian Klaster 1
            </h1>
            <p class="text-gray-500 max-w-2xl mx-auto">Isi sesuai kondisi lapangan dan unggah dokumen pendukung untuk memastikan penilaian yang akurat dan transparan.</p>
        </div>

        <form action="/submit-klaster1" method="POST" enctype="multipart/form-data" class="space-y-8">

            <?php
            $klaster = [
                [
                    'judul' => '1. Anak Yang Memiliki Akta Kelahiran (Total Nilai 60)',
                    'nama' => 'AnakAktaKelahiran',
                    'nilai' => 60,
                    'opsi' => [
                        0 => '≤ 10%',
                        20 => '10% – 20%',
                        40 => '20% – 80%',
                        60 => '80% – 100%',
                    ],
                    'file' => 'AnakAktaKelahiran.xlsx'
                ],
                [
                    'judul' => '2. Anak Yang Memiliki Kartu Identitas Anak (Jumlah Total 60)',
                    'nama' => 'anggaran',
                    'nilai' => 60,
                    'opsi' => [
                        0 => '≤ 10%',
                        20 => '10% – 20%',
                        40 => '20% – 80%',
                        60 => '80% – 100%',
                    ],
                    'file' => ''
                ],
            ];

            foreach ($klaster as $k):
                ?>
                <div class="space-y-5 bg-gray-50 p-6 rounded-xl border border-gray-200 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-1.5 h-full bg-primary-500"></div>
                    
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900"><?= $k['judul'] ?></h3>
                            <p class="text-sm text-gray-500 mt-1">Total Nilai: <span class="font-medium text-primary-700"><?= $k['nilai'] ?></span></p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
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
                        <p class="text-sm font-medium text-primary-800 flex items-center gap-2" id="<?= $k['nama'] ?>_selected">
                            <i class="ph ph-info text-lg"></i>
                            <span>Belum memilih nilai</span>
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
                                <label class="flex flex-col items-center justify-center w-full border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition file-upload">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 px-4">
                                        <i class="ph ph-cloud-arrow-up text-3xl text-gray-400 mb-2"></i>
                                        <p class="mb-2 text-sm text-gray-500">
                                            <span class="font-semibold">Klik untuk upload</span> atau drag & drop
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            <?= str_contains($k['file'], '.xlsx') ? 'Format .XLSX (MAX. 10MB)' : 'Format .PDF, .DOCX, .JPG, .PNG (MAX. 10MB)' ?>
                                        </p>
                                    </div>
                                   <input type="file" name="<?= $k['nama'] ?>_file" accept=".zip" class="hidden" />
                                </label>
                            </div>
                            <p class="text-xs mt-2 text-gray-500 file-name-preview"></p>
                        </label>
                    </div>
                </div>
            <?php endforeach; ?>

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
        </form>
    </div>

    <script>
        // Update selected value text on radio change
        document.querySelectorAll('form div[class*="space-y-5 bg-gray-50"]').forEach(section => {
            const name = section.querySelector('input[type="radio"]').name;
            const display = section.querySelector(`#${name}_selected span`);
            section.querySelectorAll(`input[name="${name}"]`).forEach(radio => {
                radio.addEventListener('change', e => {
                    const val = e.target.value;
                    const label = e.target.parentElement.querySelector('span:first-child').textContent;
                    display.textContent = `Nilai terpilih: ${val} poin (${label})`;
                    section.querySelector('[class*="bg-blue-50"]').classList.remove('bg-blue-50', 'border-blue-100', 'text-primary-800');
                    section.querySelector('[class*="bg-blue-50"]').classList.add('bg-green-50', 'border-green-100', 'text-green-800');
                });
            });
        });

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
    </script>

</body>

</html>
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
            $formReadonly = in_array($status, ['pending', 'approved']);

            $klaster = [

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


                 foreach ($klaster as $k):
        $selected = isset($existing[$k['nama']]) ? $existing[$k['nama']] : old($k['nama']);
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
                            <label
                                class="radio-option flex items-center gap-3 bg-white border border-gray-200 rounded-lg px-4 py-3 <?= $readonly ? 'cursor-not-allowed' : 'cursor-pointer' ?>">
                                <input type="radio" name="<?= $k['nama'] ?>" value="<?= $val ?>" <?= ($selected == $val) ? 'checked' : '' ?>
                                <?= $readonly ?>
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
                <p class="text-sm font-medium text-primary-800 flex items-center gap-2" id="<?= $k['nama'] ?>_selected">
                    <i class="ph ph-info text-lg"></i>
                    <span><?= is_numeric($selected) ? "Nilai terpilih: $selected poin" : 'Belum memilih nilai' ?></span>
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
                class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-primary-500 text-primary-600 text-sm font-medium rounded-lg transition duration-200 hover:bg-primary-50">
                <i class="ph ph-download-simple text-lg"></i>
                Download Template Excel
            </a>
        <?php endif; ?>

        <?php if ($formReadonly): ?>
            <p class="text-sm mt-2 text-gray-600">
                <i class="ph ph-paperclip"></i> File yang diunggah:
                <strong><?= $fileUploaded ?: 'Tidak ada file' ?></strong>
            </p>
        <?php else: ?>
            <div class="mt-2">
                <label class="block">
                    <span class="text-sm font-medium text-gray-700 flex items-center gap-2 mb-1">
                        <i class="ph ph-paperclip"></i>
                        Unggah Dokumen Pendukung
                    </span>
                    <div class="mt-1 flex items-center">
                        <label
                            class="upload-wrapper flex flex-col items-center justify-center w-full border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition relative overflow-hidden">
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
            Form sudah dikirim dan sedang diproses, tidak bisa diubah.
        </div>
    <?php endif; ?>
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
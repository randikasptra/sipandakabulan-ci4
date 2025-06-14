<?= $this->include('layouts/navbar') ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Klaster Kelembagaan</title>
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
            <h2 class="text-2xl font-bold mb-2">Selamat Datang, <?= esc($user_name ?? 'Nama Pengguna'); ?>!</h2>
            <p class="text-gray-600 flex flex-wrap gap-2 items-center text-sm">
                <i class="ph ph-envelope-simple text-gray-500"></i> <?= esc($user_email ?? 'email@example.com'); ?> |
                <i class="ph ph-user text-gray-500"></i> Tipe: <span
                    class="font-semibold text-blue-800"><?= esc(ucfirst($user_role ?? 'User')); ?></span>
            </p>
        </div>
        <div class="mt-4 md:mt-0 text-center">
            <?php if (($status ?? '') === 'approved'): ?>
                <p class="text-green-600 font-bold text-lg flex items-center gap-1 justify-center"><i
                        class="ph ph-check-circle"></i> Evaluasi Sudah Disetujui</p>
            <?php else: ?>
                <p class="text-yellow-600 font-bold text-lg flex items-center gap-1 justify-center"><i
                        class="ph ph-clock"></i> Evaluasi Belum Disetujui</p>
            <?php endif; ?>

            <p class="text-gray-700 mt-1 text-sm">
                Nilai EM: <span class="font-bold"><?= esc($nilai_em ?? '0'); ?></span> |
                Maks: <?= esc($nilai_maksimal ?? '1000'); ?>
            </p>

            <?php
            $presentase = 0;
            if (!empty($nilai_em) && !empty($nilai_maksimal) && $nilai_maksimal != 0) {
                $presentase = min(100, round(($nilai_em / $nilai_maksimal) * 100));
            }
            ?>
            <div class="w-48 bg-gray-300 rounded-full h-3 mt-2">
                <div class="bg-green-500 h-3 rounded-full transition-all duration-500"
                    style="width: <?= $presentase ?>%"></div>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-5xl mx-auto px-6 py-10 mt-6 bg-white shadow-xl rounded-3xl space-y-12">
        <div class="border-b pb-6 mb-6">
            <h1 class="text-3xl font-bold text-[color:var(--primary)] flex items-center gap-2">
                <i class="ph ph-list-check"></i> Form Penilaian Klaster Kelembagaan
            </h1>
            <p class="text-sm text-gray-500 mt-1">Isi sesuai kondisi lapangan dan unggah dokumen pendukung (jika ada).
            </p>
        </div>

        <form action="/submit-kelembagaan" method="POST" enctype="multipart/form-data" class="space-y-10"
            id="formKelembagaan">

            <?php
            $klaster = [
                [
                    'judul' => '1. Adanya Peraturan yang mencakup lima klaster',
                    'nama' => 'peraturan',
                    'nilai' => 60,
                    'opsi' => [
                        0 => 'Tidak ada',
                        15 => 'Ada 1 SK',
                        30 => 'Ada 2–3 SK',
                        45 => 'Ada 4 SK',
                        60 => 'Ada ≥5 SK'
                    ],
                    'file' => 'peraturan.xlsx'
                ],
                [
                    'judul' => '2. Adanya Anggaran Responsif Anak',
                    'nama' => 'anggaran',
                    'nilai' => 50,
                    'opsi' => [
                        0 => 'Tidak ada',
                        10 => '≤5%',
                        20 => '6–10%',
                        35 => '11–20%',
                        50 => '≥30%'
                    ],
                    'file' => 'anggaran.xlsx'
                ],
                [
                    'judul' => '3. Ada Forum Anak Desa',
                    'nama' => 'forum_anak',
                    'nilai' => 40,
                    'opsi' => [
                        0 => 'Tidak ada',
                        13 => 'Ada tapi tidak aktif',
                        26 => 'Ada, aktif sesekali',
                        40 => 'Ada dan aktif rutin'
                    ],
                    'file' => ''
                ],
                [
                    'judul' => '4. Ada Data Terpilah mencakup 5 klaster',
                    'nama' => 'data_terpilah',
                    'nilai' => 50,
                    'opsi' => [
                        0 => 'Tidak ada',
                        15 => '1 Klaster',
                        30 => '2–3 Klaster',
                        40 => '4 Klaster',
                        50 => '5 Klaster'
                    ],
                    'file' => 'data_terpilah.xlsx'
                ],
                [
                    'judul' => '5.Adakah dunia usaha di lingkungan desa yang memiliki keterlibatan dalam pemenuhan hak anak (Total Nilai 20)',
                    'nama' => 'dunia_usaha',
                    'nilai' => 20,
                    'opsi' => [
                        0 => 'Tidak ada',
                        10 => '1–2 usaha',
                        15 => '3 usaha',
                        20 => '≥4 usaha'
                    ],
                    'file' => 'dunia_usaha.xlsx'
                ]
            ];

            foreach ($klaster as $k):
                $first_key = array_key_first($k['opsi']);
                ?>
                <fieldset class="space-y-4 bg-gray-50 p-6 rounded-xl border border-gray-200">
                    <legend class="block text-lg font-semibold text-gray-800 flex justify-between items-center">
                        <span><?= $k['judul'] ?></span>
                        <span class="text-sm text-gray-500">(Total Nilai: <?= $k['nilai'] ?>)</span>
                    </legend>

                    <div class="grid gap-2 sm:grid-cols-2 md:grid-cols-3">
                        <?php foreach ($k['opsi'] as $val => $label): ?>
                            <label
                                class="flex items-center gap-2 bg-white border border-gray-300 rounded-lg px-4 py-2 hover:border-[color:var(--primary-light)] cursor-pointer transition">
                                <input type="radio" name="<?= $k['nama'] ?>" value="<?= $val ?>"
                                    class="accent-[color:var(--primary)]" <?php if ($val === $first_key)
                                        echo 'required'; ?> />
                                <span class="text-sm"><?= $label ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <p class="text-sm mt-1 font-medium text-[color:var(--primary)]" id="<?= $k['nama'] ?>_selected">Belum
                        memilih nilai</p>

                    <?php if ($k['file']): ?>
                        <a href="<?= site_url('download?file=' . $k['file']) ?>" target="_blank" download
                            class="inline-flex items-center gap-2 mt-3 px-4 py-2 border border-[color:var(--primary-light)] text-[color:var(--primary-light)] text-sm font-medium rounded-full transition duration-200 hover:bg-[color:var(--primary-light)] hover:text-white">
                            <i class="ph ph-download-simple text-lg"></i>
                            Download Template Excel
                        </a>
                    <?php endif; ?>

                    <label class="flex flex-col gap-2 mt-2">
                        <span class="text-sm font-medium text-gray-600 flex items-center gap-1"><i
                                class="ph ph-upload-simple"></i> Unggah File</span>
                        <input type="file" name="<?= $k['nama'] ?>_file" accept=".zip" ...
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-[color:var(--primary)] file:text-white file:cursor-pointer" />

                        <p class="text-xs mt-1 text-gray-600 file-name-preview"></p>
                    </label>
                </fieldset>
            <?php endforeach; ?>

            <div class="text-center flex justify-center gap-4 pt-6">
                <button type="submit"
                    class="bg-[color:var(--primary)] hover:bg-[color:var(--primary-light)] text-white px-8 py-3 rounded-xl font-semibold text-lg transition duration-300">
                    Submit
                </button>
                <button type="reset"
                    class="bg-gray-400 hover:bg-gray-500 text-white px-8 py-3 rounded-xl font-semibold text-lg transition duration-300">
                    Reset
                </button>
            </div>
        </form>
    </div>

    <script>
        // Update selected value text on radio change
        document.querySelectorAll('form#formKelembagaan fieldset').forEach(fieldset => {
            const name = fieldset.querySelector('input[type="radio"]').name;
            const display = fieldset.querySelector(#${ name }_selected);
            fieldset.querySelectorAll(input[name = "${name}"]).forEach(radio => {
                radio.addEventListener('change', e => {
                    const val = e.target.value;
                    const label = e.target.nextElementSibling.textContent;
                    display.textContent = Nilai terpilih: ${ val } (${ label });
            });
        });
        });

        // Show uploaded file name
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', e => {
                const p = input.parentElement.querySelector('.file-name-preview');
                if (input.files.length > 0) {
                    p.textContent = File dipilih: ${ input.files[0].name };
                } else {
                    p.textContent = '';
                }
            });
        });
    </script>

</body>

</html>
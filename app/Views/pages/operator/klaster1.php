<?= $this->include('layouts/navbar') ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Klaster - 1</title>
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
    <div class="bg-white p-6 rounded-xl shadow-md flex flex-col md:flex-row justify-between items-center mb-8 mx-6 mt-6">
        <div>
            <h2 class="text-2xl font-bold mb-2">Selamat Datang, <?= esc($user_name ?? 'Nama Pengguna'); ?>!</h2>
            <p class="text-gray-600 flex flex-wrap gap-2 items-center text-sm">
                <i class="ph ph-envelope-simple text-gray-500"></i> <?= esc($user_email ?? 'email@example.com'); ?> |
                <i class="ph ph-user text-gray-500"></i> Tipe: <span class="font-semibold text-blue-800"><?= esc(ucfirst($user_role ?? 'User')); ?></span>
            </p>
        </div>
        <div class="mt-4 md:mt-0 text-center">
            <?php if (($status ?? '') === 'approved') : ?>
                <p class="text-green-600 font-bold text-lg flex items-center gap-1 justify-center"><i class="ph ph-check-circle"></i> Evaluasi Sudah Disetujui</p>
            <?php else : ?>
                <p class="text-yellow-600 font-bold text-lg flex items-center gap-1 justify-center"><i class="ph ph-clock"></i> Evaluasi Belum Disetujui</p>
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
                <div class="bg-green-500 h-3 rounded-full transition-all duration-500" style="width: <?= $presentase ?>%"></div>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="max-w-5xl mx-auto px-6 py-10 mt-6 bg-white shadow-xl rounded-3xl space-y-12">
        <div class="border-b pb-6 mb-6">
            <h1 class="text-3xl font-bold text-[color:var(--primary)] flex items-center gap-2">
                <i class="ph ph-list-check"></i> Form Penilaian Klaster 1
            </h1>
            <p class="text-sm text-gray-500 mt-1">Isi sesuai kondisi lapangan dan unggah dokumen pendukung (jika ada).</p>
        </div>

        <form action="/submit-klaster1" method="POST" enctype="multipart/form-data" class="space-y-10">

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

            foreach ($klaster as $k) :
            ?>
                <div class="space-y-4 bg-gray-50 p-6 rounded-xl border border-gray-200">
                    <label class="block text-lg font-semibold text-gray-800">
                        <?= $k['judul'] ?>
                        <span class="text-sm text-gray-500">(Total Nilai: <?= $k['nilai'] ?>)</span>
                    </label>

                    <div class="grid gap-2 sm:grid-cols-2 md:grid-cols-3">
                        <?php foreach ($k['opsi'] as $val => $label) : ?>
                            <label class="flex items-center gap-2 bg-white border border-gray-300 rounded-lg px-4 py-2 hover:border-[color:var(--primary-light)] cursor-pointer transition">
                                <input type="radio" name="<?= $k['nama'] ?>" value="<?= $val ?>" class="accent-[color:var(--primary)]" />
                                <span class="text-sm"><?= $label ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>

                    <a href="<?= site_url('download?file=' . $k['file']) ?>" target="_blank" download
                        class="inline-flex items-center gap-2 mt-3 px-4 py-2 border border-[color:var(--primary-light)] text-[color:var(--primary-light)] text-sm font-medium rounded-full transition duration-200 hover:bg-[color:var(--primary-light)] hover:text-white">
                        <i class="ph ph-download-simple text-lg"></i>
                        Download Template Excel
                    </a>


                    <label class="flex flex-col gap-2 mt-2">
                        <span class="text-sm font-medium text-gray-600 flex items-center gap-1"><i class="ph ph-upload-simple"></i> Unggah File</span>
                        <input type="file" name="<?= $k['nama'] ?>_file" accept="<?= str_contains($k['file'], '.xlsx') ? '.xlsx' : '.pdf,.docx,.jpg,.png' ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:bg-[color:var(--primary)] file:text-white file:cursor-pointer" />
                    </label>
                </div>
            <?php endforeach; ?>

            <div class="text-center pt-6">
                <button type="submit" class="bg-[color:var(--primary)] hover:bg-[color:var(--primary-light)] text-white px-8 py-4 rounded-xl font-semibold shadow transition-all duration-300 flex items-center gap-2 justify-center">
                    <i class="ph ph-paper-plane-right"></i> Submit Data
                </button>
            </div>
        </form>
    </div>

</body>

</html>
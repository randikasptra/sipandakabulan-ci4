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

    <div class="bg-white p-6 rounded-lg shadow-md flex flex-col md:flex-row justify-between items-center mb-8 mx-6 mt-6">
        <div>
            <h2 class="text-2xl font-bold mb-2">
                Selamat Datang, <?= esc($user_name ?? 'Nama Pengguna'); ?>!
            </h2>
            <p class="text-gray-600">
                <i class="ph ph-envelope-simple text-gray-500"></i>
                <?= esc($user_email ?? 'email@example.com'); ?> |
                <i class="ph ph-user text-gray-500"></i>
                Tipe: <span class="font-semibold text-blue-800">
                    <?= esc(ucfirst($user_role ?? 'User')); ?>
                </span>
            </p>
        </div>
        <div class="mt-4 md:mt-0 text-center">
            <?php if (($status ?? '') === 'approved') : ?>
                <p class="text-green-600 font-bold text-lg"><i class="ph ph-check-circle"></i> Evaluasi Sudah Disetujui</p>
            <?php else : ?>
                <p class="text-yellow-600 font-bold text-lg"><i class="ph ph-clock"></i> Evaluasi Belum Disetujui</p>
            <?php endif; ?>

            <p class="text-gray-700 mt-1">
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
                <div class="bg-green-500 h-3 rounded-full" style="width: <?= $presentase ?>%"></div>
            </div>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-6 py-8 mt-6 bg-white shadow-xl rounded-2xl space-y-10">
        <div class="border-b pb-4">
            <h1 class="text-3xl font-bold text-[color:var(--primary)]">📝 Form Penilaian Klaster Kelembagaan</h1>
            <p class="text-sm text-gray-500 mt-1">Isi sesuai kondisi lapangan dan unggah dokumen pendukung (jika ada).</p>
        </div>

        <form action="/submit-kelembagaan" method="POST" enctype="multipart/form-data" class="space-y-10">

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
                    'judul' => '5. Keterlibatan Dunia Usaha',
                    'nama' => 'dunia_usaha',
                    'nilai' => 20,
                    'opsi' => [
                        0 => 'Tidak ada',
                        10 => '1–2 usaha',
                        15 => '3 usaha',
                        20 => '≥4 usaha'
                    ],
                    'file' => ''
                ]
            ];

            foreach ($klaster as $k) :
            ?>
                <div class="space-y-2">
                    <label class="block text-lg font-semibold text-gray-800">
                        <?= $k['judul'] ?>
                        <span class="text-sm text-gray-500">(Total Nilai: <?= $k['nilai'] ?>)</span>
                    </label>
                    <div class="space-y-2">
                        <?php foreach ($k['opsi'] as $val => $label) : ?>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="<?= $k['nama'] ?>" value="<?= $val ?>" class="text-[color:var(--primary-light)]">
                                <?= $label ?>
                            </label>
                        <?php endforeach; ?>
                    </div>


                    <a href="<?= site_url('download-excel?klaster=' . $k['nama'] . '&poin=' . $k['nilai']) ?>" class="text-[color:var(--primary-light)] text-sm underline flex items-center gap-1 mt-1">
                        <i class="ph ph-download-simple"></i> Download Template Excel
                    </a>



                    <input type="file" name="<?= $k['nama'] ?>_file"
                        accept="<?= str_contains($k['file'], '.xlsx') ? '.xlsx' : '.pdf,.docx,.jpg,.png' ?>"
                        class="mt-2 w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[color:var(--primary-light)]">
                </div>
            <?php endforeach; ?>

            <div class="text-center pt-4">
                <button type="submit"
                    class="bg-[color:var(--primary)] hover:bg-[color:var(--primary-light)] text-white px-6 py-3 rounded-xl font-semibold shadow transition">
                    <i class="ph ph-paper-plane-right mr-1"></i> Submit Data
                </button>
            </div>
        </form>
    </div>

</body>

</html>
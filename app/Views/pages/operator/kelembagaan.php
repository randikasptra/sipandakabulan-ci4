<?= $this->include('layouts/navbar') ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Klaster Kelembagaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Warna utama sistem (biru SIPANDAKABULAN) */
        :root {
            --primary: #1e3a8a;
            /* blue-800 */
            --primary-light: #3b82f6;
            /* blue-500 */
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <div class="bg-white p-6 rounded-lg shadow-md flex flex-col md:flex-row justify-between items-center mb-8">
        <!-- Kiri: Info User -->
        <div>
            <h2 class="text-2xl font-bold mb-2">
                Selamat Datang, <?= esc($user_name ?? 'Nama Pengguna'); ?>!
            </h2>
            <p class="text-gray-600">
                Email: <?= esc($user_email ?? 'email@example.com'); ?> |
                Tipe User:
                <span class="font-semibold text-blue-800">
                    <?= esc(ucfirst($user_role ?? 'User')); ?>
                </span>
            </p>
        </div>

        <!-- Kanan: Info Evaluasi -->
        <div class="mt-4 md:mt-0 text-center">
            <?php if (($status ?? '') === 'approved') : ?>
                <p class="text-green-600 font-bold text-lg">
                    Evaluasi SIPANDAKABULAN sudah di Approve
                </p>
            <?php else : ?>
                <p class="text-yellow-600 font-bold text-lg">
                    Evaluasi belum di-Approve
                </p>
            <?php endif; ?>

            <p class="text-gray-700">
                Nilai EM <span class="font-bold"><?= esc($nilai_em ?? '0'); ?></span> |
                Nilai Maksimal <?= esc($nilai_maksimal ?? '1000'); ?>
            </p>

            <?php
            $presentase = 0;
            if (!empty($nilai_em) && !empty($nilai_maksimal) && $nilai_maksimal != 0) {
                $presentase = min(100, round(($nilai_em / $nilai_maksimal) * 100));
            }
            ?>
            <div class="w-48 bg-gray-300 rounded-full h-4 mt-2">
                <div class="bg-green-500 h-4 rounded-full" style="width: <?= $presentase ?>%"></div>
            </div>
        </div>
    </div>

    <div class="bg-gray-100 font-sans">
        <!-- Container -->
        <div class="max-w-5xl mx-auto px-6 py-10 mt-10 bg-white shadow-xl rounded-2xl space-y-10">

            <!-- Header -->
            <div class="border-b pb-4">
                <h1 class="text-3xl font-bold text-[color:var(--primary)]">Form Penilaian Klaster Kelembagaan</h1>
                <p class="text-sm text-gray-500 mt-1">Silakan isi form di bawah ini sesuai kondisi di lapangan dan unggah dokumen pendukung.</p>
            </div>

            <!-- FORM START -->
            <form action="/submit-kelembagaan" method="POST" enctype="multipart/form-data" class="space-y-8">

                <!-- 1. Peraturan -->
                <div class="space-y-2">
                    <label class="block text-lg font-semibold text-gray-800">1. Adanya Peraturan yang mencakup lima klaster
                        <span class="text-sm text-gray-500">(Total Nilai: 60)</span>
                    </label>

                    <div class="space-y-2">
                        <label><input type="radio" name="peraturan" value="0" class="mr-2 text-[color:var(--primary-light)]">Tidak ada</label><br>
                        <label><input type="radio" name="peraturan" value="15" class="mr-2 text-[color:var(--primary-light)]">Ada 1 SK</label><br>
                        <label><input type="radio" name="peraturan" value="30" class="mr-2 text-[color:var(--primary-light)]">Ada 2–3 SK</label><br>
                        <label><input type="radio" name="peraturan" value="45" class="mr-2 text-[color:var(--primary-light)]">Ada 4 SK</label><br>
                        <label><input type="radio" name="peraturan" value="60" class="mr-2 text-[color:var(--primary-light)]">Ada ≥5 SK</label>
                    </div>

                    <a href="/downloads/peraturan.xlsx" class="text-[color:var(--primary-light)] underline text-sm">Download Template Excel</a>
                    <input type="file" name="peraturan_file" accept=".xlsx" class="mt-2 w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[color:var(--primary-light)]">
                </div>

                <!-- 2. Anggaran -->
                <div class="space-y-2">
                    <label class="block text-lg font-semibold text-gray-800">2. Adanya Anggaran Responsif Anak
                        <span class="text-sm text-gray-500">(Total Nilai: 50)</span>
                    </label>

                    <div class="space-y-2">
                        <label><input type="radio" name="anggaran" value="0" class="mr-2">Tidak ada</label><br>
                        <label><input type="radio" name="anggaran" value="10" class="mr-2">≤5%</label><br>
                        <label><input type="radio" name="anggaran" value="20" class="mr-2">6–10%</label><br>
                        <label><input type="radio" name="anggaran" value="35" class="mr-2">11–20%</label><br>
                        <label><input type="radio" name="anggaran" value="50" class="mr-2">≥30%</label>
                    </div>

                    <a href="/downloads/anggaran.xlsx" class="text-[color:var(--primary-light)] underline text-sm">Download Template Excel</a>
                    <input type="file" name="anggaran_file" accept=".xlsx" class="mt-2 w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[color:var(--primary-light)]">
                </div>

                <!-- 3. Forum Anak Desa -->
                <div class="space-y-2">
                    <label class="block text-lg font-semibold text-gray-800">3. Ada Forum Anak Desa
                        <span class="text-sm text-gray-500">(Total Nilai: 40)</span>
                    </label>

                    <div class="space-y-2">
                        <label><input type="radio" name="forum_anak" value="0" class="mr-2">Tidak ada</label><br>
                        <label><input type="radio" name="forum_anak" value="13" class="mr-2">Ada tapi tidak aktif</label><br>
                        <label><input type="radio" name="forum_anak" value="26" class="mr-2">Ada, aktif sesekali</label><br>
                        <label><input type="radio" name="forum_anak" value="40" class="mr-2">Ada dan aktif rutin</label>
                    </div>

                    <label class="text-sm text-gray-600">Upload dokumen pendukung (opsional)</label>
                    <input type="file" name="forum_file" accept=".pdf,.docx,.jpg,.png" class="mt-1 w-full border border-gray-300 rounded-lg p-2">
                </div>

                <!-- 4. Data Terpilah -->
                <div class="space-y-2">
                    <label class="block text-lg font-semibold text-gray-800">4. Ada Data Terpilah mencakup 5 klaster
                        <span class="text-sm text-gray-500">(Total Nilai: 50)</span>
                    </label>

                    <div class="space-y-2">
                        <label><input type="radio" name="data_terpilah" value="0" class="mr-2">Tidak ada</label><br>
                        <label><input type="radio" name="data_terpilah" value="15" class="mr-2">1 Klaster</label><br>
                        <label><input type="radio" name="data_terpilah" value="30" class="mr-2">2–3 Klaster</label><br>
                        <label><input type="radio" name="data_terpilah" value="40" class="mr-2">4 Klaster</label><br>
                        <label><input type="radio" name="data_terpilah" value="50" class="mr-2">5 Klaster</label>
                    </div>

                    <a href="/downloads/data_terpilah.xlsx" class="text-[color:var(--primary-light)] underline text-sm">Download Template Excel</a>
                    <input type="file" name="data_terpilah_file" accept=".xlsx" class="mt-2 w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-[color:var(--primary-light)]">
                </div>

                <!-- 5. Dunia Usaha -->
                <div class="space-y-2">
                    <label class="block text-lg font-semibold text-gray-800">5. Keterlibatan Dunia Usaha
                        <span class="text-sm text-gray-500">(Total Nilai: 20)</span>
                    </label>

                    <div class="space-y-2">
                        <label><input type="radio" name="dunia_usaha" value="0" class="mr-2">Tidak ada</label><br>
                        <label><input type="radio" name="dunia_usaha" value="10" class="mr-2">1–2 usaha</label><br>
                        <label><input type="radio" name="dunia_usaha" value="15" class="mr-2">3 usaha</label><br>
                        <label><input type="radio" name="dunia_usaha" value="20" class="mr-2">≥4 usaha</label>
                    </div>

                    <a href="/downloads/dunia_usaha.xlsx" class="text-[color:var(--primary-light)] underline text-sm">Download Template Excel</a>
                    <input type="file" name="dunia_usaha_file" accept=".xlsx" class="mt-2 w-full border border-gray-300 rounded-lg p-2">
                </div>

                <!-- Submit Button -->
                <div class="text-right">
                    <button type="submit"
                        class="bg-[color:var(--primary)] hover:bg-blue-900 text-white font-semibold px-6 py-2 rounded-xl shadow transition-all">
                        Simpan & Kirim
                    </button>
                </div>

            </form>
        </div>
    </div>


</body>

</html>
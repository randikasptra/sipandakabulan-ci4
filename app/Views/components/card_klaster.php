<a href="<?= site_url('form/show/' . urlencode($klaster) . '/' . intval($id)) ?>"
    class="flex flex-col h-full bg-white border border-blue-200 rounded-2xl shadow hover:shadow-lg transition-all duration-300 hover:ring-2 hover:ring-sky-400 group">

    <!-- Header -->
    <div
        class="px-6 py-4 min-h-[100px] bg-gradient-to-r from-sky-500 to-sky-600 text-white rounded-t-2xl group-hover:from-sky-600 group-hover:to-blue-700">
        <h3 class="text-lg font-semibold tracking-wide"><?= esc($title) ?></h3>
        <p class="text-sm mt-1">
            <?= esc($progres) ?>% | EM
            <span class="font-bold"><?= number_format($nilaiEm, 2) ?></span>
            | Maks
            <span><?= number_format($nilaiMaksimal, 2) ?></span>
        </p>
    </div>

    <!-- Progress Bar -->
    <div class="h-2 bg-gray-200">
        <div class="h-2 bg-green-500 transition-all duration-500" style="width: <?= esc($progres) ?>%"></div>
    </div>

    <!-- Tombol -->
    <div class="px-6 py-4 mt-auto">
        <div
            class="w-full text-center bg-white border-2 border-sky-500 text-sky-700 font-semibold py-2 rounded-full transition duration-300 group-hover:bg-sky-500 group-hover:text-white group-hover:border-sky-600">
            Proses Penilaian
        </div>
    </div>
</a>

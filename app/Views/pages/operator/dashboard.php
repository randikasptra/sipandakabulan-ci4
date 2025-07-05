<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="p-6">

    <?php
    $totalEm = 0;
    $totalMax = 0;

    foreach ($klasters as $klaster) {
        $totalEm += $klaster['nilai_em'] ?? 0;
        $totalMax += $klaster['nilai_maksimal'] ?? 0;
    }

    $totalProgres = $totalMax > 0 ? round(($totalEm / $totalMax) * 100) : 0;
    ?>

    <div class="bg-white p-6 rounded-lg shadow-md flex flex-col md:flex-row justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl font-bold mb-2">Selamat Datang, <?= esc(session()->get('desa')) ?>!</h2>
            <p class="text-gray-600">
                Email: <?= esc($user_email) ?> |
                Tipe User: <span class="font-semibold text-blue-800"><?= esc($user_role) ?></span>
            </p>
        </div>

        <div class="mt-4 md:mt-0 text-center">
            <p class="text-green-600 font-bold text-lg">
                Evaluasi SIPANDAKABULAN: <?= $totalProgres >= 100 ? 'Selesai ✅' : 'Berlangsung ⏳' ?>
            </p>
            <p class="text-gray-700">
                Nilai EM: <span class="font-bold"><?= number_format($totalEm, 1) ?></span>
                | Maksimal: <?= number_format($totalMax, 1) ?>
            </p>
            <div class="w-48 bg-gray-200 rounded-full h-4 mt-2 overflow-hidden">
                <div class="bg-green-500 h-full transition-all duration-700"
                     style="width: <?= $totalProgres ?>%"></div>
            </div>
        </div>
    </div>
</section>

<section class="px-6 pb-6">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($klasters as $klaster): ?>
            <?php
                $nilaiEm = $klaster['nilai_em'] ?? 0;
                $nilaiMax = $klaster['nilai_maksimal'] ?? 100;
                $progres = $nilaiMax > 0 ? round(($nilaiEm / $nilaiMax) * 100) : 0;
            ?>
            <?= view('components/card_klaster', [
                'klaster' => $klaster['slug'],
                'id' => $klaster['id'],
                'title' => $klaster['title'],
                'nilaiEm' => $nilaiEm,
                'nilaiMaksimal' => $nilaiMax,
                'progres' => $progres,
            ]) ?>
        <?php endforeach; ?>
    </div>
</section>

<?= $this->endSection() ?>

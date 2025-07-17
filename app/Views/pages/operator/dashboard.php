<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>Dashboard SIPANDAKABULAN<?= $this->endSection() ?>

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

    <div class="bg-gradient-to-br from-white to-gray-50 p-6 rounded-2xl shadow-md border border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8 transition-all hover:shadow-lg">
        <div class="space-y-3">
            <h2 class="text-2xl font-bold text-gray-800 font-sans">
                Selamat Datang, <span class="text-blue-600"><?= esc(session()->get('desa')) ?></span>!
            </h2>
            <div class="flex flex-wrap items-center gap-x-5 gap-y-3 text-gray-600 text-sm">
                <span class="flex items-center gap-2 bg-gray-100 px-3 py-1.5 rounded-full">
                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <?= esc($user_email) ?>
                </span>
                <span class="flex items-center gap-2 bg-gray-100 px-3 py-1.5 rounded-full">
                    <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Tipe User: <span class="font-semibold text-purple-600"><?= esc($user_role) ?></span>
                </span>
            </div>
        </div>

        <div class="w-full md:min-w-[300px] md:max-w-md">
            <div class="bg-gradient-to-br from-gray-50 to-white p-5 rounded-xl border border-gray-200 shadow-inner">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-base font-semibold <?= $totalProgres >= 100 ? 'text-green-700' : 'text-blue-700' ?> flex items-center gap-2">
                        <svg class="w-5 h-5 <?= $totalProgres >= 100 ? 'text-green-500' : 'text-blue-500' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <?php if ($totalProgres >= 100): ?>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            <?php else: ?>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            <?php endif; ?>
                        </svg>
                        <?= $totalProgres >= 100 ? 'Evaluasi Selesai' : 'Evaluasi Berlangsung' ?>
                    </span>
                    <span class="text-base font-bold <?= $totalProgres >= 100 ? 'text-green-600' : 'text-blue-600' ?> bg-<?= $totalProgres >= 100 ? 'green' : 'blue' ?>-100 px-3 py-1 rounded-full">
                        <?= $totalProgres ?>%
                    </span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden mb-3">
                    <div class="h-full <?= $totalProgres >= 100 ? 'bg-gradient-to-r from-green-400 to-green-600' : 'bg-gradient-to-r from-blue-400 to-blue-600' ?> transition-all duration-700 ease-out" 
                         style="width: <?= $totalProgres ?>%"></div>
                </div>
                <div class="flex justify-between text-sm font-medium text-gray-600">
                    <span class="flex items-center">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500 mr-2"></span>
                        Nilai EM: <span class="font-bold ml-1"><?= number_format($totalEm, 1) ?></span>
                    </span>
                    <span class="flex items-center">
                        <span class="w-2.5 h-2.5 rounded-full bg-gray-500 mr-2"></span>
                        Maksimal: <span class="font-bold ml-1"><?= number_format($totalMax, 1) ?></span>
                    </span>
                </div>
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
            'slug' => $klaster['slug'], 
            'id' => $klaster['id'],
            'klaster_title' => $klaster['title'],
            'nilaiEm' => $klaster['nilai_em'],
            'nilaiMaksimal' => $klaster['nilai_maksimal'],
            'progres' => ($klaster['nilai_maksimal'] > 0) ? round(($klaster['nilai_em'] / $klaster['nilai_maksimal']) * 100) : 0,
            'status' => $klaster['status'] ?? 'pending'
        ]) ?>



        <?php endforeach; ?>
    </div>
</section>

<?= $this->endSection() ?>

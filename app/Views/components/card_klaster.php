<?php
$slug = $slug ?? 'dashboard';
$urlKlaster = $slug;
$nilaiEm = $nilaiEm ?? 0;
$nilaiMaksimal = $nilaiMaksimal ?? 100;
$progres = ($nilaiMaksimal > 0) ? round(($nilaiEm / $nilaiMaksimal) * 100) : 0;

$warnaProgres = match(true) {
    $progres >= 80 => 'from-emerald-500 to-teal-600',
    $progres >= 50 => 'from-amber-400 to-orange-500',
    default => 'from-rose-500 to-pink-600'
};

$klaster_title = $klaster_title ?? 'Judul Klaster';
$status = $status ?? 'pending';

$statusText = match(strtolower($status)) {
    'approved' => 'Disetujui',
    'rejected' => 'Ditolak',
    'pending'  => 'Menunggu',
    default    => strtoupper($status),
};

$statusColor = match(strtolower($status)) {
    'approved' => 'bg-emerald-600 text-white',
    'rejected' => 'bg-rose-600 text-white',
    default    => 'bg-yellow-400 text-black',
};
?>

<a href="<?= site_url('dashboard/' . $urlKlaster . '/' . intval($id)) ?>" 
   class="group relative flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-md transition-all duration-300 hover:shadow-xl hover:border-sky-400 hover:-translate-y-1">
    
    <!-- Glow effect on hover -->
    <div class="absolute inset-0 -z-10 bg-gradient-to-br from-sky-100/50 to-blue-100/30 opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>

    <!-- Status badge floating top right -->
    <div class="absolute top-4 right-4 z-10">
        <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold uppercase tracking-wide <?= $statusColor ?> shadow-md">
            <?= $statusText ?>
        </span>
    </div>

    <!-- Header -->
    <div class="px-6 py-5 min-h-[110px] bg-gradient-to-br from-sky-500 to-blue-600 text-white transition-all duration-700 group-hover:from-sky-600 group-hover:to-blue-700">
        <div class="flex justify-between items-start gap-4">
            <div class="flex-1">
                <h3 class="text-xl font-bold tracking-tight text-white/90"><?= esc($klaster_title) ?></h3>

                <div class="mt-3 flex flex-wrap items-center gap-2 text-sm text-sky-100">
                    <span class="inline-flex items-center rounded-full bg-white/20 px-3 py-1 font-medium backdrop-blur-sm">
                        <?= $progres ?>% Complete
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        EM: <strong><?= number_format($nilaiEm, 2) ?></strong>
                    </span>
                    <span class="flex items-center gap-1">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Max: <strong><?= number_format($nilaiMaksimal, 2) ?></strong>
                    </span>
                </div>
            </div>

            
        </div>
    </div>

    <!-- Progress -->
    <div class="px-6 pt-5">
        <div class="mb-1 flex justify-between text-sm font-medium text-gray-600">
            <span>Nilai</span>
            <span><?= $nilaiEm ?> / <?= $nilaiMaksimal ?></span>
        </div>

        <div class="relative h-2.5 w-full overflow-hidden rounded-full bg-gray-200">
            <div class="absolute inset-0 h-full rounded-full bg-gradient-to-r <?= $warnaProgres ?> transition-all duration-1000 ease-out" style="width: <?= $progres ?>%">
                <div class="absolute inset-0 bg-white/20 mix-blend-overlay"></div>
            </div>
        </div>

        <div class="mt-1.5 flex justify-between text-xs text-gray-500">
            <span>0%</span>
            <span>50%</span>
            <span>100%</span>
        </div>
    </div>

    <!-- CTA Button -->
    <div class="px-6 pb-6 pt-2 mt-auto">
        <button type="button" class="relative w-full overflow-hidden rounded-full border-2 border-sky-500 bg-white py-2.5 px-4 font-semibold text-sky-600 shadow-sm transition-all duration-300 group-hover:border-transparent group-hover:bg-gradient-to-r group-hover:from-sky-500 group-hover:to-blue-600 group-hover:text-white group-hover:shadow-md">
            <span class="relative z-10 flex items-center justify-center">
                Proses Penilaian
                <svg class="ml-2 h-4 w-4 -translate-x-1 opacity-0 transition-all duration-300 group-hover:translate-x-0 group-hover:opacity-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </span>
            <span class="absolute inset-0 -z-10 rounded-full bg-gradient-to-r from-sky-400 to-blue-500 opacity-0 blur-sm transition-opacity duration-300 group-hover:opacity-20"></span>
        </button>
    </div>
</a>

<?php
$slug = getKlasterSlug($klaster);
$urlKlaster = getKlasterSlug($klaster);
?>

<a href="<?= site_url('dashboard/' . $urlKlaster . '/' . intval($id)) ?>"
   class="flex flex-col h-full bg-white border border-gray-200 rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 hover:border-sky-400 group overflow-hidden">

    <!-- Header with improved gradient -->
    <div class="px-6 py-5 min-h-[110px] bg-gradient-to-br from-sky-500 via-sky-600 to-blue-600 text-white group-hover:from-sky-600 group-hover:via-blue-600 group-hover:to-blue-700 transition-all duration-500">
        <div class="flex justify-between items-start">
            <div>
                <h3 class="text-xl font-bold tracking-tight line-clamp-2"><?= esc($title) ?></h3>
                <div class="flex items-center mt-2 space-x-3 text-sky-100">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white/20">
                        <?= esc($progres) ?>% Complete
                    </span>
                    <span class="text-sm">
                        EM <span class="font-bold"><?= number_format($nilaiEm, 2) ?></span>
                    </span>
                    <span class="text-sm">
                        Max <span class="font-medium"><?= number_format($nilaiMaksimal, 2) ?></span>
                    </span>
                </div>
            </div>
            <div class="bg-white/20 rounded-full p-2 group-hover:rotate-12 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Animated Progress Bar -->
    <div class="h-1.5 bg-gray-100 overflow-hidden">
        <div class="h-full bg-gradient-to-r from-green-400 to-green-500 transition-all duration-1000 ease-out" 
             style="width: <?= esc($progres) ?>%"></div>
    </div>

    <!-- Button with improved styling -->
    <div class="px-6 py-4 mt-auto">
        <div class="relative inline-flex w-full items-center justify-center">
            <div class="absolute -inset-1 rounded-full bg-gradient-to-r from-sky-400 to-blue-500 opacity-0 group-hover:opacity-20 blur-sm transition-all duration-300"></div>
            <span class="relative w-full text-center bg-white border-2 border-sky-500 text-sky-600 font-semibold py-2.5 px-4 rounded-full transition-all duration-300 group-hover:bg-gradient-to-r group-hover:from-sky-500 group-hover:to-blue-600 group-hover:text-white group-hover:border-transparent group-hover:shadow-md">
                Proses Penilaian
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 inline opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </span>
        </div>
    </div>
</a>
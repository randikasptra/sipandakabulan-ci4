<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="bg-gradient-to-b from-blue-50 via-white to-gray-50 min-h-screen py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="text-center mb-12" data-aos="zoom-in">
            <div class="flex items-center justify-center w-20 h-20 bg-blue-100 rounded-full shadow-inner mx-auto mb-4">
               <i class="lucide lucide-megaphone"></i>
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900">Pengumuman Resmi</h1>
            <p class="mt-2 text-gray-600">Informasi penting dari Kabupaten untuk Operator Desa</p>
        </div>

        <!-- Announcement Content -->
        <div class="space-y-6">
            <?php if (empty($pengumuman)): ?>
                <div class="bg-white p-10 rounded-2xl shadow text-center border border-dashed border-gray-300" data-aos="fade-up">
                    <i class="ph ph-newspaper text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-700">Belum ada pengumuman</h3>
                    <p class="text-gray-500 mt-2">Tidak ada pengumuman untuk desa Anda saat ini</p>
                </div>
            <?php else: ?>
                <?php foreach ($pengumuman as $p): ?>
                    <div class="group bg-white p-6 rounded-xl shadow-sm border-l-4 border-transparent hover:border-blue-600 hover:shadow-md transition-all duration-300" data-aos="fade-up">
                        <div class="flex items-start">
                            <div class="flex items-center justify-center bg-blue-100 w-12 h-12 rounded-lg mr-4 shadow-inner">
                                <i class="ph ph-info text-blue-600 text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between gap-2 flex-wrap">
                                    <h3 class="text-lg font-semibold text-gray-900"><?= esc($p['judul']) ?></h3>
                                    <span class="text-xs bg-blue-100 text-blue-800 px-3 py-1 rounded-full whitespace-nowrap font-medium">
                                        <?= esc($p['tujuan_desa'] ?? 'Semua Desa') ?>
                                    </span>
                                </div>
                                <div class="flex items-center text-sm text-gray-500 mt-2">
                                    <i class="ph ph-clock mr-1"></i>
                                    <?= date('d M Y H:i', strtotime($p['created_at'])) ?>
                                </div>
                                <div class="mt-4 text-gray-700 leading-relaxed">
                                    <?= esc($p['isi']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>

    </div>
</section>

<?= $this->endSection() ?>

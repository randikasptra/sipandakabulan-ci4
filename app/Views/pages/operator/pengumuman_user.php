<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<section class="bg-gray-50 min-h-screen ">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Header Section -->
        <div class="text-center mb-10" data-aos="zoom-in">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                <i class="ph ph-megaphone text-blue-600 text-3xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Pengumuman Resmi</h1>
            <p class="mt-2 text-gray-600">Informasi penting dari Kabupaten untuk Operator Desa</p>
        </div>

        <!-- Announcement Content -->
        <div class="space-y-6">
            <?php if (empty($pengumuman)): ?>
                <div class="bg-white p-8 rounded-xl shadow text-center" data-aos="fade-up">
                    <i class="ph ph-newspaper text-5xl text-gray-300 mb-4"></i>
                    <h3 class="text-lg font-semibold text-gray-700">Belum ada pengumuman</h3>
                    <p class="text-gray-500 mt-1">Tidak ada pengumuman untuk desa Anda saat ini</p>
                </div>
            <?php else: ?>
                <?php foreach ($pengumuman as $p): ?>
                    <div class="group bg-white p-6 rounded-xl shadow transition-all duration-200 border-l-4 border-transparent hover:border-blue-600 hover:shadow-md" data-aos="fade-up">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 bg-blue-50 p-3 rounded-lg mr-4">
                                <i class="ph ph-info text-blue-600 text-2xl"></i>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between flex-wrap gap-2">
                                    <h3 class="text-lg font-semibold text-gray-900"><?= esc($p['judul']) ?></h3>
                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full whitespace-nowrap">
                                        <?= esc($p['tujuan_desa'] ?? 'Semua Desa') ?>
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1 flex items-center">
                                    <i class="ph ph-clock mr-1"></i>
                                    <?= date('d M Y H:i', strtotime($p['created_at'])) ?>
                                </p>
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

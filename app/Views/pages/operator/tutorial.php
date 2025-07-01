<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/navbar') ?>

<!-- AOS CSS -->
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />

<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
    <!-- Header -->
    <div class="text-center mb-16" data-aos="zoom-in">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-50 rounded-full mb-6">
            <i class="ph ph-graduation-cap text-blue-600 text-3xl"></i>
        </div>
        <h1 class="text-4xl font-bold text-gray-900 mb-3">Panduan Pengisian Data Klaster</h1>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto">
            Langkah demi langkah tutorial untuk mengisi data klaster desa dengan mudah.
        </p>
    </div>

    <!-- Steps -->
    <div class="space-y-16">
        <?php
        $steps = [
            [
                'judul' => 'Pilih Klaster yang Belum Diisi',
                'deskripsi' => 'Setelah login, pilih klaster berstatus <span class="font-medium text-red-500">belum diisi</span> untuk memulai.',
                'img' => 'tutorial1.png'
            ],
            [
                'judul' => 'Isi Sub-Index Klaster',
                'deskripsi' => 'Isi semua sub-point indikator sesuai data desa Anda.',
                'img' => 'tutorial2.png'
            ],
            [
                'judul' => 'Unduh Template Excel',
                'deskripsi' => 'Unduh file Excel berisi daftar data yang perlu disiapkan.',
                'img' => 'tutorial3.png',
                'link' => true
            ],
            [
                'judul' => 'Pengumpulan Berkas',
                'deskripsi' => 'Kumpulkan setiap SK yang diperlukan sesuai data desa.',
                'img' => 'tutorial4.png'
            ],
            [
                'judul' => 'Kelompokkan Berkas',
                'deskripsi' => 'Kelompokkan semua data dalam format ZIP file.',
                'img' => 'tutorial5.png'
            ],
            [
                'judul' => 'Upload ZIP File',
                'deskripsi' => 'Pilih file ZIP yang sudah disiapkan dengan tombol <span class="font-medium text-green-600">Choose File</span>.',
                'img' => 'tutorial6.png'
            ],
            [
                'judul' => 'Submit Data',
                'deskripsi' => 'Tekan tombol <span class="font-medium text-green-600">Submit</span> untuk mengirim data ke Admin.',
                'img' => 'tutorial7.png'
            ],
        ];
        foreach ($steps as $index => $step): ?>
        <div class="flex flex-col md:flex-row gap-8 items-start" data-aos="fade-up">
            <div class="md:w-1/3 md:sticky top-24">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold mr-3">
                        <?= $index + 1 ?>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900"><?= $step['judul'] ?></h2>
                </div>
                <p class="text-gray-600 pl-2 mb-2">
                    <?= $step['deskripsi'] ?>
                </p>
                <?php if (!empty($step['link'])): ?>
                    <div class="mt-4 pl-2">
                        <a href="#" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition">
                            <i class="ph ph-download mr-2"></i> Download Template
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="md:w-2/3 bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <img src="<?= base_url('assets/tutorial/' . $step['img']) ?>" alt="Langkah <?= $index + 1 ?>" class="w-full h-auto object-cover">
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Tombol ke Dashboard -->
    
</section>

<!-- Tombol Kembali ke Atas -->
<button id="backToTopBtn" class="fixed bottom-6 right-6 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition duration-300 hidden z-50">
    <i class="ph ph-arrow-up"></i>
</button>

<!-- AOS JS & Scroll to Top -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ once: true, duration: 800, easing: 'ease-in-out' });

    const btn = document.getElementById("backToTopBtn");
    window.onscroll = () => {
        btn.style.display = (document.documentElement.scrollTop > 300) ? "block" : "none";
    };
    btn.onclick = () => window.scrollTo({ top: 0, behavior: 'smooth' });
</script>

<?= $this->include('layouts/footer') ?>

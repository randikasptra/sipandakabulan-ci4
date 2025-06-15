<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/navbar') ?>

<!-- AOS CSS -->
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet" />

<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-6xl mx-auto">
    <div class="text-center mb-12" data-aos="zoom-in">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-blue-50 rounded-full mb-6">
            <i class="ph ph-graduation-cap text-blue-600 text-3xl"></i>
        </div>
        <h1 class="text-4xl font-bold text-gray-900 mb-3">Panduan Pengisian Data Klaster</h1>
        <p class="text-lg text-gray-600 max-w-3xl mx-auto">
            Langkah demi langkah tutorial untuk mengisi data klaster desa dengan mudah
        </p>
    </div>

    <div class="space-y-12">
        <!-- Langkah 1 -->
        <div class="flex flex-col md:flex-row gap-8 items-start" data-aos="fade-up">
            <div class="md:w-1/3 sticky top-24">
                <div class="flex items-center mb-2">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white font-bold mr-3">1</div>
                    <h2 class="text-xl font-semibold text-gray-900">Pilih Klaster yang Belum Diisi</h2>
                </div>
                <p class="text-gray-600 pl-13">
                    Setelah login, pilih klaster berstatus <span class="font-medium text-red-500">belum diisi</span> untuk memulai.
                </p>
            </div>
            <div class="md:w-2/3 bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <img src="<?= base_url('assets/tutorial/tutorial1.png') ?>" alt="Pilih Klaster" class="w-full h-auto object-cover">
            </div>
        </div>

        <!-- Langkah 2 -->
        <div class="flex flex-col md:flex-row gap-8 items-start" data-aos="fade-up">
            <div class="md:w-1/3 sticky top-24">
                <div class="flex items-center mb-2">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white font-bold mr-3">2</div>
                    <h2 class="text-xl font-semibold text-gray-900">Isi Sub-Index Klaster</h2>
                </div>
                <p class="text-gray-600 pl-13">
                    Isi semua sub-point indikator sesuai data desa Anda.
                </p>
            </div>
            <div class="md:w-2/3 bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <img src="<?= base_url('assets/tutorial/tutorial2.png') ?>" alt="Isi Sub Index" class="w-full h-auto object-cover">
            </div>
        </div>

        <!-- Langkah 3 -->
        <div class="flex flex-col md:flex-row gap-8 items-start" data-aos="fade-up">
            <div class="md:w-1/3 sticky top-24">
                <div class="flex items-center mb-2">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white font-bold mr-3">3</div>
                    <h2 class="text-xl font-semibold text-gray-900">Unduh Template Excel</h2>
                </div>
                <p class="text-gray-600 pl-13">
                    Unduh file Excel berisi daftar data yang perlu disiapkan.
                </p>
                <div class="mt-4 pl-13">
                    <a href="#" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                        <i class="ph ph-download mr-2"></i> Download Template
                    </a>
                </div>
            </div>
            <div class="md:w-2/3 bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <img src="<?= base_url('assets/tutorial/tutorial3.png') ?>" alt="Download Excel" class="w-full h-auto object-cover">
            </div>
        </div>

        <!-- Langkah 4 -->
        <div class="flex flex-col md:flex-row gap-8 items-start" data-aos="fade-up">
            <div class="md:w-1/3 sticky top-24">
                <div class="flex items-center mb-2">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white font-bold mr-3">4</div>
                    <h2 class="text-xl font-semibold text-gray-900">Pengumpulan Berkas</h2>
                </div>
                <p class="text-gray-600 pl-13">
                    Kumpulkan setiap SK yang diperlukan sesuai data desa.
                </p>
            </div>
            <div class="md:w-2/3 bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <img src="<?= base_url('assets/tutorial/tutorial4.png') ?>" alt="Submit Data" class="w-full h-auto object-cover">
            </div>
        </div>

        <!-- Langkah 5 -->
        <div class="flex flex-col md:flex-row gap-8 items-start" data-aos="fade-up">
            <div class="md:w-1/3 sticky top-24">
                <div class="flex items-center mb-2">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white font-bold mr-3">5</div>
                    <h2 class="text-xl font-semibold text-gray-900">Kelompokkan Berkas</h2>
                </div>
                <p class="text-gray-600 pl-13">
                    Kelompokkan semua data dalam format ZIP file.
                </p>
            </div>
            <div class="md:w-2/3 bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <img src="<?= base_url('assets/tutorial/tutorial5.png') ?>" alt="Submit Data" class="w-full h-auto object-cover">
            </div>
        </div>

        <!-- Langkah 6 -->
        <div class="flex flex-col md:flex-row gap-8 items-start" data-aos="fade-up">
            <div class="md:w-1/3 sticky top-24">
                <div class="flex items-center mb-2">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white font-bold mr-3">6</div>
                    <h2 class="text-xl font-semibold text-gray-900">Upload ZIP File</h2>
                </div>
                <p class="text-gray-600 pl-13">
                    Pilih file ZIP yang sudah disiapkan dengan tombol <span class="font-medium text-green-600">Choose File</span>.
                </p>
            </div>
            <div class="md:w-2/3 bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <img src="<?= base_url('assets/tutorial/tutorial6.png') ?>" alt="Submit Data" class="w-full h-auto object-cover">
            </div>
        </div>

        <!-- Langkah 7 -->
        <div class="flex flex-col md:flex-row gap-8 items-start" data-aos="fade-up">
            <div class="md:w-1/3 sticky top-24">
                <div class="flex items-center mb-2">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white font-bold mr-3">7</div>
                    <h2 class="text-xl font-semibold text-gray-900">Submit Data</h2>
                </div>
                <p class="text-gray-600 pl-13">
                    Tekan tombol <span class="font-medium text-green-600">Submit</span> untuk mengirim data ke Admin.
                </p>
            </div>
            <div class="md:w-2/3 bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
                <img src="<?= base_url('assets/tutorial/tutorial7.png') ?>" alt="Submit Data" class="w-full h-auto object-cover">
            </div>
        </div>
    </div>

    <div class="mt-16 text-center" data-aos="fade-up">
        <a href="<?= base_url('dashboard/operator') ?>" class="inline-flex items-center px-8 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition duration-200 shadow-lg">
            <i class="ph ph-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>
    </div>
</section>

<!-- Tombol Kembali ke Atas -->
<button id="backToTopBtn" class="fixed bottom-6 right-6 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition duration-300 hidden z-50">
    <i class="ph ph-arrow-up"></i>
</button>

<!-- AOS JS & BackToTop Script -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        once: true,
        duration: 800,
        easing: 'ease-in-out',
    });

    // Tombol scroll ke atas
    const btn = document.getElementById("backToTopBtn");
    window.onscroll = () => {
        btn.style.display = (document.documentElement.scrollTop > 300) ? "block" : "none";
    };
    btn.onclick = () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    };
</script>

<?= $this->include('layouts/footer') ?>

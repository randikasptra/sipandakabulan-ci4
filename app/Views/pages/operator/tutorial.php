<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/navbar') ?>

<section class="p-8 max-w-5xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-2">Tutorial Pengisian Data Klaster</h1>

    <!-- Langkah 1 -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-blue-700 mb-2">1. Pilih Klaster yang Belum Diisi</h2>
        <p class="text-gray-700 mb-4">
            Setelah login, Anda akan diarahkan ke dashboard. Pilih klaster yang masih berstatus <span
                class="font-medium text-red-500">belum diisi</span> untuk memulai pengisian data.
        </p>
        <div class="bg-white border rounded-lg shadow p-4">
            <img src="<?= base_url('assets/tutorial/tutorial1.png') ?>" alt="Pilih Klaster" class="mx-auto">
        </div>
    </div>

    <!-- Langkah 2 -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-blue-700 mb-2">2. Isi Sub-Index Klaster</h2>
        <p class="text-gray-700 mb-4">
            Setelah masuk ke halaman klaster, operator akan diminta mengisi semua sub-point indikator sesuai data desa.
        </p>
        <div class="bg-white border rounded-lg shadow p-4">
            <img src="<?= base_url('assets/tutorial/tutorial2.png') ?>" alt="Isi Sub Index" class="mx-auto">
        </div>
    </div>

    <!-- Langkah 3 -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-blue-700 mb-2">3. Unduh Template Excel</h2>
        <p class="text-gray-700 mb-4">
            Untuk membantu proses input, Anda dapat mengunduh file Excel berisi daftar data yang perlu disiapkan.
            Pastikan semua data lengkap sebelum mengisi form online.
        </p>
        <div class="bg-white border rounded-lg shadow p-4">
            <img src="<?= base_url('assets/tutorial/tutorial3.png') ?>" alt="Download Excel" class="mx-auto">
        </div>
    </div>

    <!-- Langkah 4 -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-blue-700 mb-2">4. Pengumpulan dan Pengisian Berkas</h2>
        <p class="text-gray-700 mb-4">
            Setelah Download data excel operator disuruh untuk mengumpulkan setiap SK yang di perlukan dan di isi sesuai
            data
            yang ada di desa</p>
        <div class="bg-white border rounded-lg shadow p-4">
            <img src="<?= base_url('assets/tutorial/tutorial4.png') ?>" alt="Submit Data" class="mx-auto">
        </div>
    </div>
    <!-- Langkah 5 -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-blue-700 mb-2">5. Kelompokan Setiap Berkas Dengan ZIP</h2>
        <p class="text-gray-700 mb-4">
            Setelah semua data dikumpulkan dengan lengkap dan benar (yang ada didesa jika hanya ada 3 berkas tidak
            apa-apa),
        </p>
        <div class="bg-white border rounded-lg shadow p-4">
            <img src="<?= base_url('assets/tutorial/tutorial5.png') ?>" alt="Submit Data" class="mx-auto">
        </div>
    </div>
    <!-- Langkah 6 -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-blue-700 mb-2">6.Upload ZIP</h2>
        <p class="text-gray-700 mb-4">
            Setelah pengelompokan data selesai ,selanjutnya pilih ZIP yang sudah siap dengan tekan tombol<span
                class="font-medium text-green-600"> Choose File</span> dan pilih berkas ZIP nya
        </p>
        <div class="bg-white border rounded-lg shadow p-4">
            <img src="<?= base_url('assets/tutorial/tutorial6.png') ?>" alt="Submit Data" class="mx-auto">
        </div>
    </div>
    <!-- Langkah 6 -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-blue-700 mb-2">6. Submit Setelah Lengkap</h2>
        <p class="text-gray-700 mb-4">
            Setelah semua data diisi dengan lengkap dan benar, tekan tombol <span
                class="font-medium text-green-600">Submit</span> untuk mengirimkan data ke Admin.
            Status akan berubah menjadi <span class="font-medium text-green-500">Terverifikasi</span> jika sudah
            di-approve.
        </p>
        <div class="bg-white border rounded-lg shadow p-4">
            <img src="<?= base_url('assets/tutorial/tutorial7.png') ?>" alt="Submit Data" class="mx-auto">
        </div>
    </div>

    <div class="text-right mt-10">
        <a href="<?= base_url('/dashboard') ?>"
            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
            Kembali ke Dashboard
        </a>
    </div>
</section>
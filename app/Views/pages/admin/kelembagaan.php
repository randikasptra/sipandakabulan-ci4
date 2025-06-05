<?= $this->include('layouts/sidenav_admin') ?>

<main class="flex-1 bg-gray-100 min-h-screen p-6">
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-2xl font-bold text-blue-800">Data Kelembagaan</h2>
        <p class="text-gray-600">Silakan isi atau kelola data kelembagaan yang ada di wilayah Anda.</p>
    </div>

    <div class="bg-white p-4 rounded-lg shadow">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Daftar Kelembagaan</h3>
            <a href="#" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                <i class="fa-solid fa-plus"></i> Tambah Lembaga
            </a>
        </div>
        <table class="w-full text-sm text-left text-gray-700">
            <thead class="bg-blue-100 text-gray-800">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Nama Lembaga</th>
                    <th class="px-4 py-2">Jenis</th>
                    <th class="px-4 py-2">Alamat</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contoh baris -->
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">1</td>
                    <td class="px-4 py-2">Lembaga Pendidikan ABC</td>
                    <td class="px-4 py-2">Pendidikan</td>
                    <td class="px-4 py-2">Kecamatan X, Kabupaten Y</td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="#" class="text-blue-600 hover:underline">Edit</a>
                        <a href="#" class="text-red-600 hover:underline">Hapus</a>
                    </td>
                </tr>
                <!-- Tambahkan data dinamis dari controller -->
            </tbody>
        </table>
    </div>
</main>
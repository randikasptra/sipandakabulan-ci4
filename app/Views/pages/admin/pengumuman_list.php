<?php if (session()->getFlashdata('error')): ?>
    <div class="fixed top-4 right-4 z-50 animate-fade-in-down">
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-lg flex items-start max-w-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div><?= esc(session()->getFlashdata('error')) ?></div>
        </div>
    </div>

<?php endif; ?><!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengumuman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    },
                    animation: {
                        'fade-in-down': 'fadeInDown 0.5s ease-out'
                    },
                    keyframes: {
                        fadeInDown: {
                            '0%': { opacity: '0', transform: 'translateY(-20px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="h-full bg-gray-50">
    <div class="flex min-h-screen ml-72">
        <?= $this->include('layouts/sidenav_admin') ?>
        <div class="flex-1 flex flex-col mt-24">
            <?= $this->include('layouts/header_admin') ?>
            <main class="flex-1 p-6">
                <div class="max-w-7xl mx-auto">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">Daftar Pengumuman</h2>
                                <p class="text-gray-600 mt-1 text-sm">Kelola pengumuman untuk desa-desa</p>
                            </div>
                            <button onclick="document.getElementById('modal-pengumuman').classList.remove('hidden')"
                                class="flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2.5 rounded-lg transition-colors shadow-sm hover:shadow-md">
                                <i class="fas fa-plus"></i>
                                <span>Buat Pengumuman</span>
                            </button>
                        </div><?php if (session()->getFlashdata('success')): ?>
                            <div class="mx-6 mt-4 p-4 bg-green-50 border-l-4 border-green-500 rounded-lg flex items-start">
                                <i class="fas fa-check-circle text-green-500 mr-3 mt-0.5"></i>
                                <div class="text-green-700"><?= esc(session()->getFlashdata('success')) ?></div>
                            </div>
                        <?php endif; ?>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            No</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Judul</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Isi</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tujuan Desa</th>
                                        <th
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Tanggal</th>
                                        <th
                                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php foreach ($announcements as $i => $item): ?>
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4 text-sm text-gray-900"> <?= $i + 1 ?> </td>
                                            <td class="px-6 py-4 text-sm text-gray-900"> <?= esc($item['judul']) ?> </td>
                                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">
                                                <?= esc($item['isi']) ?> </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                <?= $item['tujuan_desa'] ? esc($item['tujuan_desa']) : '<span class="italic text-gray-400">Semua Desa</span>' ?>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                <?= date('d M Y H:i', strtotime($item['created_at'])) ?> </td>
                                            <td class="px-6 py-4 text-right text-sm space-x-3">
                                                <a href="#"
                                                    onclick="editPengumuman(<?= htmlspecialchars(json_encode($item)) ?>)"
                                                    class="text-blue-600 hover:text-blue-800 inline-flex items-center">
                                                    <i class="fas fa-edit mr-1"></i><span>Edit</span>
                                                </a>
                                                <a href="<?= site_url('/dashboard/pengumuman/delete/' . $item['id']) ?>"
                                                    class="text-red-600 hover:text-red-800 inline-flex items-center"
                                                    onclick="return confirm('Yakin ingin menghapus pengumuman ini?')">
                                                    <i class="fas fa-trash-alt mr-1"></i><span>Hapus</span>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($announcements)): ?>
                                        <tr>
                                            <td colspan="6" class="px-6 py-8 text-center text-gray-400">Belum ada pengumuman
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Buat/Edit Pengumuman -->
    <div id="modal-pengumuman" class="hidden fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-30">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-bold" id="modal-title">Buat Pengumuman</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600"><i
                            class="fas fa-times"></i></button>
                </div>
                <form id="formPengumuman" action="<?= site_url('dashboard/pengumuman_list/store') ?>" method="post">
                    <input type="hidden" name="id" id="id">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" name="judul" id="judul" required
                            class="w-full mt-1 border rounded px-3 py-2">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Isi</label>
                        <textarea name="isi" id="isi" rows="4" required
                            class="w-full mt-1 border rounded px-3 py-2"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Tujuan Desa</label>
                        <select name="tujuan_desa" id="tujuan_desa" class="w-full mt-1 border rounded px-3 py-2">
                            <option value="">-- Semua Desa --</option>
                            <?php foreach ($desa_list as $desa): ?>
                                <option value="<?= esc($desa['desa']) ?>"><?= esc($desa['desa']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeModal()"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-primary-600 text-white hover:bg-primary-700 rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function closeModal() {
            document.getElementById('modal-pengumuman').classList.add('hidden');
            document.getElementById('formPengumuman').reset();
            document.getElementById('formPengumuman').action = "<?= site_url('dashboard/pengumuman_list/store') ?>";
            document.getElementById('modal-title').textContent = "Buat Pengumuman";
        }

        function editPengumuman(item) {
            document.getElementById('modal-pengumuman').classList.remove('hidden');
            document.getElementById('modal-title').textContent = "Edit Pengumuman";
            document.getElementById('formPengumuman').action = "<?= site_url('dashboard/pengumuman/update') ?>";
            document.getElementById('id').value = item.id;
            document.getElementById('judul').value = item.judul;
            document.getElementById('isi').value = item.isi;
            document.getElementById('tujuan_desa').value = item.tujuan_desa;
        }

        setTimeout(() => {
            document.querySelectorAll('.animate-fade-in-down, .bg-green-50, .bg-red-50').forEach(el => {
                if (el) {
                    el.style.transition = 'opacity 0.5s ease-out';
                    el.style.opacity = '0';
                    setTimeout(() => el.remove(), 500);
                }
            });
        }, 5000);
    </script>

</body>

</html>
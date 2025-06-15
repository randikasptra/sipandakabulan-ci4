<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Kelola User') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .table-row-hover:hover {
            background-color: #f8fafc;
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .action-btn {
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .modal-enter {
            animation: modalEnter 0.3s ease-out;
        }

        @keyframes modalEnter {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800">

    <div class="flex min-h-screen">

        <!-- Sidebar Admin -->
        <?= $this->include('layouts/sidenav_admin') ?>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Header Admin -->
            <?= $this->include('layouts/header_admin') ?>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto p-6">

                <!-- Page Header -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Kelola Pengguna</h1>
                        <p class="text-gray-600 mt-1">Kelola semua pengguna yang terdaftar dalam sistem</p>
                    </div>
                    <button onclick="document.getElementById('formModal').classList.remove('hidden')"
                        class="flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-4 py-2 rounded-lg transition-colors shadow-md">
                        <i class="fas fa-user-plus"></i>
                        <span>Tambah Pengguna</span>
                    </button>
                </div>

                <!-- User Table Card -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <!-- Table Header -->
                    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-users text-primary-600"></i>
                            <h2 class="font-semibold text-gray-800">Daftar Pengguna</h2>
                        </div>
                        <div class="relative">
                            <input type="text" placeholder="Cari pengguna..."
                                class="pl-8 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        No</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Username</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Role</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Desa</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $index => $user): ?>
                                        <tr class="table-row-hover transition-all">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $index + 1 ?></td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div
                                                        class="flex-shrink-0 h-10 w-10 bg-primary-100 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-user text-primary-600"></i>
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            <?= esc($user['username']) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?= esc($user['email']) ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span
                                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    <?= $user['role'] === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800' ?>">
                                                    <?= esc(ucfirst($user['role'])) ?>
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <?= esc($user['desa'] ?? '-') ?>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end items-center gap-3">
                                                    <a href="#"
                                                        onclick="showDetail('<?= esc($user['username']) ?>', '<?= esc($user['email']) ?>', '<?= esc($user['role']) ?>', '<?= esc($user['desa']) ?>')"
                                                        class="action-btn text-blue-500 hover:text-blue-700"
                                                        title="Lihat Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="/dashboard/admin/users/<?= $user['id'] ?>/edit"
                                                        class="text-yellow-500 hover:underline mr-2">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form action="/dashboard/admin/users/<?= $user['id'] ?>/delete"
                                                        method="post" class="inline">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="action-btn text-red-500 hover:text-red-700"
                                                            title="Hapus"
                                                            onclick="return confirm('Yakin ingin menghapus user ini?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                            <div class="flex flex-col items-center justify-center py-8">
                                                <i class="fas fa-user-slash text-4xl text-gray-300 mb-2"></i>
                                                <p class="text-gray-500">Belum ada data pengguna</p>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Table Footer -->
                    <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                        <div class="text-sm text-gray-500">
                            Menampilkan <span class="font-medium">1</span> sampai <span class="font-medium">10</span>
                            dari <span class="font-medium">25</span> hasil
                        </div>
                        <div class="flex space-x-2">
                            <button
                                class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Sebelumnya
                            </button>
                            <button
                                class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-white bg-primary-600 hover:bg-primary-700">
                                1
                            </button>
                            <button
                                class="px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                Selanjutnya
                            </button>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

    <!-- Modal Form Tambah User -->
    <div id="formModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-md modal-enter">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-xl font-semibold text-gray-900 flex items-center gap-2">
                    <i class="fas fa-user-plus text-primary-600"></i>
                    Tambah Pengguna Baru
                </h3>
                <button onclick="document.getElementById('formModal').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-500 rounded-full p-1 hover:bg-gray-100">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <form action="/dashboard/admin/users/create" method="post" class="p-6 space-y-4">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" name="username" id="username" required
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 border py-2">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" name="email" id="email" required
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 border py-2">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" name="password" id="password" required
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 border py-2">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" class="text-gray-400 hover:text-gray-500"
                                onclick="togglePasswordVisibility('password')">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user-tag text-gray-400"></i>
                        </div>
                        <select name="role" id="role" required
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 border py-2 appearance-none bg-white">
                            <option value="admin">Admin</option>
                            <option value="operator">Operator</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="desa" class="block text-sm font-medium text-gray-700 mb-1">Desa</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-map-marker-alt text-gray-400"></i>
                        </div>
                        <input type="text" name="desa" id="desa"
                            class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 border py-2">
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="document.getElementById('formModal').classList.add('hidden')"
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 shadow-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 shadow-sm flex items-center gap-2">
                        <i class="fas fa-save"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Detail Pengguna -->
    <div id="detailModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-40 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-lg">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-900">
                    <i class="fas fa-user-circle text-primary-600 mr-2"></i>
                    Detail Pengguna
                </h3>
                <button onclick="toggleModal('detailModal')" class="text-gray-400 hover:text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="text-sm text-gray-500">Username:</p>
                    <p id="detailUsername" class="text-lg font-semibold text-gray-900"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email:</p>
                    <p id="detailEmail" class="text-base text-gray-800"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Role:</p>
                    <p id="detailRole" class="text-base text-gray-800"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Desa:</p>
                    <p id="detailDesa" class="text-base text-gray-800"></p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status:</p>
                    <p id="detailStatus" class="text-base font-semibold text-white inline-block px-3 py-1 rounded-full">
                    </p>
                </div>
            </div>
            <div class="p-4 border-t flex justify-end">
                <button onclick="toggleModal('detailModal')"
                    class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function showDetail(username, email, role, desa, status) {
            document.getElementById('detailUsername').textContent = username;
            document.getElementById('detailEmail').textContent = email;
            document.getElementById('detailRole').textContent = role;
            document.getElementById('detailDesa').textContent = desa || '-';

            const statusText = document.getElementById('detailStatus');
            statusText.textContent = status || '-';

            // Reset class warna status
            statusText.classList.remove('bg-yellow-500', 'bg-green-600', 'bg-red-500');

            // Warna status berdasarkan value
            switch (status?.toLowerCase()) {
                case 'approved':
                    statusText.classList.add('bg-green-600');
                    break;
                case 'pending':
                    statusText.classList.add('bg-yellow-500');
                    break;
                case 'rejected':
                    statusText.classList.add('bg-red-500');
                    break;
                default:
                    statusText.classList.add('bg-gray-500');
            }

            document.getElementById('detailModal').classList.remove('hidden');
        }

        function toggleModal(id) {
            document.getElementById(id).classList.toggle('hidden');
        }
    </script>

    <script>
        function togglePasswordVisibility(id) {
            const input = document.getElementById(id);
            const icon = input.nextElementSibling.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Add animation to modal when opening
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('formModal');
            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            });
        });
    </script>
</body>

</html>
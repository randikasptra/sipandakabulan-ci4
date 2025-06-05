<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Kelola User') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">

        <!-- Sidebar Admin -->
        <?= $this->include('layouts/sidenav_admin') ?>

        <!-- Konten Utama -->
        <div class="flex-1 flex flex-col">

            <!-- Header Admin -->
            <?= $this->include('layouts/header_admin') ?>

            <!-- Konten -->
            <main class="flex-1 p-8">

                <!-- Judul & Deskripsi -->
                <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                    <h2 class="text-2xl font-bold mb-2">Kelola User</h2>
                    <p class="text-gray-600">Berikut adalah daftar user yang terdaftar di sistem.</p>
                </div>

                <!-- Tabel User -->
                <div class="bg-white p-4 rounded-lg shadow-md overflow-x-auto">
                    <table class="min-w-full table-auto">
    <thead class="bg-blue-800 text-white">
        <tr>
            <th class="px-4 py-2 text-left">No</th>
            <th class="px-4 py-2 text-left">Username</th>
            <th class="px-4 py-2 text-left">Email</th>
            <th class="px-4 py-2 text-left">Role</th>
            <th class="px-4 py-2 text-left">Desa</th>
            <th class="px-4 py-2 text-left">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $index => $user): ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2"><?= $index + 1 ?></td>
                    <td class="px-4 py-2"><?= esc($user['username']) ?></td>
                    <td class="px-4 py-2"><?= esc($user['email']) ?></td>
                    <td class="px-4 py-2 capitalize"><?= esc($user['role']) ?></td>
                    <td class="px-4 py-2"><?= esc($user['desa'] ?? '-') ?></td>
                    <td class="px-4 py-2 space-x-2">
                        <a href="/admin/users/<?= $user['id'] ?>/edit" class="text-blue-600 hover:underline">Edit</a>
                        <a href="/admin/users/<?= $user['id'] ?>" class="text-gray-700 hover:underline">Lihat</a>
                        <form action="/admin/users/<?= $user['id'] ?>/delete" method="post" class="inline">
                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Yakin ingin menghapus user ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center text-gray-500 py-4">Belum ada data pengguna.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
                </div>

            </main>
        </div>
    </div>

</body>

</html>

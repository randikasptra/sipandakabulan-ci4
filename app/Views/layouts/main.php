<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'SIPANDAKABULAN') ?></title>

    <!-- Tambahkan CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body x-data="{ open: false, dropdownOpen: false, showPasswordModal: false }" class="bg-gray-50 min-h-screen">

    <!-- Header + Navbar -->
    <?= $this->include('layouts/header') ?>
    <?= $this->include('layouts/navbar') ?>

    <!-- Main Content -->
    <main class="pt-24">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Modal Ubah Password -->
    <div x-show="showPasswordModal" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div @click.away="showPasswordModal = false"
             class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
            <h2 class="text-lg font-semibold mb-4">Ganti Password Baru</h2>
            <form action="<?= site_url('ubah-password') ?>" method="POST" class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label for="new_password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                    <input type="password" name="new_password" id="new_password" required
                           class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" @click="showPasswordModal = false"
                            class="px-4 py-2 text-sm text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?= $this->include('layouts/footer') ?>
</body>
</html>

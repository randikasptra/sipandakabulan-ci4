<?php $user = session()->get(); ?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'SIPANDAKABULAN') ?></title>

    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/LogoKKLA.png') ?>">

    <style>
        [x-cloak] { display: none !important; }
        .loader {
            border-top-color: transparent;
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen relative">

    <!-- 🔃 Loading Screen -->
    <div id="loading-screen" class="fixed inset-0 bg-white z-[9999] flex items-center justify-center transition-opacity duration-500">
        <div class="loader ease-linear rounded-full border-8 border-t-8 border-blue-500 h-20 w-20 animate-spin"></div>
    </div>

    <!-- Konten Utama -->
    <div x-data="{ open: false, dropdownOpen: false, showPasswordModal: false }" id="main-content" class="relative z-10">
        <!-- Header + Navbar -->
        <?= $this->include('layouts/header') ?>
        <?= $this->include('layouts/navbar') ?>

        <!-- Main Content -->
        <main class="pt-24">
            <?= $this->renderSection('content') ?>
        </main>

        <!-- Modal Password -->
        <div 
            x-show="showPasswordModal" 
            x-cloak 
            x-transition.opacity 
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
            @click.self="showPasswordModal = false"
            @keydown.escape.window="showPasswordModal = false"
        >
            <div @click.stop class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">
                <h2 class="text-lg font-semibold mb-4">Ganti Password Baru</h2>
                <form action="<?= site_url('update-password/' . $user['id']) ?>" method="POST">
                    <?= csrf_field() ?>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
                        <input type="password" name="password" id="password"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
                    </div>

                    <div class="mt-4">
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <input type="password" name="confirm_password" id="confirm_password"
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            required>
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
    </div>

    <!-- 🔽 Script untuk Hilangkan Loader Setelah Page Selesai -->
    <script>
        window.addEventListener('load', function () {
            const loader = document.getElementById('loading-screen');
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.display = 'none';
            }, 500); // delay untuk transisi
        });
    </script>
</body>
</html>

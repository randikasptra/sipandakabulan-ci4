<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/LogoKKLA.png') ?>">

    <!-- CDN SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/LogoKKLA.png') ?>">
    

    <!-- SweetAlert Trigger -->
    <?php if (session()->getFlashdata('success')): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sukses!',
                text: '<?= session()->getFlashdata('success') ?>',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        </script>
    <?php endif; ?>

</head>

    <body class="bg-gray-100" x-data="{ open: false, dropdownOpen: false, showPasswordModal: false }">

    <!-- Modal Ubah Password -->
<div x-show="showPasswordModal"
     x-cloak
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


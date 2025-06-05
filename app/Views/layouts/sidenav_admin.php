<!-- app/Views/components/sidenav.php -->
<aside class="w-64 bg-blue-900 text-white flex flex-col min-h-screen">
    <div class="px-6 py-4 text-2xl font-bold border-b border-blue-700">
        SIPANDAKABULAN
    </div>
    <nav class="flex-1 px-4 py-6 space-y-2">
        <a href="<?= base_url('dashboard') ?>" class="flex items-center gap-2 py-2 px-4 rounded hover:bg-blue-700">
            <i class="fa-solid fa-chart-line"></i> Dashboard
        </a>
        <a href="<?= base_url('kelembagaan') ?>" class="flex items-center gap-2 py-2 px-4 rounded hover:bg-blue-700">
            <i class="fa-solid fa-building"></i> Kelembagaan
        </a>
        <a href="<?= base_url('klaster') ?>" class="flex items-center gap-2 py-2 px-4 rounded hover:bg-blue-700">
            <i class="fa-solid fa-layer-group"></i> Klaster
        </a>
        <a href="<?= base_url('berkas') ?>" class="flex items-center gap-2 py-2 px-4 rounded hover:bg-blue-700">
            <i class="fa-solid fa-folder-open"></i> Berkas
        </a>
        <a href="<?= base_url('pengguna') ?>" class="flex items-center gap-2 py-2 px-4 rounded hover:bg-blue-700">
            <i class="fa-solid fa-users"></i> Pengguna
        </a>
        <a href="<?= base_url('logout') ?>" class="flex items-center gap-2 py-2 px-4 rounded hover:bg-blue-700">
            <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
    </nav>
</aside>

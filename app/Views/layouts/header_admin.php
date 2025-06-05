<!-- app/Views/layouts/header_admin.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <header class="bg-white shadow px-6 py-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-2">
        <!-- Title & Subtitle -->
        <div>
            <h1 class="text-xl md:text-2xl font-bold text-blue-800">SIPANDAKABULAN Admin Panel</h1>
            <p class="text-sm text-gray-500">Panduan: Silakan isi data sesuai klaster yang tersedia</p>
        </div>

        <!-- User Info -->
        <div class="text-left md:text-right">
            <p class="text-gray-700">
                <span class="font-semibold">Login sebagai:</span> <?= esc($user_name ?? 'Admin Kabupaten') ?>
            </p>
            <p class="text-sm text-gray-500">
                Role: <span class="text-blue-700 font-semibold"><?= esc($user_role ?? 'Administrator') ?></span>
            </p>
        </div>
    </header>

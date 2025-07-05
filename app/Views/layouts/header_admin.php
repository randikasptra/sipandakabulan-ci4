<!-- app/Views/layouts/header_admin.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dashboard') ?> | SIPANDAKABULAN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/png" href="<?= base_url('assets/img/LogoKKLA.png') ?>">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50">
    <header
        class="z-20 fixed top-0 w-full bg-gradient-to-r from-blue-800 to-blue-700 text-white shadow-lg px-6 py-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <!-- Title & Subtitle -->

        <!-- User Info -->
        <div class="flex items-center gap-4 ml-auto">
            <div class="hidden md:flex flex-col text-right">
                <p class="text-white font-medium">
                    <i class="fas fa-user-circle mr-1"></i> <?= esc($user_name ?? 'Admin Kabupaten') ?>
                </p>
                <p class="text-xs text-blue-100">
                    Role: <span class="font-semibold"><?= esc($user_role ?? 'Administrator') ?></span>
                </p>
            </div>
            <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center border-2 border-blue-300">
                <i class="fas fa-user text-white"></i>
            </div>
        </div>
    </header>

    
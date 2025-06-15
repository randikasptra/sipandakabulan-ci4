<?= $this->include('layouts/navbar') ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pengumuman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <style>
        :root {
            --primary: #1e3a8a;
            --primary-light: #3b82f6;
        }
    </style>
</head>

<body class="bg-gray-100 text-gray-800">
    <div class="bg-gray-100 p-4 mb-4 rounded shadow text-sm text-gray-800">
    <strong>Debug Info Login (Session):</strong><br>
    Username: <?= session()->get('username') ?><br>
    Email: <?= session()->get('email') ?><br>
    Role: <?= session()->get('role') ?><br>
    Desa: <?= session()->get('desa') ?><br>
</div>


    <div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold text-blue-700 mb-6">📢 Pengumuman</h2>

        <?php if (empty($pengumuman)): ?>
            <div class="text-center text-gray-500 italic">
                Belum ada pengumuman untuk desa kamu.
            </div>
        <?php else: ?>
            <?php foreach ($pengumuman as $p): ?>
                <div class="mb-6 border border-blue-200 rounded p-4 shadow-sm hover:shadow transition duration-300">
                    <h3 class="text-xl font-semibold text-blue-800 mb-1"><?= esc($p['judul']) ?></h3>
                    <p class="text-sm text-gray-500 mb-2">
                        <?= date('d M Y H:i', strtotime($p['created_at'])) ?> 
                        | Tujuan: <span class="font-medium text-gray-700">
                            <?= esc($p['tujuan_desa'] ?? 'Semua Desa') ?>
                        </span>
                    </p>
                    <p class="text-gray-700 leading-relaxed"><?= esc($p['isi']) ?></p>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>

</body>
</html>

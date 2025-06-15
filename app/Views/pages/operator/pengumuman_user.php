<?= $this->include('layouts/navbar') ?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>hHA </title>
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

    <div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold text-blue-700 mb-4">Pengumuman</h2>

        <?php if (empty($pengumuman)): ?>
            <p class="text-gray-600">Belum ada pengumuman untuk desa kamu.</p>
        <?php else: ?>
            <?php foreach ($pengumuman as $p): ?>
                <div class="mb-6 border border-blue-200 rounded p-4 shadow-sm hover:shadow transition duration-300">
                    <h3 class="text-lg font-semibold text-blue-800"><?= esc($p['judul']) ?></h3>
                    <p class="text-sm text-gray-500 mb-2">Tujuan: <?= esc($p['tujuan_desa']) ?> |
                        <?= date('d M Y H:i', strtotime($p['created_at'])) ?>
                    </p>
                    <p class="text-gray-700"><?= esc($p['isi']) ?></p>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>

</body>

</html>
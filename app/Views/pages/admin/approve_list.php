<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Evaluasi Desa</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body class="bg-gray-100 text-gray-800">

  <div class="flex min-h-screen ml-72">

    <!-- Sidebar Admin -->
    <?= $this->include('layouts/sidenav_admin') ?>

    <!-- Konten Utama -->
    <div class="flex-1 flex flex-col mt-24">

      <!-- Header Admin -->
      <?= $this->include('layouts/header_admin') ?>
      <main class="flex-1 p-8">
        <div class="max-w-6xl mx-auto px-6 py-10">
          <h1 class="text-3xl font-bold text-blue-900 mb-6 flex items-center gap-2">
            <i class="ph ph-check-square text-2xl"></i> Daftar Evaluasi dari Operator Desa
          </h1>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (!empty($users) && is_array($users)): ?>
              <?php foreach ($users as $user): ?>
                <div class="bg-white p-6 rounded-xl shadow-md flex flex-col justify-between">
                  <div class="space-y-2">
                    <h2 class="text-xl font-bold text-gray-800"><?= esc($user['username'] ?? 'Tanpa Nama') ?></h2>
                    <p class="text-sm text-gray-600 flex items-center gap-1">
                      <i class="ph ph-map-pin text-blue-700"></i> Desa: <?= esc($user['desa'] ?? 'Belum Diisi') ?>
                    </p>
                    <p class="text-sm text-gray-600 flex items-center gap-1">
                      <i class="ph ph-envelope text-blue-700"></i> <?= esc($user['email']) ?>
                    </p>
                    <p class="text-sm text-gray-600 flex items-center gap-1">
                      <i class="ph ph-file-text text-blue-700"></i>
                      Status Input:
                      <span
                        class="font-semibold <?= $user['status_input'] === 'sudah' ? 'text-green-600' : 'text-red-600' ?>">
                        <?= esc(ucfirst($user['status_input'])) ?>
                      </span>
                    </p>
                    <p class="text-sm text-gray-600 flex items-center gap-1">
                      <i class="ph ph-clipboard-check text-blue-700"></i>
                      Status Approve:
                      <span
                        class="font-semibold <?= $user['status_approve'] === 'approved' ? 'text-green-600' : 'text-yellow-500' ?>">
                        <?= esc(ucfirst($user['status_approve'])) ?>
                      </span>
                    </p>
                  </div>

                  <div class="mt-4 text-right">
                    <a href="<?= site_url('dashboard/admin/approve/' . $user['id']) ?>"
                      class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                      <i class="ph ph-eye"></i> Lihat Detail
                    </a>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <p class="text-gray-600">Tidak ada data pengguna yang tersedia.</p>
            <?php endif; ?>
          </div>
        </div>
      </main>
    </div>
  </div>

</body>

</html>
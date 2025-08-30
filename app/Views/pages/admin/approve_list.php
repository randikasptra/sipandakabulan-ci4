<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Evaluasi Desa</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body class="bg-gray-50 text-gray-800">

  <div class="flex min-h-screen ml-72">

    <!-- Sidebar Admin -->
    <?= $this->include('layouts/sidenav_admin') ?>

    <!-- Konten Utama -->
    <div class="flex-1 flex flex-col mt-24">

      <!-- Header Admin -->
      <?= $this->include('layouts/header_admin') ?>
      <main class="flex-1 p-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
          <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
            <div>
              <h1 class="text-3xl font-bold text-gray-900 flex items-center gap-3">
                <span class="bg-blue-100 p-3 rounded-full">
                  <i class="ph ph-check-square text-2xl text-blue-700"></i>
                </span>
                Daftar Evaluasi dari Operator Desa
              </h1>
              <p class="text-gray-500 mt-2">Kelola evaluasi dari berbagai desa</p>
            </div>
            <div class="mt-4 sm:mt-0">
              <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="ph ph-magnifying-glass text-gray-400"></i>
                </div>
                <input type="text" id="searchInput" placeholder="Cari Nama Desa..."
                  class="pl-8 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
              </div>
            </div>
          </div>

          <!-- Tabel -->
          <div class="overflow-x-auto bg-white rounded-xl shadow">
            <table class="min-w-full divide-y divide-gray-200">
           <thead class="bg-gray-100">
  <tr>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Nama Operator</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Desa</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Email</th>
    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Progress</th>
    <th class="px-6 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">Aksi</th>
  </tr>
</thead>

<tbody class="bg-white divide-y divide-gray-200">
  <?php foreach ($users as $user): ?>
    <tr class="hover:bg-gray-50 transition" data-desa="<?= strtolower($user['desa'] ?? '') ?>">
      
      <!-- Nama Operator -->
      <td class="px-6 py-4 font-medium text-gray-800 flex items-center gap-2">
        <i class="ph ph-user-circle text-lg text-blue-600"></i>
        <?= esc($user['username'] ?? 'Tanpa Nama') ?>
      </td>
      
      <!-- Desa -->
      <td class="px-6 py-4 text-gray-700">
        <?= esc($user['desa'] ?? 'Belum Diisi') ?>
      </td>
      
      <!-- Email -->
      <td class="px-6 py-4 text-gray-700">
        <?= esc($user['email']) ?>
      </td>

      <!-- Progress -->
      <td class="px-6 py-4">
        <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
          <div 
            class="<?= $user['is_complete'] ? 'bg-green-600' : 'bg-yellow-500' ?> h-2.5 rounded-full"
            style="width: <?= $user['progress_percent'] ?>%">
          </div>
        </div>
        <div class="flex items-center gap-2 text-xs">
          <span class="text-gray-500"><?= $user['progress'] ?></span>
          <?php if ($user['is_complete']): ?>
            <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full font-medium flex items-center gap-1">
              <i class="fas fa-check-circle"></i> Selesai
            </span>
          <?php else: ?>
            <span class="px-2 py-0.5 bg-yellow-100 text-yellow-700 rounded-full font-medium flex items-center gap-1">
              <i class="fas fa-hourglass-half"></i> Belum Selesai
            </span>
          <?php endif; ?>
        </div>
      </td>

      <!-- Aksi -->
      <td class="px-6 py-4 text-right">
        <a href="<?= site_url('dashboard/admin/approve/' . $user['id']) ?>"
          class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
          <i class="ph ph-arrow-right"></i> Lihat
        </a>
      </td>

    </tr>
  <?php endforeach; ?>
</tbody>



            </table>
          </div>

        </div>
      </main>
    </div>
  </div>

  <script>
    document.getElementById('searchInput').addEventListener('input', function () {
      const keyword = this.value.toLowerCase();
      const rows = document.querySelectorAll('tbody tr[data-desa]');

      rows.forEach(row => {
        const desa = row.dataset.desa?.toLowerCase() || '';
        if (desa.includes(keyword)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    });
  </script>

</body>

</html>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Evaluasi Desa</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
  <style>
    .card-hover {
      transition: all 0.3s ease;
      border-left: 4px solid transparent;
    }

    .card-hover:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
      border-left-color: #1d4ed8;
    }

    .status-badge {
      padding: 0.25rem 0.5rem;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 600;
    }
  </style>
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
                <div class="relative">
                  <input type="text" id="searchInput" placeholder="Cari Nama Desa..."
                    class="pl-8 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (!empty($users) && is_array($users)): ?>
              <?php foreach ($users as $user): ?>
                <div class="card-hover bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md"
                  data-desa="<?= strtolower($user['desa'] ?? '') ?>">
                  <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-3">
                      <div class="bg-blue-100 p-3 rounded-full">
                        <i class="ph ph-user-circle text-xl text-blue-700"></i>
                      </div>
                      <div>
                        <h2 class="text-lg font-bold text-gray-800"><?= esc($user['username'] ?? 'Tanpa Nama') ?></h2>
                      </div>
                    </div>
                    
                  </div>

                  <div class="space-y-3 mb-4">
                    <div class="flex items-center gap-3 text-sm">
                      <div class="bg-blue-50 p-2 rounded-lg">
                        <i class="ph ph-map-pin text-blue-700"></i>
                      </div>
                      <div>
                        <p class="text-gray-500">Desa</p>
                        <p class="font-medium"><?= esc($user['desa'] ?? 'Belum Diisi') ?></p>
                      </div>
                    </div>

                    <div class="flex items-center gap-3 text-sm">
                      <div class="bg-blue-50 p-2 rounded-lg">
                        <i class="ph ph-envelope text-blue-700"></i>
                      </div>
                      <div>
                        <p class="text-gray-500">Email</p>
                        <p class="font-medium"><?= esc($user['email']) ?></p>
                      </div>
                    </div>
                  </div>

                  <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                    <div class="text-xs text-gray-500 flex items-center gap-1">
                      <i class="ph ph-calendar-blank"></i>
                      <?= date('d M Y', strtotime($user['created_at'] ?? 'now')) ?>
                    </div>
                    <a href="<?= site_url('dashboard/admin/approve/' . $user['id']) ?>"
                      class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm">
                      <i class="ph ph-arrow-right"></i> Review
                    </a>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="col-span-full py-12 text-center">
                <div class="mx-auto max-w-md">
                  <i class="ph ph-folder-open text-5xl text-gray-300 mb-4"></i>
                  <h3 class="text-lg font-medium text-gray-900">Tidak ada data pengguna</h3>
                  <p class="mt-1 text-sm text-gray-500">Belum ada evaluasi dari operator desa yang tersedia.</p>
                </div>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </main>
    </div>
  </div>

  <script>
    document.getElementById('searchInput').addEventListener('input', function () {
      const keyword = this.value.toLowerCase();
      const cards = document.querySelectorAll('.card-hover');

      cards.forEach(card => {
        const desa = card.dataset.desa?.toLowerCase() || '';
        if (desa.includes(keyword)) {
          card.style.display = '';
        } else {
          card.style.display = 'none';
        }
      });
    });
  </script>

</body>

</html>

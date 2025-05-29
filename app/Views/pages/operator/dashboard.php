<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/navbar') ?>

<!-- Hero Section -->
<section class="p-6">
    <div class="bg-white p-6 rounded-lg shadow-md flex flex-col md:flex-row justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl font-bold mb-2">Selamat Datang, Kabupaten Tasikmalaya!</h2>
            <p class="text-gray-600">
                Email: <?= esc($user_email) ?> |
                Tipe User: <span class="font-semibold text-blue-800"><?= esc($user_role) ?></span>
            </p>

        </div>

        <div class="mt-4 md:mt-0 text-center">
            <p class="text-green-600 font-bold text-lg">Evaluasi SIPANDAKABULAN sudah di Approve</p>
            <p class="text-gray-700">Nilai EM <span class="font-bold">805.2</span> | Nilai Maksimal 1000</p>
            <div class="w-48 bg-gray-300 rounded-full h-4 mt-2">
                <div class="bg-green-500 h-4 rounded-full" style="width: 80%"></div>
            </div>
        </div>
    </div>
</section>

<!-- Card Klaster Section -->
<section class="px-6 pb-6 ">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($klasters as $klaster) : ?>
            <?= view('components/card_klaster', [
                'klaster' => $klaster['slug'],
                'id' => $klaster['id'],
                'title' => $klaster['title'],
                'nilaiEm' => $klaster['nilai_em'],
                'nilaiMaksimal' => $klaster['nilai_maksimal'],
                'progres' => $klaster['progres'],
            ]) ?>
        <?php endforeach; ?>
    </div>
</section>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>


<?= $this->include('layouts/footer') ?>
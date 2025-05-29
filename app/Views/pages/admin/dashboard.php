<h1>Selamat Datang Admin SIPANDA</h1>
<!-- <a href="/logout">Logout</a>
  -->
<a href="<?= base_url('logout') ?>">Logout</a>
<form method="POST" action="<?= site_url('logout') ?>" class="inline">
  <?= csrf_field() ?>
  <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-4 rounded-full text-sm">
    Logout
  </button>
</form>
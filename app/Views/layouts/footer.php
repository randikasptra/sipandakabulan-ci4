<footer class="bg-blue-900 text-white text-center p-4 mt-8">
    <p class="text-sm">© 2025 Kabupaten Tasikmalaya | Evaluasi SIPANDAKABULAN</p>
</footer>

<script>
    document.getElementById('menu-toggle').addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: '<?= session()->getFlashdata('success') ?>',
            confirmButtonColor: '#3085d6',
            timer: 3000
        });
    <?php elseif (session()->getFlashdata('error')) : ?>
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '<?= session()->getFlashdata('error') ?>',
            confirmButtonColor: '#d33',
            timer: 3000
        });
    <?php endif; ?>
</script>


</body>

</html>
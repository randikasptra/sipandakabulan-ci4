<?= $this->include('layouts/header') ?>
<?= $this->include('layouts/navbar') ?>

<section class="py-12 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Edit User</h2>

    <form action="/dashboard/admin/users/<?= $user['id'] ?>/update" method="post" class="space-y-4">
        <div>
            <label for="username" class="block font-medium">Username</label>
            <input type="text" name="username" id="username" value="<?= esc($user['username']) ?>" required
                class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label for="email" class="block font-medium">Email</label>
            <input type="email" name="email" id="email" value="<?= esc($user['email']) ?>" required
                class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label for="password" class="block font-medium">Password (kosongkan jika tidak diganti)</label>
            <input type="password" name="password" id="password" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label for="role" class="block font-medium">Role</label>
            <select name="role" id="role" class="w-full border rounded px-3 py-2">
                <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="operator" <?= $user['role'] == 'operator' ? 'selected' : '' ?>>Operator</option>
            </select>
        </div>

        <div>
            <label for="desa" class="block font-medium">Desa</label>
            <input type="text" name="desa" id="desa" value="<?= esc($user['desa']) ?>"
                class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label for="status_input" class="block font-medium">Status Input</label>
            <select name="status_input" id="status_input" class="w-full border rounded px-3 py-2">
                <option value="belum" <?= $user['status_input'] == 'belum' ? 'selected' : '' ?>>Belum</option>
                <option value="sudah" <?= $user['status_input'] == 'sudah' ? 'selected' : '' ?>>Sudah</option>
            </select>
        </div>

        <div>
            <label for="status_approve" class="block font-medium">Status Approve</label>
            <select name="status_approve" id="status_approve" class="w-full border rounded px-3 py-2">
                <option value="pending" <?= $user['status_approve'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                <option value="approved" <?= $user['status_approve'] == 'approved' ? 'selected' : '' ?>>Approved</option>
                <option value="rejected" <?= $user['status_approve'] == 'rejected' ? 'selected' : '' ?>>Rejected</option>
            </select>
        </div>

        <div class="flex justify-between items-center">
            <a href="/dashboard/users" class="text-blue-500 hover:underline">← Kembali</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
        </div>
    </form>
</section>

<?= $this->include('layouts/footer') ?>
<h2 class="text-xl font-semibold mb-4"><?= esc($desa['username']) ?> - Detail Klaster</h2>

<table class="table-auto w-full border border-collapse border-gray-300">
    <thead>
        <tr>
            <th class="border px-4 py-2">Klaster</th>
            <th class="border px-4 py-2">File</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($klasterFiles as $klaster => $file): ?>
            <tr>
                <td class="border px-4 py-2"><?= $klaster ?></td>
                <td class="border px-4 py-2">
                    <?php if ($file): ?>
                        <a href="<?= base_url('uploads/' . $file) ?>" 
                           class="text-blue-600 hover:underline" 
                           download>
                            Download Excel
                        </a>
                    <?php else: ?>
                        <span class="text-gray-500 italic">Belum diunggah</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

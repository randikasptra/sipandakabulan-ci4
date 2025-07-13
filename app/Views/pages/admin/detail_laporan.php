<h2 class="text-xl font-bold mb-4">Detail Laporan Klaster</h2>

<table class="table-auto w-full text-sm border">
    <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 border">Indikator</th>
            <th class="px-4 py-2 border">File</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($indikatorList as $key => $label): ?>
            <tr class="border-t">
                <td class="px-4 py-2 border"><?= esc($label) ?></td>
                <td class="px-4 py-2 border">
                    <?php if (!empty($data[$key . '_file'])): ?>
                        <a href="<?= base_url('uploads/' . $folder . '/' . $data[$key . '_file']) ?>" class="text-blue-600 underline" target="_blank">
                            Download <?= esc($label) ?>
                        </a>
                    <?php else: ?>
                        <span class="text-gray-500 italic">Tidak ada file</span>
                    <?php endif ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

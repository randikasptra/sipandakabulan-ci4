<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h2 { margin-bottom: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #aaa; padding: 6px; }
    </style>
</head>
<body>
    <h2>Laporan Klaster 1 - Kelembagaan</h2>
    <p><strong>Nama Desa:</strong> <?= esc($user['desa']) ?></p>
    <p><strong>Tahun:</strong> <?= esc($data['tahun']) ?> | <strong>Bulan:</strong> <?= esc($data['bulan']) ?></p>

    <h3>Detail Indikator</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Soal</th>
                <th>Nilai</th>
                <th>Keterangan</th>
                <th>File</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($indikator as $i => $item): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= esc($item['judul']) ?></td>
                <td><?= esc($item['nilai']) ?></td>
                <td><?= esc($item['opsi'][$item['nilai']] ?? '-') ?></td>
                <td><?= $item['file'] ? $item['file'] : '-' ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <p style="margin-top: 20px;"><strong>Total Nilai:</strong> <?= esc($data['total_nilai']) ?></p>
</body>
</html>

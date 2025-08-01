<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Klaster 2</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
        }
        .kop {
            border-bottom: 3px solid black;
            padding-bottom: 10px;
            margin-bottom: 30px;
            overflow: hidden;
        }
        .kop img {
            float: left;
            width: 80px;
            height: auto;
            margin-right: 15px;
        }
        .kop .text {
            text-align: center;
        }
        .kop h1 {
            margin: 0;
            font-size: 16px;
        }
        .kop h2 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .kop p {
            margin: 2px 0;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            text-decoration: underline;
            margin: 40px 0 20px;
        }

        .info {
            margin-bottom: 20px;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 4px;
            vertical-align: top;
        }

        .clear {
            clear: both;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <!-- Kop Surat -->
    <div class="kop">
        <img src="assets/img/LogoKABTASIKMALAYA.png" alt="">
        <div class="text">
            <h1>PEMERINTAH DAERAH KABUPATEN TASIKMALAYA</h1>
            <h2>DINAS SOSIAL, PENGENDALIAN PENDUDUK,<br>
                KELUARGA BERENCANA, PEMBERDAYAAN PEREMPUAN<br>
                DAN PERLINDUNGAN ANAK</h2>
            <p>Komplek Perkantoran Jl. Sukapura II Telp./Faks (0265) 333156</p>
            <p>Website: <u>dinsosppkbp3a.tasikmalayakab.go.id</u> &nbsp; Email: <u>dinsosppkbp3a@tasikmalayakab.go.id</u></p>
            <p><strong>Singaparna – 46415</strong></p>
        </div>
        <div class="clear"></div>
    </div>

    <!-- Judul -->
    <h2>LAPORAN KLASTER II: LINGKUNGAN KELUARGA</h2>

    <!-- Info Umum -->
    <div class="info">
        <table>
            <tr>
                <td><strong>Nama Desa</strong></td>
                <td>: <?= $data['desa'] ?? '-' ?></td>
            </tr>
            <tr>
                <td><strong>Nama Klaster</strong></td>
                <td>: <?= $data['klaster'] ?? 'Klaster II: Lingkungan Keluarga' ?></td>
            </tr>
            <tr>
                <td><strong>Bulan</strong></td>
                <td>: <?= $data['bulan'] ?? '-' ?></td>
            </tr>
            <tr>
                <td><strong>Tahun</strong></td>
                <td>: <?= $data['tahun'] ?? '-' ?></td>
            </tr>
            <tr>
                <td><strong>Total Nilai</strong></td>
                <td>: <?= $data['total_nilai'] ?? '-' ?></td>
            </tr>
        </table>
    </div>

    <!-- Tabel Penilaian -->
    <table>
        <tr>
            <th>No</th>
            <th>Pertanyaan</th>
            <th>Nilai</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Apakah ada Perkawinan Anak (Total Nilai 25)</td>
            <td><?= esc($data['perkawinanAnak'] ?? '-') ?></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Upaya yang dilakukan untuk Pencegahan Pernikahan Anak (Total Nilai 45)</td>
            <td><?= esc($data['pencegahanPernikahan'] ?? '-') ?></td>
        </tr>
        <tr>
            <td>3</td>
            <td>Tersedia Lembaga Konsultasi bagi Keluarga dalam Pengasuhan dan Perawatan Anak (Total Nilai 30)</td>
            <td><?= esc($data['lembagaKonsultasi'] ?? '-') ?></td>
        </tr>
    </table>

</body>
</html>

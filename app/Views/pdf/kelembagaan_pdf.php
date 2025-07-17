<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Kelembagaan</title>
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
      <img src="<?= base_url('assets/img/LogoKABTASIKMALAYA.png') ?>" alt="Logo" width="80">

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
    <h2>LAPORAN KELEMBAGAAN</h2>

    <!-- Info Umum -->
    <div class="info">
        <table>
            <tr>
                <td><strong>Nama Desa</strong></td>
                <td>: <?= $data['desa'] ?? '-' ?></td>
            </tr>
            <tr>
                <td><strong>Nama Klaster</strong></td>
                <td>: <?= $data['klaster'] ?? 'Kelembagaan' ?></td>
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
            <td>Adanya Peraturan yang mencakup lima klaster (Total Nilai 60)</td>
            <td><?= esc($data['peraturan_value']) ?></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Adanya Anggaran yang Responsif Anak (Total Nilai 50)</td>
            <td><?= esc($data['anggaran_value']) ?></td>
        </tr>
        <tr>
            <td>3</td>
            <td>Ada Forum Anak Desa (Total Nilai 40)</td>
            <td><?= esc($data['forum_anak_value']) ?></td>
        </tr>
        <tr>
            <td>4</td>
            <td>Ada Data Terpilah mencakup 5 Klaster (Total Nilai 50)</td>
            <td><?= esc($data['data_terpilah_value']) ?></td>
        </tr>
        <tr>
            <td>5</td>
            <td>Adakah dunia usaha di lingkungan desa yang memiliki keterlibatan dalam pemenuhan hak anak (Total Nilai 20)</td>
            <td><?= esc($data['dunia_usaha_value']) ?></td>
        </tr>
    </table>

</body>
</html>

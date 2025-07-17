<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Klaster 1</title>
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

        .section {
            margin-bottom: 20px;
        }

        .clear {
            clear: both;
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
    <h2>LAPORAN KLASTER I: HAK SIPIL DAN KEBEBASAN</h2>

    <!-- Info Umum -->
    <div class="info">
        <table>
            <tr>
                <td><strong>Nama Desa</strong></td>
                <td>: <?= $data['desa'] ?? '-' ?></td>
            </tr>
            <tr>
                <td><strong>Nama Klaster</strong></td>
                <td>: <?= $data['klaster'] ?? 'Klaster I: Hak Sipil dan Kebebasan' ?></td>
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

    <!-- Detail Penilaian -->
    <div class="section">
        <strong>1. Semua Anak Memiliki Akta Kelahiran (Total Nilai 50)</strong><br>
        Nilai: <?= $data['AnakAktaKelahiran'] ?? '-' ?>
    </div>

    <div class="section">
        <strong>2. Adanya Anggaran untuk Pemenuhan Hak Sipil Anak (Total Nilai 50)</strong><br>
        Nilai: <?= $data['anggaran'] ?? '-' ?>
    </div>

</body>
</html>

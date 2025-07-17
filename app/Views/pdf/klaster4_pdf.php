<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Klaster 4</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; }
        h2 { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; vertical-align: top; }
        th { background-color: #f2f2f2; }
        .section { margin-bottom: 20px; }
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
    <h2>LAPORAN KLASTER IV : Pendidikan, Waktu Luang, Budaya</h2>

    <!-- Info Umum -->
    <div class="info">
        <table>
            <tr>
                <td><strong>Nama Desa</strong></td>
                <td>: <?= $data['desa'] ?? '-' ?></td>
            </tr>
            <tr>
                <td><strong>Nama Klaster</strong></td>
                <td>: <?= $data['klaster'] ?? 'Klaster III: Kesehatan' ?></td>
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

  
    <table>
        <tr>
            <th>No</th>
            <th>Pertanyaan</th>
            <th>Jawaban</th>
        </tr>
        <tr>
            <td>1</td>
            <td>Tersedia Fasilitas Informasi Layak Anak (Jumlah Total 45)</td>
            <td><?= esc($data['infoAnak']) ?></td>
        </tr>
        <tr>
            <td>2</td>
            <td>Ada Kelompok Anak (termasuk FAD) (Jumlah Total 40)</td>
            <td><?= esc($data['kelompokAnak']) ?></td>
        </tr>
        <tr>
            <td>3</td>
            <td>Partisipasi Anak Usia Dini (Jumlah Total 30)</td>
            <td><?= esc($data['partisipasiDini']) ?></td>
        </tr>
        <tr>
            <td>4</td>
            <td>Presentasi belajar 12 tahun (Jumlah Total 50)</td>
            <td><?= esc($data['belajar12Tahun']) ?></td>
        </tr>
        <tr>
            <td>5</td>
            <td>Sekolah Ramah Anak (Jumlah Total 20)</td>
            <td><?= esc($data['sekolahRamahAnak']) ?></td>
        </tr>
        <tr>
            <td>6</td>
            <td>Tersedia Fasilitas kreativitas anak di luar sekolah (Jumlah Total 45)</td>
            <td><?= esc($data['fasilitasAnak']) ?></td>
        </tr>
        <tr>
            <td>7</td>
            <td>Sekolah yang memiliki program sarana dan prasarana perjalanan anak dari dan ke sekolah (Jumlah Total 20)</td>
            <td><?= esc($data['programPerjalanan']) ?></td>
        </tr>
    </table>
</body>
</html>

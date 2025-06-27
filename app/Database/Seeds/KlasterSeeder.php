<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KlasterSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Kelembagaan',
                'slug' => 'kelembagaan',
                'nilai_em' => 0,
                'nilai_maksimal' => 100,
                'progres' => 0
            ],
            [
                'title' => 'Klaster I: Hak Sipil dan Kebebasan',
                'slug' => 'klaster1',
                'nilai_em' => 0,
                'nilai_maksimal' => 100,
                'progres' => 0
            ],
            [
                'title' => 'Klaster II: Lingkungan Keluarga',
                'slug' => 'klaster2',
                'nilai_em' => 0,
                'nilai_maksimal' => 100,
                'progres' => 0
            ],
            [
                'title' => 'Klaster III: Kesehatan Dasar dan Kesejahteraan',
                'slug' => 'klaster3',
                'nilai_em' => 0,
                'nilai_maksimal' => 100,
                'progres' => 0
            ],
            [
                'title' => 'Klaster IV: Pendidikan, Waktu Luang, Budaya',
                'slug' => 'klaster4',
                'nilai_em' => 0,
                'nilai_maksimal' => 100,
                'progres' => 0
            ],
            [
                'title' => 'Klaster V: Perlindungan Khusus',
                'slug' => 'klaster5',
                'nilai_em' => 0,
                'nilai_maksimal' => 100,
                'progres' => 0
            ],
            // [
            //     'title' => 'Penyelenggaraan KLA di Kecamatan/Desa',
            //     'slug' => 'penyelenggaraan-kla-di-kecamatan-desa',
            //     'nilai_em' => 0,
            //     'nilai_maksimal' => 100,
            //     'progres' => 0
            // ],
        ];

        // Masukkan ke tabel 'klasters'
        $this->db->table('klasters')->insertBatch($data);
    }
}

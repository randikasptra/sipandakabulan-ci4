<?php


// 2. Model: app/Models/KelembagaanModel.php

namespace App\Models;

use CodeIgniter\Model;

class KelembagaanModel extends Model
{
    protected $table = 'kelembagaan';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id', 'tahun','bulan',
        'peraturan_value', 'peraturan_file',
        'anggaran_value', 'anggaran_file',
        'forum_anak_value', 'forum_anak_file',
        'data_terpilah_value', 'data_terpilah_file',
        'dunia_usaha_value', 'dunia_usaha_file',
        'total_nilai', 'status', 'created_at', 'updated_at'
    ];

    protected $useTimestamps = true;
}

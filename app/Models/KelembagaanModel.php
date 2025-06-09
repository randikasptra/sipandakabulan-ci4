<?php
namespace App\Models;

use CodeIgniter\Model;

class KelembagaanModel extends Model
{
    protected $table = 'kelembagaan_forms';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id', 'tahun', 'peraturan_value', 'anggaran_value',
        'forum_anak_value', 'data_terpilah_value', 'dunia_usaha_value',
        'total_nilai', 'peraturan_file', 'anggaran_file',
        'forum_anak_file', 'data_terpilah_file', 'dunia_usaha_file',
        'status', 'created_at', 'updated_at'
    ];
}

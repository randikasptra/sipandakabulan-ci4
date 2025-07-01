<?php

namespace App\Models;

use CodeIgniter\Model;

class Klaster4Model extends Model
{
    protected $table = 'klaster4';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'tahun',
        'bulan',

        'infoAnak',
        'infoAnak_file',

        'kelompokAnak',
        'kelompokAnak_file',

        'partisipasiDini',
        'partisipasiDini_file',

        'belajar12Tahun',
        'belajar12Tahun_file',

        'sekolahRamahAnak',
        'sekolahRamahAnak_file',

        'fasilitasAnak',
        'fasilitasAnak_file',

        'programPerjalanan',
        'programPerjalanan_file',

        'status',
        'created_at',
        'updated_at',
        'total_nilai'
    ];

    protected $useTimestamps = true;
}

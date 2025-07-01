<?php

namespace App\Models;

use CodeIgniter\Model;

class Klaster1Model extends Model
{
    protected $table = 'klaster1';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'tahun',
        'bulan',
        'AnakAktaKelahiran',
        'AnakAktaKelahiran_file',
        'anggaran',
        'anggaran_file',
        'status',
        'total_nilai',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}

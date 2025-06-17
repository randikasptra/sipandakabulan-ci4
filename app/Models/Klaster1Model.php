<?php

namespace App\Models;

use CodeIgniter\Model;

class Klaster1Model extends Model
{
    protected $table = 'klaster1';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'AnakAktaKelahiran',
        'AnakAktaKelahiran_file',
        'anggaran',
        'anggaran_file',
        'total_nilai',
        'status',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}
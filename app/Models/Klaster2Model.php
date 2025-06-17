<?php

namespace App\Models;

use CodeIgniter\Model;

class Klaster2Model extends Model
{
    protected $table = 'klaster2';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'tahun',
        'bulan',
        'status',
        'perkawinanAnak',
        'perkawinanAnak_file',
        'pencegahanPernikahan',
        'pencegahanPernikahan_file',
        'lembagaKonsultasi',
        'lembagaKonsultasi_file',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
}

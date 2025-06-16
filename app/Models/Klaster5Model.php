<?php

namespace App\Models;

use CodeIgniter\Model;

class Klaster5Model extends Model
{
    protected $table = 'klaster5';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'user_id',
        'laporanKekerasanAnak',
        'laporanKekerasanAnak_file',
        'mekanismePenanggulanganBencana',
        'mekanismePenanggulanganBencana_file',
        'programPencegahanKekerasan',
        'programPencegahanKekerasan_file',
        'programPencegahanPekerjaanAnak',
        'programPencegahanPekerjaanAnak_file',
    ];
}
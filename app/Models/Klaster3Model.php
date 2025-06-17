<?php

namespace App\Models;

use CodeIgniter\Model;

class Klaster3Model extends Model
{
    protected $table = 'klaster3';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'user_id',
        'tahun',
        'bulan',
        'status',
        'kematianBayi',
        'kematianBayi_file',
        'giziBalita',
        'giziBalita_file',
        'asiEksklusif',
        'asiEksklusif_file',
        'pojokAsi',
        'pojokAsi_file',
        'pusatKespro',
        'pusatKespro_file',
        'imunisasiAnak',
        'imunisasiAnak_file',
        'layananAnakMiskin',
        'layananAnakMiskin_file',
        'kawasanTanpaRokok',
        'kawasanTanpaRokok_file',
    ];

    protected $useTimestamps = true;
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class BerkasKlasterModel extends Model
{
    protected $table            = 'berkas_klaster';
    protected $primaryKey       = 'id';

    protected $allowedFields    = [
        'user_id',
        'klaster',
        'tahun',
        'bulan',
        'total_nilai',
        'nama_berkas',
        'file_path',
        'status',
        'catatan',
    ];

    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Optional: if you want soft deletes in the future
    // protected $useSoftDeletes = true;
}
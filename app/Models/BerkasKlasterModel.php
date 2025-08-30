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

    // Ambil data rekap dengan filter
    public function getRekap($filters = [])
    {
        $builder = $this->select('
                berkas_klaster.*,
                users.fullname as nama_user,   -- ganti fullname sesuai kolom yang ada di tabel users
                users.desa,
                klasters.title as nama_klaster
            ')
            ->join('users', 'users.id = berkas_klaster.user_id')
            ->join('klasters', 'klasters.id = berkas_klaster.klaster')
            ->where('berkas_klaster.status', 'approved');

        if (!empty($filters['desa'])) {
            $builder->where('users.desa', $filters['desa']);
        }
        if (!empty($filters['klaster'])) {
            $builder->where('klasters.title', $filters['klaster']);
        }
        if (!empty($filters['search_desa'])) {
            $builder->like('users.desa', $filters['search_desa']);
        }

        return $builder->orderBy('berkas_klaster.created_at', 'DESC')->findAll();
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class AnnouncementModel extends Model
{
    protected $table            = 'announcements';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $allowedFields    = ['judul', 'isi', 'tujuan_desa', 'created_at', 'updated_at'];
    protected $useTimestamps    = true; // otomatis handle created_at dan updated_at
}
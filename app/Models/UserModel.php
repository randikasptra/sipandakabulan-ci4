<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'username',
        'email',
        'password',
        'role',
        'desa',
        'status_input',
        'status_approve',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;

    // Method untuk ambil desa unik yang tidak null
    public function getUniqueDesa()
    {
        return $this->select('desa')
            ->where('desa IS NOT NULL')
            ->groupBy('desa')
            ->findAll();
    }
}
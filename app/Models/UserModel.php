<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    // Tambahkan kolom yang sesuai dengan database kamu
    protected $allowedFields = ['username', 'email', 'password', 'role'];

    protected $useTimestamps = true; // Kalau kamu pakai created_at / updated_at
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $returnType    = 'array'; // Bisa 'object' juga kalau kamu prefer
}

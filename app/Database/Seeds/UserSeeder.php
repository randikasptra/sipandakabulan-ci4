<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'   => 'admin',
                'email'      => 'admin@example.com',
                'password'   => password_hash('admin123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'desa'       => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'Sariwangi',
                'email'      => 'sariwangi@example.com',
                'password'   => password_hash('sariwangi123', PASSWORD_DEFAULT),
                'role'       => 'operator',
                'desa'       => 'Desa Sariwangi',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'Jayaputa',
                'email'      => 'jayaputra@example.com',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => 'operator',
                'desa'       => 'Desa Jayaputra',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'Jayaratu',
                'email'      => 'jayaratu@example.com',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => 'operator',
                'desa'       => 'Desa Jayaratu',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
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
                'email'      => 'admin@gmail.com',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => 'admin',
                'desa'       => null,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'Sariwangi',
                'email'      => 'sariwangi@gmail.com',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => 'operator',
                'desa'       => 'Desa Sariwangi',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'Jayaputa',
                'email'      => 'jayaputra@gmail.com',
                'password'   => password_hash('password123', PASSWORD_DEFAULT),
                'role'       => 'operator',
                'desa'       => 'Desa Jayaputra',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'Jayaratu',
                'email'      => 'jayaratu@gmail.com',
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
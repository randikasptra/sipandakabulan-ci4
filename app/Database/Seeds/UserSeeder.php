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
                'username'   => 'Sukamulih',
                'email'      => 'sariwangi@example.com',
                'password'   => password_hash('sariwangi123', PASSWORD_DEFAULT),
                'role'       => 'operator',
                'desa'       => 'Desa Sukamulih',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'Jayaputa',
                'email'      => 'jayaputra2@example.com',
                'password'   => password_hash('operator456', PASSWORD_DEFAULT),
                'role'       => 'operator',
                'desa'       => 'Desa Jayaputra',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
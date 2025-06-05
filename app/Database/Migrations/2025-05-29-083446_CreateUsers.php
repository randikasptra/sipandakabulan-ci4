<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'username'   => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null'           => true,
            ],
            'email'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '150',
                'unique'         => true,
            ],
            'password'   => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'role'       => [
                'type'           => 'ENUM',
                'constraint'     => ['operator', 'admin'],
                'default'        => 'operator',
            ],
            'desa'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '100',
                'null' => 'true'
            ],
            'created_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'updated_at' => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}

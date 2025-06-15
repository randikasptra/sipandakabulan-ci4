<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnnouncements extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => [
                'type'           => 'INT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'judul'          => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'isi'            => [
                'type'           => 'TEXT',
            ],
            'tujuan_desa'    => [
                'type'           => 'VARCHAR',
                'constraint'     => 100,
                'null'           => true, // NULL = semua desa
            ],
            'created_at'     => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
            'updated_at'     => [
                'type'           => 'DATETIME',
                'null'           => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('announcements');
    }

    public function down()
    {
        $this->forge->dropTable('announcements');
    }
}
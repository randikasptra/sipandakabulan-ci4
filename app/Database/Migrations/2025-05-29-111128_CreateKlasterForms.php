<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKlasters extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'auto_increment' => true],
            'slug'            => ['type' => 'VARCHAR', 'constraint' => 100],
            'title'           => ['type' => 'VARCHAR', 'constraint' => 255],
            'nilai_em'        => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0],
            'nilai_maksimal'  => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0],
            'progres'         => ['type' => 'DECIMAL', 'constraint' => '5,2', 'default' => 0],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('klasters');  // <-- ubah nama tabel di sini
    }

    public function down()
    {
        $this->forge->dropTable('klasters');  // <-- ubah nama tabel di sini
    }
}

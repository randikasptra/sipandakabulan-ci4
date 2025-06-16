<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKlaster2 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'unsigned' => true],
            'perkawinanAnak' => ['type' => 'INT', 'constraint' => 11],
            'perkawinanAnak_file' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'pencegahanPernikahan' => ['type' => 'INT', 'constraint' => 11],
            'pencegahanPernikahan_file' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'lembagaKonsultasi' => ['type' => 'INT', 'constraint' => 11],
            'lembagaKonsultasi_file' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('klaster2');
    }

    public function down()
    {
        $this->forge->dropTable('klaster2');
    }
}
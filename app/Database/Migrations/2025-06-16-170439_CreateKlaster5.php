<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKlaster5 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                                   => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'                              => ['type' => 'INT', 'unsigned' => true],
            'laporanKekerasanAnak'                 => ['type' => 'INT', 'null' => true],
            'laporanKekerasanAnak_file'            => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'mekanismePenanggulanganBencana'       => ['type' => 'INT', 'null' => true],
            'mekanismePenanggulanganBencana_file'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'programPencegahanKekerasan'           => ['type' => 'INT', 'null' => true],
            'programPencegahanKekerasan_file'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'programPencegahanPekerjaanAnak'       => ['type' => 'INT', 'null' => true],
            'programPencegahanPekerjaanAnak_file'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'created_at'                           => ['type' => 'DATETIME', 'null' => true],
            'updated_at'                           => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('klaster5');
    }

    public function down()
    {
        $this->forge->dropTable('klaster5');
    }
}
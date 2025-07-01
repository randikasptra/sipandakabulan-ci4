<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKlaster5 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'unsigned' => true],

            // Tahun & Bulan
            'tahun' => ['type' => 'YEAR'],
            'bulan' => ['type' => 'VARCHAR', 'constraint' => 20],

            // Nilai & File
            'laporanKekerasanAnak' => ['type' => 'INT', 'null' => true],
            'laporanKekerasanAnak_file' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'mekanismePenanggulanganBencana' => ['type' => 'INT', 'null' => true],
            'mekanismePenanggulanganBencana_file' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'programPencegahanKekerasan' => ['type' => 'INT', 'null' => true],
            'programPencegahanKekerasan_file' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'programPencegahanPekerjaanAnak' => ['type' => 'INT', 'null' => true],
            'programPencegahanPekerjaanAnak_file' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],

            'total_nilai' => ['type' => 'INT', 'null' => true],
            // Status approval
            'status' => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected'], 'default' => 'pending'],

            // Timestamps
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('klaster5');
    }

    public function down()
    {
        $this->forge->dropTable('klaster5');
    }
}

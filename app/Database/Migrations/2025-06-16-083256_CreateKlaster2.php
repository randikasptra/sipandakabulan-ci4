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
            'tahun' => ['type' => 'INT', 'constraint' => 4],
            'bulan' => ['type' => 'VARCHAR', 'constraint' => 20],
            'status' => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected'], 'default' => 'pending'],

            'perkawinanAnak' => ['type' => 'INT', 'constraint' => 11],
            'perkawinanAnak_file' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'pencegahanPernikahan' => ['type' => 'INT', 'constraint' => 11],
            'pencegahanPernikahan_file' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'lembagaKonsultasi' => ['type' => 'INT', 'constraint' => 11],
            'lembagaKonsultasi_file' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'total_nilai' => ['type' => 'INT', 'null' => true],
            
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('klaster2');
    }

    public function down()
    {
        $this->forge->dropTable('klaster2');
    }
}

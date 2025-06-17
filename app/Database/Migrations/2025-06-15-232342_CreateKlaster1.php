<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKlaster1 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'unsigned' => true],
            
            'tahun' => ['type' => 'INT', 'constraint' => 4],
            'bulan' => ['type' => 'VARCHAR', 'constraint' => 20],

            'AnakAktaKelahiran' => ['type' => 'INT', 'constraint' => 11],
            'AnakAktaKelahiran_file' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'anggaran' => ['type' => 'INT', 'constraint' => 11],
            'anggaran_file' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            
            'status' => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected'], 'default' => 'pending'],

            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('klaster1');
    }

    public function down()
    {
        $this->forge->dropTable('klaster1');
    }
}

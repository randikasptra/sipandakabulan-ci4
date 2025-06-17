<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKlaster4 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'unsigned' => true],

            'tahun' => ['type' => 'VARCHAR', 'constraint' => 10],
            'bulan' => ['type' => 'VARCHAR', 'constraint' => 20],

            'infoAnak' => ['type' => 'INT', 'constraint' => 11],
            'infoAnak_file' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],

            'kelompokAnak' => ['type' => 'INT', 'constraint' => 11],
            'kelompokAnak_file' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],

            'partisipasiDini' => ['type' => 'INT', 'constraint' => 11],
            'partisipasiDini_file' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],

            'belajar12Tahun' => ['type' => 'INT', 'constraint' => 11],
            'belajar12Tahun_file' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],

            'sekolahRamahAnak' => ['type' => 'INT', 'constraint' => 11],
            'sekolahRamahAnak_file' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],

            'fasilitasAnak' => ['type' => 'INT', 'constraint' => 11],
            'fasilitasAnak_file' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],

            'programPerjalanan' => ['type' => 'INT', 'constraint' => 11],
            'programPerjalanan_file' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],

            'status' => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected'], 'default' => 'pending'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('klaster4');
    }

    public function down()
    {
        $this->forge->dropTable('klaster4');
    }
}

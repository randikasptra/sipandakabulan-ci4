<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKlaster3 extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id'                     => ['type' => 'INT', 'unsigned' => true],
            'tahun'                       => ['type' => 'INT', 'constraint' => 4],
            'bulan'                       => ['type' => 'VARCHAR', 'constraint' => 20],
            'status'                      => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected'], 'default' => 'pending'],

            'kematianBayi'               => ['type' => 'INT', 'constraint' => 11],
            'kematianBayi_file'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],

            'giziBalita'                 => ['type' => 'INT', 'constraint' => 11],
            'giziBalita_file'            => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],

            'asiEksklusif'               => ['type' => 'INT', 'constraint' => 11],
            'asiEksklusif_file'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],

            'pojokAsi'                   => ['type' => 'INT', 'constraint' => 11],
            'pojokAsi_file'              => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],

            'pusatKespro'                => ['type' => 'INT', 'constraint' => 11],
            'pusatKespro_file'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],

            'imunisasiAnak'              => ['type' => 'INT', 'constraint' => 11],
            'imunisasiAnak_file'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],

            'layananAnakMiskin'          => ['type' => 'INT', 'constraint' => 11],
            'layananAnakMiskin_file'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],

            'kawasanTanpaRokok'          => ['type' => 'INT', 'constraint' => 11],
            'kawasanTanpaRokok_file'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],

            'created_at'                 => ['type' => 'DATETIME', 'null' => true],
            'updated_at'                 => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('klaster3');
    }

    public function down()
    {
        $this->forge->dropTable('klaster3');
    }
}

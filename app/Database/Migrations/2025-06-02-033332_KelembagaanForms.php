<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KelembagaanForms extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                        => ['type' => 'INT', 'auto_increment' => true],
            'user_id'                   => ['type' => 'INT', 'constraint' => 11],
            'tahun'                     => ['type' => 'INT', 'default' => date('Y')],
            'peraturan_value'          => ['type' => 'INT', 'default' => 0],
            'peraturan_file'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'anggaran_value'           => ['type' => 'INT', 'default' => 0],
            'anggaran_file'            => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'forum_anak_value'         => ['type' => 'INT', 'default' => 0],
            'forum_anak_file'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'data_terpilah_value'      => ['type' => 'INT', 'default' => 0],
            'data_terpilah_file'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'dunia_usaha_value'        => ['type' => 'INT', 'default' => 0],
            'dunia_usaha_file'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'total_nilai'              => ['type' => 'INT', 'default' => 0],
            'status'                   => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected'], 'default' => 'pending'],
            'created_at'               => ['type' => 'DATETIME', 'null' => true],
            'updated_at'               => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('kelembagaan_forms');
    }

    public function down()
    {
        $this->forge->dropTable('kelembagaan_forms');
    }
}

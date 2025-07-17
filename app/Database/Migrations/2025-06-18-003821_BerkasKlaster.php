<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BerkasKlaster extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'auto_increment' => true],
            'user_id'     => ['type' => 'INT', 'unsigned' => true], // refer to users
            'klaster'     => ['type' => 'INT', 'unsigned' => true], // refer to klaster table if available
            // 'nama_berkas' => ['type' => 'VARCHAR', 'constraint' => 255],
            // 'file_path'   => ['type' => 'VARCHAR', 'constraint' => 255],

            'tahun'       => ['type' => 'YEAR'],
            'bulan'       => ['type' => 'VARCHAR', 'constraint' => 20], // ex: 'Januari', 'Februari'

            'total_nilai' => ['type' => 'INT', 'null' => true], // optional score

            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected'],
                'default'    => 'pending'
            ],
            'catatan' => ['type' => 'TEXT', 'null' => true],

            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('berkas_klaster');
    }

    public function down()
    {
        $this->forge->dropTable('berkas_klaster');
    }
}
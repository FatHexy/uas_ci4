<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAnggotaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_Anggota' => [
                'type' => 'VARCHAR',
                'constraint' => 6,
            ],
            'Nama' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'Alamat' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'No_Telepon' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => false,
            ],
            'Email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('ID_Anggota', true);
        $this->forge->addUniqueKey(['Email', 'No_Telepon']);
        $this->forge->createTable('anggota');
    }

    public function down()
    {
        $this->forge->dropTable('anggota');
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBukuTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'Kode_Buku' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'katalog_ISBN' => [
                'type' => 'VARCHAR',
                'constraint' => 13,
                'null' => false
            ],
            'Tersedia' => [
                'type' => 'TINYINT',
                'unsigned' => true,
                'null' => true
            ]
        ]);

        $this->forge->addKey('Kode_Buku', true);
        $this->forge->addKey('katalog_ISBN');
        $this->forge->addForeignKey('katalog_ISBN', 'katalog', 'ISBN', 'CASCADE', 'CASCADE');
        $this->forge->createTable('buku');
    }

    public function down()
    {
        $this->forge->dropTable('buku');
    }
}

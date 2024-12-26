<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateKatalogTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ISBN' => [
                'type' => 'VARCHAR',
                'constraint' => 13,
            ],
            'Judul' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'Penulis' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'Penerbit' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'Tahun_Terbit' => [
                'type' => 'VARCHAR',
                'constraint' => 4,
                'null' => true,
            ],
            'Jumlah_Eksemplar' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'Jumlah_Tersedia' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
        ]);
        $this->forge->addKey('Kode_Buku', true);
        $this->forge->createTable('Katalog');
    }

    public function down()
    {
        $this->forge->dropTable('Katalog');
    }
}

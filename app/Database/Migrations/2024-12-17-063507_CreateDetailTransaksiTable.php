<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDetailTransaksiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'transaksi_ID_Transaksi' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
            ],
            'buku_Kode_Buku' => [
                'type' => 'INT',
                'unsigned' => true
            ],
        ]);
        $this->forge->addForeignKey('transaksi_ID_Transaksi', 'transaksi', 'ID_Transaksi', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('buku_Kode_Buku', 'buku', 'Kode_Buku', 'CASCADE', 'CASCADE');
        $this->forge->createTable('detail_transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('detail_transaksi');
    }
}

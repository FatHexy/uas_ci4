<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTransaksiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_Transaksi' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
            ],
            'anggota_ID_Anggota' => [
                'type' => 'VARCHAR',
                'constraint' => 6,
                'null' => false,
            ],
            'Tanggal_Pinjam' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'Tanggal_Kembali_Rencana' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'Tanggal_Kembali_Realisasi' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'Denda' => [
                'type' => 'BIGINT',
                'null' => true,
            ],
            'Status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'done'],
                'null' => true,
            ],
        ]);
        $this->forge->addKey('ID_Transaksi', true);
        $this->forge->addForeignKey('anggota_ID_Anggota', 'anggota', 'ID_Anggota', 'CASCADE', 'CASCADE');
        $this->forge->createTable('transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('transaksi');
    }
}

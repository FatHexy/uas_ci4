<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLogTransaksiTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'ID_Log' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'admin_ID_Admin' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
            ],
            'transaksi_ID_Transaksi' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
            ],
            'Deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'Waktu' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('ID_Log', true);
        $this->forge->addForeignKey('admin_ID_Admin', 'admin', 'ID_Admin', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('transaksi_ID_Transaksi', 'transaksi', 'ID_Transaksi', 'CASCADE', 'CASCADE');
        $this->forge->createTable('log_transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('log_transaksi');
    }
}

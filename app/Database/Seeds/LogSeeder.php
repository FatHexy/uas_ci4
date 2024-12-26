<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LogSeeder extends Seeder
{
    public function run()
    {
        $query = $this->db->query('SELECT Tanggal_Pinjam FROM transaksi LIMIT 1')->getRow();

        $data = [
            [
                'ID_Log' => 1,
                'admin_ID_Admin' => 'X10450b17c',
                'transaksi_ID_Transaksi' => 'TA3379667612166',
                'Deskripsi' => 'Peminjaman buku oleh anggota A33796',
                'Waktu' => $query->Tanggal_Pinjam,
            ],
        ];

        $this->db->table('log_transaksi')->insertBatch($data);
    }
}

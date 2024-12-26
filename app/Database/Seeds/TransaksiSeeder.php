<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    public function run()
    {
        $queryAnggota = $this->db->query('SELECT ID_Anggota FROM anggota LIMIT 1')->getRow();

        $data = [
            [
                'ID_Transaksi' => 'T' . $queryAnggota->ID_Anggota . substr(uniqid(), 0, 8),
                'anggota_ID_Anggota' => $queryAnggota->ID_Anggota,
                'Tanggal_Pinjam' => date('Y-m-d H:i:s'),
                'Tanggal_Kembali_Rencana' => date('Y-m-d', strtotime('+7 days')),
                'Tanggal_Kembali_Realisasi' => null,
                'Denda' => 0,
                'Status' => 'active',
            ],
        ];

        $this->db->table('transaksi')->insertBatch($data);
    }
}

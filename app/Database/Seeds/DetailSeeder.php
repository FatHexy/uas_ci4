<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DetailSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'ID_Transaksi' => 'TA3379667612166',
                'Kode_Buku' => '9780987654321'
            ],
            [
                'ID_Transaksi' => 'TA3379667612166',
                'Kode_Buku' => '9781234567890'
            ]
        ];

        $this->db->table('detail_transaksi')->insertBatch($data);
    }
}

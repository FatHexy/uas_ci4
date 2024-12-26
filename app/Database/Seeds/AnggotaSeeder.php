<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnggotaSeeder extends Seeder
{
    public function run()
    {
        $query = $this->db->query('SELECT CONCAT("A", RIGHT(UUID_SHORT(), 5)) AS ID_Anggota')->getRow();

        $data = [
            [
                'ID_Anggota' => $query->ID_Anggota,
                'Nama' => 'Budi Santoso',
                'Alamat' => 'Jl. Mawar No.10',
                'No_Telepon' => '081234567890',
                'Email' => 'budi@example.com',
            ]
        ];

        $this->db->table('anggota')->insertBatch($data);
    }
}

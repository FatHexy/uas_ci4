<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KatalogSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'Kode_Buku' => '9781234567890', // ISBN 13 digit
                'Judul' => 'Belajar CodeIgniter 4',
                'Penulis' => 'John Doe',
                'Penerbit' => 'Tech Publisher',
                'Tahun_Terbit' => '2023',
                'Jumlah_Eksemplar' => 10,
                'Jumlah_Tersedia' => 8,
            ],
            [
                'Kode_Buku' => '9780987654321', // ISBN 13 digit
                'Judul' => 'Mastering PHP',
                'Penulis' => 'Jane Smith',
                'Penerbit' => 'WebDev Publisher',
                'Tahun_Terbit' => '2022',
                'Jumlah_Eksemplar' => 5,
                'Jumlah_Tersedia' => 5,
            ],
        ];

        $this->db->table('katalog')->insertBatch($data);
    }
}

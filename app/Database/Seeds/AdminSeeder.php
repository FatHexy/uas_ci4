<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $query = $this->db->query('SELECT CONCAT("X", SUBSTRING(SHA(UUID()), 1, 9)) AS ID_Admin')->getRow();

        $data = [
            [
                'ID_Admin' => $query->ID_Admin,
                'Username' => 'fatkhul',
                'Password' => password_hash('1234', PASSWORD_DEFAULT),
                'Nama' => 'Fatkhul Abdillah',
                'Email' => 'fatkhul@example.com',
            ]
        ];

        $this->db->table('admin')->insertBatch($data);
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table            = 'buku';
    protected $primaryKey       = 'Kode_Buku';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'Kode_Buku',
        'katalog_ISBN',
        'Tersedia'
    ];
}

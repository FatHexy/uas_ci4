<?php

namespace App\Models;

use CodeIgniter\Model;

class KatalogModel extends Model
{
    protected $table            = 'katalog';
    protected $primaryKey       = 'ISBN';
    protected $useAutoIncrement = false;
    protected $allowedFields    = [
        'ISBN',
        'Judul',
        'Penulis',
        'Penerbit',
        'Tahun_Terbit',
        'Jumlah_Eksemplar',
        'Jumlah_Tersedia'
    ];
}

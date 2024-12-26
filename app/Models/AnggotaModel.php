<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table            = 'anggota';
    protected $primaryKey       = 'ID_Anggota';
    protected $useAutoIncrement = false;
    protected $allowedFields    = [
        'ID_Anggota',
        'Nama',
        'Alamat',
        'No_Telepon',
        'Email'
    ];
}

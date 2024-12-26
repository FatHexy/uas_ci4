<?php

namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table            = 'log_transaksi';
    protected $primaryKey       = 'ID_Log';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'admin_ID_Admin',
        'transaksi_ID_Transaksi',
        'Deskripsi',
        'Waktu'
    ];
}

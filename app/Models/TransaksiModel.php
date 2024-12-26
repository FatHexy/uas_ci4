<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table            = 'transaksi';
    protected $primaryKey       = 'ID_Transaksi';
    protected $useAutoIncrement = false;
    protected $allowedFields    = [
        'ID_Transaksi',
        'anggota_ID_Anggota',
        'Tanggal_Pinjam',
        'Tanggal_Kembali_Rencana',
        'Tanggal_Kembali_Realisasi',
        'Sisa_Hari',
        'Denda',
        'Status'
    ];
}

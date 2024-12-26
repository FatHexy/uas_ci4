<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailTransaksiModel extends Model
{
    protected $table            = 'detail_transaksi';
    protected $primaryKey       = 'ID_Detail_Transaksi';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'transaksi_ID_Transaksi',
        'buku_Kode_Buku',
        'Batas_Pengembalian',
        'Tanggal_Kembali',
        'Sisa_Hari',
        'status',
    ];
}

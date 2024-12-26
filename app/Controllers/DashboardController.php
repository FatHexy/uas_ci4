<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\TransaksiModel;
use App\Models\AnggotaModel;
use App\Models\KatalogModel;
use CodeIgniter\I18n\Time;

class DashboardController extends Controller
{
    protected $transaksi;
    protected $anggota;
    protected $katalog;
    protected $db;
    protected $currentTime;
    function __construct()
    {
        $this->transaksi = new TransaksiModel();
        $this->anggota = new AnggotaModel();
        $this->katalog = new KatalogModel();
        $this->db = \Config\Database::connect();
        $this->currentTime = Time::now('Asia/Jakarta');
    }
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['jumlah_buku'] = $this->katalog->countAllResults();
        $data['jumlah_anggota'] = $this->anggota->countAllResults();
        $data['jumlah_transaksi'] = $this->transaksi->countAllResults();
        $data['transaksi'] = $this->transaksi->where('status', 'active')->findAll();

        $tanggalSekarang = $this->currentTime->format('Y-m-d');

        $this->db->transStart();

        $this->db->query("UPDATE transaksi SET Sisa_Hari = DATEDIFF(Tanggal_Kembali_Rencana, '$tanggalSekarang')");
        $this->db->query("
            UPDATE detail_transaksi dt 
            JOIN transaksi t 
            ON dt.transaksi_ID_Transaksi = t.ID_Transaksi 
            SET dt.Sisa_Hari = t.Sisa_Hari
            WHERE dt.Sisa_Hari IS NOT NULL;
        ");
        $this->db->query("UPDATE transaksi SET Denda = Sisa_Hari * 10000 WHERE Sisa_Hari < 0");

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            // Handle transaction failure
            throw new \RuntimeException('Transaction failed');
        }

        return view('dashboard/index', $data);
    }
}

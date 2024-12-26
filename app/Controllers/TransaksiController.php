<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\AnggotaModel;
use App\Models\DetailTransaksiModel;
use App\Models\BukuModel;
use App\Models\LogModel;
use App\Models\KatalogModel;
use CodeIgniter\Controller;
use CodeIgniter\Session\Session;
use CodeIgniter\I18n\Time;

class TransaksiController extends BaseController
{
    protected $transaksiModel;
    protected $katalogModel;
    protected $anggotaModel;
    protected $detailModel;
    protected $bukuModel;
    protected $logModel;
    protected $session;
    protected $db;
    protected $currentTime;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->katalogModel = new KatalogModel();
        $this->anggotaModel = new AnggotaModel();
        $this->detailModel = new DetailTransaksiModel();
        $this->bukuModel = new BukuModel();
        $this->logModel = new LogModel();
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
        $this->currentTime = Time::now('Asia/Jakarta');
    }

    public function index()
    {
        $data['transaksi'] = $this->transaksiModel->findAll();
        return view('transaksi/index', $data);
    }

    // ! bi function method

    public function checkAnggota()
    {
        $jenisPeminjaman = $this->request->getPost('jenis_transaksi');
        $anggotaId = $this->request->getPost('anggota_id');
        $anggota = $this->anggotaModel->find($anggotaId);

        if ($jenisPeminjaman == 'peminjaman') {
            if ($anggota) {
                $this->session->set('anggota', $anggota);
                $this->session->set('currentStepPeminjaman', 2);
                return redirect()->to('/transaksi/entry-peminjaman')->with('success', 'Anggota ditemukan');
            }
        } else if ($jenisPeminjaman == 'pengembalian') {
            if ($anggota) {
                $this->session->set('anggota', $anggota);
                $this->session->set('currentStepPengembalian', 2);
                return redirect()->to('/transaksi/entry-pengembalian')->with('success', 'Anggota ditemukan');
            }
        }

        return redirect()->to('/transaksi/entry-peminjaman')->with('anggota404', 'Anggota tidak ditemukan.');
    }


    public function batalkanTransaksi($action)
    {
        if ($action == 1) {
            $this->session->remove('anggota');
            $this->session->remove('currentStepPengembalian');
            return redirect()->to('/transaksi/entry-pengembalian')->with('success', 'Pengembalian Di batalkan');
        }
        if ($action == 2) {
            $this->session->remove('anggota');
            $this->session->remove('currentStepPeminjaman');
            return redirect()->to('/transaksi/entry-peminjaman')->with('success', 'Peminjaman Di batalkan');
        }
    }


    public function peminjaman()
    {
        $data['title'] = 'Peminjaman';
        $data['tableData'] = $this->db->table('anggota a')
            ->select('a.ID_Anggota, a.Nama, t.ID_Transaksi')
            ->join('transaksi t', 't.anggota_ID_Anggota = a.ID_Anggota')
            ->where('t.Status', 'active')
            ->get()
            ->getResultArray();
        return view('transaksi/peminjaman', $data);
    }


    // ! entry peminjaman page
    public function entryPeminjaman()
    {
        if (!isset($this->session->currentStepPeminjaman)) {
            $this->session->set('currentStepPeminjaman', 1);
        }

        $data['title'] = 'Entry Peminjaman';
        $buku_tidak_tersedia = $this->bukuModel->select('Kode_Buku')->where('Tersedia', 0)->findAll();
        $data['buku_tidak_tersedia'] = array_column($buku_tidak_tersedia, 'Kode_Buku');
        $buku_tersedia = $this->db->table('katalog k')
            ->select('b.Kode_Buku, k.Judul, k.ISBN')
            ->join('buku b', 'k.ISBN = b.katalog_ISBN')
            ->where('b.Tersedia', 1)
            ->get()
            ->getResultArray();
        $data['buku_tersedia'] = $buku_tersedia;
        return view('transaksi/entry-peminjaman', $data);
    }

    public function finalizePeminjaman($id)
    {
        $arrayBuku = $this->request->getPost('data_array');


        $tanggalTransaksi = $this->currentTime->format('Y-m-d H:i:s');

        $idAnggota = $id;

        $idTransaksi = 'T' . $idAnggota . substr(uniqid(), 0, 8);
        $transaksiData = [
            'ID_Transaksi' => $idTransaksi,
            'anggota_ID_Anggota' => $idAnggota,
            'Tanggal_Pinjam' => $tanggalTransaksi,
            'Tanggal_Kembali_Rencana' => $this->currentTime->addDays(14)->format('Y-m-d'),
            'Status' => 'active'
        ];
        $this->transaksiModel->insert($transaksiData);

        $idAdmin = $this->session->get("ID_Admin");
        $logData = [
            'admin_ID_Admin' => $idAdmin,
            'transaksi_ID_Transaksi' => $idTransaksi,
            'Deskripsi' => 'Peminjaman Buku Oleh ' . $idAnggota,
            'Waktu' => $this->currentTime->format('Y-m-d H:i:s'),
        ];
        $this->logModel->insert($logData);

        $arrayBuku = json_decode($arrayBuku, true);
        foreach ($arrayBuku as $item) {
            $kodeBuku = (int)$item[0];

            $detailData = [
                'transaksi_ID_Transaksi' => $idTransaksi,
                'buku_Kode_Buku' => $kodeBuku,
                'Batas_Pengembalian' =>  $this->currentTime->addDays(14)->format('Y-m-d'),
            ];
            $this->detailModel->insert($detailData);
            $this->bukuModel->update($kodeBuku, ['Tersedia' => 0]);
            $buku = $this->bukuModel->find($kodeBuku);
            if ($buku) {
                $katalogISBN = $buku['katalog_ISBN'];
                $this->katalogModel->where('ISBN', $katalogISBN)
                    ->set('Jumlah_Tersedia', 'Jumlah_Tersedia - 1', false)
                    ->update();
            }
        }

        $this->session->remove('anggota');
        $this->session->remove('currentStepPeminjaman');
        return redirect()->to('/transaksi/invoice/' . $idTransaksi)->with('success', 'Peminjaman berhasil diselesaikan.');
    }


    public function pengembalian()
    {
        $data['title'] = 'Pengembalian';
        $data['tableData'] = $this->db->table('anggota a')
            ->select('a.ID_Anggota, a.Nama, t.ID_Transaksi')
            ->join('transaksi t', 't.anggota_ID_Anggota = a.ID_Anggota')
            ->where('t.Status', 'done')
            ->get()
            ->getResultArray();
        return view('transaksi/pengembalian', $data);
    }

    // ! entry pengembalian page
    public function entryPengembalian()
    {
        if (!isset($this->session->currentStepPengembalian)) {
            $this->session->set('currentStepPengembalian', 1);
        }

        $data['title'] = 'Entry Pengembalian';

        if (isset($this->session->anggota)) {
            $anggota = $this->session->get('anggota');
            $buku_dipinjam = $this->db->table('katalog k')
                ->select('b.Kode_Buku, k.Judul, k.ISBN, t.Tanggal_Kembali_Rencana, t.Denda')
                ->join('buku b', 'b.katalog_ISBN = k.ISBN')
                ->join('detail_transaksi dt', 'dt.buku_Kode_Buku = b.Kode_Buku')
                ->join('transaksi t', 'dt.transaksi_ID_Transaksi = t.ID_Transaksi')
                ->where('t.anggota_ID_Anggota', $anggota['ID_Anggota'])
                ->where('dt.status !=', 'dikembalikan')
                ->get()
                ->getResultArray();

            $data['buku_dipinjam'] = $buku_dipinjam;
        } else {
            $data['buku_dipinjam'] = [];
        }
        return view('transaksi/entry-pengembalian', $data);
    }

    public function handlePengembalian()
    {
        $buku_dikembalikan = json_decode($this->request->getPost('buku_dikembalikan'), true);
        $buku_diperpanjang = json_decode($this->request->getPost('buku_diperpanjang'), true);

        if (!empty($buku_dikembalikan)) {
            foreach ($buku_dikembalikan as $kodeBuku) {
                $this->detailModel->where('buku_Kode_Buku', $kodeBuku)->set([
                    'status' => 'dikembalikan',
                    'Tanggal_Kembali' => $this->currentTime->format('Y-m-d H:i:s'),
                    'Sisa_Hari' => NULL,
                ])->update();
            }

            $transaksiIds = $this->detailModel->whereIn('buku_Kode_Buku', $buku_dikembalikan)->select('transaksi_ID_Transaksi')->distinct()->findAll();
            foreach ($transaksiIds as $transaksi) {
                $idTransaksi = $transaksi['transaksi_ID_Transaksi'];

                $allReturned = $this->detailModel->where('transaksi_ID_Transaksi', $idTransaksi)->where('status !=', 'dikembalikan')->countAllResults() === 0;

                if ($allReturned) {
                    $latestReturnDate = $this->detailModel->where('transaksi_ID_Transaksi', $idTransaksi)->selectMax('Tanggal_Kembali')->get()->getRow()->Tanggal_Kembali;

                    $this->transaksiModel->update($idTransaksi, [
                        'Tanggal_Kembali_Realisasi' => $latestReturnDate,
                        'Sisa_Hari' => null,
                        'Denda' => null,
                        'Status' => 'done',
                    ]);
                }
            }
        }

        if (!empty($buku_diperpanjang)) {
            foreach ($buku_diperpanjang as $kodeBuku) {
                $currentBatas = $this->detailModel->where('buku_Kode_Buku', $kodeBuku)->select('Batas_Pengembalian')->get()->getRow()->Batas_Pengembalian;
                $currentSisa_Hari = $this->detailModel->where('buku_Kode_Buku', $kodeBuku)->select('Sisa_Hari')->get()->getRow()->Sisa_Hari;

                $newBatas = date('Y-m-d', strtotime($currentBatas . ' +14 days'));

                $this->detailModel->where('buku_Kode_Buku', $kodeBuku)->set([
                    'Batas_Pengembalian' => $newBatas,
                    'Sisa_Hari' => $currentSisa_Hari + 14,
                ])->update();

                $transaksiId = $this->detailModel->where('buku_Kode_Buku', $kodeBuku)->select('transaksi_ID_Transaksi')->get()->getRow()->transaksi_ID_Transaksi;
                $this->transaksiModel->update($transaksiId, [
                    'Tanggal_Kembali_Rencana' => $newBatas,
                ]);
            }
        }

        return redirect()->to('/transaksi/entry-pengembalian')->with('success', 'Transaksi Berhasil Di Update');
    }

    public function invoice($id)
    {
        $transaksi = $this->transaksiModel->find($id);
        if (!$transaksi) {
            return redirect()->to('/transaksi/peminjaman')->with('error', 'Transaksi tidak ditemukan.');
        }

        $query = $this->db->query(
            'SELECT b.Kode_Buku, k.Judul, k.ISBN 
             FROM katalog k 
             JOIN buku b ON b.katalog_ISBN = k.ISBN 
             JOIN detail_transaksi dt ON dt.buku_Kode_Buku = b.Kode_Buku 
             WHERE dt.transaksi_ID_Transaksi = ?',
            [$id]
        );

        $data['title'] = 'Invoice';
        $data['transaksi'] = $transaksi;
        $data['dataTransaksi'] = $query->getResultArray();


        return view('transaksi/invoice', $data);
    }
}

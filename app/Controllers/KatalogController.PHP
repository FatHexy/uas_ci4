<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KatalogModel;

class KatalogController extends BaseController
{
    protected $katalog;

    public function __construct()
    {
        $this->katalog = new KatalogModel();
    }

    public function index()
    {
        $data['katalog'] = $this->katalog->findAll();
        $data['title'] = 'Katalog';
        return view('katalog/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Buku';
        return view('katalog/create', $data);
    }

    public function store()
    {
        $minTahun = 869;
        $maxTahun = intval(date("Y"));
        $tahunTerbitText = "Tahun Terbit harus berada di antara rentang tahun {$minTahun} sampai {$maxTahun}";
        if (!$this->validate([
            'ISBN' => [
                'rules' => 'required|exact_length[13]|is_unique[katalog.ISBN]',
                'errors' => [
                    'required' => 'Kode Buku Harus diisi',
                    'exact_length' => 'Kode Buku harus terdiri dari 13 karakter.',
                    'is_unique' => 'Kode Buku sudah ada dalam database.'
                ]
            ],
            'Judul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'Penulis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'Penerbit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'Tahun_Terbit' => [
                'rules' => "required|numeric|greater_than_equal_to[{$minTahun}]|less_than_equal_to[{$maxTahun}]",
                'errors' => [
                    'required' => 'Tahun Terbit Harus diisi',
                    'numeric' => 'Tahun Terbit Harus berupa angka',
                    'greater_than_equal_to' => "{$tahunTerbitText}",
                    'less_than_equal_to' => "{$tahunTerbitText}"
                ]
            ],
            'Jumlah_Eksemplar' => [
                'rules' => "required|numeric",
                'errors' => [
                    'required' => 'Jumlah Eksemplar Harus diisi',
                    'numeric' => 'Jumlah Eksemplar Harus nomor',
                ]
            ]
        ])) {
            $errors = $this->validator->getErrors();
            session()->setFlashdata('validation_errors', $errors);
            return redirect()->back()->withInput();
        }

        $this->katalog->insert([
            'ISBN' => $this->request->getPost('ISBN'),
            'Judul' => $this->request->getPost('Judul'),
            'Penulis' => $this->request->getPost('Penulis'),
            'Penerbit' => $this->request->getPost('Penerbit'),
            'Tahun_Terbit' => $this->request->getPost('Tahun_Terbit'),
            'Jumlah_Eksemplar' => $this->request->getPost('Jumlah_Eksemplar'),
            'Jumlah_Tersedia' => $this->request->getPost('Jumlah_Eksemplar'),
        ]);

        return redirect()->to('/katalog')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data['katalog'] = $this->katalog->find($id);
        $data['title'] = 'Edit Buku';
        if (!$data['katalog']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }
        return view('katalog/edit', $data);
    }

    public function update($id)
    {
        $katalogData = $this->katalog->find($id);
        $minEksemplar = $katalogData['Jumlah_Eksemplar'];
        $minTahun = 869;
        $maxTahun = intval(date("Y"));
        $tahunTerbitText = "Tahun Terbit harus berada di antara rentang tahun {$minTahun} sampai {$maxTahun}";
        if (!$this->validate([
            'Judul' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'Penulis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'Penerbit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} Harus diisi'
                ]
            ],
            'Tahun_Terbit' => [
                'rules' => "required|numeric|greater_than_equal_to[{$minTahun}]|less_than_equal_to[{$maxTahun}]",
                'errors' => [
                    'required' => 'Tahun Terbit Harus diisi',
                    'numeric' => 'Tahun Terbit Harus berupa angka',
                    'greater_than_equal_to' => "{$tahunTerbitText}",
                    'less_than_equal_to' => "{$tahunTerbitText}"
                ]
            ],
            'Jumlah_Eksemplar' => [
                'rules' => "required|numeric|greater_than_equal_to[{$minEksemplar}]",
                'errors' => [
                    'required' => 'Jumlah Eksemplar Harus diisi',
                    'numeric' => 'Jumlah Eksemplar Harus nomor',
                    'greater_than_equal_to' => "Jumlah Eksemplar tidak boleh kurang dari {$minEksemplar}"
                ]
            ]
        ])) {
            $errors = $this->validator->getErrors();
            session()->setFlashdata('validation_errors', $errors);
            return redirect()->back()->withInput();
        }

        $this->katalog->update($id, [
            'ISBN' => $id,
            'Judul' => $this->request->getPost('Judul'),
            'Penulis' => $this->request->getPost('Penulis'),
            'Penerbit' => $this->request->getPost('Penerbit'),
            'Tahun_Terbit' => $this->request->getPost('Tahun_Terbit'),
            'Jumlah_Eksemplar' => $this->request->getPost('Jumlah_Eksemplar'),
        ]);

        return redirect()->to('/katalog')->with('success', 'Buku berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->katalog->delete($id);
        session()->setFlashdata('success', 'Katalog berhasil dihapus!');
        return redirect()->to('/katalog')->with('success', 'Buku berhasil dihapus!');
    }
}

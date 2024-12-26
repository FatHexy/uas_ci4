<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AnggotaModel;

class AnggotaController extends BaseController
{
    protected $anggota;
    protected $db;

    public function __construct()
    {
        $this->anggota = new AnggotaModel();
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data['anggota'] = $this->anggota->findAll();
        $data['title'] = 'Anggota';
        return view('anggota/index', $data);
    }

    public function create()
    {
        $data['title'] = 'Tambah Anggota';
        return view('anggota/create', $data);
    }

    public function store()
    {
        if (!$this->validate([
            'Nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi.'
                ]
            ],
            'Alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat harus diisi.'
                ]
            ],
            'No_Telepon' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Nomor telepon harus diisi.',
                    'numeric' => 'Nomor telepon harus berupa angka.'
                ]
            ],
            'Email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email harus diisi.',
                    'valid_email' => 'Email harus valid.'
                ]
            ],
        ])) {
            $errors = $this->validator->getErrors();
            session()->setFlashdata('validation_errors', $errors);
            return redirect()->back()->withInput();
        }

        $query = $this->db->query('SELECT CONCAT("A", RIGHT(UUID_SHORT(), 5)) AS ID_Anggota')->getRow();

        $this->anggota->insert([
            'ID_Anggota' => $query->ID_Anggota,
            'Nama' => ucwords($this->request->getPost('Nama')),
            'Alamat' => $this->request->getPost('Alamat'),
            'No_Telepon' => $this->request->getPost('No_Telepon'),
            'Email' => $this->request->getPost('Email'),
        ]);

        return redirect()->to('/anggota')->with('success', 'Anggota berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $data['anggota'] = $this->anggota->find($id);
        $data['title'] = 'Edit Anggota';
        if (!$data['anggota']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Data tidak ditemukan');
        }
        return view('anggota/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'Nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama harus diisi.'
                ]
            ],
            'Alamat' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat harus diisi.'
                ]
            ],
            'No_Telepon' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Nomor telepon harus diisi.',
                    'numeric' => 'Nomor telepon harus berupa angka.'
                ]
            ],
            'Email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email harus diisi.',
                    'valid_email' => 'Email harus valid.'
                ]
            ],
        ])) {
            $errors = $this->validator->getErrors();
            session()->setFlashdata('validation_errors', $errors);
            return redirect()->back()->withInput();
        }

        $this->anggota->update($id, [
            'ID_Anggota' => $id,
            'Nama' => ucwords($this->request->getPost('Nama')),
            'Alamat' => $this->request->getPost('Alamat'),
            'No_Telepon' => $this->request->getPost('No_Telepon'),
            'Email' => $this->request->getPost('Email'),
        ]);

        return redirect()->to('/anggota')->with('success', 'Anggota berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->anggota->delete($id);
        session()->setFlashdata('success', 'anggota berhasil dihapus!');
        return redirect()->to('/anggota')->with('success', 'Anggota berhasil dihapus!');
    }
}

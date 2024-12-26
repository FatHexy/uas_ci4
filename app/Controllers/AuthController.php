<?php

namespace App\Controllers;

use App\Models\AdminModel;
use CodeIgniter\Controller;

class AuthController extends Controller
{
    protected $adminModel;

    public function __construct()
    {
        $this->adminModel = new AdminModel();
        helper(['form', 'url', 'session']);
    }

    public function login()
    {
        return view('auth/login');
    }

    public function processLogin()
    {

        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/login')->with('error', 'Username atau Password tidak boleh kosong.');
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $admin = $this->adminModel->where('Username', $username)->first();

        if ($admin) {
            if (password_verify($password, $admin['Password'])) {
                $sessionData = [
                    'ID_Admin' => $admin['ID_Admin'],
                    'user' => $admin['Username'],
                    'nama' => $admin['Nama'],
                    'logged_in' => true
                ];
                session()->set($sessionData);

                return redirect()->to('dashboard')->with('success', 'Login Berhasil!');
            } else {
                return redirect()->to('/login')->with('error', 'Password salah.');
            }
        } else {
            return redirect()->to('/login')->with('error', 'Username tidak ditemukan.');
        }
    }

    public function register()
    {
        return view('auth/register');
    }

    public function processRegister()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nama' => 'required',
            'username' => 'required|is_unique[admin.Username]',
            'email' => 'required|valid_email|is_unique[admin.Email]',
            'password' => 'required|min_length[4]',
            'confirm_password' => 'matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/register')->with('errors', $validation->getErrors())->withInput();
        }

        $data = [
            'ID_Admin' => 'X' . substr(sha1(uniqid()), 0, 9), // Generate ID Admin
            'Username' => $this->request->getPost('username'),
            'Password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'Nama' => $this->request->getPost('nama'),
            'Email' => $this->request->getPost('email')
        ];

        $this->adminModel->insert($data);

        return redirect()->to('/login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Logout berhasil.');
    }
}

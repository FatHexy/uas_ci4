<?php

namespace App\Models;

use CodeIgniter\Model;

class AdminModel extends Model
{
    protected $table            = 'admin';
    protected $primaryKey       = 'ID_Admin';
    protected $useAutoIncrement = false;
    protected $allowedFields    = [
        'ID_Admin',
        'Username',
        'Password',
        'Nama',
        'Email'
    ];
}

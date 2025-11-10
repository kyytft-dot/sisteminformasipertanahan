<?php

// ============================================================
// File: app/Models/Penduduk.php
// ============================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;
    
    // Tambahkan baris ini untuk menyesuaikan dengan tabel di database
    protected $table = 'penduduk';

    protected $fillable = [
        'nik',
        'nama',
        'alamat',
        'telepon',
        'latitude',
        'longitude'
    ];
}
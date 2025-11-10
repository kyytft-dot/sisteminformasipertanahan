<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polygon extends Model
{
    use HasFactory;

    
    // Tambahkan baris ini untuk menyesuaikan dengan tabel di database
    protected $table = 'polygon';

    protected $fillable = [
        'nama',
        'luas',
        'keterangan',
        'warna',
        'coordinates'
    ];

    protected $casts = [
        'coordinates' => 'array'
    ];
}
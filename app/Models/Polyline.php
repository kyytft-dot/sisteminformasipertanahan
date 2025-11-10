<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polyline extends Model
{
    use HasFactory;

    
    // Tambahkan baris ini untuk menyesuaikan dengan tabel di database
    protected $table = 'polyline';

    protected $fillable = [
        'nama',
        'jarak',
        'keterangan',
        'warna',
        'coordinates'
    ];

    protected $casts = [
        'coordinates' => 'array'
    ];
}

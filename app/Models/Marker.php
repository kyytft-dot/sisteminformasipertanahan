<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marker extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk menyesuaikan dengan tabel di database
    protected $table = 'marker';

    protected $fillable = [
        'nama',
        'tipe',
        'deskripsi',
        'latitude',
        'longitude',
    ];
}

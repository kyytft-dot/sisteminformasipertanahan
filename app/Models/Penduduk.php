<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    protected $table = 'penduduk';

    protected $fillable = [
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'rt',
        'rw',
        'kelurahan',
        'kecamatan',
        'kota',
        'provinsi',
        'telepon',
        'email',
        'status_perkawinan',
        'pekerjaan',
        'agama',
        'latitude',
        'longitude'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // Accessor untuk mendapatkan umur
    public function getUmurAttribute()
    {
        return $this->tanggal_lahir->age;
    }
}
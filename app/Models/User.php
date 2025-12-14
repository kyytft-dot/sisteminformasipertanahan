<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// ← Tambahan Spatie (hanya 2 baris ini)
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // ← Tambahkan HasRoles di sini (bisa di baris yang sama atau terpisah, bebas)
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'language_preference',     // ← sudah ada dari kamu
        'profile_photo_path',      // ← BARU: untuk simpan path foto
        'is_approved',            // ← (opsional) kalau pakai approval
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_approved'      => 'boolean',           // ← tambahan
        ];
    }

    /**
     * ACCESSOR: URL Foto Profil (ini yang bikin foto langsung muncul di topbar & pengaturan)
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path) {
            return asset('storage/' . $this->profile_photo_path) . '?' . time();
        }

        // Kalau belum ada foto, pakai default
        return asset('sbadmin/img/undraw_profile.svg');
    }

    /**
     * ACCESSOR: Nama role yang sedang dipakai (biar mudah dipanggil di blade)
     * Contoh: {{ auth()->user()->role_name }}
     */
    public function getRoleNameAttribute()
    {
        return $this->getRoleNames()->first() ?? 'user';
    }

    /**
     * ACCESSOR: Apakah user sudah di-approve (kalau pakai fitur approval)
     */
    public function getIsApprovedAttribute()
    {
        return $this->attributes['is_approved'] ?? false;
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_tanah', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tanah')->unique();
            $table->string('nama_jenis');
            $table->string('warna', 10); // warna diset otomatis dari controller
            $table->string('keterangan'); // dari dropdown
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_tanah');
    }
};

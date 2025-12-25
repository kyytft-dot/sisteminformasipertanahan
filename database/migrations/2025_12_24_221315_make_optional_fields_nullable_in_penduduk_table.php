<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('penduduk', function (Blueprint $table) {
            // Koordinat
            $table->decimal('latitude', 10, 8)->nullable()->change();
            $table->decimal('longitude', 11, 8)->nullable()->change();
            
            // Data pribadi opsional
            $table->date('tanggal_lahir')->nullable()->change();
            $table->string('jenis_kelamin', 20)->nullable()->change();
            $table->string('status_perkawinan', 50)->nullable()->change();
            $table->string('pekerjaan', 100)->nullable()->change();
            $table->string('agama', 50)->nullable()->change();
            
            // Data lokasi opsional
            $table->string('kelurahan', 100)->nullable()->change();
            $table->string('kecamatan', 100)->nullable()->change();
            $table->string('kota', 100)->nullable()->change();
            
            // Kontak opsional
            $table->string('telepon', 15)->nullable()->change();
            $table->string('email', 100)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable(false)->change();
            $table->decimal('longitude', 11, 8)->nullable(false)->change();
            $table->date('tanggal_lahir')->nullable(false)->change();
            $table->string('jenis_kelamin', 20)->nullable(false)->change();
            $table->string('status_perkawinan', 50)->nullable(false)->change();
            $table->string('pekerjaan', 100)->nullable(false)->change();
            $table->string('agama', 50)->nullable(false)->change();
            $table->string('kelurahan', 100)->nullable(false)->change();
            $table->string('kecamatan', 100)->nullable(false)->change();
            $table->string('kota', 100)->nullable(false)->change();
            $table->string('telepon', 15)->nullable(false)->change();
            $table->string('email', 100)->nullable(false)->change();
        });
    }
};
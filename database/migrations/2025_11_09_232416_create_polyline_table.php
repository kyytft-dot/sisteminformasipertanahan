<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('polyline', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 100);
            $table->decimal('jarak', 12, 2);
            $table->text('keterangan')->nullable();
            $table->string('warna', 7)->default('#3b82f6');
            $table->json('coordinates');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('polyline');
    }
};

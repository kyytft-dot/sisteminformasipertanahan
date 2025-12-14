<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('polygon', function (Blueprint $table) {
            // add penduduk reference
            $table->unsignedBigInteger('penduduk_id')->nullable()->after('id');
            $table->string('nik', 50)->nullable()->after('penduduk_id');

            // additional fields
            $table->decimal('luas_detail', 12, 2)->nullable()->after('luas');
            $table->string('keperluan', 100)->nullable()->after('luas_detail');

            // file storage
            $table->string('file_path')->nullable()->after('warna');

            // optional foreign key (if penduduk table exists)
            try {
                $table->foreign('penduduk_id')->references('id')->on('penduduk')->onDelete('set null');
            } catch (\Exception $e) {
                // ignore if table doesn't exist yet in some environments
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('polygon', function (Blueprint $table) {
            if (Schema::hasColumn('polygon', 'penduduk_id')) {
                try { $table->dropForeign(['penduduk_id']); } catch (\Exception $e) { }
                $table->dropColumn('penduduk_id');
            }
            if (Schema::hasColumn('polygon', 'nik')) $table->dropColumn('nik');
            if (Schema::hasColumn('polygon', 'luas_detail')) $table->dropColumn('luas_detail');
            if (Schema::hasColumn('polygon', 'keperluan')) $table->dropColumn('keperluan');
            if (Schema::hasColumn('polygon', 'file_path')) $table->dropColumn('file_path');
        });
    }
};

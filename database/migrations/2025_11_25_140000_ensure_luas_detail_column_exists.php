<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('detail_pertanahan') &&
            !Schema::hasColumn('detail_pertanahan', 'luas_detail')) {

            Schema::table('detail_pertanahan', function (Blueprint $table) {
                $table->decimal('luas_detail', 10, 2)->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('detail_pertanahan') &&
            Schema::hasColumn('detail_pertanahan', 'luas_detail')) {

            Schema::table('detail_pertanahan', function (Blueprint $table) {
                $table->dropColumn('luas_detail');
            });
        }
    }
};

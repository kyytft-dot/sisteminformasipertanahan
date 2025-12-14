
<?php
// database/migrations/xxxx_xx_xx_000001_add_profile_fields_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_photo_path')->nullable()->after('email');
            $table->string('language_preference')->default('id')->after('profile_photo_path');
            // Jika kamu pakai Spatie Permission, tambahkan ini juga (opsional)
            // $table->boolean('is_approved')->default(false)->after('language_preference');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['profile_photo_path', 'language_preference']);
        });
    }
};
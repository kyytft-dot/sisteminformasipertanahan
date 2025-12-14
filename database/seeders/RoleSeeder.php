<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = ['admin','staff','user'];
        foreach ($roles as $r) {
            if (!Role::where('name', $r)->exists()) Role::create(['name' => $r]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use MoonShine\Models\MoonshineUserRole;

class MoonshineRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MoonshineUserRole::create([
            'name' => 'Manager'
        ]);
    }
}

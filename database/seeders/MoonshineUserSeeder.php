<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use MoonShine\Models\MoonshineUser;
use Illuminate\Support\Facades\Hash;

class MoonshineUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MoonshineUser::create([
            'email' => config('moonshine.user.email'),
            'name' => config('moonshine.user.name'),
            'password' => Hash::make(config('moonshine.user.password')),
        ]);
    }
}

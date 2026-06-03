<?php

namespace Database\Seeders;

use App\Models\Penulis;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Penulis::create([
            'nama_lengkap' => 'Administrator',
            'user_name'    => 'admin',
            'password'     => bcrypt('admin123'),
            'foto'         => 'default.png',
        ]);
    }
}

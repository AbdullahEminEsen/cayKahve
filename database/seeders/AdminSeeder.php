<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => '$2y$10$XJFssAC9a4CgXX5.bfs3Peul0paUpiBJM.MKCKPvO2vGezSzGkJSS', //password
        ])->assignRole('writer', 'admin');
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Çaycı 2. Kat',
            'email' => 'cayci@cayci.com',
            'password' => bcrypt('123123123'),
            'office_id' => '2',
            'role_id' => '2',
        ])->assignRole('cayci');
        User::create([
            'name' => 'İnsan Kaynakları 2. Kat',
            'email' => 'ik2@ik.com',
            'password' => bcrypt('123123123'),
            'office_id' => '3',
            'role_id' => '3',
        ])->assignRole('kullanici');
        User::create([
            'name' => 'İnsan Kaynakları 3. Kat',
            'email' => 'ik3@ik.com',
            'password' => bcrypt('123123123'),
            'office_id' => '4',
            'role_id' => '3',
        ])->assignRole('kullanici');
    }
}

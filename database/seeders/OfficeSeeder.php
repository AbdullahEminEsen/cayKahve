<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Office::create([
            'name' => 'Z3',
            'kat' => '1',
        ]);
        Office::create([
            'name' => 'Çay Ocağı 2',
            'kat' => '2',
        ]);
        Office::create([
            'name' => 'İnsan Kaynakları 2',
            'kat' => '2',
        ]);
        Office::create([
            'name' => 'İnsan Kaynakları 3',
            'kat' => '3',
        ]);
    }
}

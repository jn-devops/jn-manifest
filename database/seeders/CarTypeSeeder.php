<?php

namespace Database\Seeders;

use App\Models\CarType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CarType::updateOrCreate(['name' => 'Sedan'], ['description' => 'Sedan']);
        CarType::updateOrCreate(['name' => 'SUV'], ['description' => 'SUV','capacity' => 7]);
        CarType::updateOrCreate(['name' => 'Van'], ['description' => 'Van','capacity' => 9]);
    }
}

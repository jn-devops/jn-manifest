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
        $data = [
            ['name' => 'SUV', 'description' => 'SUV', 'capacity' => '7'],
            ['name' => 'Van', 'description' => 'Van', 'capacity' => '14'],
        ];
        foreach($data as $item){
            CarType::updateOrCreate(['name' => $item['name']], ['description' => $item['description'], 'capacity' => $item['capacity']]);
        }
    }
}

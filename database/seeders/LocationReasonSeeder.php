<?php

namespace Database\Seeders;

use App\Models\CarType;
use App\Models\LocationReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocationReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['code' => 'pick_up', 'description' => 'SUV'],
            ['code' => 'drop_off', 'description' => 'Van'],
            ['code' => 'site_visit', 'description' => 'Site Visit'],
            ['code' => 'others', 'description' => 'Others'],
        ];
        foreach($data as $item){
            LocationReason::updateOrCreate(['code' => $item['code']], ['description' => $item['description']]);
        }
    }
}

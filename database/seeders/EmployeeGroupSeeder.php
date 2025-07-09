<?php

namespace Database\Seeders;

use App\Models\EmployeeGroup;
use App\Models\LocationReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['code' => 'ddu', 'description' => 'Digital Development Unit'],
            ['code' => 'pdu', 'description' => 'Project Development Unit'],
            ['code' => 'pcu', 'description' => 'People Culture Unit'],
        ];
        foreach($data as $item){
            EmployeeGroup::updateOrCreate(['code' => $item['code']], ['description' => $item['description']]);
        }
    }
}

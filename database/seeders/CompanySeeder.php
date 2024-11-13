<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Raemulan Lands Inc'],
            ['name' => 'Rayvaness Realty Corp'],
            ['name' => 'Enclavewrx Commune Inc'],
            ['name' => 'Enclavewrx Digital Inc'],
            ['name' => 'Fortis Investment Corp'],
            ['name' => 'Quantuvis Resource Corp'],
            ['name' => 'ZKFX'],
            ['name' => 'Joy Nostalg Foundation'],
        ];
        foreach($data as $item){
            Company::updateOrCreate(['name' => $item['name']]);
        }
    }
}

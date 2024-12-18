<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\MarketSegment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MarketSegmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Economic Housing Group', 'code' => 'EHG'],
            ['name' => 'Socialized Housing Group', 'code' => 'SHG'],
            ['name' => 'Middle Housing Group', 'code' => 'MHG'], // Adjusted code for uniqueness
        ];

        foreach ($data as $item) {
            MarketSegment::updateOrCreate(
                ['code' => $item['code']], // Match on 'code'
                ['name' => $item['name']] // Update 'name'
            );
        }

    }
}

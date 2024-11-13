<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [ 'name' => 'PAGSIBOL VILLAGE SOUTH PHASE 2', 'code' => 'PV3-02', 'description' => '' ],
            [ 'name' => 'PAGSIBOL VILLAGE SOUTHWEST', 'code' => 'PV-05', 'description' => '' ],
            [ 'name' => 'PAGSINAG PLACE WEST REDEV', 'code' => 'PPW2', 'description' => '' ],
            [ 'name' => 'PAGSIBOL VILLAGE SOUTHERN NAIC', 'code' => 'PVSN', 'description' => '' ],
            [ 'name' => 'PAGSIKAT PLACE SOUTHERN NAIC', 'code' => 'PPSN', 'description' => '' ],
            [ 'name' => 'PASINAYA HOMES SOUTHERN NAIC', 'code' => 'PHSN', 'description' => '' ],
            [ 'name' => 'PAGSIBOL VILLAGE TERESA 3', 'code' => 'PVT3', 'description' => '' ],
            [ 'name' => 'PAGSIBOL VILLAGE MAGALANG PAMPANGA', 'code' => 'PVMP', 'description' => '' ],
            [ 'name' => 'PAGSIBOL BULACAN 2 PHASE 1', 'code' => 'PB2-01', 'description' => '' ],
            [ 'name' => 'PAGSIBOL BULACAN 1 PHASE 1', 'code' => 'PB1-01', 'description' => '' ],
            [ 'name' => 'PAGSIBOL BULACAN 1 PHASE 2', 'code' => 'PB1-02', 'description' => '' ],
            [ 'name' => 'PAGSIBOL BULACAN 1 PHASE 3', 'code' => 'PB1-03', 'description' => '' ],
            [ 'name' => 'PAGSIBOL VILLAGE 1', 'code' => 'PV1', 'description' => '' ],
            [ 'name' => 'PAGSIBOL VILLAGE 2', 'code' => 'PV2', 'description' => '' ],
            [ 'name' => 'PAGSIBOL VILLAGE 3', 'code' => 'PV3', 'description' => '' ],
            [ 'name' => 'PAGSIBOL VILLAGE 4 PHASE 1', 'code' => 'PV4-01', 'description' => '' ],
            [ 'name' => 'PAGSIBOL VILLAGE 4 PHASE 2', 'code' => 'PV4-02', 'description' => '' ],
            [ 'name' => 'PAGSINAG PLACE BULACAN', 'code' => 'PPB', 'description' => '' ],
            [ 'name' => 'PAGSINAG PLACE BULACAN PHASE 2', 'code' => 'PPB-02', 'description' => '' ],
            [ 'name' => 'PAGSINAG PLACE EAST', 'code' => 'PPE', 'description' => '' ],
            [ 'name' => 'PAGSINAG PLACE NORTHEAST', 'code' => 'PPNE', 'description' => '' ],
            [ 'name' => 'PAGSINAG PLACE NORTHEAST 2', 'code' => 'PPNE2', 'description' => '' ],
            [ 'name' => 'PAGSINAG PLACE SOUTH', 'code' => 'PPS1', 'description' => '' ],
            [ 'name' => 'PAGSINAG PLACE WEST', 'code' => 'PPW', 'description' => '' ],
            // [ 'name' => 'PAGSINAG PLACE WEST 2', 'code' => 'PPW2', 'description' => '' ], // Duplicated Code
            [ 'name' => 'PAGSIKAT PLACE EAST MARIA', 'code' => 'PPEM', 'description' => '' ],
            [ 'name' => 'PAGSIKAT PLACE MAGALANG', 'code' => 'PPMP', 'description' => '' ],
            // [ 'name' => 'PAGSIKAT PLACE SOUTHERN NAIC', 'code' => 'PPSN', 'description' => '' ], // Duplicated Code
            [ 'name' => 'PASINAYA HOMES BULACAN PHASE 4', 'code' => 'PHB-04', 'description' => '' ],
            [ 'name' => 'PASINAYA HOMES HILAGA', 'code' => 'PHH1', 'description' => '' ],
            [ 'name' => 'PASINAYA HOMES PRIME CENTRAL', 'code' => 'PHPC', 'description' => '' ],
            [ 'name' => 'PASINAYA HOMES PRIME SOUTH', 'code' => 'PHPS', 'description' => '' ],
            [ 'name' => 'PASINAYA HOMES SOUTH', 'code' => 'PHS', 'description' => '' ],
            // [ 'name' => 'PASINAYA HOMES SOUTHERN NAIC', 'code' => 'PHSN', 'description' => '' ], // Duplicated Code
            [ 'name' => 'PASINAYA HOMES WEST', 'code' => 'PHW', 'description' => '' ],
            [ 'name' => 'PASINAYA HOMES NORTHEAST', 'code' => 'PNE', 'description' => '' ],
            [ 'name' => 'PASINAYA HOMES NORTHEAST PHASE 3', 'code' => 'PNE-03', 'description' => '' ],
            [ 'name' => 'PASINAYA HOMES PRIME NORTH', 'code' => 'PPN', 'description' => '' ],
            [ 'name' => 'TERRACES - JUBILATION ENCLAVE - A01', 'code' => 'TER-JE-A01', 'description' => '' ],
            [ 'name' => 'TERRACES - JUBILATION ENCLAVE - A02', 'code' => 'TER-JE-A02', 'description' => '' ],
            [ 'name' => 'TERRACES - JUBILATION ENCLAVE - B01', 'code' => 'TER-JE-B01', 'description' => '' ],
            [ 'name' => 'TERRACES - JUBILATION ENCLAVE - C01', 'code' => 'TER-JE-C01', 'description' => '' ],
            [ 'name' => 'TERRACES - JUBILATION ENCLAVE - C02', 'code' => 'TER-JE-C02', 'description' => '' ],
            [ 'name' => 'TERRACES - JUBILATION ENCLAVE - D01', 'code' => 'TER-JE-D01', 'description' => '' ],
            [ 'name' => 'TERRACES - JUBILATION ENCLAVE - PB1', 'code' => 'TER-JE-PB1', 'description' => '' ],
            [ 'name' => 'TERRACES - JUBILATION ENCLAVE - PB2', 'code' => 'TER-JE-PB2', 'description' => '' ],
            [ 'name' => 'TERRACES @ TRADIZO ENCLAVE - A01', 'code' => 'TER-TE-A01', 'description' => '' ],
            [ 'name' => 'TERRACES @ TRADIZO ENCLAVE - B01', 'code' => 'TER-TE-B01', 'description' => '' ],
            [ 'name' => 'TERRACES @ TRADIZO ENCLAVE - B02', 'code' => 'TER-TE-B02', 'description' => '' ],
            [ 'name' => 'TERRACES @ TRADIZO ENCLAVE - B03', 'code' => 'TER-TE-B03', 'description' => '' ],
            [ 'name' => 'TERRACES @ TRADIZO ENCLAVE - C01', 'code' => 'TER-TE-C01', 'description' => '' ],
            [ 'name' => 'TERRACES @ TRADIZO ENCLAVE - C02', 'code' => 'TER-TE-C02', 'description' => '' ],
            [ 'name' => 'TERRACES - VILLAGIO TRIAS', 'code' => 'TER-VE', 'description' => '' ],
            [ 'name' => 'ZAYA PHASE 3 - A02', 'code' => 'ZYA-03-A02', 'description' => '' ],
            [ 'name' => 'ZAYA PHASE 3 - A05', 'code' => 'ZYA-03-A05', 'description' => '' ],
            [ 'name' => 'ZAYA PHASE 3 - A1A', 'code' => 'ZYA-03-A1A', 'description' => '' ],
            [ 'name' => 'ZAYA PHASE 3 - A1B', 'code' => 'ZYA-03-A1B', 'description' => '' ],
            [ 'name' => 'ZAYA PHASE 3 - A1C', 'code' => 'ZYA-03-A1C', 'description' => '' ],
            [ 'name' => 'ZAYA PHASE 3 - D01', 'code' => 'ZYA-03-D01', 'description' => '' ],
            [ 'name' => 'ZAYA PHASE 3 - I01', 'code' => 'ZYA-03-I01', 'description' => '' ],
            [ 'name' => 'ZAYA PHASE 1A - B01', 'code' => 'ZYA-1A-B01', 'description' => '' ],
            [ 'name' => 'ZAYA PHASE 1A - C01', 'code' => 'ZYA-1A-C01', 'description' => '' ],
            [ 'name' => 'ZAYA PHASE 1B - A03', 'code' => 'ZYA-1B-A03', 'description' => '' ],
            [ 'name' => 'ZAYA PHASE 1B - A04', 'code' => 'ZYA-1B-A04', 'description' => '' ],
            [ 'name' => 'ZAYA PHASE 2A - D02', 'code' => 'ZYA-2A-D02', 'description' => '' ],
            [ 'name' => 'ZAYA PHASE 2A - G01', 'code' => 'ZYA-2A-G01', 'description' => '' ],
            [ 'name' => 'ZAYA PHASE 2B - E01', 'code' => 'ZYA-2B-E01', 'description' => '' ],
            [ 'name' => 'ZAYA PHASE 2B - G02', 'code' => 'ZYA-2B-G02', 'description' => '' ],
            [ 'name' => 'ZAYA PHASE 2C - F01', 'code' => 'ZYA-2C-F01', 'description' => '' ],
            [ 'name' => 'ZAYA PHASE 2C - H01', 'code' => 'ZYA-2C-H01', 'description' => '' ],
            [ 'name' => 'ESTANZIA EAST', 'code' => 'ESE', 'description' => '' ],
            [ 'name' => 'ESTANZIA WEST', 'code' => 'ESW', 'description' => '' ],
            [ 'name' => 'JUBILATION ENCLAVE NORTH', 'code' => 'JEN', 'description' => '' ],
            [ 'name' => 'JUBILATION ENCLAVE PHASE 1', 'code' => 'JEP-01', 'description' => '' ],
            [ 'name' => 'JUBILATION ENCLAVE PHASE 2', 'code' => 'JEP-02', 'description' => '' ],
            [ 'name' => 'THE PENTHOUSE - JUBILATION NORTH', 'code' => 'JPH', 'description' => '' ],
            [ 'name' => 'VALENZIA ENCLAVE', 'code' => 'VAP', 'description' => '' ],
            [ 'name' => 'VILLAGIO ENCLAVE', 'code' => 'VEP', 'description' => '' ],
            [ 'name' => 'AGAPEYA ', 'code' => 'AGM', 'description' => '' ],
        ];

        foreach($data as $item){
            Account::updateOrCreate(['name' => $item['name'], 'code'=>$item['code']],['description' => $item['description']]);
        }
    }
}

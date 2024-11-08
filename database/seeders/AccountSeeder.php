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
       Account::updateOrCreate(['name' => 'Pagsikat Trips','code'=>'pgskt'],['description' => 'Pagsikat']);
       Account::updateOrCreate(['name' => 'Pagsibol Trips','code'=>'pgsbt'],['description' => 'Pagsibol']);
       Account::updateOrCreate(['name' => 'Pasinaya Trips','code'=>'psnyt'],['description' => 'Pasinaya']);

    }
}

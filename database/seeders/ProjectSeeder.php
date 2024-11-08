<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::updateOrCreate(['name' => 'Pasinaya','code'=>'psny'],['description' => 'Pasinaya']);
        Project::updateOrCreate(['name' => 'Pagsikat','code'=>'pgsk'],['description' => 'Pagsikat']);
        Project::updateOrCreate(['name' => 'Pagsibol','code'=>'pgsb'],['description' => 'Pagsibol']);
    }
}

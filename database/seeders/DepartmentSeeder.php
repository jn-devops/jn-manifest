<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::updateOrCreate(['name' => 'Sales']);
        Department::updateOrCreate(['name' => 'IT']);
        Department::updateOrCreate(['name' => 'HR']);
        Department::updateOrCreate(['name' => 'Accounting']);
        Department::updateOrCreate(['name' => 'Engineering']);
        Department::updateOrCreate(['name' => 'Marketing']);
    }
}

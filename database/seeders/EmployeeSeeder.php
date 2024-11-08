<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::updateOrCreate(['name' => 'Renzo Carianga','email' => 'renzo.carianga@gmail.com','mobile' => '9611074515'],['company_id' => 1,'department_id' => 1]);
        Employee::updateOrCreate(['name' => 'Lester Hurtado','email' => 'devops@joy-nostalg.com','mobile' => '9173011987'],['company_id' => 1,'department_id' => 1]);
    }
}

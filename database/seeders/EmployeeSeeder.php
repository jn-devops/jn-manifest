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
        Employee::updateOrCreate(['email' => 'renzo.carianga@gmail.com'],['mobile' => '9611074515','name' => 'Renzo Carianga','company_id' => 1,'department_id' => 1]);
        Employee::updateOrCreate(['email' => 'devops@joy-nostalg.com'],['mobile' => '9173011987','name' => 'Lester Hurtado','company_id' => 1,'department_id' => 1]);
    }
}

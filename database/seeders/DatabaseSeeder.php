<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProjectSeeder::class,
            CompanySeeder::class,
            DepartmentSeeder::class,
            CarTypeSeeder::class,
            AccountSeeder::class,
            EmployeeSeeder::class,
        ]);
    }
}

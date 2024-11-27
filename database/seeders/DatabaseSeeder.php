<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Company;
use App\Models\Contract;
use App\Models\Tools;
use App\Models\ToolsMaintenance;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            DepartmentSeeder::class,
            CompanySeeder::class,
            ContractSeeder::class,
            BranchSeeder::class,
            UserSeeder::class,
            EmployeSeeder::class,
            VehicleTypesSeeder::class,
            VehicleOwnershipsSeeder::class,
            VehicleSeeder::class,
            MaintenanceRecordsSeeder::class,
            AssignmentsSeeder::class,
            InsurancePoliciesSeeder::class,
            ToolsCategorieSeeder::class,
            ToolsOwnersSeeder::class,
            ToolsSeeder::class,
            ToolsStockSeeder::class,
            ToolsMaintenanceSeeder::class,
            ToolsTransactionSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Company;
use App\Models\Contract;
use App\Models\CostBidsAnalysis;
use App\Models\CostBidsInventory;
use App\Models\IncomingInventory;
use App\Models\IncomingShipments;
use App\Models\IncomingSupplier;
use App\Models\TicketsCategories;
use App\Models\Tools;
use App\Models\ToolsMaintenance;
use App\Models\VehicleTransaction;
use App\Models\Warehouses;
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
            CompanySeeder::class,
            DepartmentSeeder::class,
            BranchSeeder::class,
            WarehouseSeeder::class,
            UserSeeder::class,
            EmployeSeeder::class,
            ContractSeeder::class,
            ProjectSeeder::class,
            VehicleTypesSeeder::class,
            VehicleSeeder::class,
            ToolsCategorieSeeder::class,
            ToolsSeeder::class,
            ToolsMaintenanceSeeder::class,
            ToolsTransactionSeeder::class,
            ToolsShipmentsSeeder::class,
            TicketsCategoriesSeeder::class,
            TicketsSeeder::class,
            TicketsCommentsSeeder::class,
            IncomingSupplierSeeder::class,
            IncomingShipmentsSeeder::class,
            IncomingInventorySeeder::class,
            CostBidsVendorSeeder::class,
            CostBidsInventorySeeder::class,
            CostBidsSeeder::class,
            CostBidsInventoryVendorSeeder::class,
            CostBidsAnalysisSeeder::class
        ]);
    }
}

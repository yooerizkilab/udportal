<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Daftar permissions yang ingin dibuat
        $permissions = [
            'view roles',
            'create roles',
            'update roles',
            'delete roles',
            'view permissions',
            'create permissions',
            'update permissions',
            'delete permissions',
            'view users',
            'create users',
            'update users',
            'delete users',
            'view contracts',
            'create contracts',
            'update contracts',
            'delete contracts',
            'view tools',
            'create tools',
            'update tools',
            'delete tools',
            'view tools categories',
            'create tools categories',
            'update tools categories',
            'delete tools categories',
            'view tools ownership',
            'create tools ownership',
            'update tools ownership',
            'delete tools ownership',
            'view tools transaction',
            'create tools transaction',
            'update tools transaction',
            'delete tools transaction',
            'view tools maintenance',
            'create tools maintenance',
            'update tools maintenance',
            'delete tools maintenance',
            'view vehicle',
            'create vehicle',
            'update vehicle',
            'delete vehicle',
            'view vehicle maintenance',
            'create vehicle maintenance',
            'update vehicle maintenance',
            'delete vehicle maintenance',
            'view vehicle insurance',
            'create vehicle insurance',
            'update vehicle insurance',
            'delete vehicle insurance',
            'view vehicle transaction',
            'create vehicle transaction',
            'update vehicle transaction',
            'delete vehicle transaction',
            'view ticket',
            'create ticket',
            'update ticket',
            'delete ticket',
            'view ticket reply',
            'create ticket reply',
            'update ticket reply',
            'delete ticket reply',
        ];

        // Buat atau cek apakah permissions sudah ada
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat Role atau cek apakah role sudah ada
        $superAdminRole = Role::firstOrCreate(['name' => 'Superadmin']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminAccounting = Role::firstOrCreate(['name' => 'Admin Accounting']);
        $adminPurchasing = Role::firstOrCreate(['name' => 'Admin Purchasing']);
        $adminFinance = Role::firstOrCreate(['name' => 'Admin Finance']);
        $adminLegal = Role::firstOrCreate(['name' => 'Admin Legal']);
        $adminSales = Role::firstOrCreate(['name' => 'Admin Sales']);
        $adminIT = Role::firstOrCreate(['name' => 'Admin IT']);
        $adminGA = Role::firstOrCreate(['name' => 'Admin General Affairs']);
        $adminHR = Role::firstOrCreate(['name' => 'Admin HR']);
        $staffRole = Role::firstOrCreate(['name' => 'Staff']);
        $userRole = Role::firstOrCreate(['name' => 'User']);

        // Berikan semua permissions ke role Superadmin
        $allPermissions = Permission::all();
        $superAdminRole->syncPermissions($allPermissions);

        // Buat User Super Admin
        $super = User::create([
            'name' => 'Super',
            'username' => 'superadmin',
            'last_name' => 'Admin',
            'email' => 'superadmin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            // 'remember_token' => Str::random(10),
        ]);

        $super->assignRole($superAdminRole);
    }
}

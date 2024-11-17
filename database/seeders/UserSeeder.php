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
            'view role',
            'create role',
            'update role',
            'delete role',
            'view permission',
            'create permission',
            'update permission',
            'delete permission',
            'view user',
            'create user',
            'update user',
            'delete user',
            'view product',
            'create product',
            'update product',
            'delete product',
            'view category',
            'create category',
            'update category',
            'delete category',
        ];

        // Buat atau cek apakah permissions sudah ada
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat Role atau cek apakah role sudah ada
        $superAdminRole = Role::firstOrCreate(['name' => 'Superadmin']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $staffRole = Role::firstOrCreate(['name' => 'Staff']);
        $userRole = Role::firstOrCreate(['name' => 'User']);

        // Berikan semua permissions ke role Superadmin
        $allPermissions = Permission::all();
        $superAdminRole->syncPermissions($allPermissions);

        // Berikan permissions tertentu ke role User
        $userPermissions = Permission::whereIn('name', ['view product', 'create product', 'update product', 'delete product'])->get();
        $userRole->syncPermissions($userPermissions);

        // Buat User Super Admin
        $super = User::create([
            'name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'superadmin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            // 'remember_token' => Str::random(10),
        ]);

        $super->assignRole($superAdminRole);

        // Buat Users
        $users = User::create([
            'name' => 'User',
            'last_name' => 'ABC',
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            // 'remember_token' => Str::random(10),
        ]);

        $users->assignRole($userRole);
    }
}

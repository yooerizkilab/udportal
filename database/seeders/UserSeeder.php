<?php

namespace Database\Seeders;

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

        // Define permissions
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
        ];

        // Create or update permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles
        $rolesPermissions = [
            'Superadmin' => Permission::all(),
            'Admin Legal' => [
                'view contracts',
                'create contracts',
                'update contracts',
                'delete contracts',
                'view ticket',
                'create ticket',
                'update ticket',
                'delete ticket',
            ],
            'Admin GA' => [
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
            ],
            'Admin Branch' => [], // Define specific permissions here if needed
            'Admin IT' => [], // Define specific permissions here if needed
            'User' => [], // Define specific permissions here if needed
        ];

        foreach ($rolesPermissions as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }

        // Create users
        $users = [
            // Superadmin
            [
                'name' => 'Super',
                'username' => 'superadmin',
                'last_name' => 'Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password'),
                'role' => 'Superadmin',
            ],
            // Admin Department
            [
                'name' => 'Admin',
                'username' => 'adminlegal',
                'last_name' => 'Legal',
                'email' => 'adminlegal@example.com',
                'password' => Hash::make('password'),
                'role' => 'Admin Legal',
            ],
            [
                'name' => 'Admin',
                'username' => 'adminga',
                'last_name' => 'GA',
                'email' => 'adminga@example.com',
                'password' => Hash::make('password'),
                'role' => 'Admin GA',
            ],
            // Admin Branch
            [
                'name' => 'Admin',
                'username' => 'adminbranch1',
                'last_name' => 'Branch 1',
                'email' => 'adminbranch@example.com',
                'password' => Hash::make('password'),
                'role' => 'Admin Branch',
            ],
            [
                'name' => 'Admin',
                'username' => 'adminbranch2',
                'last_name' => 'Branch 2',
                'email' => 'adminbranch2@example.com',
                'password' => Hash::make('password'),
                'role' => 'Admin Branch',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'username' => $userData['username'],
                    'last_name' => $userData['last_name'],
                    'password' => $userData['password'],
                    'email_verified_at' => now(),
                    'remember_token' => Str::random(10),
                ]
            );
            $user->assignRole($userData['role']);
        }
    }
}

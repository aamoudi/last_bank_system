<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //NOTE: php artisan cache:clear

        // ROLES
        Role::create(['name' => 'User', 'guard_name' => 'user']);

        //ADMIN PERMISSIONS
        Permission::create(['name' => 'Create-Admins', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Admins', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Admins', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Admins', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Users', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Users', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Users', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Users', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Cities', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Cities', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Cities', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Cities', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Currencies', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Currencies', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Currencies', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Currencies', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Professions', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Professions', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Professions', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Professions', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Roles', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Roles', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Roles', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Roles', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Permissions', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Permissions', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Permissions', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Permissions', 'guard_name' => 'admin']);

        //USER PERMISSIONS//
        Permission::create(['name' => 'Create-Users', 'guard_name' => 'user']);
        Permission::create(['name' => 'Read-Users', 'guard_name' => 'user']);
        Permission::create(['name' => 'Update-Users', 'guard_name' => 'user']);
        Permission::create(['name' => 'Delete-Users', 'guard_name' => 'user']);

        Permission::create(['name' => 'Create-Income-Types', 'guard_name' => 'user']);
        Permission::create(['name' => 'Read-Income-Types', 'guard_name' => 'user']);
        Permission::create(['name' => 'Update-Income-Types', 'guard_name' => 'user']);
        Permission::create(['name' => 'Delete-Income-Types', 'guard_name' => 'user']);

        Permission::create(['name' => 'Create-Expense-Types', 'guard_name' => 'user']);
        Permission::create(['name' => 'Read-Expense-Type', 'guard_name' => 'user']);
        Permission::create(['name' => 'Update-Expense-Type', 'guard_name' => 'user']);
        Permission::create(['name' => 'Delete-Expense-Type', 'guard_name' => 'user']);

        Permission::create(['name' => 'Create-Wallets', 'guard_name' => 'user']);
        Permission::create(['name' => 'Read-Wallets', 'guard_name' => 'user']);
        Permission::create(['name' => 'Update-Wallets', 'guard_name' => 'user']);
        Permission::create(['name' => 'Delete-Wallets', 'guard_name' => 'user']);

        Permission::create(['name' => 'Create-Debits', 'guard_name' => 'user']);
        Permission::create(['name' => 'Read-Debits', 'guard_name' => 'user']);
        Permission::create(['name' => 'Update-Debits', 'guard_name' => 'user']);
        Permission::create(['name' => 'Delete-Debits', 'guard_name' => 'user']);

        // Permission::create(['name' => 'Create-', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Read-', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Update-', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Delete-', 'guard_name' => 'admin']);
    }
}

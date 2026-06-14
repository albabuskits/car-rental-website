<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'manage cars', 'guard_name' => 'web']);
        Permission::create(['name' => 'manage bookings', 'guard_name' => 'web']);
        Permission::create(['name' => 'manage users', 'guard_name' => 'web']);
        Permission::create(['name' => 'manage settings', 'guard_name' => 'web']);

        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $admin->givePermissionTo(Permission::all());

        Role::create(['name' => 'user', 'guard_name' => 'web']);

        $adminUser = User::create([
            'name' => 'مسؤول النظام',
            'email' => 'admin@arhab.rentals',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);
        $adminUser->assignRole('admin');
    }
}

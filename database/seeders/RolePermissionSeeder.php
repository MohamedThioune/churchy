<?php

namespace Database\Seeders;

use App\Enums\Rolenum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creation permissions
        Permission::create(['name' => 'view expenses']);
        Permission::create(['name' => 'add expenses']);
        Permission::create(['name' => 'edit expenses']);
        Permission::create(['name' => 'view general expenses']);

        // Creation all roles
        $adminRole = Role::firstOrCreate(['name' => Rolenum::ADMIN->value]);
        $cashierRole = Role::firstOrCreate(['name' =>  Rolenum::CASHIER->value]);
        $christianRole = Role::firstOrCreate(['name' =>  Rolenum::CHRISTIAN->value]);

        // Assign all permissions to admin role
        $adminRole->givePermissionTo(Permission::all());

        // Assign some permission to cashier role
        $cashierRole->givePermissionTo('view expenses');
        $cashierRole->givePermissionTo('add expenses');
        $cashierRole->givePermissionTo('edit expenses');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'admin', 'description' => 'super user']);
        Role::create(['name' => 'user', 'description' => 'can add expenses']);

        Permission::create(['name' => 'add users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'remove users']);
        Permission::create(['name' => 'view users']);
    }
}

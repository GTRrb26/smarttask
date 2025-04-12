<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Project permissions
        Permission::create(['name' => 'create projects']);
        Permission::create(['name' => 'edit projects']);
        Permission::create(['name' => 'delete projects']);
        Permission::create(['name' => 'view projects']);

        // Task permissions
        Permission::create(['name' => 'create tasks']);
        Permission::create(['name' => 'edit tasks']);
        Permission::create(['name' => 'delete tasks']);
        Permission::create(['name' => 'view tasks']);

        // Comment permissions
        Permission::create(['name' => 'create comments']);
        Permission::create(['name' => 'edit comments']);
        Permission::create(['name' => 'delete comments']);
        Permission::create(['name' => 'view comments']);
    }
} 
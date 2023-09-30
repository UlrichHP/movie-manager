<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        Permission::create(['name' => 'create-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'delete-users']);

        Permission::create(['name' => 'create-movies']);
        Permission::create(['name' => 'edit-movies']);
        Permission::create(['name' => 'delete-movies']);
        Permission::create(['name' => 'create-genres']);
        Permission::create(['name' => 'edit-genres']);
        Permission::create(['name' => 'delete-genres']);
        Permission::create(['name' => 'create-actors']);
        Permission::create(['name' => 'edit-actors']);
        Permission::create(['name' => 'delete-actors']);

        $adminRole = Role::create(['name' => 'admin']);
        $editorRole = Role::create(['name' => 'editor']);

        $adminRole->givePermissionTo([
            'create-users',
            'edit-users',
            'delete-users',
            'create-movies',
            'edit-movies',
            'delete-movies',
            'create-genres',
            'edit-genres',
            'delete-genres',
            'create-actors',
            'edit-actors',
            'delete-actors',
        ]);

        $editorRole->givePermissionTo([
            'create-movies',
            'edit-movies',
            'delete-movies',
            'create-genres',
            'edit-genres',
            'delete-genres',
            'create-actors',
            'edit-actors',
            'delete-actors',
        ]);
    }
}

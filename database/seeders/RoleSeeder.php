<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::factory()->create(['name' => 'Admin']);
        $editor = Role::factory()->create(['name' => 'Editor']);
        $viewer = Role::factory()->create(['name' => 'Viewer']);

        $permissions = Permission::all();

        // Admin have all permissions
        $admin->permissions()->attach($permissions->pluck('id'));

        // Editor have all permissions but not role-edit
        $editor->permissions()->attach($permissions->pluck('id'));
        $editor->permissions()->detach(4);

        // Viewer have only view permissions
        $viewer->permissions()->attach([1, 3, 5, 7]);
    }
}

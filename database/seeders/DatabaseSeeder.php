<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::factory()->create(['name' => 'Admin']);
        Role::factory()->create(['name' => 'Editor']);
        Role::factory()->create(['name' => 'Viewer']);

        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@laravel-api.com',
            'role_id' => 1,
        ]);

        User::factory()->create([
            'first_name' => 'Editor',
            'last_name' => 'User',
            'email' => 'editor@laravel-api.com',
            'role_id' => 2,
        ]);

        User::factory()->create([
            'first_name' => 'View',
            'last_name' => 'User',
            'email' => 'viewer@laravel-api.com',
            'role_id' => 3,
        ]);

        User::factory(20)->create();
    }
}

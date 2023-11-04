<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $user1 = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => '12345678',
        ]);

        User::factory()->create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'password' => '12345678',
        ]);
        $role = Role::create(['name' => 'Admin']);
        $user1->assignRole($role);
    }
}

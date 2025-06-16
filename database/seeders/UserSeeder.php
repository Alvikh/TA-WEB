<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Superadmin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@powersmartiq.com',
            'password' => Hash::make('superadmin123'),
            'role' => 'superadmin',
            'email_verified_at' => now(),
        ]);

        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@powersmartiq.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Regular users
        User::factory()->count(5)->create([
            'role' => 'user',
        ]);
    }
}
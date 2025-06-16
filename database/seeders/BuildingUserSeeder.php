<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\User;
use Illuminate\Database\Seeder;

class BuildingUserSeeder extends Seeder
{
    public function run()
    {
        // Superadmin memiliki akses ke semua gedung
        $superadmin = User::where('email', 'superadmin@powersmartiq.com')->first();
        $superadmin->buildings()->attach(Building::all());

        // Admin memiliki akses ke gedung 1 dan 2
        $admin = User::where('email', 'admin@powersmartiq.com')->first();
        $admin->buildings()->attach([1, 2]);

        // User biasa memiliki akses ke gedung acak
        $regularUsers = User::where('role', 'user')->get();
        foreach ($regularUsers as $user) {
            $buildingCount = rand(1, 3);
            $buildings = Building::inRandomOrder()->limit($buildingCount)->get();
            $user->buildings()->attach($buildings);
        }
    }
}
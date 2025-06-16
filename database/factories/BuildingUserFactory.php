<?php

namespace Database\Factories;

use App\Models\Building;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BuildingUserFactory extends Factory
{
    public function definition()
    {
        return [
            'building_id' => Building::factory(),
            'user_id' => User::factory(),
        ];
    }
}
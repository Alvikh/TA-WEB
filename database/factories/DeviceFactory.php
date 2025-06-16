<?php

namespace Database\Factories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    public function definition()
    {
        $types = ['Smart Meter', 'Environment Sensor', 'Power Monitor', 'Energy Logger'];
        $statuses = ['active', 'inactive', 'maintenance'];
        
        return [
            'building_id' => Building::factory(),
            'name' => $this->faker->word() . ' ' . $this->faker->randomElement(['Sensor', 'Meter', 'Device']),
            'device_id' => 'DEV-' . $this->faker->unique()->bothify('??-####'),
            'type' => $this->faker->randomElement($types),
            'manufacturer' => $this->faker->company(),
            'model' => $this->faker->bothify('??-####'),
            'firmware_version' => $this->faker->numerify('#.#.#'),
            'installation_date' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'status' => $this->faker->randomElement($statuses),
        ];
    }
}
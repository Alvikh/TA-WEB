<?php

namespace Database\Factories;

use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnergyMeasurementFactory extends Factory
{
    public function definition()
    {
        return [
            'device_id' => Device::factory(),
            'voltage' => $this->faker->randomFloat(2, 210, 230),
            'current' => $this->faker->randomFloat(2, 5, 20),
            'power' => $this->faker->randomFloat(2, 1000, 5000),
            'energy' => $this->faker->randomFloat(2, 50, 200),
            'frequency' => $this->faker->randomFloat(2, 49.8, 50.2),
            'power_factor' => $this->faker->randomFloat(2, 0.85, 0.99),
            'temperature' => $this->faker->randomFloat(2, 25, 35),
            'humidity' => $this->faker->randomFloat(2, 50, 90),
            'measured_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ];
    }
}
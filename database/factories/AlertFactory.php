<?php

namespace Database\Factories;

use App\Models\Device;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlertFactory extends Factory
{
    public function definition()
    {
        $types = ['over_voltage', 'under_voltage', 'over_current', 'high_temperature', 'low_power_factor'];
        $severities = ['low', 'medium', 'high', 'critical'];
        
        return [
            'device_id' => Device::factory(),
            'type' => $this->faker->randomElement($types),
            'message' => $this->faker->sentence(),
            'severity' => $this->faker->randomElement($severities),
            'is_resolved' => $this->faker->boolean(30),
            'resolved_at' => function (array $attributes) {
                return $attributes['is_resolved'] ? $this->faker->dateTimeBetween('-1 week', 'now') : null;
            },
        ];
    }
}
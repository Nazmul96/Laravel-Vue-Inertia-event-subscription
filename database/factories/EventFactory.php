<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Achievement>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'start_date' => $this->faker->dateTime()->format('Y-m-d H:i:00'),
            'end_date' => $this->faker->dateTime()->format('Y-m-d H:i:00'),
        ];
    }
}

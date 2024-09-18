<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'position' => $this->faker->jobTitle,
            'office' => $this->faker->city,
            'start_date' => $this->faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'salary' => $this->faker->numberBetween(16000, 150000),
        ];
    }
}

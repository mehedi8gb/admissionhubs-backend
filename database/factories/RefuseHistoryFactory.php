<?php

namespace Database\Factories;

use App\Models\RefuseHistory;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RefuseHistory>
 */
class RefuseHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::inRandomOrder()->first()->id,
            'refusalType' => $this->faker->word,
            'refusalDate' => fake()->date('Y-m-d', fake()->dateTimeBetween('-10 years', '-5 years')),
            'details' => $this->faker->sentence,
            'country' => $this->faker->country,
            'visaType' => $this->faker->word,
            'status' => $this->faker->randomElement(['Resolved', 'Pending']),
        ];
    }
}

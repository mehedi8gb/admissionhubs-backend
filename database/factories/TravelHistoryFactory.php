<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\TravelHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TravelHistory>
 */
class TravelHistoryFactory extends Factory
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
            'purpose' => fake()->word,
            'arrival' => fake()->date('Y-m-d', fake()->dateTimeBetween('-10 years', '-5 years')),
            'departure' => fake()->date('Y-m-d', fake()->dateTimeBetween('-5 years', 'now')),
            'visaStart' => fake()->date('Y-m-d', fake()->dateTimeBetween('-10 years', '-5 years')),
            'visaExpiry' => fake()->date('Y-m-d', fake()->dateTimeBetween('-5 years', 'now')),
            'visaType' => fake()->word,
        ];
    }
}

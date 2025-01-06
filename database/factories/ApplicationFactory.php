<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class ApplicationFactory extends Factory
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
            'institution' => fake()->company,
            'course' => fake()->word,
            'term' => fake()->randomElement(['Fall', 'Spring', 'Summer']),
            'type' => fake()->randomElement(['Full-time', 'Part-time']),
            'amount' => fake()->randomFloat(2, 1000, 50000),
            'status' => fake()->numberBetween(0, 1),
        ];
    }
}

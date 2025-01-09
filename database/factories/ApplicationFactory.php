<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Institute;
use App\Models\Student;
use App\Models\Term;
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
            'institute_id' => Institute::inRandomOrder()->first()->id,
            'course_id' => Course::inRandomOrder()->first()->id,
            'term_id' => Term::inRandomOrder()->first()->id,
            'type' => fake()->randomElement(['Full-time', 'Part-time']),
            'amount' => fake()->randomFloat(2, 1000, 50000),
            'status' => fake()->numberBetween(0, 1),
        ];
    }
}

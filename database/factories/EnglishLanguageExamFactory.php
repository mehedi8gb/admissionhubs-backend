<?php

namespace Database\Factories;

use App\Models\EnglishLanguageExam;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EnglishLanguageExam>
 */
class EnglishLanguageExamFactory extends Factory
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
            'exam' => fake()->sentence(3),
            'examDate' => fake()->date(),
            'score' => fake()->numberBetween(0, 100),
            'status' => fake()->boolean(80) ? 1 : 0,
        ];
    }
}

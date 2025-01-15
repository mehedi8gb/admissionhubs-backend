<?php

namespace Database\Factories;

use App\Models\AcademicHistory;
use App\Models\AcademicYear;
use App\Models\Student;
use App\Models\Term;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AcademicHistory>
 */
class AcademicHistoryFactory extends Factory
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
            'institution' => $this->faker->company,
            'course' => $this->faker->word,
            'studyLevel' => fake()->randomElement(['Undergraduate', 'Graduate', 'Diploma']),
            'resultScore' => $this->faker->randomFloat(2, 1, 5),
            'outOf' => 5,
            'startDate' => fake()->date('Y-m-d', '-10 years'),
            'endDate' => fake()->date('Y-m-d', '-5 years'),
            'status' => rand(0, 1),
        ];
    }
}

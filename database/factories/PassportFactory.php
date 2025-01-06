<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Passport>
 */
class PassportFactory extends Factory
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
            'passportName' => fake()->name,
            'passportIssueLocation' => fake()->city,
            'passportNumber' => fake()->unique()->randomNumber(8),
            'passportIssueDate' => fake()->date('Y-m-d', fake()->dateTimeBetween('-10 years', '-5 years')),
            'passportExpiryDate' => fake()->date('Y-m-d', fake()->dateTimeBetween('+5 years', '+10 years')),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\WorkDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WorkDetail>
 */
class WorkDetailFactory extends Factory
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
            'jobTitle' => fake()->jobTitle,
            'organization' => fake()->company,
            'address' => fake()->address,
            'phone' => fake()->phoneNumber,
            'fromDate' => fake()->date('Y-m-d', '-10 years'),
            'toDate' => fake()->date('Y-m-d', '-5 years'),
            'status' => fake()->boolean,
            'currentlyWorking' => $this->faker->boolean,
        ];
    }
}

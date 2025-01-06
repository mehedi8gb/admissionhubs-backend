<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
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
            'addressLine1' => fake()->streetAddress,
            'addressLine2' => fake()->streetAddress,
            'townCity' => fake()->city,
            'state' => fake()->word(),
            'postCode' => fake()->postcode,
            'country' => fake()->country,
        ];
    }
}

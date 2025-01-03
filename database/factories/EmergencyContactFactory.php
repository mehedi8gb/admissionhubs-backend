<?php

namespace Database\Factories;

use App\Models\EmergencyContact;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EmergencyContact>
 */
class EmergencyContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::inRandomOrder()->value('id'),
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'address' => $this->faker->address,
            'relationship' => $this->faker->randomElement(['Parent', 'Sibling', 'Guardian', 'Friend']),
            'status' => $this->faker->randomElement(['Active', 'Inactive']),
        ];
    }
}

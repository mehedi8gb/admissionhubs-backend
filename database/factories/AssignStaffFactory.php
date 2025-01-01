<?php

namespace Database\Factories;

use App\Models\AssignStaff;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AssignStaff>
 */
class AssignStaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'staffId' => 1, // Replace with a valid staff ID or use a factory
            'type' => 'Counselor',
        ];
    }
}

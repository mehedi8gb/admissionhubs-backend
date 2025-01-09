<?php

namespace Database\Factories;

use App\Models\AssignStaff;
use App\Models\Staff;
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
            'staffId' => Staff::factory()->create()->id,
        ];
    }
}

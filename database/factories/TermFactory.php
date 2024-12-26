<?php

namespace Database\Factories;

use App\Models\Term;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Term>
 */
class TermFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'term_data' => [
                'term' => $this->faker->unique()->word(),
                'academic_year' => $this->faker->year() . '-' . $this->faker->year(),
            ],
            'status' => $this->faker->boolean(),

        ];
    }
}

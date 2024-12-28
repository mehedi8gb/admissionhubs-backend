<?php

namespace Database\Factories;

use App\Models\AcademicYear;
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
        $termName = [
            'First Term',
            'Second Term',
            'Third Term',
        ];

        return [
            'term_data' => [
                'term' => $termName[$this->faker->numberBetween(0, 2)],
            ],
            'academic_year_id' => AcademicYear::inRandomOrder()->first()->id,
            'status' => $this->faker->boolean(),

        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AcademicYear>
 */
class AcademicYearFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $startYear = 2019; // Starting academic year

        // Generate the next academic year in sequence
        $academicYear = $startYear . '-' . ($startYear + 1);
        $startYear++; // Increment the starting year for the next call

        return [
            'academic_year' => $academicYear,
            'status' => true,
        ];
    }
}

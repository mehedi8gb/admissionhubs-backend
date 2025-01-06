<?php

namespace Database\Factories;

use App\Models\AcademicYear;
use App\Models\Institute;
use App\Models\Student;
use App\Models\Term;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    private static int $studentCount = 1;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        echo "\r \t" . self::$studentCount . " Students Created: " . "   ";
        self::$studentCount++;
        flush();

        return [
            'created_by' => User::inRandomOrder()->first()->id,
            'academic_year_id' => AcademicYear::inRandomOrder()->first()->id,
            'term_id' => Term::inRandomOrder()->first()->id,
//            'institute_id' => Institute::inRandomOrder()->first()->id,
            'status' => fake()->boolean,
            'ref_id' => fake()->uuid,
            'name' => fake()->name,
            'email' => fake()->unique()->safeEmail,
            'phone' => fake()->phoneNumber,
            'dob' => fake()->date('Y-m-d', fake()->dateTimeBetween('-30 years', '-18 years')),
            'agent' => fake()->name,
            'staff' => fake()->name,
            'student_data' => [
                'title' => fake()->title,
                'firstName' => fake()->firstName,
                'lastName' => fake()->lastName,
                'email' => fake()->unique()->safeEmail,
                'phone' => fake()->phoneNumber,
                'dob' => fake()->date('Y-m-d', fake()->dateTimeBetween('-30 years', '-18 years')),
                'maritualStatus' => fake()->randomElement(['Single', 'Married', 'Divorced', 'Widowed']),
                'gender' => fake()->randomElement(['Male', 'Female']),
                'nationality' => fake()->country,
                'countryResidence' => fake()->country,
                'countryBirth' => fake()->country,
                'nativeLanguage' => fake()->languageCode,

                'disabilities' => fake()->randomElement(['None', 'Visual', 'Hearing', 'Mobility']),
                'ethnicity' => fake()->word(),
                'genderIdentity' => fake()->randomElement(['Male', 'Female', 'Transgender']),
                'sexualOrientation' => fake()->randomElement(['Heterosexual', 'Homosexual', 'Bisexual']),
                'religion' => fake()->word(),
            ]
        ];
    }
}

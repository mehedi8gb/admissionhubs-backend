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
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'created_by' => User::inRandomOrder()->first()->id,
//            'academic_year_id' => AcademicYear::inRandomOrder()->first()->id,
//            'term_id' => Term::inRandomOrder()->first()->id,
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
                'passportName' => fake()->name,
                'passportIssueLocation' => fake()->city,
                'passportNumber' => fake()->unique()->randomNumber(8),
                'passportIssueDate' => fake()->date('Y-m-d', fake()->dateTimeBetween('-10 years', '-5 years')),
                'passportExpiryDate' => fake()->date('Y-m-d', fake()->dateTimeBetween('+5 years', '+10 years')),
                'addressLine1' => fake()->streetAddress,
                'addressLine2' => fake()->streetAddress,
                'townCity' => fake()->city,
                'state' => fake()->word(),
                'postCode' => fake()->postcode,
                'country' => fake()->country,
                'disabilities' => fake()->randomElement(['None', 'Visual', 'Hearing', 'Mobility']),
                'ethnicity' => fake()->word(),
                'genderidentity' => fake()->randomElement(['Male', 'Female', 'Transgender']),
                'sexualOrientation' => fake()->randomElement(['Heterosexual', 'Homosexual', 'Bisexual']),
                'religion' => fake()->word(),
                'emergencyContact' => [
                    [
                        'name' => fake()->name,
                        'phone' => fake()->phoneNumber,
                        'email' => fake()->unique()->safeEmail,
                        'address' => fake()->address,
                        'relationship' => fake()->word(),
                        'status' => 'Active',
                    ],
                ],
                'travelHistory' => [
                    [
                        'purpose' => fake()->word,
                        'arrival' => fake()->date('Y-m-d', fake()->dateTimeBetween('-10 years', '-5 years')),
                        'departure' => fake()->date('Y-m-d', fake()->dateTimeBetween('-5 years', 'now')),
                        'visaStart' => fake()->date('Y-m-d', fake()->dateTimeBetween('-10 years', '-5 years')),
                        'visaExpiry' => fake()->date('Y-m-d', fake()->dateTimeBetween('-5 years', 'now')),
                        'visaType' => fake()->word,
                    ],
                ],
                'visaNeed' => fake()->boolean,
                'refuseHistory' => [
                    [
                        'refusaltype' => fake()->word,
                        'refusalDate' => fake()->date('Y-m-d', fake()->dateTimeBetween('-10 years', '-5 years')),
                        'details' => fake()->sentence,
                        'country' => fake()->country,
                        'visaType' => fake()->word,
                        'status' => 'Resolved',
                    ],
                ],
                'academicHistory' => [
                    [
                        'institution' => fake()->company,
                        'course' => fake()->word,
                        'studylevel' => fake()->randomElement(['Undergraduate', 'Graduate', 'Diploma']),
                        'resultScore' => fake()->numberBetween(2.0, 4.0),
                        'outof' => 4.0,
                        'startDate' => fake()->date('Y-m-d', '-10 years'),
                        'endDate' => fake()->date('Y-m-d', '-5 years'),
                        'status' => 'Completed',
                    ],
                ],
                'workDetails' => [
                    [
                        'jobtitle' => fake()->jobTitle,
                        'organization' => fake()->company,
                        'address' => fake()->address,
                        'phone' => fake()->phoneNumber,
                        'fromDate' => fake()->date('Y-m-d', '-10 years'),
                        'toDate' => fake()->date('Y-m-d', '-5 years'),
                        'active' => fake()->boolean,
                        'currentlyWorking' => false,
                    ],
                ],
                'documents' => [
                    'passport' => 'passport.pdf', // Example filenames
                    'bankstatement' => 'bankstatement.pdf',
                    'qualification' => 'qualification.pdf',
                    'workExperience' => 'workexperience.pdf',
                    'cv' => 'cv.pdf',
                ],
                'application' => [
                    [
                        'institution' => fake()->company,
                        'course' => fake()->word,
                        'term' => fake()->randomElement(['Fall', 'Spring', 'Summer']),
                        'type' => fake()->randomElement(['Full-time', 'Part-time']),
                        'amount' => fake()->randomFloat(2, 1000, 50000),
                        'status' => 'Submitted',
                    ],
                ],
                'assignStaff' => [
                    [
                        'staffid' => 1, // Replace with a valid staff ID or use a factory
                        'type' => 'Counselor',
                    ],
                ],
            ]
        ];
    }
}

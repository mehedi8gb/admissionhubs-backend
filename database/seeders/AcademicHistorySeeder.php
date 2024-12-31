<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AcademicHistorySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();  // Create Faker instance

        DB::table('academic_histories')->insert([
            [
                'user_id' => 1, // Associate with the first user (you can change this as needed)
                'institution' => $faker->company,  // Random institution name
                'course' => $faker->word,          // Random course name
                'study_level' => $faker->randomElement(['Diploma', 'Bachelor', 'Master', 'PhD']),  // Random study level
                'result_score' => $faker->randomFloat(2, 0, 4),  // Random result score between 0 and 4
                'out_of' => $faker->randomFloat(2, 0, 4), // Random maximum score between 0 and 4
                'start_date' => $faker->date(),  // Random start date
                'end_date' => $faker->date(),    // Random end date
                'status' => $faker->randomElement(['Completed', 'Ongoing', 'Graduated']),  // Random status
                'academic_year' => $faker->year.'-'.$faker->year(),  // Random academic year
                'term' => $faker->randomElement(['First Term', 'Second Term', 'Summer Term']), // Random term
                'created_at' => now(),  // Current timestamp
                'updated_at' => now(),  // Current timestamp
            ]
            // Add more records as needed
        ]);
    }
}

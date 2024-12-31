<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RefuseHistorySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();  // Create Faker instance

        DB::table('refusals')->insert([
            [
                'user_id' => 1, // Associate with the first user (you can change this as needed)
                'refusal_type' => $faker->randomElement(['Visa Denial', 'Entry Refusal', 'Work Permit Refusal', 'Study Visa Denial']),  // Random refusal type
                'refusal_date' => $faker->date(),  // Random refusal date
                'details' => $faker->text(200),  // Random details about the refusal
                'country' => $faker->country(),  // Random country
                'visa_type' => $faker->randomElement(['Tourist', 'Student', 'Business', 'Work']),  // Random visa type
                'status' => $faker->randomElement(['Resolved', 'Pending', 'Rejected']),  // Random status
                'created_at' => now(),  // Current timestamp
                'updated_at' => now(),  // Current timestamp
            ],
            [
                'user_id' => 2,  // Associate with the second user
                'refusal_type' => $faker->randomElement(['Visa Denial', 'Entry Refusal', 'Work Permit Refusal', 'Study Visa Denial']),
                'refusal_date' => $faker->date(),
                'details' => $faker->text(200),
                'country' => $faker->country(),
                'visa_type' => $faker->randomElement(['Tourist', 'Student', 'Business', 'Work']),
                'status' => $faker->randomElement(['Resolved', 'Pending', 'Rejected']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more records as needed
        ]);
    }
}

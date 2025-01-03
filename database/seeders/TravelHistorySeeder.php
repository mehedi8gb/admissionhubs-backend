<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TravelHistorySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();  // Create Faker instance

        DB::table('travel_histories')->insert([
            [
                'user_id' => 1, // Associate with the first user (you can change this as needed)
                'purpose' => $faker->randomElement(['Business', 'Tourism', 'Study', 'Visit']),  // Random travel purpose
                'arrival' => $faker->date(),  // Random arrival date
                'departure' => $faker->date(),  // Random departure date (nullable if not applicable)
                'visa_start' => $faker->date(),  // Random visa start date
                'visa_expiry' => $faker->date(),  // Random visa expiry date
                'visa_type' => $faker->randomElement(['Tourist', 'Business', 'Student']),  // Random visa type
                'created_at' => now(),  // Current timestamp
                'updated_at' => now(),  // Current timestamp
            ]

            // Add more records as needed
        ]);
    }
}

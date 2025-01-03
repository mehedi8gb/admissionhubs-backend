<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class WorkDetailsSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create(); // Create Faker instance

        DB::table('work_details')->insert([
            [
                'user_id' => 1, // Associate with the first user (you can change this as needed)
                'job_title' => $faker->jobTitle,  // Random job title
                'organization' => $faker->company,  // Random company name
                'address' => $faker->address,  // Random address
                'phone' => $faker->phoneNumber,  // Random phone number
                'from_date' => $faker->date,  // Random start date
                'to_date' => $faker->date,    // Random end date (nullable)
                'active' => $faker->boolean,  // Random active status (true/false)
                'currently_working' => $faker->boolean,  // Random currently working status (true/false)
                'created_at' => now(),  // Current timestamp
                'updated_at' => now(),  // Current timestamp
            ],
            [
                'user_id' => 2,  // Associate with the second user
                'job_title' => $faker->jobTitle,
                'organization' => $faker->company,
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'from_date' => $faker->date,
                'to_date' => $faker->date,
                'active' => $faker->boolean,
                'currently_working' => $faker->boolean,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more records as needed
        ]);
    }
}

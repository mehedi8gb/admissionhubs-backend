<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class AssignStaffSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create(); // Create Faker instance

        DB::table('assign_staff')->insert([
            [
                'staffid' => 1, // Associate with the first staff (you can change this as needed)
                'type' => $faker->randomElement(['Counselor', 'Administrator', 'Instructor', 'Manager']), // Random role type
                'created_at' => now(), // Current timestamp
                'updated_at' => now(), // Current timestamp
            ],
            [
                'staffid' => 2, // Associate with the second staff
                'type' => $faker->randomElement(['Counselor', 'Administrator', 'Instructor', 'Manager']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more records as needed
        ]);
    }
}

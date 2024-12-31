<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;




class EmergencyContactSeeder extends Seeder
{
    public function run()
    {
        // Create a Faker instance to generate fake data
        $faker = Faker::create();

        // Insert emergency contact data
        DB::table('emergency_contacts')->insert([
            [
                'user_id' => 1, // Associate with the first user (you can change this as needed)
                'name' => $faker->name,  // Faker generated name
                'phone' => $faker->phoneNumber,  // Faker generated phone number
                'email' => $faker->unique()->safeEmail,  // Faker generated unique email
                'address' => $faker->address,  // Faker generated address
                'relationship' => $faker->randomElement(['Brother', 'Spouse', 'Friend', 'Parent']), // Random relationship
                'status' => $faker->randomElement(['Active', 'Inactive']),  // Random status (Active or Inactive)
                'created_at' => now(),  // Current timestamp
                'updated_at' => now(),  // Current timestamp
            ],
            [
                'user_id' => 2,  // Associate with the second user
                'name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'address' => $faker->address,
                'relationship' => $faker->randomElement(['Brother', 'Spouse', 'Friend', 'Parent']),
                'status' => $faker->randomElement(['Active', 'Inactive']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more records as needed
        ]);
    }
}

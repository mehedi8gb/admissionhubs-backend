<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create demo Admin
        $superAgent = User::factory()->create([
            'email' => 'admin@demo.com',
        ]);
        $superAgent->assignRole('admin');

        // Create demo Agent
        $superAgent = User::factory()->create([
            'email' => 'agent@demo.com',
        ]);
        $superAgent->assignRole('agent');

        // create demo student account
        $student = User::factory()->create([
            'email' => 'student@demo.com',
        ]);
        $student->assignRole('student');

        // create demo staff account
        $staff = User::factory()->create([
            'email' => 'staff@demo.com',
        ]);
        $staff->assignRole('staff');

        // create demo university account
        $university = User::factory()->create([
            'email' => 'university@demo.com',
        ]);
        $university->assignRole('university');

        // Create Agents
        User::factory()
            ->count(5)
            ->create()
            ->each(function ($user) {
                $user->assignRole('agent');
            });

        // Create Students
        User::factory()
            ->count(10)
            ->create()
            ->each(function ($user) {
                $user->assignRole('student');
            });

        // Create Universities
        User::factory()
            ->count(3)
            ->create()
            ->each(function ($user) {
                $user->assignRole('university');
            });

        // Create Staff
        User::factory()
            ->count(5)
            ->create()
            ->each(function ($user) {
                $user->assignRole('staff');
            });
    }
}

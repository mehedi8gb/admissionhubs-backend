<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = [
            'Computer Science',
            'Computer Engineering',
            'Electrical Engineering',
            'Mechanical Engineering',
            'Civil Engineering',
            'Petroleum Engineering',
            'Chemical Engineering',
            'Agricultural Engineering',
            'Agricultural Science',
            'Agricultural Economics',
            'Agricultural Extension',
            'Agricultural Education',
            'Agricultural Engineering',
            'Agricultural Science',
            'Agricultural Economics',
            'Agricultural Extension',
            'Agricultural Education',
            'Agricultural Engineering',
            'Agricultural Science',
            'Agricultural Economics',
            'Agricultural Extension',
            'Agricultural Education',
            'Agricultural Engineering',
            'Agricultural Science',
            'Agricultural Economics',
            'Agricultural Extension',
            'Agricultural Education',
            'Agricultural Engineering',
            'Agricultural Science',
            'Agricultural Economics',
            'Agricultural Extension',
            'Agricultural Education',
            'Agricultural Engineering',
            'Agricultural Science',
            'Agricultural Economics',
            'Agricultural Extension',
            'Agricultural Education',
            'Agricultural Engineering',
            'Agricultural Science',
            'Agricultural Economics',
            'Agricultural Extension',
            'Agricultural Education',
            'Agricultural Engineering',
            'Agricultural Science',
            'Agricultural Economics',
            'Agricultural Extension',
            'Agricultural Education',
            'Agricultural Engineering',
            'Agricultural Science',
            'Agricultural Economics',
            'Agricultural Extension',
            'Agricultural Education',
            'Agricultural Engineering',
            'Agricultural Science',
            'Agricultural Economics',
            'Agricultural Extension',
            'Agricultural Education',
        ];

        foreach ($name as $course) {
            Course::factory()->create([
                'course_data' => [
                    'name' => $course
                ],
            ]);
        }
    }
}

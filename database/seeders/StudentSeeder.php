<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\EmergencyContact;
use App\Models\Application;
use App\Models\AcademicHistory;
use App\Models\TravelHistory;
use App\Models\RefuseHistory;
use App\Models\WorkDetail;
use App\Models\AssignStaff;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Student::factory(10)->create()->each(function ($student) {
            EmergencyContact::factory(rand(2, 7))->create(['student_id' => $student->id]);
            Application::factory(rand(2, 7))->create(['student_id' => $student->id]);
            AcademicHistory::factory(rand(2, 7))->create(['student_id' => $student->id]);
            TravelHistory::factory(rand(2, 7))->create(['student_id' => $student->id]);
            RefuseHistory::factory(rand(2, 7))->create(['student_id' => $student->id]);
            WorkDetail::factory(rand(2, 7))->create(['student_id' => $student->id]);
            AssignStaff::factory(rand(2, 7))->create(['student_id' => $student->id]);
        });

        echo "\n";
    }
}

<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\EnglishLanguageExam;
use App\Models\Passport;
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
        Student::factory(50)->create()->each(function ($student) {
            EmergencyContact::factory(rand(2, 7))->create(['student_id' => $student->id]);
            Application::factory(rand(2, 7))->create(['student_id' => $student->id]);
            AcademicHistory::factory(rand(2, 7))->create(['student_id' => $student->id]);
            TravelHistory::factory(rand(2, 7))->create(['student_id' => $student->id]);
            RefuseHistory::factory(rand(2, 7))->create(['student_id' => $student->id]);
            WorkDetail::factory(rand(2, 7))->create(['student_id' => $student->id]);
            AssignStaff::factory(rand(2, 7))->create(['student_id' => $student->id]);
            EnglishLanguageExam::factory(rand(2, 7))->create(['student_id' => $student->id]);
//            Address::factory(rand(2, 4))->create(['student_id' => $student->id]);
//            Passport::factory(rand(1, 3))->create(['student_id' => $student->id]);
        });

        echo "\n";
    }
}

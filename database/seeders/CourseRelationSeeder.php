<?php

namespace Database\Seeders;

use App\Models\CourseRelation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CourseRelation::factory()->count(10)->create();
    }
}

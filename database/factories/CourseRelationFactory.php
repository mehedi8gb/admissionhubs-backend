<?php

namespace Database\Factories;

use App\Models\CourseRelation;
use App\Models\Institute;
use App\Models\Course;
use App\Models\Term;
use App\Models\AcademicYear;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseRelationFactory extends Factory
{
    protected $model = CourseRelation::class;

    public function definition()
    {
        return [
            'institute_id' => Institute::inRandomOrder()->first()->id,
            'course_id' => Course::inRandomOrder()->first()->id,
            'term_id' => Term::inRandomOrder()->first()->id,
            'academic_year_id' => AcademicYear::inRandomOrder()->first()->id,
            'local' => $this->faker->boolean(),
            'local_amount' => $this->faker->randomFloat(2, 100, 1000),
            'international' => $this->faker->boolean(),
            'international_amount' => $this->faker->randomFloat(2, 200, 2000),
            'status' => $this->faker->boolean(),
        ];
    }
}


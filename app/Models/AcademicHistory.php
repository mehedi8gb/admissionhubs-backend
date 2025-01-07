<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicHistory extends Model
{
   use hasFactory;

    protected $fillable = [
        'student_id',
        'institution',
        'course',
        'academic_year_id',
        'term_id',
        'studyLevel',
        'resultScore',
        'outOf',
        'startDate',
        'endDate',
        'status',
    ];

    protected $with = ['academicYear', 'term'];

//    public function student(): BelongsTo
//    {
//        return $this->belongsTo(Student::class, 'id');
//    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class, 'term_id');
    }
}

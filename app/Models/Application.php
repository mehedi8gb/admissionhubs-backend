<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'institute_id',
        'course_id',
        'term_id',
        'type',
        'amount',
        'status',
    ];

    protected $with = ['institute', 'course', 'term'];

//    public function student(): BelongsTo
//    {
//        return $this->belongsTo(Student::class, 'id');
//    }

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class, 'institute_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class, 'term_id');
    }
}

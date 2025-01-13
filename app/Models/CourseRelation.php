<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseRelation extends Model
{
    use HasFactory;

    protected $fillable = [
        'institute_id',
        'course_id',
        'term_id',
        'local',
        'local_amount',
        'international',
        'international_amount',
        'status',
    ];

    protected $casts = [
        'local' => 'boolean',
        'international' => 'boolean',
        'status' => 'boolean',
    ];

    protected $with = ['institute', 'course', 'term'];

    // Relationship to Institute
    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    // Relationship to Course
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    // Relationship to Term
    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }
}


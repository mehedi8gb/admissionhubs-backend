<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'institute_id',
        'course_id',
        'term_id',
        'choice',
        'amount',
        'status',
    ];

    protected $with = ['institute', 'course', 'term', 'statusLogs'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

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

    public function statusLogs(): HasMany
    {
        return $this->hasMany(ApplicationStatusLog::class, 'application_id');
    }

    // Log status change
    public static function logApplicationStatusChange($changedTo, $application): void
    {
        // Create a new log entry
        ApplicationStatusLog::create([
            'application_id' => $application->id,
            'prev_status' => $application->status,
            'assigned_by' => auth()->id(),
            'assigned_at' => $application->assigned_at ?? now(),
            'changed_to' => $changedTo,
            'changed_by' => auth()->id(),
            'changed_at' => now(), // Use current timestamp
        ]);
    }
}

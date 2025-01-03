<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'created_by', // User ID who created the record
        'academic_year_id', // Academic year the student is enrolled in
        'term_id', // Academic term the student is in
//        'institute_id', // Institute name
        'status', // Student's status
        'ref_id', // Unique reference ID for the student
        'name', // Student's name
        'email', // Student's email address
        'phone', // Student's phone number
        'dob', // Student's date of birth
        'agent', // Agent information (if any)
        'staff', // Staff assigned to the student (if any)
        'student_data', // JSON column containing the entire student object
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'student_data' => 'array', // Automatically casts JSON data to an array
        'dob' => 'date', // Cast date of birth to a date type
    ];

    /**
     * The attributes that should be indexed.
     *
     * @var array<int, string>
     */
    protected array $indexes = [
        'created_by',
        'status',
        'ref_id',
        'name',
        'email',
        'phone',
        'dob',
        'academic_year_id',
        'term_id',
//        'institute_id',
        'agent',
        'staff',
    ];

    protected $with = [
        'createdBy',
        'academicYear',
        'term',
        'documents',
        'applications',
        'assignStaffs',
        'workDetails',
        'academicHistories',
        'refuseHistories',
        'travelHistories',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($student) {
            $latestStudent = self::latest('id')->first();
            $nextId = $latestStudent ? $latestStudent->id + 1 : 1;
            $student->ref_id = sprintf('STD%05d', $nextId);
        });
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }
//
//    public function institute(): BelongsTo
//    {
//        return $this->belongsTo(Institute::class);
//    }

    public function emergencyContacts(): HasMany
    {
        return $this->hasMany(EmergencyContact::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(File::class);
    }

    public function assignStaffs(): HasMany
    {
        return $this->hasMany(AssignStaff::class);
    }

    public function workDetails(): HasMany
    {
        return $this->hasMany(WorkDetail::class);
    }

    public function academicHistories(): HasMany
    {
        return $this->hasMany(AcademicHistory::class);
    }

    public function refuseHistories(): HasMany
    {
        return $this->hasMany(RefuseHistory::class);
    }

    public function travelHistories(): HasMany
    {
        return $this->hasMany(TravelHistory::class);
    }
}

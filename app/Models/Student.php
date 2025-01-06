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
        'ref_id', // Unique reference ID for the student
        'term_id', // Academic term the student is in
        'status', // Student's status
        'name', // Student's name
        'email', // Student's email address
        'phone', // Student's phone number
        'dob', // Student's date of birth
        'agent', // Agent information (if any)
        'staff', // Staff assigned to the student (if any)
        'student_data', // JSON column containing the entire student object
        'maritual_status', // Marital status of the student
        'gender', // Gender of the student
        'nationality', // Nationality of the student
        'country_residence', // Country of residence
        'country_birth', // Country of birth
        'native_language', // Native language of the student

//        'visa_need', // Whether the student needs a visa
//        'refused_permission', // Whether the student has refused permission
//        'english_language_required', // Whether English language proficiency is required
//        'academic_history_required', // Whether academic history is required
//        'work_experience', // Whether work experience is required
//        'ukinpast', // Whether the student has been in the UK in the past
//        'maritual_status', // Marital status of the student
//        'gender_identity', // Gender identity of the student
//        'sexual_orientation', // Sexual orientation of the student
//        'religion', // Religion of the student
//        'ethnicity', // Ethnicity of the student
//        'disabilities', // Disabilities of the student
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
        'englishLanguageExams'
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

    public function englishLanguageExams(): HasMany
    {
        return $this->hasMany(EnglishLanguageExam::class);
    }
}

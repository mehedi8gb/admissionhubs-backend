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
        'studyLevel',
        'resultScore',
        'outOf',
        'startDate',
        'endDate',
        'status',
    ];


//    public function student(): BelongsTo
//    {
//        return $this->belongsTo(Student::class, 'id');
//    }
}

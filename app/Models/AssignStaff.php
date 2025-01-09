<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignStaff extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'staffId',
        'status'
    ];

    protected $with = ['staff'];
//    public function student(): BelongsTo
//    {
//        return $this->belongsTo(Student::class);
//    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'staffId');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RefuseHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'refusalType',
        'refusalDate',
        'details',
        'country',
        'visaType',
        'status',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}

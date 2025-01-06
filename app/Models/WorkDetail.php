<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkDetail extends Model
{
    use hasFactory;

    protected $fillable = [
        'student_id',
        'jobTitle',
        'organization',
        'address',
        'phone',
        'fromDate',
        'toDate',
        'status',
        'currentlyWorking',
    ];
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}

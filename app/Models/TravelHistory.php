<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelHistory extends Model
{
    protected $fillable = [
        'student_id',
        'country',
        'city',
        'reason',
        'date',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

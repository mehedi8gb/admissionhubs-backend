<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkDetail extends Model
{
    protected $fillable = [
        'student_id',
        'company_name',
        'company_address',
        'company_phone',
        'company_email',
        'supervisor_name',
        'supervisor_phone',
        'supervisor_email',
        'job_title',
        'job_description',
        'start_date',
        'end_date',
        'status',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}

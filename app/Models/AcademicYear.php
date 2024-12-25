<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $fillable = [
        'academic_year',
        'status',
    ];

    protected $casts = [
        'academic_year' => 'string',
        'status' => 'boolean',
    ];
}

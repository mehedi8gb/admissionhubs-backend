<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'course_data',
        'status',
    ];

    protected $casts = [
        'course_data' => 'array',
        'status' => 'boolean',
    ];
}

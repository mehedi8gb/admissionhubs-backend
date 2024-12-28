<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_data',
        'status',
    ];

    protected $casts = [
        'course_data' => 'array',
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class AcademicYear extends Model
{
    use HasFactory;
    protected $fillable = [
        'academic_year',
        'status',
    ];

    protected $casts = [
        'academic_year' => 'string',
        'status' => 'boolean',
    ];
}

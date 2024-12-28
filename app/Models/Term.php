<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Term extends Model
{
    use HasFactory;
    protected $fillable = [
        'academic_year_id',
        'term_data',
        'status',
    ];

    protected $casts = [
        'term_data' => 'array',
        'status' => 'boolean',
    ];

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }
}

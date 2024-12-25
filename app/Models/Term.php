<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $fillable = [
        'term_data',
        'status',
    ];

    protected $casts = [
        'term_data' => 'array',
        'status' => 'boolean',
    ];
}

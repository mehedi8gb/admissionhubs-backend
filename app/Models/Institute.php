<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Institute extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}

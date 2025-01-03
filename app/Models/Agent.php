<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'organization',
        'contact_person',
        'location',
        'status',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

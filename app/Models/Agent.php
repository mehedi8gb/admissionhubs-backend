<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Agent extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'agentName',
        'contactPerson',
        'email',
        'location',
        'nominatedStaff',
        'organization',
        'phone',
        'password',
        'status',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function nominatedStaff(): HasOne
    {
        return $this->hasOne(Staff::class, 'id', 'nominatedStaff');
    }
}

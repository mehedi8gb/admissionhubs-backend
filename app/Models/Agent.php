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
        'agent_name',
        'contact_person',
        'email',
        'location',
        'nominated_staff',
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
        return $this->hasOne(Staff::class, 'id', 'nominated_staff');
    }
}

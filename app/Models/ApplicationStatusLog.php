<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationStatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'prev_status',
        'assigned_by',
        'assigned_at',
        'changed_to',
        'changed_by',
        'changed_at',
    ];

    protected $with = [
        'assignedBy',
        'changedBy',
    ];
//
//    // Define relationship to the Application model
//    public function application(): BelongsTo
//    {
//        return $this->belongsTo(Application::class, 'application_id');
//    }

    // Define relationship to the User model
    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    // Define relationship to the User model
    public function changedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id');
    }
}

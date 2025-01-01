<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TravelHistory extends Model
{
    use hasFactory;

    protected $fillable = [
        'student_id',
        'purpose',
        'arrival',
        'departure',
        'visaStart',
        'visaExpiry',
        'visaType',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}

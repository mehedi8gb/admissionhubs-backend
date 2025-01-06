<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passport extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'passport_name', 'passport_issue_location',
        'passport_number', 'passport_issue_date', 'passport_expiry_date',
    ];
}

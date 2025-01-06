<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'addressLine1', 'addressLine2', 'townCity',
        'state', 'postCode', 'country',
    ];
}

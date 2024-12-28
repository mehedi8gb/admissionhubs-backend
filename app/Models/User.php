<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 *
 *
 * @property int $id
 * @property string $academic_year
 * @property bool|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Database\Factories\AcademicYearFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicYear newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicYear newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicYear query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicYear whereAcademicYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicYear whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicYear whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicYear whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicYear whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AcademicYear inRandomOrder()
 */

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasRoles;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'email' => $this->email,
            'name' => $this->name,
            'role' => $this->getRoleNames()->first(), // Fetches the first role name as a string
        ];
    }


    public function getProfilePhotoUrlAttribute(): Application|string|\Illuminate\Contracts\Routing\UrlGenerator|null
    {
        return $this->profile_photo_path
            ? url('storage/' . $this->profile_photo_path)
            : null;
    }
}

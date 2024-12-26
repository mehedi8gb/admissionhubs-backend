<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'created_by', // User ID who created the record
        'student_data', // JSON column containing the entire student object
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'student_data' => 'array', // Automatically casts JSON data to an array
    ];

    /**
     * Get a specific field from the student_data JSON.
     *
     * @param string $key
     * @return mixed|null
     */
    public function getDataField(string $key): mixed
    {
        return $this->student_data[$key] ?? null;
    }

    /**
     * Set a specific field in the student_data JSON.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setDataField(string $key, $value): void
    {
        $data = $this->student_data;
        $data[$key] = $value;
        $this->student_data = $data;
        $this->save();
    }

    /**
     * Scopes a query to search by a specific key in student_data.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $key
     * @param mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchDataField($query, $key, $value)
    {
        return $query->where("student_data->{$key}", $value);
    }

    /**
     * Scopes a query to filter students created by a specific user.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCreatedBy($query, int $userId)
    {
        return $query->where('created_by', $userId);
    }
}

<?php

namespace App\Http\Resources;

use App\Traits\ConvertsStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $course = $this->course_data;

        return [
            'id' => $this->id,
            'name' => $course['name'],
            'status' => convertStatus($this->status),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}

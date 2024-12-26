<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AcademicYearResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'academic_year' => $this->academic_year,
            'status' => convertStatus($this->status),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}

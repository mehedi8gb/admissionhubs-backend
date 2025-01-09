<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AcademicHistoryResource extends JsonResource
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
            'institution' => $this->institution,
            'course' => $this->course,
            'academicYear' => $this->academicYear,
            'term' => TermResource::make($this->term),
            'studyLevel' => $this->studyLevel,
            'resultScore' => $this->resultScore,
            'outOf' => $this->outOf,
            'startDate' => $this->startDate,
            'endDate' => $this->endDate,
            'status' => convertStatus($this->status),
        ];
    }
}

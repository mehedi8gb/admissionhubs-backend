<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseRelationResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'institute' => new InstituteResource($this->institute),
            'course' => new CourseResource($this->course),
            'term' => new TermResource($this->term),
            'academic_year' => new AcademicYearResource($this->academicYear),
            'local' => $this->local,
            'local_amount' => $this->local_amount,
            'international' => $this->international,
            'international_amount' => $this->international_amount,
            'status' => $this->status,
        ];
    }
}


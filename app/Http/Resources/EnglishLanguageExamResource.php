<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EnglishLanguageExamResource extends JsonResource
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
            'exam' => $this->exam,
            'examDate' => $this->examDate,
            'score' => $this->score,
            'status' => convertStatus($this->status),
        ];
    }
}

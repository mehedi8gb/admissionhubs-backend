<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TermResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $term = $this->term_data;

        return [
            'id' => $this->id,
            'term' => $term['term'],
            'academic_year' => $term['academic_year'],
            'status' => convertStatus($this->status),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}

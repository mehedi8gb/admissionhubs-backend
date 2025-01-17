<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RefuseHistoryResource extends JsonResource
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
            'refusalType' => $this->refusalType,
            'refusalDate' => $this->refusalDate,
            'details' => $this->details,
            'country' => $this->country,
            'visaType' => $this->visaType,
            'status' => convertStatus($this->status),
        ];
    }
}

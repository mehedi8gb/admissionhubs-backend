<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TravelHistoryResource extends JsonResource
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
            'purpose' => $this->purpose,
            'arrival' => $this->arrival,
            'departure' => $this->departure,
            'visaStart' => $this->visaStart,
            'visaExpiry' => $this->visaExpiry,
            'visaType' => $this->visaType,
            'status' => convertStatus($this->status),
        ];
    }
}

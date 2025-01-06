<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkDetailResource extends JsonResource
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
            'jobTitle' => $this->jobTitle,
            'organization' => $this->organization,
            'address' => $this->address,
            'phone' => $this->phone,
            'fromDate' => $this->fromDate,
            'toDate' => $this->toDate,
            'currentlyWorking' => $this->currentlyWorking,
            'status' => convertStatus($this->status),
        ];
    }
}

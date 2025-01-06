<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
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
            'addressLine1' => $this->addressLine1,
            'addressLine2' => $this->addressLine2,
            'townCity' => $this->townCity,
            'state' => $this->state,
            'postCode' => $this->postCode,
            'country' => $this->country,
        ];
    }
}

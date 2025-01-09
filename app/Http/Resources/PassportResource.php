<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PassportResource extends JsonResource
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
            'passportName' => $this->passportName,
            'passportIssueLocation' => $this->passportIssueLocation,
            'passportNumber' => $this->passportNumber,
            'passportIssueDate' => $this->passportIssueDate,
            'passportExpiryDate' => $this->passportExpiryDate,
        ];
    }
}

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
            'passportName' => $this->passport_name,
            'passportIssueLocation' => $this->passport_issue_location,
            'passportNumber' => $this->passport_number,
            'passportIssueDate' => $this->passport_issue_date,
            'passportExpiryDate' => $this->passport_expiry_date,
        ];
    }
}

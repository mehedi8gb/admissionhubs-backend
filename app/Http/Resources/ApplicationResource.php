<?php


namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    public function toArray($request)
    {
        // Since this is an array, you can directly return the array as response
        return [
            'id' => $this->id,
            'institution' => $this->institution,
            'course' => $this->course,
            'term' => $this->term,
            'type' => $this->type,
            'amount' => $this->amount,
            'status' => convertStatus($this->status)
        ];
    }
}

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
            'institution' => $this->resource['institution'] ?? null,  // Using array access
            'course' => $this->resource['course'] ?? null,
            'term' => $this->resource['term'] ?? null,
            'type' => $this->resource['type'] ?? null,
            'amount' => $this->resource['amount'] ?? null,
            'status' => $this->resource['status'] ?? null,
            'created_at' => $this->resource['created_at'] ?? null,
            'updated_at' => $this->resource['updated_at'] ?? null,
        ];
    }
}

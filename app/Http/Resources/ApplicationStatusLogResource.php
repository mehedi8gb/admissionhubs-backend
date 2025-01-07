<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationStatusLogResource extends JsonResource
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
            'prev_status' => $this->prev_status,
            'assigned_by' => UserResource::make($this->assignedBy),
            'changed_by' => UserResource::make($this->changedBy),
            'assigned_at' => $this->assigned_at,
            'changed_to' => $this->changed_to,
            'created_at' => $this->created_at,
        ];
    }
}

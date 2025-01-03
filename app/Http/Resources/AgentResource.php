<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AgentResource extends JsonResource
{
    public function toArray($request): array
    {
        $agent = $this->resource->user;

        return [
            'id' => $this->id,
            'agent_name' => $agent->name,
            'organization' => $this->organization,
            'contact_person' => $this->contact_person,
            'phone' => $agent->phone,
            'email' => $agent->email,
            'location' => $this->location,
            'status' => convertStatus($this->status),
        ];
    }
}

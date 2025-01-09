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
            'agentName' => $this->agent_name,
            'contactPerson' => $this->contact_person,
            'email' => $this->email,
            'location' => $this->location,
            'organization' => $this->organization,
            'phone' => $this->phone,
//            'user' => UserResource::make($this->user),
            'nominatedStaff' => StaffResource::make($this->nominatedStaff), // Related staff resource
            'createdAt' => $this->created_at->toDateTimeString(),
            'updatedAt' => $this->updated_at->toDateTimeString(),
            'status' => convertStatus($this->status),
        ];
    }
}

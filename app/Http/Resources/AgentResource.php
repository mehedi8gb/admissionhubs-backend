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
            'agent_name' => $this->agent_name,
            'contact_person' => $this->contact_person,
            'email' => $this->email,
            'location' => $this->location,
            'organization' => $this->organization,
            'phone' => $this->phone,
//            'user' => UserResource::make($this->user),
            'nominated_staff' => StaffResource::make($this->nominatedStaff), // Related staff resource
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'status' => convertStatus($this->status),
        ];
    }
}

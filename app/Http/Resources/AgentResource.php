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
            'agentName' => $this->agentName,
            'contactPerson' => $this->contactPerson,
            'email' => $this->email,
            'location' => $this->location,
            'organization' => $this->organization,
            'phone' => $this->phone,
//            'user' => UserResource::make($this->user),
            'nominatedStaff' => StaffResource::make($this->nominatedStaff), // Related staff resource
            'status' => convertStatus($this->status),
        ];
    }
}

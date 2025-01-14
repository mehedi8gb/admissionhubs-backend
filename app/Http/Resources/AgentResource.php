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
            'agentName' => $this->user->name,
            'contactPerson' => $this->contactPerson,
            'email' => $this->user->email,
            'location' => $this->location,
            'organization' => $this->organization,
            'phone' => $this->user->phone,
//            'user' => UserResource::make($this->user),
            'nominatedStaff' => $this->nominatedStaff ? StaffResource::make($this->nominatedStaff) : [],
            'status' => convertStatus($this->user->status),
        ];
    }
}

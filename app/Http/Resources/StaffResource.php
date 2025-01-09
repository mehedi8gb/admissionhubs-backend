<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
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
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'email' => $this->user->email,
            'phone' => $this->user->phone,
            'role' => $this->user->roles->first()->name,
            'status' => convertStatus($this->status),
//            'user' => UserResource::make($this->user),
        ];
    }
}

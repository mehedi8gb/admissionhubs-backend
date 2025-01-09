<?php

namespace App\Http\Requests;

use App\Models\Agent;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAgentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $agent = Agent::find($this->route('agent')); // Fetch the Agent instance (null if not found)
        $user = $agent?->user; // Fetch the User instance (null if not found)

        return [
            'agentName' => 'nullable|string|max:255',
            'contactPerson' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . ($user?->id ?? 'null'),
            'location' => 'nullable|string|max:255',
            'nominatedStaff' => 'nullable|exists:staffs,id',
            'organization' => 'nullable|string|max:255',
            'phone' => 'nullable|string|unique:users,phone,' . ($user?->id ?? 'null'),
            'password' => 'nullable|string|min:8', // Hash if provided
            'status' => 'nullable|boolean',
        ];
    }
}

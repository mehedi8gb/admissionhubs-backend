<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAgentRequest extends FormRequest
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
        return [
            'agentName' => 'required|string|max:255',
            'contactPerson' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'location' => 'nullable|string|max:255',
            'nominatedStaff' => 'nullable|exists:staffs,id',
            'organization' => 'nullable|string|max:255',
            'phone' => 'required|string|unique:users,phone',
            'password' => 'required|string|min:8',
            'status' => 'nullable|boolean',
        ];
    }
}

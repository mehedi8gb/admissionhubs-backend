<?php

namespace App\Http\Requests;

use App\Models\Staff;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules(): array
    {
        $staff = Staff::findOrFail($this->route('staff'));
        $user = $staff->user;

        return [
            'firstName' => 'nullable|string|max:255',
            'lastName' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email' . ($user->id ? ',' . $user->id : ''),
            'phone' => 'nullable|string|unique:users,phone' . ($user->id ? ',' . $user->id : ''),
            'password' => 'nullable|string|min:8',
            'status' => 'nullable|boolean',
        ];
    }
}

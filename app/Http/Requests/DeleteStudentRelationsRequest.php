<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class DeleteStudentRelationsRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'applications.*.id' => 'nullable|integer',
            'emergencyContact.*.id' => 'nullable|integer',
            'workDetails.*.id' => 'nullable|integer',
            'assignStaff.*.id' => 'nullable|integer',
            'academicHistory.*.id' => 'nullable|integer',
            'refuseHistory.*.id' => 'nullable|integer',
            'travelHistory.*.id' => 'nullable|integer',
            'passport.*.id' => 'nullable|integer',
            'address.*.id' => 'nullable|integer',
        ];
    }
}

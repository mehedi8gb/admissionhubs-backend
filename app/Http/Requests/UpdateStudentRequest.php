<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Update as per your authorization logic if needed.
    }

    public function rules(): array
    {
        $studentId = $this->route('student');

        return [
            'status' => 'nullable|boolean',
            'createdBy' => 'nullable|integer',
            'title' => 'nullable|string|max:255',
            'firstName' => 'nullable|string|max:255',
            'lastName' => 'nullable|string|max:255',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('students')->ignore($studentId, 'id') // Ignore the current student's email
            ],
            'phone' => 'nullable|string|max:20',
            'dob' => 'nullable|date_format:Y-m-d',
            'maritualStatus' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:50',
            'nationality' => 'nullable|string|max:255',
            'countryResidence' => 'nullable|string|max:255',
            'countryBirth' => 'nullable|string|max:255',
            'nativeLanguage' => 'nullable|string|max:255',
            'disabilities' => 'nullable|string|max:255',
            'ethnicity' => 'nullable|string|max:255',
            'genderIdentity' => 'nullable|string|max:255',
            'sexualOrientation' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'visaNeed' => 'nullable|boolean',

            'addressLine1' => 'nullable|string|max:255', // Address Line 1 is required
            'addressLine2' => 'nullable|string|max:255', // Address Line 2 is nullable
            'townCity' => 'nullable|string|max:255', // Town/City is required
            'state' => 'nullable|string|max:255', // State is required
            'postCode' => 'nullable|string|max:20', // Post Code is required
            'country' => 'nullable|string|max:255', // Country is required

            'passportName' => 'nullable|string|max:255',
            'passportIssueLocation' => 'nullable|string|max:255',
            'passportNumber' => 'nullable|string|max:255',
            'passportIssueDate' => 'nullable|date_format:Y-m-d',
            'passportExpiryDate' => 'nullable|date_format:Y-m-d',

            'refusedPermission' => 'nullable|boolean', // Refused permission flag
            'englishLanguageRequired' => 'nullable|boolean', // English language requirement
            'academicHistoryRequired' => 'nullable|boolean', // Academic history requirement
            'workExperience' => 'nullable|boolean', // Work experience flag
            'ukInPast' => 'nullable|boolean', // UK in the past flag
            'currentlyInUk' => 'nullable|boolean',

            'academicYearId' => 'nullable|integer',
            'termId' => 'nullable|integer',
        ];
    }
}

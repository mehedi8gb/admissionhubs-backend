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
            'dob' => 'nullable|date_format:d-m-Y',
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

            'refusedPermission' => 'nullable|boolean', // Refused permission flag
            'englishLanguageRequired' => 'nullable|boolean', // English language requirement
            'academicHistoryRequired' => 'nullable|boolean', // Academic history requirement
            'workExperience' => 'nullable|boolean', // Work experience flag
            'ukinpast' => 'nullable|boolean', // UK in the past flag

            'academicYearId' => 'nullable|integer',
            'termId' => 'nullable|integer',
        ];
    }
}

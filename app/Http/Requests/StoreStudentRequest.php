<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Update as per your authorization logic if needed.
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255', // Title is required
            'firstName' => 'required|string|max:255', // First Name is required
            'lastName' => 'required|string|max:255', // Last Name is required
            'email' => 'required|email|max:255|unique:students,student_data->email', // Email is required and unique
            'phone' => 'required|string|max:20', // Phone is required
            'dob' => 'required|date_format:d-m-Y', // Date of Birth is required
            'maritualStatus' => 'required|string|max:255', // Marital Status is required
            'addressLine1' => 'required|string|max:255', // Address Line 1 is required
            'townCity' => 'required|string|max:255', // Town/City is required
            'state' => 'required|string|max:255', // State is required
            'postCode' => 'required|string|max:20', // Post Code is required
            'country' => 'required|string|max:255', // Country is required
            'gender' => 'required|string|max:50',

            'claimDisabilities' => 'nullable|string', // Claim Disabilities is required
            'disabilitiesOption' => 'nullable|string|max:255', // Disabilities Option is required

            'passportName' => 'nullable|string|max:255',
            'passportIssueLocation' => 'nullable|string|max:255',
            'passportNumber' => 'nullable|string|max:255',
            'passportIssueDate' => 'nullable|date_format:d-m-Y',
            'passportExpiryDate' => 'nullable|date_format:d-m-Y',

            // All other fields remain nullable
            'status' => 'nullable|boolean', // Status is nullable
            'addressLine2' => 'nullable|string|max:255', // Address Line 2 is nullable
            'disabilities' => 'nullable|string|max:255',
            'nativeLanguage' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'ethnicity' => 'nullable|string|max:255',
            'genderIdentity' => 'nullable|string|max:255',
            'sexualOrientation' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'visaNeed' => 'nullable|boolean',
            'refusedPermission' => 'nullable|boolean', // Refused permission flag
            'englishLanguageRequired' => 'nullable|boolean', // English language requirement
            'academicHistoryRequired' => 'nullable|boolean', // Academic history requirement
            'workExperience' => 'nullable|boolean', // Work experience flag
            'ukInPast' => 'nullable|boolean', // UK in the past flag
            'currentlyInUk' => 'nullable|boolean', // Currently in UK flag
            'academicYearId' => 'nullable|integer',
            'termId' => 'nullable|integer',
        ];
    }
}

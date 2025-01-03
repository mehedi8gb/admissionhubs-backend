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
            'gender' => 'required|string|max:50', // Gender is required
            'maritualStatus' => 'required|string|max:255', // Marital Status is required
            'addressLine1' => 'required|string|max:255', // Address Line 1 is required
            'addressLine2' => 'nullable|string|max:255', // Address Line 2 is nullable
            'townCity' => 'required|string|max:255', // Town/City is required
            'state' => 'required|string|max:255', // State is required
            'postCode' => 'required|string|max:20', // Post Code is required
            'country' => 'required|string|max:255', // Country is required

            // All other fields remain nullable
            'status' => 'nullable|boolean', // Status is nullable
            'nativeLanguage' => 'nullable|string|max:255',
            'passportName' => 'nullable|string|max:255',
            'passportIssueLocation' => 'nullable|string|max:255',
            'passportNumber' => 'nullable|string|max:255',
            'passportIssueDate' => 'nullable|date_format:d-m-Y',
            'passportExpiryDate' => 'nullable|date_format:d-m-Y',
            'disabilities' => 'nullable|string|max:255',
            'ethnicity' => 'nullable|string|max:255',
            'genderidentity' => 'nullable|string|max:255',
            'sexualOrientation' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',
            'visaNeed' => 'nullable|boolean',
        ];
    }
}

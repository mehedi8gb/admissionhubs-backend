<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Update as per your authorization logic if needed.
    }

    public function rules(): array
    {
        return [
            'status' => 'nullable|boolean',
            'createdBy' => 'nullable|integer',
            'title' => 'nullable|string|max:255',
            'firstName' => 'nullable|string|max:255',
            'lastName' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255|unique:students,student_data->email',
            'phone' => 'nullable|string|max:20',
            'dob' => 'nullable|date_format:d-m-Y',
            'maritualStatus' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:50',
            'nationality' => 'nullable|string|max:255',
            'countryResidence' => 'nullable|string|max:255',
            'countryBirth' => 'nullable|string|max:255',
            'nativeLanguage' => 'nullable|string|max:255',
            'passportName' => 'nullable|string|max:255',
            'passportIssueLocation' => 'nullable|string|max:255',
            'passportNumber' => 'nullable|string|max:255',
            'passportIssueDate' => 'nullable|date_format:d-m-Y',
            'passportExpiryDate' => 'nullable|date_format:d-m-Y',
            'addressLine1' => 'nullable|string|max:255',
            'addressLine2' => 'nullable|string|max:255',
            'townCity' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postCode' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'disabilities' => 'nullable|string|max:255',
            'ethnicity' => 'nullable|string|max:255',
            'genderidentity' => 'nullable|string|max:255',
            'sexualOrientation' => 'nullable|string|max:255',
            'religion' => 'nullable|string|max:255',


            'visaNeed' => 'nullable|boolean',




        ];
    }
}

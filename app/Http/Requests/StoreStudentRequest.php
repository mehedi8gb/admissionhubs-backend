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
            'emergencyContact' => 'nullable|array',
            'emergencyContact.*.name' => 'required_with:emergencyContact|string|max:255',
            'emergencyContact.*.phone' => 'required_with:emergencyContact|string|max:20',
            'emergencyContact.*.email' => 'nullable|email|max:255',
            'emergencyContact.*.address' => 'nullable|string|max:255',
            'emergencyContact.*.relationship' => 'nullable|string|max:255',
            'emergencyContact.*.status' => 'nullable|string|max:50',
            'travelHistory' => 'nullable|array',
            'travelHistory.*.purpose' => 'nullable|string|max:255',
            'travelHistory.*.arrival' => 'nullable|date_format:d-m-Y',
            'travelHistory.*.departure' => 'nullable|date_format:d-m-Y',
            'travelHistory.*.visaStart' => 'nullable|date_format:d-m-Y',
            'travelHistory.*.visaExpiry' => 'nullable|date_format:d-m-Y',
            'travelHistory.*.visaType' => 'nullable|string|max:255',
            'visaNeed' => 'nullable|boolean',
            'refuseHistory' => 'nullable|array',
            'refuseHistory.*.refusaltype' => 'nullable|string|max:255',
            'refuseHistory.*.refusalDate' => 'nullable|date_format:d-m-Y',
            'refuseHistory.*.details' => 'nullable|string|max:1000',
            'refuseHistory.*.country' => 'nullable|string|max:255',
            'refuseHistory.*.visaType' => 'nullable|string|max:255',
            'refuseHistory.*.status' => 'nullable|string|max:50',
            'academicHistory' => 'nullable|array',
            'academicHistory.*.institution' => 'nullable|string|max:255',
            'academicHistory.*.course' => 'nullable|string|max:255',
            'academicHistory.*.studylevel' => 'nullable|string|max:255',
            'academicHistory.*.resultScore' => 'nullable|numeric',
            'academicHistory.*.outof' => 'nullable|numeric',
            'academicHistory.*.startDate' => 'nullable|date_format:d-m-Y',
            'academicHistory.*.endDate' => 'nullable|date_format:d-m-Y',
            'academicHistory.*.status' => 'nullable|string|max:50',
            'workDetails' => 'nullable|array',
            'workDetails.*.jobtitle' => 'nullable|string|max:255',
            'workDetails.*.organization' => 'nullable|string|max:255',
            'workDetails.*.address' => 'nullable|string|max:255',
            'workDetails.*.phone' => 'nullable|string|max:20',
            'workDetails.*.fromDate' => 'nullable|date_format:d-m-Y',
            'workDetails.*.toDate' => 'nullable|date_format:d-m-Y',
            'workDetails.*.active' => 'nullable|boolean',
            'workDetails.*.currentlyWorking' => 'nullable|boolean',
            'documents' => 'nullable|array',
            'documents.passport' => 'nullable|string|max:255',
            'documents.bankstatement' => 'nullable|string|max:255',
            'documents.qualification' => 'nullable|string|max:255',
            'documents.workExperience' => 'nullable|string|max:255',
            'documents.cv' => 'nullable|string|max:255',
            'application' => 'nullable|array',
            'application.*.institution' => 'nullable|string|max:255',
            'application.*.course' => 'nullable|string|max:255',
            'application.*.term' => 'nullable|string|max:255',
            'application.*.type' => 'nullable|string|max:255',
            'application.*.amount' => 'nullable|numeric',
            'application.*.status' => 'nullable|string|max:50',
            'assignStaff' => 'nullable|array',
            'assignStaff.*.staffid' => 'nullable|integer',
            'assignStaff.*.type' => 'nullable|string|max:255',
        ];
    }
}

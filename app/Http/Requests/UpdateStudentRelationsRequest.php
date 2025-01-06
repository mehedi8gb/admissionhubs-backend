<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRelationsRequest extends FormRequest
{

    public function authorize(): true
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'emergencyContact' => 'nullable|array',
            'emergencyContact.*.id' => 'nullable:integer',
            'emergencyContact.*.name' => 'nullable:string|max:255',
            'emergencyContact.*.phone' => 'nullable:string|max:20',
            'emergencyContact.*.email' => 'nullable|email|max:255',
            'emergencyContact.*.address' => 'nullable|string|max:255',
            'emergencyContact.*.relationship' => 'nullable|string|max:255',
            'emergencyContact.*.status' => 'nullable|string|max:50',

            'applications' => 'nullable|array',
            'applications.*.id' => 'nullable|integer',
            'applications.*.delete' => 'nullable|boolean',
            'applications.*.institution' => 'nullable|string|max:255',
            'applications.*.course' => 'nullable|string|max:255',
            'applications.*.term' => 'nullable|string|max:255',
            'applications.*.type' => 'nullable|string|max:255',
            'applications.*.amount' => 'nullable|numeric',
            'applications.*.status' => 'nullable|string|max:50',

            'assignStaff' => 'nullable|array',
            'assignStaff.*.id' => 'nullable|integer',
            'assignStaff.*.staffId' => 'nullable|integer',
            'assignStaff.*.type' => 'nullable|string|max:255',

            'workDetails' => 'nullable|array',
            'workDetails.*.id' => 'nullable|integer',
            'workDetails.*.jobTitle' => 'nullable|string|max:255',
            'workDetails.*.organization' => 'nullable|string|max:255',
            'workDetails.*.address' => 'nullable|string|max:255',
            'workDetails.*.phone' => 'nullable|string|max:20',
            'workDetails.*.fromDate' => 'nullable|date',
            'workDetails.*.toDate' => 'nullable|date',
            'workDetails.*.active' => 'nullable|boolean',
            'workDetails.*.currentlyWorking' => 'nullable|boolean',

            'academicHistory' => 'nullable|array',
            'academicHistory.*.id' => 'nullable|integer',
            'academicHistory.*.institution' => 'nullable|string|max:255',
            'academicHistory.*.course' => 'nullable|string|max:255',
            'academicHistory.*.academicYearId' => 'nullable|string|max:255',
            'academicHistory.*.termId' => 'nullable|string|max:255',
            'academicHistory.*.studyLevel' => 'nullable|string|max:255',
            'academicHistory.*.resultScore' => 'nullable|numeric',
            'academicHistory.*.outOf' => 'nullable|numeric',
            'academicHistory.*.startDate' => 'nullable|date',
            'academicHistory.*.endDate' => 'nullable|date',
            'academicHistory.*.status' => 'nullable|string|max:50',

            'refuseHistory' => 'nullable|array',
            'refuseHistory.*.id' => 'nullable|integer',
            'refuseHistory.*.refusalType' => 'nullable|string|max:255',
            'refuseHistory.*.refusalDate' => 'nullable|date',
            'refuseHistory.*.details' => 'nullable|string|max:1000',
            'refuseHistory.*.country' => 'nullable|string|max:255',
            'refuseHistory.*.visaType' => 'nullable|string|max:255',
            'refuseHistory.*.status' => 'nullable|string|max:50',

            'travelHistory' => 'nullable|array',
            'travelHistory.*.id' => 'nullable|integer',
            'travelHistory.*.purpose' => 'nullable|string|max:255',
            'travelHistory.*.arrival' => 'nullable|date',
            'travelHistory.*.departure' => 'nullable|date',
            'travelHistory.*.visaStart' => 'nullable|date',
            'travelHistory.*.visaExpiry' => 'nullable|date',
            'travelHistory.*.visaType' => 'nullable|string|max:255',

            'passports' => 'nullable|array',
            'passports.*.id' => 'nullable|integer',
            'passports.*.passportName' => 'nullable|string|max:255',
            'passports.*.passportIssueLocation' => 'nullable|string|max:255',
            'passports.*.passportNumber' => 'nullable|string|max:255',
            'passports.*.passportIssueDate' => 'nullable|date_format:d-m-Y',
            'passports.*.passportExpiryDate' => 'nullable|date_format:d-m-Y',

            'addresses' => 'nullable|array',
            'addresses.*.id' => 'nullable|integer',
            'addresses.*.addressLine1' => 'nullable|string|max:255',
            'addresses.*.addressLine2' => 'nullable|string|max:255',
            'addresses.*.townCity' => 'nullable|string|max:255',
            'addresses.*.state' => 'nullable|string|max:255',
            'addresses.*.postCode' => 'nullable|string|max:20',
            'addresses.*.country' => 'nullable|string|max:255',
        ];
    }
}

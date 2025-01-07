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
            'emergencyContact.*.status' => 'nullable|boolean',

            'applications' => 'nullable|array',
            'applications.*.id' => 'nullable|integer',
            'applications.*.delete' => 'nullable|boolean',
            'applications.*.institution' => 'nullable|string|max:255',
            'applications.*.course' => 'nullable|string|max:255',
            'applications.*.term' => 'nullable|string|max:255',
            'applications.*.type' => 'nullable|string|max:255',
            'applications.*.amount' => 'nullable|numeric',
            'applications.*.status' => 'nullable|boolean',

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
            'workDetails.*.currentlyWorking' => 'nullable|boolean',
            'workDetails.*.status' => 'nullable|boolean',

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
            'academicHistory.*.status' => 'nullable|boolean',

            'refuseHistory' => 'nullable|array',
            'refuseHistory.*.id' => 'nullable|integer',
            'refuseHistory.*.refusalType' => 'nullable|string|max:255',
            'refuseHistory.*.refusalDate' => 'nullable|date',
            'refuseHistory.*.details' => 'nullable|string|max:1000',
            'refuseHistory.*.country' => 'nullable|string|max:255',
            'refuseHistory.*.visaType' => 'nullable|string|max:255',
            'refuseHistory.*.status' => 'nullable|boolean',

            'travelHistory' => 'nullable|array',
            'travelHistory.*.id' => 'nullable|integer',
            'travelHistory.*.purpose' => 'nullable|string|max:255',
            'travelHistory.*.arrival' => 'nullable|date',
            'travelHistory.*.departure' => 'nullable|date',
            'travelHistory.*.visaStart' => 'nullable|date',
            'travelHistory.*.visaExpiry' => 'nullable|date',
            'travelHistory.*.visaType' => 'nullable|string|max:255',
            'travelHistory.*.status' => 'nullable|boolean',

            'englishLanguageExam' => 'nullable|array',
            'englishLanguageExam.*.id' => 'nullable|integer',
            'englishLanguageExam.*.exam' => 'nullable|string|max:255',
            'englishLanguageExam.*.examDate' => 'nullable|date',
            'englishLanguageExam.*.score' => 'nullable|numeric',
            'englishLanguageExam.*.status' => 'nullable|boolean',
        ];
    }
}

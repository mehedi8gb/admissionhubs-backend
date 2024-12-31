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
            'assignStaff.*.staffid' => 'nullable|integer',
            'assignStaff.*.type' => 'nullable|string|max:255',


            'workDetails' => 'nullable|array',
            'workDetails.*.id' => 'nullable|integer',
            'workDetails.*.jobtitle' => 'nullable|string|max:255',
            'workDetails.*.organization' => 'nullable|string|max:255',
            'workDetails.*.address' => 'nullable|string|max:255',
            'workDetails.*.phone' => 'nullable|string|max:20',
            'workDetails.*.fromDate' => 'nullable|date_format:d-m-Y',
            'workDetails.*.toDate' => 'nullable|date_format:d-m-Y',
            'workDetails.*.active' => 'nullable|boolean',
            'workDetails.*.currentlyWorking' => 'nullable|boolean',


            'academicHistory' => 'nullable|array',
            'academicHistory.*.id' => 'nullable|integer',
            'academicHistory.*.institution' => 'nullable|string|max:255',
            'academicHistory.*.course' => 'nullable|string|max:255',
            'academicHistory.*.academicYearId' => 'nullable|string|max:255',
            'academicHistory.*.termId' => 'nullable|string|max:255',
            'academicHistory.*.studylevel' => 'nullable|string|max:255',
            'academicHistory.*.resultScore' => 'nullable|numeric',
            'academicHistory.*.outof' => 'nullable|numeric',
            'academicHistory.*.startDate' => 'nullable|date_format:d-m-Y',
            'academicHistory.*.endDate' => 'nullable|date_format:d-m-Y',
            'academicHistory.*.status' => 'nullable|string|max:50',


            'refuseHistory' => 'nullable|array',
            'refuseHistory.*.id' => 'nullable|integer',
            'refuseHistory.*.refusaltype' => 'nullable|string|max:255',
            'refuseHistory.*.refusalDate' => 'nullable|date_format:d-m-Y',
            'refuseHistory.*.details' => 'nullable|string|max:1000',
            'refuseHistory.*.country' => 'nullable|string|max:255',
            'refuseHistory.*.visaType' => 'nullable|string|max:255',
            'refuseHistory.*.status' => 'nullable|string|max:50',


            'travelHistory' => 'nullable|array',
            'travelHistory.*.id' => 'nullable|integer',
            'travelHistory.*.purpose' => 'nullable|string|max:255',
            'travelHistory.*.arrival' => 'nullable|date_format:d-m-Y',
            'travelHistory.*.departure' => 'nullable|date_format:d-m-Y',
            'travelHistory.*.visaStart' => 'nullable|date_format:d-m-Y',
            'travelHistory.*.visaExpiry' => 'nullable|date_format:d-m-Y',
            'travelHistory.*.visaType' => 'nullable|string|max:255',



        ];
    }
}

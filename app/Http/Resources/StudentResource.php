<?php

namespace App\Http\Resources;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $studentData = $this->student_data;
        $studentData['academicHistory'][0]['academicYear'] = $this->academicYear->academic_year;
        $studentData['academicHistory'][0]['term'] = $this->term->term_data['term'];

        return [
            'id' => $this->id,
            'refId' => $this->ref_id,
            'status' => convertStatus($this->status),
            'createdBy' => $this->createdBy->name,
//            'institute' => $this->institute->name,
            'title' => $studentData['title'] ?? null,
            'firstName' => $studentData['firstName'] ?? null,
            'lastName' => $studentData['lastName'] ?? null,
            'email' => $studentData['email'] ?? null,
            'phone' => $studentData['phone'] ?? null,
            'dob' => $studentData['dob'] ?? null,
            'maritualStatus' => $studentData['maritualStatus'] ?? null,
            'gender' => $studentData['gender'] ?? null,
            'nationality' => $studentData['nationality'] ?? null,
            'countryResidence' => $studentData['countryResidence'] ?? null,
            'countryBirth' => $studentData['countryBirth'] ?? null,
            'nativeLanguage' => $studentData['nativeLanguage'] ?? null,
            'passportName' => $studentData['passportName'] ?? null,
            'passportIssueLocation' => $studentData['passportIssueLocation'] ?? null,
            'passportNumber' => $studentData['passportNumber'] ?? null,
            'passportIssueDate' => $studentData['passportIssueDate'] ?? null,
            'passportExpiryDate' => $studentData['passportExpiryDate'] ?? null,
            'addressLine1' => $studentData['addressLine1'] ?? null,
            'addressLine2' => $studentData['addressLine2'] ?? null,
            'townCity' => $studentData['townCity'] ?? null,
            'state' => $studentData['state'] ?? null,
            'postCode' => $studentData['postCode'] ?? null,
            'country' => $studentData['country'] ?? null,
            'disabilities' => $studentData['disabilities'] ?? null,
            'ethnicity' => $studentData['ethnicity'] ?? null,
            'genderidentity' => $studentData['genderidentity'] ?? null,
            'sexualOrientation' => $studentData['sexualOrientation'] ?? null,
            'religion' => $studentData['religion'] ?? null,
            'emergencyContact' => $studentData['emergencyContact'] ?? [],
            'travelHistory' => $studentData['travelHistory'] ?? [],
            'visaNeed' => $studentData['visaNeed'] ?? false,
            'refuseHistory' => $studentData['refuseHistory'] ?? [],
            'academicHistory' => $studentData['academicHistory'] ?? [],
            'workDetails' => $studentData['workDetails'] ?? [],
            'documents' => FileResource::collection($this->documents),
            'application' => $studentData['application'] ?? [],
            'assignStaff' => $studentData['assignStaff'] ?? [],
        ];
    }
}

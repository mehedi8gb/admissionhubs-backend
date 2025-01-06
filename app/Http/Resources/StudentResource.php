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
        $studentData['academicHistory'][0]['academicYear'] = $this->academicYear->academic_year ?? null;
        $studentData['academicHistory'][0]['term'] = $this->term->term_data['term'] ?? null;

        return [
            'id' => $this->id,
            'refId' => $this->ref_id,
            'status' => convertStatus($this->status),
            'createdBy' => UserResource::make($this->createdBy),
//            'institute' => $this->institute->name,
            'title' => $studentData['title'] ?? null,
            'firstName' => $studentData['firstName'] ?? null,
            'lastName' => $studentData['lastName'] ?? null,
            'email' => $studentData['email'] ?? null,
            'phone' => $studentData['phone'] ?? null,
            'dob' => $studentData['dob'] ?? null,
            'maritualStatus' => $studentData['maritualStatus'] ?? null,
            'nationality' => $studentData['nationality'] ?? null,
            'countryResidence' => $studentData['countryResidence'] ?? null,
            'countryBirth' => $studentData['countryBirth'] ?? null,
            'nativeLanguage' => $studentData['nativeLanguage'] ?? null,
            'country' => $studentData['country'] ?? null,
            'disabilities' => $studentData['disabilities'] ?? null,
            'ethnicity' => $studentData['ethnicity'] ?? null,
            'genderIdentity' => $studentData['genderIdentity'] ?? null,
            'sexualOrientation' => $studentData['sexualOrientation'] ?? null,
            'religion' => $studentData['religion'] ?? null,
            'visaNeed' => $studentData['visaNeed'] ?? false,
            'refusedPermission' => $studentData['refusedPermission'] ?? false,
            'englishLanguageRequired' => $studentData['englishLanguageRequired'] ?? false,
            'academicHistoryRequired' => $studentData['academicHistoryRequired'] ?? false,
            'workExperience' => $studentData['workExperience'] ?? false,
            'ukinpast' => $studentData['ukinpast'] ?? false,
            'emergencyContact' => EmergencyContactResource::collection($this->emergencyContacts),
            'travelHistory' => TravelHistoryResource::collection($this->travelHistories),
            'refuseHistory' => RefuseHistoryResource::collection($this->refuseHistories),
            'academicHistory' => AcademicHistoryResource::collection($this->academicHistories),
            'workDetails' => WorkDetailResource::collection($this->workDetails),
            'documents' => FileResource::collection($this->documents),
            'applications' => ApplicationResource::collection($this->applications),
            'addresses' => AddressResource::collection($this->addresses),
            'passports' => PassportResource::collection($this->passports),
            'assignStaff' => AssignStaffResource::collection($this->assignStaffs),
            'englishLanguageExam' => EnglishLanguageExamResource::collection($this->englishLanguageExams),
        ];
    }
}

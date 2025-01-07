<?php

namespace App\Http\Resources;

use App\Helpers\FileUploadHelper;
use App\Models\File;
use Carbon\Carbon;
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
        $profileUrl = $this->documents->where('file_type', 'profile')->sortByDesc('created_at')->first();

        return [
            'id' => $this->id,
            'refId' => $this->ref_id,
            'status' => convertStatus($this->status),
            'profilePhotoUrl' => FileUploadHelper::generateSignedUrl($profileUrl->id),
            'createdBy' => UserResource::make($this->createdBy),
//            'institute' => $this->institute->name,
            'title' => $studentData['title'] ?? null,
            'firstName' => $studentData['firstName'] ?? null,
            'lastName' => $studentData['lastName'] ?? null,
            'email' => $studentData['email'] ?? null,
            'phone' => $studentData['phone'] ?? null,
            'dob' => Carbon::parse($studentData['dob'])->format('Y-m-d') ?? null,
            'maritualStatus' => $studentData['maritualStatus'] ?? null,
            'nationality' => $studentData['nationality'] ?? null,
            'gender' => $studentData['gender'],
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
            'genderIdentity' => $studentData['genderIdentity'] ?? null,
            'sexualOrientation' => $studentData['sexualOrientation'] ?? null,
            'religion' => $studentData['religion'] ?? null,
            'visaNeed' => $studentData['visaNeed'] ?? false,
            'refusedPermission' => $studentData['refusedPermission'] ?? false,
            'englishLanguageRequired' => $studentData['englishLanguageRequired'] ?? false,
            'academicHistoryRequired' => $studentData['academicHistoryRequired'] ?? false,
            'workExperience' => $studentData['workExperience'] ?? false,
            'ukInPast' => $studentData['ukInPast'] ?? false,
            'currentlyInUk' => $studentData['currentlyInUk'] ?? false,
            'emergencyContact' => EmergencyContactResource::collection($this->emergencyContacts),
            'travelHistory' => TravelHistoryResource::collection($this->travelHistories),
            'refuseHistory' => RefuseHistoryResource::collection($this->refuseHistories),
            'academicHistory' => AcademicHistoryResource::collection($this->academicHistories),
            'workDetails' => WorkDetailResource::collection($this->workDetails),
            'documents' => FileResource::collection($this->documents),
            'applications' => ApplicationResource::collection($this->applications),
            'assignStaff' => AssignStaffResource::collection($this->assignStaffs),
            'englishLanguageExam' => EnglishLanguageExamResource::collection($this->englishLanguageExams),
        ];
    }
}

<?php

namespace App\Services\Handlers;

use App\Http\Resources\AcademicHistoryResource;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\AssignStaffResource;
use App\Http\Resources\EnglishLanguageExamResource;
use App\Http\Resources\RefuseHistoryResource;
use App\Http\Resources\TravelHistoryResource;
use App\Http\Resources\WorkDetailResource;
use App\Models\AcademicHistory;
use App\Models\Application;
use App\Models\AssignStaff;
use App\Models\EnglishLanguageExam;
use App\Models\RefuseHistory;
use App\Models\TravelHistory;
use App\Models\WorkDetail;
use Throwable;

class DefaultHandler extends AbstractHandler
{
    protected array $nestedArrays = [
//        'applications' => [
//            'model' => Application::class,
//            'resource' => ApplicationResource::class,
//        ],
//        'emergencyContact' => [
//            'model' => EmergencyContact::class,
//            'resource' => EmergencyContactResource::class,
//        ],
        'travelHistory' => [
            'model' => TravelHistory::class,
            'resource' => TravelHistoryResource::class,
        ],
        'refuseHistory' => [
            'model' => RefuseHistory::class,
            'resource' => RefuseHistoryResource::class,
        ],
        'academicHistory' => [
            'model' => AcademicHistory::class,
            'resource' => AcademicHistoryResource::class,
        ],
        'workDetails' => [
            'model' => WorkDetail::class,
            'resource' => WorkDetailResource::class,
        ],
//        'assignStaff' => [
//            'model' => AssignStaff::class,
//            'resource' => AssignStaffResource::class,
//        ],
        'englishLanguageExam' => [
            'model' => EnglishLanguageExam::class,
            'resource' => EnglishLanguageExamResource::class,
        ],
    ];

    /**
     * @throws Throwable
     */
    public function handle(array $validatedArray, object $student): array
    {
        foreach ($this->nestedArrays as $key => $class) {
            if (array_key_exists($key, $validatedArray)) {
                $nestedData = $validatedArray[$key][0];

                if (isset($nestedData['id'])) {
                    $data = $class['model']::find($nestedData['id']);
                    $data->update($nestedData);
                    $msg = 'updated';
                } else {
                    $nestedData['student_id'] = $student->id;
                    $data = $class['model']::create($nestedData);
                    $msg = 'created';
                }

                return [
                    'success' => true,
                    'message' => strtolower(preg_replace('/([a-z])([A-Z])/', '$1 $2', $key)) . ' was ' . $msg . ' successfully',
                    'data' => $class['resource']::make($data)
                ];
            }
        }

        return [
            'success' => false,
            'message' => 'No data was processed'
        ];
    }
}

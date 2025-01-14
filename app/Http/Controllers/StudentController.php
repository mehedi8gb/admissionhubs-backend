<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteStudentRelationsRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRelationsRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\AcademicHistoryResource;
use App\Http\Resources\ApplicationResource;
use App\Http\Resources\AssignStaffResource;
use App\Http\Resources\EmergencyContactResource;
use App\Http\Resources\EnglishLanguageExamResource;
use App\Http\Resources\RefuseHistoryResource;
use App\Http\Resources\StudentResource;
use App\Http\Resources\TravelHistoryResource;
use App\Http\Resources\WorkDetailResource;
use App\Models\AcademicHistory;
use App\Models\Address;
use App\Models\Application;
use App\Models\AssignStaff;
use App\Models\EmergencyContact;
use App\Models\EnglishLanguageExam;
use App\Models\Passport;
use App\Models\RefuseHistory;
use App\Models\Student;
use App\Models\TravelHistory;
use App\Models\WorkDetail;
use App\Services\NestedRelationService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class StudentController extends Controller
{
    protected array $nestedArrays = [
        'applications' => [
            'model' => Application::class,
            'resource' => ApplicationResource::class,
        ],
        'emergencyContact' => [
            'model' => EmergencyContact::class,
            'resource' => EmergencyContactResource::class,
        ],
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
        'assignStaff' => [
            'model' => AssignStaff::class,
            'resource' => AssignStaffResource::class,
        ],
        'englishLanguageExam' => [
            'model' => EnglishLanguageExam::class,
            'resource' => EnglishLanguageExamResource::class,
        ],
    ];


    public function index(Request $request): JsonResponse
    {
        $query = Student::query();
        $results = $this->handleApiRequest($request, $query, ['createdBy', 'documents']);

        // Convert $results to a collection if it's an array
        $results = collect($results);
        if ($results->isEmpty()) {
            return $this->sendErrorResponse('No students found', 404);
        }

        return $this->sendSuccessResponse('Students retrieved successfully', $results);
    }

    public function store(StoreStudentRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            DB::beginTransaction();

            $validatedData['currentlyInUk'] = false;
            $validatedData['ukInPast'] = false;

            $student = new Student([
                'created_by' => auth()->id(),
                'name' => $validatedData['firstName'] . ' ' . $validatedData['lastName'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'dob' => $validatedData['dob'],
                'academic_year_id' => $validatedData['academicYearId'] ?? null,
                'term_id' => $validatedData['termId'] ?? null,
//                'institute' => $validatedData['institute'],
                'status' => $validatedData['status'] ?? true,
                'agent' => $validatedData['agent'] ?? null,
                'staff' => $validatedData['staff'] ?? null,
                'student_data' => $validatedData, // json column
            ]);
            $student->save();
            DB::commit();

            return sendSuccessResponse('Student created successfully', StudentResource::make($student), 201);
        } catch (\Exception|Throwable $e) {
            DB::rollBack();
            return sendErrorResponse($e, 500);
        }
    }

    public function update(UpdateStudentRequest $request, UpdateStudentRelationsRequest $req, string $id): JsonResponse
    {
        $student = Student::findOrFail($id);
        $validatedData = $request->validated();
        $validatedArray = $req->validated();
        try {
            DB::beginTransaction();
            $studentData = $student->student_data;
            $studentData = deepMerge($studentData, $validatedData);
            $student->update([
                'name' => $validatedData['firstName'] ?? $student->name,
                'created_by' => $validatedData['createdBy'] ?? $student->created_by,
                'email' => $validatedData['email'] ?? $student->email,
                'phone' => $validatedData['phone'] ?? $student->phone,
                'dob' => $validatedData['dob'] ?? $student->dob,
                'academic_year_id' => $validatedData['academicYearId'] ?? optional($student->academicYear)->id,
                'term_id' => $validatedData['termId'] ?? optional($student->term)->id,
//                'institute' => $validatedData['institute'] ?? $student->institute,
                'status' => $validatedData['status'] ?? $student->status,
                'agent_id' => $validatedData['agentId'] ?? $student->agent_id,
                'staff_id' => $validatedData['staffId'] ?? $student->staff_id,
                'student_data' => $studentData,
            ]);

            $result = NestedRelationService::process($validatedArray, $student);
            DB::commit();

            if ($result['success']) {
                return sendSuccessResponse($result['message'], $result['data'], 201);
            }

            $student->refresh();
            return sendSuccessResponse('Student updated successfully', StudentResource::make($student), 200);
        } catch (Exception|Throwable $e) {
            DB::rollBack();
            return sendErrorResponse($e, 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);

            return $this->sendSuccessResponse('Student details retrieved successfully', StudentResource::make($student));
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e, 500);
        }
    }

    public function destroy($id, DeleteStudentRelationsRequest $req): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
            $validatedArray = $req->validated();

            if (!empty($validatedArray)) {
                foreach ($this->nestedArrays as $key => $classes) {
                    if (array_key_exists($key, $validatedArray)) {
                        $nestedData = $validatedArray[$key][0];
                        $nestedModel = $classes['model']::findOrFail($nestedData['id']);
                        $nestedModel->delete();

                        $normalizedKeyName = strtolower(preg_replace('/([a-z])([A-Z])/', '$1 $2', $key));
                        return $this->sendSuccessResponse($normalizedKeyName . ' was deleted successfully');
                    }
                }
            }
            $student->delete();

            return $this->sendSuccessResponse('Student deleted successfully');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e, 500);
        }
    }
}

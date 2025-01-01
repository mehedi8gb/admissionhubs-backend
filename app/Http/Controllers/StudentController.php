<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteStudentRelationsRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRelationsRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\AcademicHistory;
use App\Models\Application;
use App\Models\AssignStaff;
use App\Models\EmergencyContact;
use App\Models\RefuseHistory;
use App\Models\Student;
use App\Models\TravelHistory;
use App\Models\WorkDetail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    protected array $nestedArrays = [
        'applications' => Application::class,
        'emergencyContact' => EmergencyContact::class,
        'travelHistory' => TravelHistory::class,
        'refuseHistory' => RefuseHistory::class,
        'academicHistory' => AcademicHistory::class,
        'workDetails' => WorkDetail::class,
        'assignStaff' => AssignStaff::class,
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

            $student = new Student([
                'created_by' => auth()->id(),
                'name' => $validatedData['firstName'] . ' ' . $validatedData['lastName'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'dob' => $validatedData['dob'],
                'academic_year_id' => $validatedData['academicHistory'][0]['academicYearId'] ?? null,
                'term_id' => $validatedData['academicHistory'][0]['termId'] ?? null,
//                'institute' => $validatedData['institute'],
                'status' => $validatedData['status'] ?? true,
                'agent' => $validatedData['agent'] ?? null,
                'staff' => $validatedData['staff'] ?? null,
                'student_data' => $validatedData,
            ]);
            $student->save();

            DB::commit();

            return $this->sendSuccessResponse('Student created successfully', StudentResource::make($student));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
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
                'academic_year_id' => $validatedData['academicHistory'][0]['academicYearId'] ?? $student->academicYear->id,
                'term_id' => $validatedData['academicHistory'][0]['termId'] ?? $student->term->id,
//                'institute' => $validatedData['institute'] ?? $student->institute,
                'status' => $validatedData['status'] ?? $student->status,
                'agent' => $validatedData['agent'] ?? $student->agent,
                'staff' => $validatedData['staff'] ?? $student->staff,
                'student_data' => $studentData,
            ]);


            if (!empty($validatedArray)) {
                foreach ($this->nestedArrays as $key => $class) {
                    if (array_key_exists($key, $validatedArray)) {
                        $nestedData = $validatedArray[$key][0];

                        if (isset($nestedData['id'])) {
                            $nestedModel = $class::find($nestedData['id'])->update(
                                $nestedData
                            );
                        } else {
                            $nestedData['student_id'] = $student->id;
                            $nestedModel = $class::create($nestedData);
                        }
                        $nestedModel->save();
                    }
                }
            }

            DB::commit();
            $student->refresh();
            return $this->sendSuccessResponse('Student updated successfully', StudentResource::make($student));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);

            return $this->sendSuccessResponse('Student details retrieved successfully', StudentResource::make($student));
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    public function destroy($id, DeleteStudentRelationsRequest $req): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
            $validatedArray = $req->validated();

            if (!empty($validatedArray)) {
                foreach ($this->nestedArrays as $key => $class) {
                    if (array_key_exists($key, $validatedArray)) {
                        $nestedData = $validatedArray[$key][0];
                        $nestedModel = $class::findOrFail($nestedData['id']);
                        $nestedModel->delete();

                        $normalizedKeyName = strtolower(preg_replace('/([a-z])([A-Z])/', '$1 $2', $key));
                        return $this->sendSuccessResponse($normalizedKeyName . ' was deleted successfully');
                    }
                }
            }
//            $student->delete();

            return $this->sendSuccessResponse('Student deleted successfully');
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }
}

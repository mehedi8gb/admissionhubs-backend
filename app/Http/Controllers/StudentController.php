<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
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
                'academic_year_id' => $validatedData['academicHistory'][0]['academicYearId'],
                'term_id' => $validatedData['academicHistory'][0]['termId'],
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

    public function update(UpdateStudentRequest $request, string $id): JsonResponse
    {
        $student = Student::findOrFail($id);
        $validatedData = $request->validated();

        try {
            DB::beginTransaction();

            $student->update([
                'name' => $validatedData['firstName'] ?? $student->name,
                'email' => $validatedData['email'] ?? $student->email,
                'phone' => $validatedData['phone'] ?? $student->phone,
                'dob' => $validatedData['dob'] ?? $student->dob,
                'academic_year_id' => $validatedData['academicHistory'][0]['academicYearId'] ?? $student->academic_year,
                'term_id' => $validatedData['academicHistory'][0]['termId'] ?? $student->term,
//                'institute' => $validatedData['institute'] ?? $student->institute,
                'status' => $validatedData['status'] ?? $student->status,
                'agent' => $validatedData['agent'] ?? $student->agent,
                'staff' => $validatedData['staff'] ?? $student->staff,
                'student_data' => deepMerge($student->student_data, $validatedData ?? []),
            ]);

            DB::commit();

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

    public function destroy($id): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);
            $student->delete();

            return $this->sendSuccessResponse('Student deleted successfully');
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }
}

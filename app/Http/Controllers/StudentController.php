<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Resources\StudentResource;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Student::query();
        $results = $this->handleApiRequest($request, $query);

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
            $student = new Student([
                'created_by' => auth()->id(),
                'student_data' => $validatedData,
            ]);
            $student->save();

            return $this->sendSuccessResponse('Student created successfully',
                StudentResource::make($student));
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    public function update(UpdateStudentRequest $request, string $id): JsonResponse
    {
        $student = Student::findOrFail($id);
        $validatedData = $request->validated();

        try {
            // Get existing student data
            $existingStudentData = $student->student_data;

            // Perform a deep merge, overwriting existing keys
            $mergedData = deepMerge($existingStudentData, $validatedData);

            // Update the student record
            $student->update([
                'student_data' => $mergedData,
            ]);

            return $this->sendSuccessResponse('Student updated successfully', StudentResource::make($student));
        } catch (\Exception $e) {
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

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $students = Student::limit(10)->get();

        if ($students->isEmpty()) {
            return $this->sendErrorResponse('No students found', 404);
        }

        return $this->sendSuccessResponse('Students retrieved successfully', $students);
    }

    public function store(StoreStudentRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            $studentObject = $request->all();
            $student = new Student([
                'created_by' => auth()->id(),
                'student_data' => $studentObject,
            ]);
            $student->save();

            return $this->sendSuccessResponse('Student created successfully', $student);
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
            $mergedData = $this->deepMerge($existingStudentData, $validatedData);

            // Update the student record
            $student->update([
                'student_data' => $mergedData,
            ]);

            return $this->sendSuccessResponse('Student updated successfully', $student);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Perform a deep merge of two arrays, allowing forced replacement with a "forceReplace" value.
     *
     * @param array $original
     * @param array $new
     * @param string $forceReplaceIndicator
     * @return array
     */
    private function deepMerge(array $original, array $new, string $forceReplaceIndicator = 'forceReplace'): array
    {
        foreach ($new as $key => $value) {
            // Check if the value is marked as a forced replacement
            if ($value === $forceReplaceIndicator) {
                // Replace the key in the original array with an empty value
                $original[$key] = '';
                continue;
            }

            // Check if the new value is empty (null, empty string, or empty array)
            if (is_null($value) || (is_string($value) && trim($value) === '') || (is_array($value) && empty($value))) {
                // Skip overwriting if the new value is empty
                continue;
            }

            if (is_array($value) && isset($original[$key]) && is_array($original[$key])) {
                // Recursively merge arrays
                $original[$key] = $this->deepMerge($original[$key], $value, $forceReplaceIndicator);
            } else {
                // Overwrite scalar values or arrays
                $original[$key] = $value;
            }
        }
        return $original;
    }


    public function show($id): JsonResponse
    {
        try {
            $student = Student::findOrFail($id);

            return $this->sendSuccessResponse('Student details retrieved successfully', $student);
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

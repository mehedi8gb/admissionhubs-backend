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
                'created_by' => $validatedData['createdBy'],
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
            $studentObject = $request->all();
            $student->update([
                'created_by' => $validatedData['createdBy'],
                'student_data' => $studentObject,
            ]);

            return $this->sendSuccessResponse('Student updated successfully', $student);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
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

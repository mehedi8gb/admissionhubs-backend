<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Course::query();
        $results = $this->handleApiRequest($request, $query);

        // Convert $results to a collection if it's an array
        $results = collect($results);
        if ($results->isEmpty()) {
            return $this->sendErrorResponse('No records found', 404);
        }

        return $this->sendSuccessResponse('Records retrieved successfully', $results);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        try {
            $data = new Course([
                'course_data' => [
                    'name' => $validatedData['name'],
                ],
                'status' => $request->status ?? true,
            ]);
            $data->save();

            return $this->sendSuccessResponse('Record created successfully', CourseResource::make($data));
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $data = Course::findOrFail($id);
            return $this->sendSuccessResponse('Records retrieved successfully', CourseResource::make($data));
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $data = Course::findOrFail($id);
        $request->validate([
            'name' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
        ]);
        try {
            $updateData = [];

            if ($request->has('name')) {
                $updateData['course_data'] = [
                    'name' => $request->name,
                ];
            }

            if ($request->has('status')) {
                $updateData['status'] = $request->status;
            }

            $data->update($updateData);

            return $this->sendSuccessResponse('Record updated successfully', CourseResource::make($data));
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $data = Course::findOrFail($id);
            $data->delete();
            return $this->sendSuccessResponse('Record deleted successfully');
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }
}

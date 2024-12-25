<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = AcademicYear::query();
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
            'academic_year' => 'required|string|max:255',
        ]);

        try {
            $data = new AcademicYear([
                'academic_year' => $validatedData['academic_year'],
            ]);
            $data->save();

            return $this->sendSuccessResponse('Record created successfully', $data);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $data = AcademicYear::findOrFail($id);
            return $this->sendSuccessResponse('Records retrieved successfully', $data);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $data = AcademicYear::findOrFail($id);
        $validatedData = $request->validate([
            'academic_year' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
        ]);
        $validatedData['status'] = $validatedData['status'] ?? false;
        try {
            $data->fill($validatedData);
            $data->save();

            return $this->sendSuccessResponse('Record updated successfully', $data);
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
            $data = AcademicYear::findOrFail($id);
            $data->delete();
            return $this->sendSuccessResponse('Record deleted successfully');
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }
}

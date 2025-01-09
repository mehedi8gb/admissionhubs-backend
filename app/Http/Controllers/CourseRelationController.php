<?php

namespace App\Http\Controllers;

use App\Models\CourseRelation;
use App\Http\Resources\CourseRelationResource;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CourseRelationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = CourseRelation::query();
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
            'institute_id' => 'required|exists:institutes,id',
            'course_id' => 'required|exists:courses,id',
            'term_id' => 'required|exists:terms,id',
            'academic_year_id' => 'required|exists:academic_years,id',
            'local' => 'nullable|boolean',
            'local_amount' => 'nullable|numeric',
            'international' => 'nullable|boolean',
            'international_amount' => 'nullable|numeric',
            'status' => 'nullable|boolean',
        ]);

        if (empty($validatedData['local'])) {
            $validatedData['local'] = false;
        }
        if (empty($validatedData['international'])) {
            $validatedData['international'] = false;
        }

        try {
            $courseRelation = CourseRelation::create($validatedData);
            return $this->sendSuccessResponse('Course relation created successfully', new CourseRelationResource($courseRelation));
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $courseRelation = CourseRelation::findOrFail($id);
            return $this->sendSuccessResponse('Course relation retrieved successfully', new CourseRelationResource($courseRelation));
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $courseRelation = CourseRelation::findOrFail($id);

        $validatedData = $request->validate([
            'institute_id' => 'nullable|exists:institutes,id',
            'course_id' => 'nullable|exists:courses,id',
            'term_id' => 'nullable|exists:terms,id',
            'academic_year_id' => 'nullable|exists:academic_years,id',
            'local' => 'nullable|boolean',
            'local_amount' => 'nullable|numeric',
            'international' => 'nullable|boolean',
            'international_amount' => 'nullable|numeric',
            'status' => 'nullable|boolean',
        ]);

        try {
            $courseRelation->update($validatedData);
            return $this->sendSuccessResponse('Course relation updated successfully', new CourseRelationResource($courseRelation));
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $courseRelation = CourseRelation::findOrFail($id);
            $courseRelation->delete();
            return $this->sendSuccessResponse('Course relation deleted successfully');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e->getMessage(), 500);
        }
    }
}


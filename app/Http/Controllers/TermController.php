<?php

namespace App\Http\Controllers;

use App\Http\Resources\TermResource;
use App\Models\Term;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TermController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Term::with('academicYear');
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
            'term' => 'required|string|max:255',
            'academic_year_id' => 'required|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        try {
            $data = new Term([
                'term_data' => [
                    'term' => $validatedData['term'],
                ],
                'academic_year_id' => $validatedData['academic_year_id'],
                'status' => $validatedData['status'] ?? true,
            ]);
            $data->save();

            return $this->sendSuccessResponse('Record created successfully', TermResource::make($data), 201);
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $data = Term::findOrFail($id);
            return $this->sendSuccessResponse('Records retrieved successfully', TermResource::make($data));
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $data = Term::findOrFail($id);
        $request->validate([
            'term' => 'nullable|string|max:255',
            'academic_year_id' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
        ]);
        try {
            $updateData = [];

            if ($request->has('term')) {
                $updateData['term_data'] = [
                    'term' => $request->term,
                ];
            }

            if ($request->has('academic_year_id')) {
                $updateData['academic_year_id'] = $request->academic_year_id;
            }

            // Update 'status' only if it's explicitly provided in the request
            if ($request->has('status')) {
                $updateData['status'] = $request->status;
            }

            $data->update($updateData);

            return $this->sendSuccessResponse('Record updated successfully', TermResource::make($data));
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
            $data = Term::findOrFail($id);
            $data->delete();
            return $this->sendSuccessResponse('Record deleted successfully');
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }
}

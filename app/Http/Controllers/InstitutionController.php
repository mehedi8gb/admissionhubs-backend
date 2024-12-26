<?php

namespace App\Http\Controllers;

use App\Http\Resources\InstituteResource;
use App\Models\Institute;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InstitutionController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Institute::query();
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
            'status' => 'required|boolean',
        ]);

        try {
            $data = new Institute([
                'name' => $validatedData['name'],
                'status' => $request->status ?? 1,
            ]);
            $data->save();

            return $this->sendSuccessResponse('Record created successfully', InstituteResource::make($data));
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $data = Institute::findOrFail($id);
            return $this->sendSuccessResponse('Records retrieved successfully', InstituteResource::make($data));
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $data = Institute::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'status' => 'nullable|boolean',
        ]);
        $validatedData['status'] = $validatedData['status'] ?? false;
        try {
            $data->fill($validatedData);
            $data->save();

            return $this->sendSuccessResponse('Record updated successfully', InstituteResource::make($data));
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $data = Institute::findOrFail($id);
            $data->delete();
            return $this->sendSuccessResponse('Record deleted successfully');
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }
}

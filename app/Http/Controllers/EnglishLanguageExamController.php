<?php

namespace App\Http\Controllers;

use App\Http\Resources\EnglishLanguageExamResource;
use App\Models\EnglishLanguageExam;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EnglishLanguageExamController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = EnglishLanguageExam::query();
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
            'exam' => 'required|string|max:255',
            'examDate' => 'required|date',
            'score' => 'required|numeric',
            'status' => 'nullable|boolean',
        ]);

        try {
            $data = new EnglishLanguageExam([
                'student_id' => auth()->user()->id,
                'exam' => $validatedData['exam'],
                'examDate' => $validatedData['examDate'],
                'score' => $validatedData['score'],
                'status' => $validatedData['status'] ?? true,
            ]);
            $data->save();

            return $this->sendSuccessResponse('Record created successfully', EnglishLanguageExamResource::make($data));
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e, 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $data = EnglishLanguageExam::findOrFail($id);
            return $this->sendSuccessResponse('Records retrieved successfully', EnglishLanguageExamResource::make($data));
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e, 500, $e);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $data = EnglishLanguageExam::findOrFail($id);
        $validatedData = $request->validate([
            'exam' => 'required|string|max:255',
            'examDate' => 'required|date',
            'score' => 'required|numeric',
            'status' => 'nullable|boolean',
        ]);
        $validatedData['status'] = $validatedData['status'] ?? false;
        try {
            $data->fill($validatedData);
            $data->save();

            return $this->sendSuccessResponse('Record updated successfully', EnglishLanguageExamResource::make($data));
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $data = EnglishLanguageExam::findOrFail($id);
            $data->delete();
            return $this->sendSuccessResponse('Record deleted successfully');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e, 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\AgentResource;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Staff::query();
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
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:agents,email',
            'phone' => 'required|string|unique:agents,phone|max:15',
            'password' => 'required|string|min:8',
            'status' => 'nullable|boolean',
        ]);

        try {
            $user = User::create([
                'name' => $validatedData['first_name'] . ' ' . $validatedData['last_name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'password' => Hash::make($validatedData['password']),
            ]);
            $user->assignRole('staff');
            $user->save();

            $validatedData['user_id'] = $user->id;

            $staff = Staff::create($validatedData);
            $staff->save();
            $staff->refresh();

            return $this->sendSuccessResponse('Record created successfully', AgentResource::make($staff));
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e, 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $data = Staff::findOrFail($id);
            return $this->sendSuccessResponse(
                'Staff record retrieved successfully',
                AgentResource::make($data)
            );
        }
        catch (\Exception $e) {
            return $this->sendErrorResponse($e, 500, $e);
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $staff = Staff::findOrFail($id);
        $user = $staff->user; // Get the associated user

        $validatedData = $request->validate([
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:agents,email' . $user->id,
            'phone' => 'nullable|string|unique:agents,phone|max:15' . $user->id,
            'password' => 'nullable|string|min:8',
            'status' => 'nullable|boolean',
        ]);

        $validatedData['status'] = $validatedData['status'] ?? $staff->status;

        try {
            // Update the user record
            $user->update([
                'name' => $validatedData['first_name'] . $validatedData['last_name'] ?? $user->name,
                'email' => $validatedData['email'] ?? $user->email,
                'phone' => $validatedData['phone'] ?? $user->phone,
            ]);

            // Update the staff record
            $staff->update($validatedData);

            return $this->sendSuccessResponse('Staff record updated successfully', AgentResource::make($staff));
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e, 500);
        }
    }


    public function destroy($id): JsonResponse
    {
        try {
            $data = Staff::findOrFail($id);
            $data->delete();
            return $this->sendSuccessResponse('Record deleted successfully');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e, 500);
        }
    }
}

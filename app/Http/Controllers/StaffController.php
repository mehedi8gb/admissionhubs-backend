<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Http\Resources\StaffResource;
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

    public function store(StoreStaffRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            $user = User::create([
                'name' => $request->firstName . $request->lastName,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
            ]);
            $user->assignRole('staff');
            $user->save();

            $validatedData['user_id'] = $user->id;

            $staff = Staff::create($validatedData);
            $staff->save();
            $staff->refresh();

            return $this->sendSuccessResponse('Record created successfully', StaffResource::make($staff));
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
                StaffResource::make($data)
            );
        }
        catch (\Exception $e) {
            return $this->sendErrorResponse($e, 500, $e);
        }
    }

    public function update(UpdateStaffRequest $request, string $id): JsonResponse
    {
        $staff = Staff::findOrFail($id);
        $user = $staff->user; // Get the associated user

        $validatedData = $request->validated();

        $validatedData['status'] = $validatedData['status'] ?? $staff->status;

        try {
            // Update the user record
            $user->update([
                'name' => $request->firstName . $request->lastName ?? $user->name,
                'email' => $request->email ?? $user->email,
                'phone' => $request->phone ?? $user->phone,
                'password' => bcrypt($request->password) ?? $user->password,
            ]);

            // Update the staff record
            $staff->update($validatedData);

            return $this->sendSuccessResponse('Staff record updated successfully', StaffResource::make($staff));
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

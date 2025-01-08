<?php

namespace App\Http\Controllers;

use App\Http\Resources\AgentResource;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Agent::query();
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
            'agent_name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'required|email|unique:agents,email',
            'location' => 'nullable|string|max:255',
            'nominated_staff' => 'required|exists:staffs,id',
            'organization' => 'nullable|string|max:255',
            'phone' => 'required|string|unique:agents,phone|max:15',
            'password' => 'required|string|min:8',
            'status' => 'nullable|boolean',
        ]);

        try {
            $user = User::create([
                'name' => $validatedData['agent_name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'password' => Hash::make($validatedData['password']),
            ]);
            $user->assignRole('agent');
            $user->save();

            $validatedData['user_id'] = $user->id;

            $agent = Agent::create($validatedData);
            $agent->save();
            $agent->refresh();

            return $this->sendSuccessResponse('Record created successfully', AgentResource::make($agent));
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e, 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $data = Agent::findOrFail($id);
            return $this->sendSuccessResponse(
                'Agent record retrieved successfully',
                AgentResource::make($data)
            );
        }
        catch (\Exception $e) {
            return $this->sendErrorResponse($e, 500, $e);
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $agent = Agent::findOrFail($id);
        $user = $agent->user; // Get the associated user

        $validatedData = $request->validate([
            'agent_name' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:agents,email,' . $agent->id,
            'location' => 'nullable|string|max:255',
            'nominated_staff' => 'nullable|exists:staffs,id',
            'organization' => 'nullable|string|max:255',
            'phone' => 'nullable|string|unique:agents,phone,' . $agent->id . '|max:15',
            'password' => 'nullable|string|min:8', // Hash if provided
            'status' => 'nullable|boolean',
        ]);

        $validatedData['status'] = $validatedData['status'] ?? $agent->status;

        try {
            // Update the user record
            $user->update([
                'name' => $validatedData['agent_name'] ?? $user->name,
                'email' => $validatedData['email'] ?? $user->email,
                'phone' => $validatedData['phone'] ?? $user->phone,
            ]);

            // Update the agent record
            $agent->update($validatedData);

            return $this->sendSuccessResponse('Agent record updated successfully', AgentResource::make($agent));
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e, 500);
        }
    }


    public function destroy($id): JsonResponse
    {
        try {
            $data = Agent::findOrFail($id);
            $data->delete();
            return $this->sendSuccessResponse('Record deleted successfully');
        } catch (\Exception $e) {
            return $this->sendErrorResponse($e, 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\AgentResource;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
            'organization' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'phone' => 'required|string|unique:users,phone|max:15',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'location' => 'required|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        try {
            $user = User::create([
                'name' => $validatedData['agent_name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
                'password' => $validatedData['password'],
            ]);
            $user->assignRole('agent');
            $user->save();

            $agent = Agent::create([
                'user_id' => $user->id,
                'organization' => $validatedData['organization'],
                'contact_person' => $validatedData['contact_person'],
                'location' => $validatedData['location'],
            ]);
            $agent->save();
            $agent->refresh();

            return $this->sendSuccessResponse('Record created successfully', AgentResource::make($agent));
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $data = Agent::findOrFail($id);
            return $this->sendSuccessResponse('Record retrieved successfully', AgentResource::make($data));
        }
        catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500, $e);
        }
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $agent = Agent::findOrFail($id);
        $user = $agent->user; // Get the associated user

        $validatedData = $request->validate([
            'agent_name' => 'nullable|string|max:255',
            'organization' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15|unique:users,phone,' . $user->id,
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'location' => 'nullable|string|max:255',
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
            $agent->update([
                'organization' => $validatedData['organization'] ?? $agent->organization,
                'contact_person' => $validatedData['contact_person'] ?? $agent->contact_person,
                'location' => $validatedData['location'] ?? $agent->location,
                'status' => $validatedData['status'],
            ]);

            return $this->sendSuccessResponse('Record updated successfully', AgentResource::make($agent));
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }


    public function destroy($id): JsonResponse
    {
        try {
            $data = Agent::findOrFail($id);
            $data->delete();
            return $this->sendSuccessResponse('Record deleted successfully');
        } catch (\Exception $e) {
            return $this->sendErrorResponse('An error occurred: ' . $e->getMessage(), 500);
        }
    }
}

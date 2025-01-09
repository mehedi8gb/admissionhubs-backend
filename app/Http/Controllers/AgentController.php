<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAgentRequest;
use App\Http\Requests\UpdateAgentRequest;
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

    public function store(StoreAgentRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        try {
            $user = User::create([
                'name' => $request->firstName . $request->lastName,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
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

    public function update(UpdateAgentRequest $request, $id): JsonResponse
    {
        $agent = Agent::findOrFail($id);
        $user = $agent->user; // Get the associated user

        $validatedData = $request->validated();
        $validatedData['status'] = $validatedData['status'] ?? $agent->status;

        try {
            // Update the user record
            $user->update([
                'name' => $request->firstName . $request->lastName ?? $user->name,
                'email' => $request->email ?? $user->email,
                'phone' => $request->phone ?? $user->phone,
                'password' => bcrypt($request->password) ?? $user->password,
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

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAgentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'agentName' => 'required|string|max:255',
            'contactPerson' => 'nullable|string|max:255',
            'email' => 'required|email|unique:agents,email',
            'location' => 'nullable|string|max:255',
            'nominatedStaff' => 'nullable|exists:staffs,id',
            'organization' => 'nullable|string|max:255',
            'phone' => 'required|string|unique:agents,phone|max:15',
            'password' => 'required|string|min:8',
            'status' => 'nullable|boolean',
        ];
    }

    /**
     * Override validated method to apply transformations.
     */
    public function validated($key = null, $default = null): array
    {
        $validated = parent::validated($key, $default);
        return $this->transformSelectedKeys($validated);
    }


    /**
     * Transform specific camelCase keys to snake_case.
     */
    private function transformSelectedKeys(array $data): array
    {
        // Define the keys to transform.
        $keysToTransform = [
            'agentName' => 'agent_name',
            'contactPerson' => 'contact_person',
            'nominatedStaff' => 'nominated_staff',
        ];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->transformSelectedKeys($value); // Recursive for nested arrays.
            } elseif (isset($keysToTransform[$key])) {
                // Transform key if it matches the ones in the mapping.
                $data[$keysToTransform[$key]] = $value;
                unset($data[$key]); // Remove old key.
            }
        }

        return $data;
    }
}

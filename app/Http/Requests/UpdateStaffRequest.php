<?php

namespace App\Http\Requests;

use App\Models\Staff;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     */
    public function rules(): array
    {
        $staff = Staff::findOrFail($this->route('staff'));
        $user = $staff->user;

        return [
            'firstName' => 'nullable|string|max:255',
            'lastName' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email' . ($user->id ? ',' . $user->id : ''),
            'phone' => 'nullable|string|unique:users,phone|max:15' . ($user->id ? ',' . $user->id : ''),
            'password' => 'nullable|string|min:8',
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
            'firstName' => 'first_name',
            'lastName' => 'last_name',
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

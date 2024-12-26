<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Update as per your authorization logic if needed.
    }

    public function rules(): array
    {
        return (new StoreStudentRequest())->rules();
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BesoinStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'date' => ['nullable', 'date'],
            'service_id' => ['nullable', 'integer', 'exists:services,id'],
            'status' => ['required', 'in:pending,validated,refused,partial_validated'],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
        ];
    }
}

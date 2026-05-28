<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntretienUpdateRequest extends FormRequest
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
            'comment' => ['nullable', 'string'],
            'candidature_id' => ['nullable', 'integer', 'exists:candidatures,id'],
            'autor_id' => ['nullable', 'string'],
        ];
    }
}

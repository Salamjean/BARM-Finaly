<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidatsadmiUpdateRequest extends FormRequest
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
            'candidature_id' => ['nullable', 'string'],
            'date' => ['nullable', 'date'],
            'recu' => ['nullable', 'string'],
            'intitule_concours' => ['nullable', 'string'],
            'type_concours' => ['nullable', 'string'],
            'autor_id' => ['nullable', 'string'],
        ];
    }
}

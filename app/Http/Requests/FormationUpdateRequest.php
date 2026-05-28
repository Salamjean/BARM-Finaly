<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FormationUpdateRequest extends FormRequest
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
            'entreprise_id' => ['nullable', 'string'],
            'intitule' => ['nullable', 'string'],
            'date_db' => ['nullable', 'date'],
            'date_fin' => ['nullable', 'date'],
            'lieu' => ['nullable', 'string'],
            'autor_id' => ['nullable', 'string'],
        ];
    }
}

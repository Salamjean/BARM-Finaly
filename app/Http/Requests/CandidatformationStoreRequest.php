<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidatformationStoreRequest extends FormRequest
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
            'formation_id' => ['nullable', 'string'],
            'presence' => ['nullable', 'in:0,1'],
            'commentaire' => ['nullable', 'string'],
            'attestation' => ['nullable', 'string'],
            'autor_id' => ['nullable', 'string'],
        ];
    }
}

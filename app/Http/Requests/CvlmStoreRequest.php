<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CvlmStoreRequest extends FormRequest
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
            'cv' => ['nullable', 'string'],
            'lm' => ['nullable', 'string'],
            'type' => ['nullable', 'in:cv,lm,cvlm'],
            'presence' => ['nullable', 'in:0,1'],
            'date' => ['nullable', 'date'],
            'commentaire' => ['nullable', 'string'],
            'autor_id' => ['nullable', 'string'],
        ];
    }
}

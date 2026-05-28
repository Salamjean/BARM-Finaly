<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SuiviStoreRequest extends FormRequest
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
            'candidatentreprise_id' => ['nullable', 'string'],
            'candidature_id' => ['nullable', 'string'],
            'entreprise_id' => ['nullable', 'string'],
            'intitule' => ['nullable', 'string'],
            'date' => ['nullable', 'date'],
            'commentaire' => ['nullable', 'string'],
            'rapport' => ['nullable', 'string'],
        ];
    }
}

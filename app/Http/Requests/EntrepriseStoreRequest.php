<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntrepriseStoreRequest extends FormRequest
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
            'nom' => ['nullable', 'string'],
            'localisation' => ['nullable', 'string'],
            'specialisation' => ['nullable', 'string'],
            'num_decharge' => ['nullable', 'string'],
            'nom_point_focal' => ['nullable', 'string'],
            'email_point_focal' => ['nullable', 'email'],
            'type' => ['nullable', 'string'],
            'autor_id' => ['nullable', 'string'],
        ];
    }
}

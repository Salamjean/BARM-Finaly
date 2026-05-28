<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BesoinitemStoreRequest extends FormRequest
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
            'designation' => ['nullable', 'string'],
            'qte_demande' => ['nullable', 'string'],
            'qte_recue' => ['nullable', 'string'],
            'qte_manquante' => ['nullable', 'string'],
            'besoin_id' => ['nullable', 'integer', 'exists:besoins,id'],
        ];
    }
}

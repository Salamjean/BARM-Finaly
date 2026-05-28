<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidatentrepriseStoreRequest extends FormRequest
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
            'entreprise_id' => ['nullable', 'string'],
            'date_mise_disposition' => ['nullable', 'date'],
            'statut' => ['required', 'in:pending,accepted,refused,finished,on_hold'],
            'poste' => ['nullable', 'string'],
            'type_contrat' => ['nullable', 'string'],
            'date_db' => ['nullable', 'date'],
            'date_fin' => ['nullable', 'date'],
            'contrat' => ['nullable', 'string'],
            'localisation' => ['nullable', 'string'],
            'commentaire' => ['nullable', 'string'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BudgetsectionUpdateRequest extends FormRequest
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
            'titre' => ['nullable', 'string'],
            'total_vote' => ['nullable', 'string'],
            'total_recu' => ['nullable', 'string'],
            'budget_id' => ['nullable', 'integer', 'exists:budgets,id'],
        ];
    }
}

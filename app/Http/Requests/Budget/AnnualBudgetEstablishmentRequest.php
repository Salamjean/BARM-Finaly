<?php

namespace App\Http\Requests\Budget;

use Illuminate\Foundation\Http\FormRequest;

class AnnualBudgetEstablishmentRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->http == 'post')
            return [
                'elements' => 'required|array',
                'description' => 'nullable|string'
            ];
        else
            return [
                'elements' => 'required|array',
                'description' => 'nullable|string'
            ];
    }
}

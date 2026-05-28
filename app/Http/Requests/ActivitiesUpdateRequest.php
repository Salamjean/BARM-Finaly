<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivitiesUpdateRequest extends FormRequest
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
    public function rules()
    {
        $rules = [
            'title' => 'required|string|min:3',
            'objectifs' => 'required|string|min:3',
            'cible' => 'required|array',
            'canal' => 'required|array',
            'periode' => 'required|string|min:3',
            'budget' => 'required|min:5',
            'source' => 'nullable',
            'observations' => 'required|string|min:3',
        ];

        return $rules;

    }

    public function messages()
    {
        return [
            'title.required' => 'Le titre est obligatoire.',
            'title.string' => 'Le titre doit être une chaine de caractères',
            'title.min' => 'Le titre doit avoir au minimun :min caractères',
            'title.max' => 'Le titre doit avoir au maximun :max caractères',

            'objectifs.required' => 'L\'objectif est obligatoire.',
            'objectifs.string' => 'L\'objectif doit être une chaine de caractères',
            'objectifs.min' => 'L\'objectif doit avoir au minimun :min caractères',


            'cible.required' => 'La cible est obligatoire.',
            'canal.required' => 'Le canal est obligatoire.',

            'periode.required' => 'Ce champ est obligatoire.',
            'periode.string' => 'La période doit être une chaine de caractères',
            'periode.min' => 'La période doit avoir au minimun :min caractères',

            'budget.required' => 'L\'estimation budgetaire est obligatoire.',
            'budget.min' => 'L\'estimation budgetaire doit avoir au minimun :min caractères',

            'observations.required' => 'L\'observation est obligatoire.',
            'observations.string' => 'L\'observation doit être une chaine de caractères',
            'observations.min' => 'L\'observation doit avoir au minimun :min caractères',
        ];
    }
}

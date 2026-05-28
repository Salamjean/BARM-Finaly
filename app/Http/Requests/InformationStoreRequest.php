<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InformationStoreRequest extends FormRequest
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
            'title' => 'required|min:3|max:50',
            'contenu' => 'required|min:3|max:5000',
        ];

        return $rules;

    }

    public function messages()
    {
        return [
            'title.required' => 'Le titre est obligatoire.',
            'title.min' => 'Le titre doit avoir au minimun :min caractères',
            'title.max' => 'Le titre doit avoir au maximun :max caractères',
            'contenu.required' => 'Le message est obligatoire.',
            'contenu.min' => 'Le message doit avoir au minimun :min caractères',
            'contenu.max' => 'Le message doit avoir au maximun :max caractères',
        ];
    }
}

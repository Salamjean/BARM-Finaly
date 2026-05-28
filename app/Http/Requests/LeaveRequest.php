<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class   LeaveRequest extends FormRequest
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
            'leave_type' => 'required',
            'leavefrom' => 'required|date',
            'leaveto' => 'required|date|after_or_equal:leavefrom',
            'returndate' => 'required|date|after_or_equal:leaveto',
            'reason' => 'required',
            'file' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ];

        if ($this->leave_type == 'Congé') {
            $rules['reason'] = 'nullable|string|min:3';
        }

        return $rules;

    }

    public function messages()
    {
        return [
            'leave_type.required' => 'Le type de demande est obligatoire.',
            'leavefrom.required' => 'La date de départ est obligatoire.',
            'leaveto.after_or_equal' => 'La date de retour doit être après ou égale à la date de départ.',
            'leaveto.required' => 'La date de retour est obligatoire.',
            'returndate.after_or_equal' => 'La date de reprise doit être après ou égale à la date de retour.',
            'returndate.required' => 'La date de reprise est obligatoire.',
            'reason.required' => 'Le motif est obligatoire.',
            'file.mimes' => 'Le fichier doit être de type :values.',
            'file.max' => 'Le fichier ne doit pas dépasser :max kilo-octets.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;


class   LeaveUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(Request $request)
    {
        $rules = [
            'leavefrom' => 'required|date',
            'leaveto' => 'required|date|after_or_equal:leavefrom',
            'returndate' => 'required|date|after_or_equal:leaveto',
            'reason' => 'required',
            'file' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ];

        // Lire la valeur de leave_type depuis les données de la requête
        if ($request->input('leave_type') === 'Congé') {
            $rules['reason'] = 'nullable|string|min:3';
        }

        return $rules;
    }

    /**
     * Custom error messages.
     */
    public function messages()
    {
        return [
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

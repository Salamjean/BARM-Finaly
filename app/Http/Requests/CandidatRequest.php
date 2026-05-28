<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CandidatRequest extends FormRequest
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
        return [

             //Situation Matrimoniale
             'situation_matrimoniale' => 'required',
             'partnerName' => 'required|string|max:255',
             'partnerJob' => 'required|string|max:255',
             'contactPartner' => 'required|string|max:255',
             'partnerCard' => 'required|string|max:255',
             'marriageCertificate' => 'required|string|max:255',

             //enfants_items
             'child_name.*' => 'required',
             'child_birthdate.*' => 'required|date',
             'child_niveau.*' => 'required',
             'child_file.*' => 'required|file',
             
             'email' => 'email|max:255',
             'residence' => 'string|max:255',
             'address' => 'string|max:255',

             //Situation professionnelle
             'armee' => 'required|string|max:255',
             'unite_rattachement' => 'required|string|max:255',
             'statut_prof' => 'required',
             'grade' => 'required|string|max:255',
             'date_entree' => 'required',
             'date_radiation' => 'required',

             //emploi_items
             'periode.*' => 'required',
             'organism.*' => 'required|string|max:255',
             'fonction.*' => 'required|string|max:255',

             //Projet
             'orientation' => 'required',

                              //1er choix
                              'domaine_1c' => 'required|string|max:64', 
                              'specialisation_1c' => 'required|string|max:64', 
                              'region_retraite_1c' => 'required', 
                              'department_1c' => 'required', 
                              'locality_1c' => 'required', 
                              'adressGeo_1c' => 'required', 
                              'formation_1c' => 'required', 
                              'autres_form_1c' => 'string|max:255', 

                              //2e choix
                              'domaine_2c' => 'required|string|max:64', 
                              'specialisation_2c' => 'required|string|max:64', 
                              'region_retraite_2c' => 'required', 
                              'department_2c' => 'required', 
                              'locality_2c' => 'required', 
                              'adressGeo_2c' => 'required', 
                              'formation_2c' => 'required', 
                              'autres_form_2c' => 'string|max:255', 

            //conditions
            'condition_admin' => 'required', 
            'condition_financiere' => 'required', 
            'condition_disciplinaire' => 'required',

            //Accident ou maladie
            'accident_maladie' => 'required', 
            'demarche_nature' => 'required|string|max:255', 
            'demarche_admin' => 'required|string|max:255', 
            'etat_avancement' => 'required|string|max:255', 
            'indication' => 'required|string|max:255', 

             //Pièces jointes
             'demande_manuscrite' => 'required',
             'cv' => 'required',
             'id_card' => 'required',
             'carte_pro' => 'required',
             'fiche_engagement' => 'required',
             'fiche_individuelle' => 'required',
             'arrete_radiation' => 'required',
             'certificat' => 'required',

        ];
    }

    public function messages()
    {
        return [
                    
            'required' => 'Ce champ est requis.',
            'string' => 'Ce champ doit être une chaîne de caractères.',
            'max' => 'Ce champ ne doit pas dépasser :max caractères.',
            'email' => 'Ce champ doit être une adresse email valide.',
            'unique' => 'Ce :attribute est déjà utilisé.',
            'date' => 'Ce champ doit être une date valide.',
        ];
    }
}

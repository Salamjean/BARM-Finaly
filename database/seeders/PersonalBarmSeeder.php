<?php

namespace Database\Seeders;

use App\Models\FicheAutorisationCandidature;
use App\Models\PersonalBarm;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PersonalBarmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (PERSONALBARM as $key => $personal) {


            PersonalBarm::create([
                'firstname' => $personal['user']['firstname'],
                'lastname' => $personal['user']['lastname'],
                'username' => $personal['user']['username'],
                'email' => "personal$key@barm.ci",
                'phone' => deleteSpace($personal['user']['phone']),
                'type' => $personal['partner']['type'],
                'gender' => $personal['partner']['gender'],
                'birth_date' => $personal['partner']['birth_date'],
                'matricule_barm' => $personal['partner']['matricule_barm'],
                'grade' => $personal['partner']['grade'] ?? null,
                'statut_personnel' => $personal['partner']['statut_personnel'],
                'ville_barm' => $personal['partner']['ville_barm'] ?? null,
                'cell' => $personal['service'],
                'posts' => json_encode($personal['post']),
            ]);


        }
    }
}

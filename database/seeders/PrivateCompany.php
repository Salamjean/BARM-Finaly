<?php

namespace Database\Seeders;

use App\Models\Cohort;
use App\Models\Entreprise;
use Illuminate\Database\Seeder;

class PrivateCompany extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
                'nom' => 'Agence Emploi Jeune',
                'localisation' => 'Abidjan',
                'specialisation' => 'Sécurité',
                'num_decharge' => '45N10',
                'nom_point_focal' => 'Kouassi Bernard',
                'email_point_focal' => 'bernard@gmail.com',
            ],
            [
                'nom' => 'Entreprise privée 2',
                'localisation' => 'Bouaké',
                'specialisation' => 'Informatique',
                'num_decharge' => '78R68',
                'nom_point_focal' => 'Ahoussou Amandine',
                'email_point_focal' => 'amandine@gmail.com',
            ],
        ];

        foreach ($datas as $data) {
            $entreprise = new Entreprise();
            $entreprise->nom = $data['nom'];
            $entreprise->localisation = $data['localisation'];
            $entreprise->specialisation = $data['specialisation'];
            $entreprise->num_decharge = $data['num_decharge'];
            $entreprise->nom_point_focal = $data['nom_point_focal'];
            $entreprise->email_point_focal = $data['email_point_focal'];
            $entreprise->save();
        }

        $cohort = new Cohort();
        $cohort->reference = 'co-1';
        $cohort->title = 'Cohorte 1';
        $cohort->number_adherent = '45';
        $cohort->status = '0';
        $cohort->save();
    }
}

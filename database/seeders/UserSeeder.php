<?php

namespace Database\Seeders;

use App\Models\Candidature;
use App\Models\Partenaire;
use App\Models\Role;
use App\Models\Retired;
use App\Models\User;
use App\Models\Personnel;
use App\Models\Permission;
use App\Models\Submission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //ADMIN
        $admin = User::create([
            'firstname' => 'KKS',
            'lastname' => 'TECHNOLOGY',
            'username' => 'ADMIN',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('1234'),
        ]);

        $role = Role::whereName('ADMIN')->first();
        $admin->roles()->sync([$role->id]);

        $permissions = [];
        foreach ($role->permissions as $key => $can)
            $permissions[$key] = $can->id;

        foreach ($permissions as $perm)
            $admin->permissions()->sync([$perm]);

        //PARTNER
        $partners = [
            [
                'user' => [
                    'firstname' => '',
                    'lastname' => '',
                    'username' => 'FIDRA',
                    'email' => 'fidra@barm.ci',
                ],
                'partner' => [
                    'phone_number' => '+2252722558787',
                    'no_registre' => '2',
                    'address' => 'Abidjan, 02 Plateaux, 7ième tranche, Boulevard Latrille - BP 23 cidex 2 Abidjan 08',
                    'no_identification' => 'PF1',
                ]
            ],
            [
                'user' => [
                    'firstname' => '',
                    'lastname' => '',
                    'username' => 'ANADER',
                    'email' => 'anader@barm.ci',
                ],
                'partner' => [
                    'phone_number' => '+2252720216700',
                    'no_registre' => '1',
                    'address' => 'Plateau, Boulevard de la paix BPV 183 ABIDJAN',
                    'no_identification' => 'PT1',
                ]
            ],
            [
                'user' => [
                    'firstname' => '',
                    'lastname' => '',
                    'username' => 'AGEFOP',
                    'email' => 'agefop@barm.ci',
                ],
                'partner' => [
                    'phone_number' => '+2250715969696',
                    'no_registre' => '3',
                    'address' => 'En Zone 4c, à l’angle des rues Pierre et Marie Curie/Canal de Biétry',
                    'no_identification' => 'PT2',
                ]
            ],
            [
                'user' => [
                    'firstname' => '',
                    'lastname' => '',
                    'username' => 'INIE',
                    'email' => 'inie@barm.ci',
                ],
                'partner' => [
                    'phone_number' => '+2252722597507',
                    'no_registre' => '4',
                    'address' => 'Abidjan Cocody à l’angle de la rue Booker Washington et l’Avenue Jacques AKA',
                    'no_identification' => 'PT3',
                ]
            ],
            [
                'user' => [
                    'firstname' => '',
                    'lastname' => '',
                    'username' => 'PFS-CI',
                    'email' => 'pfsci@barm.ci',
                ],
                'partner' => [
                    'phone_number' => '+2250702966597',
                    'no_registre' => '5',
                    'address' => 'Yopougon, quartier Banco à proximité de l\'allocodrome municipal 21 BP12 Abidjan 21 -Abidjan, Côte d\'Ivoire',
                    'no_identification' => 'PT4',
                ]
            ],
            [
                'user' => [
                    'firstname' => '',
                    'lastname' => '',
                    'username' => 'BARM',
                    'email' => 'partner@barm.ci',
                ],
                'partner' => [
                    'phone_number' => '0153538950',
                    'no_registre' => '0012002550',
                    'address' => 'Abidjan, cocody',
                    'no_identification' => '00895AD0029',
                ]
            ],
        ];
        $role = Role::whereName('PARTNER')->first();
        $permissions = [];
        foreach ($role->permissions as $keyy => $can)
            $permissions[$keyy] = $can->id;

        foreach ($partners as $key => $partner) {

            $p = User::create([
                'firstname' => $partner['user']['firstname'],
                'lastname' => $partner['user']['lastname'],
                'username' => $partner['user']['username'],
                'email' => $partner['user']['email'],
                'password' => bcrypt('1234'),
            ]);

            Partenaire::create([
                'user_id' => $p->id,
                'phone_number' => $partner['partner']['phone_number'],
                'no_registre' => $partner['partner']['no_registre'] . $key,
                'address' => $partner['partner']['address'],
                'no_identification' => $partner['partner']['no_identification'] . $key,
            ]);

            $p->roles()->sync([$role->id]);

            if ($key == 0)
                $p->permissions()->sync([$permissions[0]]);
            elseif ($key == 5)
                $p->permissions()->sync($permissions);
            else {
                $p->permissions()->sync([$permissions[2]]);
            }
        }

        //PERSONAL
        foreach (PERSONALS as $key => $personal) {

            $p = User::create([
                'firstname' => $personal['user']['firstname'],
                'lastname' => $personal['user']['lastname'],
                'username' => $personal['user']['username'],
                'email' => "personal$key@barm.ci",
                'phone' => deleteSpace($personal['user']['phone']),
                'password' => bcrypt('1234'),
            ]);
            Personnel::create([
                'user_id' => $p->id,
                'type' => $personal['partner']['type'],
                'gender' => $personal['partner']['gender'],
                'birth_date' => $personal['partner']['birth_date'],
                'matricule_barm' => $personal['partner']['matricule_barm'],
                'grade' => $personal['partner']['grade'] ?? null,
                'statut_personnel' => $personal['partner']['statut_personnel'],
                'ville_barm' => $personal['partner']['ville_barm'] ?? null,

            ]);

            $role = Role::whereName($personal['service'])->first();
            $p->roles()->sync([$role->id]);

            $permissions  = [];
            foreach($personal['post'] as $post){
                $per = Permission::whereName($post)->first();
                // dd($per);
                if($per)
                    $permissions[] = $per->id;
            }

            if(count($permissions) == 0)
                dd($role);
            /**
             * view error
             *      @model role
             *      or
             *      @model permission
             */

            $p->permissions()->sync($permissions);
        }
    }
}

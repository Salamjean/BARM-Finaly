<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = [
            [
                'name' => 'ADMIN',
                'permissions' => [
                    'ADMIN',
                ],
            ],
            [
                'name' => 'CANDIDAT',
                'permissions' => [
                    'CANDIDAT',
                ],
            ],
            [
                'name' => 'PARTNER',
                'permissions' => [
                    'PARTNER FINANCIAL',
                    'PARTNER EMPLOYMENT',
                    'PARTNER TECHNICAL',
                ],
            ],
            [
                'name' => 'CHEF BARM',
                'permissions' => [
                    'CHEF BARM'
                ],
            ],
            [
                'name' => 'POINTS FOCAUX',
                'permissions' => [
                    'POINT FOCAL',
                ],
            ],

            [
                'name' => 'CELLULE FORMATION ET INSERTION',
                'permissions' => [
                    'CHEF CELLULE FORMATION ET INSERTION',
                    'CONSEILLER AUTO EMPLOI',
                    'CONSEILLER ENTREPRISE PRIVE',
                    'CONSEILLER FONCTION PUBLIC',
                    'CONSEILLER EN RECONVERSION',
                ],
            ],
            [
                'name' => 'CELLULE SUIVI-EVALUATION',
                'permissions' => [
                    'CHEF CELULLE SUIVI-EVALUATION',
                    'RESPONSABLE DES SYSTEMES DE L’INFORMATION',
                    'RESPONSABLE SUIVI-EVALUATION',
                    'ASSISTANT SUIVI-EVALUATION',
                ],
            ],
            [
                'name' => 'CELLULE ADMINISTRATION FINANCE LOGISTIQUE',
                'permissions' => [
                    'RESPONSABLE GESTIONNAIRE DES RESSOURCES HUMAINES',
                ],
            ],
            [
                'name' => 'CABINET CHEF BARM',
                'permissions' => [
                    'RESPONSABLE DES MOYENS GENERAUX',
                ],
            ],

        ];

        foreach ($roles as $role) {

            (string)$name = $role['name'];

            $r = new Role();
            $r->name = $name;
            $r->slug = generateSlug($name);

            $r->save();

            $pId = [];

                foreach ($role['permissions'] as $key => $permission) {

                    $p = Permission::create([
                        'name' => $permission,
                        'slug' => generateSlug($permission),
                    ]);

                    $pId[] = (int)$p->id;
                }



            $r->permissions()->sync($pId);
        }
    }
}

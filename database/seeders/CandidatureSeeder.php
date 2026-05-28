<?php

namespace Database\Seeders;

use App\Models\Candidature;
use App\Models\Role;
use App\Models\Retired;
use App\Models\User;
use Illuminate\Database\Seeder;

class CandidatureSeeder extends Seeder
{

    public function run(): void
    {
        $retired = Retired::create([
            'mecano' => 'MECAN2024',
            'matricule' => 'MECAN2024',
            'firstname' => 'AHUA',
            'lastname' => 'Djenaba',
            'birth_date' => '1985-12-29',
            'year' => date('Y'),
            'grade' => 'Lieutenant',
            'gender' => 'M',
            'unit' => 'Cavalerie',
            'army' => 'Terre',
            'retired_date' => '2024-01-01',
            'retired_type' => 'Départ volontaire',
            'used' =>  true,
            'personal_id' => 10,
        ]);

        $user = User::create([
            'mecano' => 'MECAN2024',
            'matricule' => 'MECAN2024',
            'firstname' => 'AHUA',
            'lastname' => 'Djenaba',
            'username' => 'Ahua2024',
            'email' => 'candidat1@gmail.com',
            'password' => bcrypt('1234'),
        ]);

        Candidature::create([
            'date_radiation' => $retired->retired_date,
            'condition_admin' => $retired->retired_type,
            'unite_rattachement' => $retired->unit,
            'armee' => $retired->army,
            'grade' => $retired->grade,
            'user_id' => $user->id,
            'created_by' => 14,
            'cgrae_no' => '2622222',
            'image' => '',
            'phone_number' => '0173333388',
            'type_piece' => TYPEPIECES[0],
            'no_card' => 'CN2938843838',
            'birth_date' => '1985-12-29',
            'gender' => GENDERS[0],
            'ethnic' => ETHNICS[2],
            'religion' => RELIGIONS[0],
        ]);
        $role = Role::whereName('CANDIDAT')->first();
        $user->roles()->sync([$role->id]);

        $permissions = [];
        foreach ($role->permissions as $key => $can)
            $permissions[$key] = $can->id;

        foreach ($permissions as $perm)
            $user->permissions()->sync([$perm]);
    }
}

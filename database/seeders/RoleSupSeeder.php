<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = [
            
            [
                'name' => 'MINISTERE DE LA DÉFENSE',
                'permissions' => [
                    'C2D',
                    'MEMDEF',
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

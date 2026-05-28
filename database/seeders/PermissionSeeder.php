<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create role',
            'edit role',
            'delete role',
            'view roles list',
            'update role',
            'create user',
            'edit user',
            'delete user',
            'view users list',
            'update user',
            'create permission',
            'edit permission',
            'delete permission',
            'view permissions list',
            'update permission',
            'submit permission formulaire',
            'delete personnel',
            'edit personnel',
            'create personnel',
            'view personnel',
            'manage personnel',
            'delete candidat',
            'edit candidat',
            'create candidat',
            'view candidat',
            'manage candidat',
            'delete partenaire',
            'edit partenaire',
            'create partenaire',
            'view partenaire',
            'manage partenaire',
         ];
 
         foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
          }
    }
}

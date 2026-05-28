<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Console\Command;

class AssignPermission extends Command
{
    protected $signature = 'assign:permission {user} {permission}';
    protected $description = 'Assign a permission to a user';

    public function handle()
    {
        $userId = $this->argument('user');
        $permissionName = $this->argument('permission');

        $user = User::findOrFail($userId);
        $permission = Permission::where('name', $permissionName)->firstOrFail();

        $user->permissions()->syncWithoutDetaching([$permission->id]);

        $this->info("Permission {$permission->name} assigned to user {$user->name}.");
    }
}

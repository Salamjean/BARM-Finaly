<?php

namespace App\Console\Commands;

use App\Models\Role;
use App\Models\User;
use Illuminate\Console\Command;

class AssignRole extends Command
{
    protected $signature = 'assign:role {user} {role}';
    protected $description = 'Assign a role to a user';

    public function handle()
    {
        $userId = $this->argument('user');
        $roleName = $this->argument('role');

        $user = User::findOrFail($userId);
        $role = Role::where('name', $roleName)->firstOrFail();

        $user->roles()->syncWithoutDetaching([$role->id]);

        $this->info("Role {$role->name} assigned to user {$user->name}.");
    }
}

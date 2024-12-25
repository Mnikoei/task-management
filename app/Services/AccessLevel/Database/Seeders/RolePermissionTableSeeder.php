<?php

namespace App\Services\AccessLevel\Database\Seeders;

use App\Services\AccessLevel\Models\Permission;
use App\Services\AccessLevel\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionTableSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = $this->getAdminRole();

        Permission::query()
            ->get()
            ->each(fn($permission) => $adminRole->permissions()->save($permission));
    }

    public function getAdminRole(): Role
    {
         return Role::whereTitle('admin')->first();
    }
}

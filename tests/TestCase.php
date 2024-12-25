<?php

namespace Tests;

use App\Services\AccessLevel\Models\Role;
use App\Services\User\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    public function authenticatedUser(array $data = []): User
    {
        $user = $this->user($data, adminAccess: true);

        $this->authenticate($user);

        return $user;
    }

    public function user(array $data = [], bool $adminAccess = false): User
    {
        $user = User::factory()->create($data);

        if ($adminAccess) {
            $this->attachAdminRole($user);
        }

        return $user;
    }

    public function authenticate(User $user)
    {
        Sanctum::actingAs($user, ['*']);
    }

    public function attachAdminRole(User $user)
    {
        $user->roles()->save(value(function () {

            $adminRole = Role::whereTitle('admin')->first();

            if (!$adminRole) {
                abort(500, 'There is no admin role, did you seed roles?');
            }

            return $adminRole;
        }));
    }
}

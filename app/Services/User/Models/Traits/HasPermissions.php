<?php

namespace App\Services\User\Models\Traits;

use App\Services\AccessLevel\Models\Permission;
use Illuminate\Support\Collection;


trait HasPermissions
{
    public function hasPermission(string $title): bool
    {
        return (bool) $this->permissions()
            ->firstWhere(fn(Permission $permission) => $permission->title === $title );
    }

    public function permissions(): Collection
    {
        return static::cacheRepo()->remember(
            key: 'permissions',
            ttl: now()->addDay(),
            callback: fn() => ($this->roles->map->permissions)->flatten()
        );
    }
}

<?php

namespace App\Services\User\Models;

use App\Contracts\CacheRepoContract;
use App\Services\AccessLevel\Models\Role;
use App\Services\AccessLevel\Models\RoleUser;
use App\Services\User\Database\Factory\UserFactory;
use App\Services\User\Models\Traits\HasCacheRepo;
use App\Services\User\Models\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements CacheRepoContract
{
    use HasFactory;
    use Notifiable;
    use HasApiTokens;
    use HasPermissions;
    use HasCacheRepo;

    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->using(RoleUser::class);
    }
}

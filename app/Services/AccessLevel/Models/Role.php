<?php

namespace App\Services\AccessLevel\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $fillable = [
        'title',
        'description'
    ];

    public function permissions(): BelongsToMany
    {
       return $this->belongsToMany(Permission::class)->using(PermissionRole::class);
    }
}

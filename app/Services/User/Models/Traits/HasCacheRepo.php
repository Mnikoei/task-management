<?php

namespace App\Services\User\Models\Traits;

use Illuminate\Cache\TaggedCache;
use Illuminate\Support\Facades\Cache;

trait HasCacheRepo
{
    public static function cacheTags(): array
    {
        return ['user-cache-tag'];
    }

    public static function cacheRepo(array $extraTags = []): TaggedCache
    {
        // @todo this should a single specified class for each Model in practice
        return Cache::tags(static::cacheTags());
    }
}

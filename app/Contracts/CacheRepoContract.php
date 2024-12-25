<?php

namespace App\Contracts;

use Illuminate\Cache\TaggedCache;

interface CacheRepoContract
{
    public static function cacheTags(): array;
    public static function cacheRepo(array $extraTags = []): TaggedCache;
}

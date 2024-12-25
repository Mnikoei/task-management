<?php

namespace App\Services\Task\Models;

use App\Contracts\CacheRepoContract;
use App\Services\Task\Database\Factory\TaskFactory;
use App\Services\Task\Models\Enums\TaskStatus;
use App\Services\Task\Models\Observers\TaskHistoryRecorder;
use App\Services\Task\Models\Traits\HasState;
use App\Services\User\Models\User;
use App\Services\Utils\ModelsSupport\HasFilters;
use Illuminate\Cache\TaggedCache;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

#[ObservedBy([TaskHistoryRecorder::class])]
class Task extends Model implements CacheRepoContract
{
    use HasFactory, SoftDeletes, HasState, HasFilters;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'status',
        'creator_id'
    ];

    protected $casts = [
        'status' => TaskStatus::class,
        'due_date' => 'datetime',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function user(): BelongsTo
    {
        return $this->creator();
    }

    protected static function newFactory()
    {
        return TaskFactory::new();
    }

    public static function cacheTags(): array
    {
        return ['tasks'];
    }

    public static function cacheRepo(array $extraTags = []): TaggedCache
    {
        return Cache::tags(static::cacheTags() + $extraTags);
    }

    protected static function boot()
    {
        parent::boot();

        $flushCachedTasksOfUser = function ($task) {
            static::cacheRepo(["user-{$task->creator_id}"])->flush();
        };

        static::created($flushCachedTasksOfUser);
        static::deleted($flushCachedTasksOfUser);
        static::updated($flushCachedTasksOfUser);
    }
}

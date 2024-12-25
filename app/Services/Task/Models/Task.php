<?php

namespace App\Services\Task\Models;

use App\Services\Task\Models\Enums\TaskStatus;
use App\Services\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'created_by',
        'due_date',
        'status'
    ];

    protected $casts = [
        'status' => TaskStatus::class,
        'due_date' => 'datetime:Y-m-d H:i:s',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

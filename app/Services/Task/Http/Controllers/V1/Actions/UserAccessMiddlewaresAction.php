<?php

namespace App\Services\Task\Http\Controllers\V1\Actions;

use App\Services\AccessLevel\Http\MiddleWares\EnsureHasPermission;
use App\Services\Task\Http\Controllers\V1\TaskController;
use Illuminate\Routing\Controllers\Middleware;

readonly class UserAccessMiddlewaresAction
{
    public function __construct(){}

    public function register(): array
    {
        return [
            new Middleware(EnsureHasPermission::class.':creates-task', only: ['store']),
            new Middleware(EnsureHasPermission::class.':updates-task', only: ['update']),
            new Middleware(EnsureHasPermission::class.':deletes-task', only: ['destroy']),
        ];
    }
}

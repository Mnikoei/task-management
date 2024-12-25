<?php

namespace App\Services\AccessLevel\Http\MiddleWares;

use Illuminate\Http\Request;

class EnsureHasPermission
{
    public function handle(Request $request, \Closure $next, string $permission)
    {
        return $request->user()?->hasPermission($permission)
            ? $next($request)
            : abort(403, 'access denied!');
    }
}

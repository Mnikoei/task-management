<?php

namespace App\Services\User\Http\Resources\Auth;

use App\Services\User\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        return [
            'access_token' => $this->plainTextToken,
            'scopes' => $this->accessToken->abilities,
            'expires_at' => $this->accessToken->expires_at->toDatetimeString()
        ];
    }
}

<?php

namespace App\Services\User\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterUserResource extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        return [
            'user' => new UserResource($this->resource),
            'redirect_to' => 'panel'
        ];
    }
}

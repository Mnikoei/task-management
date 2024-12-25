<?php

namespace App\Services\User\Http\Resources;

use App\Services\Utils\FileSystem\Models\File;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        return [
            'username' => $this->username,
        ];
    }
}

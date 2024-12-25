<?php

namespace App\Services\Task\Http\Resources\V1;

use App\Services\User\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public static $wrap = false;
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'creator' => new UserResource($this->creator),
            'due_date' => $this->due_date->toDatetimeString(),
            'due_date_for_humans' => $this->due_date->diffForHumans(),
            'status' => $this->status
        ];
    }
}

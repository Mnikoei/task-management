<?php

namespace App\Services\Task\Http\Requests\V1;

use App\Services\Task\Models\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskListRequest extends FormRequest
{
    public function rules()
    {
        return [

        ];
    }
}

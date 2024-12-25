<?php

namespace App\Services\Task\Http\Requests\V1;

use App\Services\Task\Models\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTaskRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'sometimes|string|min:3|max:255',
            'description' => 'sometimes|string|min:3|max:5000',
            'due_date' => 'sometimes|date|after:+1 hour',
            'status' => ['sometimes', Rule::in(TaskStatus::cases())]
        ];
    }
}

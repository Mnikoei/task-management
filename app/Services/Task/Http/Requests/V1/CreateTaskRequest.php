<?php

namespace App\Services\Task\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:3|max:5000',
            'due_date' => 'required|date|after:+1 hour'
        ];
    }
}

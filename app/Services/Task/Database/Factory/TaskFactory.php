<?php

namespace App\Services\Task\Database\Factory;

use App\Services\Task\Models\Enums\TaskStatus;
use App\Services\Task\Models\Task;
use App\Services\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => fake()->title,
            'description' => fake()->text,
            'due_date' => now()->addHours(5),
            'status' => TaskStatus::PENDING,
            'creator_id' => User::factory()->create()->id
        ];
    }
}

<?php

use App\Services\Task\Http\Controllers\V1\TaskController;

Route::resource('task', TaskController::class);

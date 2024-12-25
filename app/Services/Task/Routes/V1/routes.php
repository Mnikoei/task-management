<?php

use App\Services\Task\Http\Controllers\V1\StateController;
use App\Services\Task\Http\Controllers\V1\TaskController;

Route::resource('task', TaskController::class);

Route::prefix('task')->group(function () {

    Route::post('{task}/state/next', [StateController::class, 'next']);
    Route::post('{task}/state/previous', [StateController::class, 'previous']);

});

<?php

use App\Http\Controllers\Api\UserTasksController;
use Illuminate\Support\Facades\Route;

Route::get('/users/{user}/tasks', [UserTasksController::class, 'index']);

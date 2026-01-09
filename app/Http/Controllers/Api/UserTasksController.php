<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserTasksController extends Controller
{
    public function index(User $user)
    {
        $tasks = $user->tasks()
            ->orderBy('due_date')
            ->orderBy('id')
            ->get(['id', 'user_id', 'title', 'description', 'status', 'due_date', 'created_at', 'updated_at']);

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->mobile,
            ],
            'tasks' => $tasks,
        ]);
    }
}

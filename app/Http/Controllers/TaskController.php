<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()->orderBy('name')->get(['id', 'name']);

        $query = Task::query()->with('user')->orderBy('due_date')->orderBy('id');

        $status = $request->string('status')->toString();
        if (in_array($status, ['pending', 'completed'], true)) {
            $query->where('status', $status);
        }

        $userId = $request->integer('user_id');
        if ($userId) {
            $query->where('user_id', $userId);
        }

        if ($request->boolean('overdue')) {
            $query->where('status', 'pending')
                ->whereDate('due_date', '<', Carbon::today());
        }

        $tasks = $query->paginate(10)->withQueryString();

        return view('tasks.index', compact('tasks', 'users'));
    }

    public function create(Request $request)
    {
        $users = User::query()->orderBy('name')->get(['id', 'name']);
        $selectedUserId = $request->integer('user_id') ?: null;

        return view('tasks.create', compact('users', 'selectedUserId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:pending,completed'],
            'due_date' => ['required', 'date', 'after_or_equal:today'],
        ]);

        Task::create($validated);

        return redirect()->route('tasks.index')->with('success', 'Task created.');
    }

    public function edit(Task $task)
    {
        $users = User::query()->orderBy('name')->get(['id', 'name']);

        return view('tasks.edit', compact('task', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:pending,completed'],
            'due_date' => ['required', 'date'],
        ]);

        $incomingDueDate = Carbon::parse($validated['due_date'])->startOfDay();
        $currentDueDate = optional($task->due_date)->startOfDay();

        if ($incomingDueDate->isBefore(Carbon::today()) && (! $currentDueDate || ! $incomingDueDate->equalTo($currentDueDate))) {
            throw ValidationException::withMessages([
                'due_date' => ['The due date cannot be a past date.'],
            ]);
        }

        $task->update($validated);

        return redirect()->route('tasks.index')->with('success', 'Task updated.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }
}

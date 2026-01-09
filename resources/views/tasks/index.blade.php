@extends('layouts.app')

@section('title', 'Tasks')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Tasks</h1>
        <a class="btn btn-primary" href="{{ route('tasks.create') }}">Add Task</a>
    </div>

    <form class="card mb-3" method="get" action="{{ route('tasks.index') }}">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label" for="user_id">User</label>
                    <select class="form-select" name="user_id" id="user_id">
                        <option value="">All</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected((string)$user->id === request('user_id'))>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label" for="status">Status</label>
                    <select class="form-select" name="status" id="status">
                        <option value="">All</option>
                        <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                        <option value="completed" @selected(request('status') === 'completed')>Completed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="overdue" name="overdue" value="1" @checked(request()->boolean('overdue'))>
                        <label class="form-check-label" for="overdue">Overdue only</label>
                    </div>
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button class="btn btn-outline-primary w-100" type="submit">Filter</button>
                    <a class="btn btn-outline-secondary w-100" href="{{ route('tasks.index') }}">Reset</a>
                </div>
            </div>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
            <tr>
                <th>Title</th>
                <th>User</th>
                <th>Status</th>
                <th>Due Date</th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($tasks as $task)
                @php
                    $isOverdue = $task->status === 'pending' && $task->due_date && $task->due_date->isBefore(\Carbon\Carbon::today());
                @endphp
                <tr class="{{ $isOverdue ? 'table-danger' : '' }}">
                    <td>
                        <div class="fw-semibold">{{ $task->title }}</div>
                        @if ($task->description)
                            <div class="text-muted small">{{ $task->description }}</div>
                        @endif
                    </td>
                    <td>{{ $task->user?->name }}</td>
                    <td>
                        <span class="badge {{ $task->status === 'completed' ? 'text-bg-success' : 'text-bg-secondary' }}">{{ ucfirst($task->status) }}</span>
                    </td>
                    <td>{{ optional($task->due_date)->format('Y-m-d') }}</td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('tasks.edit', $task) }}">Edit</a>
                        <form class="d-inline" method="post" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No tasks found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $tasks->links() }}
@endsection

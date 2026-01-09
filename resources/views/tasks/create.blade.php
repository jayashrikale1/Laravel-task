@extends('layouts.app')

@section('title', 'Add Task')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Add Task</h1>
        <a class="btn btn-outline-secondary" href="{{ route('tasks.index') }}">Back</a>
    </div>

    <form method="post" action="{{ route('tasks.store') }}" class="card">
        @csrf
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label" for="user_id">User</label>
                <select class="form-select" id="user_id" name="user_id" required>
                    <option value="">Select user</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" @selected((string)$user->id === old('user_id', (string)($selectedUserId ?? '')))>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="title">Title</label>
                <input class="form-control" id="title" name="title" value="{{ old('title') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label" for="status">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="pending" @selected(old('status', 'pending') === 'pending')>Pending</option>
                        <option value="completed" @selected(old('status') === 'completed')>Completed</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="due_date">Due Date</label>
                    <input class="form-control" id="due_date" name="due_date" type="date" value="{{ old('due_date') }}" required>
                </div>
            </div>
            <div class="mt-3">
                <button class="btn btn-primary" type="submit">Create</button>
            </div>
        </div>
    </form>
@endsection

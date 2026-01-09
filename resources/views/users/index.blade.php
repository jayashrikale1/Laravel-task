@extends('layouts.app')

@section('title', 'Users')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Users</h1>
        <a class="btn btn-primary" href="{{ route('users.create') }}">Add User</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th class="text-end">Total Tasks</th>
                <th class="text-end">Completed Tasks</th>
                <th class="text-end">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->mobile }}</td>
                    <td class="text-end">{{ $user->tasks_count }}</td>
                    <td class="text-end">{{ $user->completed_tasks_count }}</td>
                    <td class="text-end">
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('users.edit', $user) }}">Edit</a>
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('tasks.create', ['user_id' => $user->id]) }}">Add Task</a>
                        <form class="d-inline" method="post" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')">
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">No users found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $users->links() }}
@endsection

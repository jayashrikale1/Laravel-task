@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Edit User</h1>
        <a class="btn btn-outline-secondary" href="{{ route('users.index') }}">Back</a>
    </div>

    <form method="post" action="{{ route('users.update', $user) }}" class="card">
        @csrf
        @method('put')
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label" for="name">Name</label>
                <input class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input class="form-control" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="mobile">Mobile</label>
                <input class="form-control" id="mobile" name="mobile" value="{{ old('mobile', $user->mobile) }}" required>
            </div>
            <button class="btn btn-primary" type="submit">Save</button>
        </div>
    </form>
@endsection

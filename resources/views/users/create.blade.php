@extends('layouts.app')

@section('title', 'Add User')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Add User</h1>
        <a class="btn btn-outline-secondary" href="{{ route('users.index') }}">Back</a>
    </div>

    <form method="post" action="{{ route('users.store') }}" class="card">
        @csrf
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label" for="name">Name</label>
                <input class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="mobile">Mobile</label>
                <input class="form-control" id="mobile" name="mobile" value="{{ old('mobile') }}" required>
            </div>
            <button class="btn btn-primary" type="submit">Create</button>
        </div>
    </form>
@endsection

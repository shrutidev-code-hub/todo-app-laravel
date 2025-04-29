<!-- resources/views/auth/login.blade.php -->
@extends('layout')

@section('content')
<div class="col-md-6 offset-md-3">
    <h2>Login</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary">Login</button>
        <a href="{{ route('register') }}" class="btn btn-link">New user? Register here</a>
    </form>
</div>
@endsection

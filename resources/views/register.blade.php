<!-- resources/views/auth/register.blade.php -->
@extends('layout')

@section('content')
<div class="col-md-6 offset-md-3">
    <h2>Register</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Password:</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button class="btn btn-primary">Register</button>
        <a href="{{ route('login') }}" class="btn btn-link">Already have an account?</a>
    </form>
</div>
@endsection


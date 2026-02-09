@extends('layouts.app')

@section('content')
    <div class="card bg-base-100 shadow-xl border border-base-300">
        <div class="card-body">
            <div class="mb-8 text-center">
                <h1
                    class="text-3xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent mb-2">
                    Reset Password</h1>
                <p class="text-base-content/60">Enter your email to receive reset instructions</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success text-sm mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div class="form-control">
                    <label for="email" class="label">
                        <span class="label-text">Email Address</span>
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="input input-bordered w-full {{ $errors->has('email') ? 'input-error' : '' }}">
                    @error('email')
                        <p class="mt-1 text-sm text-error">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="btn btn-primary w-full">
                        Send Reset Link
                    </button>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}" class="link link-hover text-sm text-base-content/60">
                        Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('content')
    <div class="card bg-base-100 shadow-xl border border-base-300">
        <div class="card-body">
            <div class="mb-8 text-center">
                <h1
                    class="text-3xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent mb-2">
                    Welcome Back</h1>
                <p class="text-base-content/60">Enter your credentials to access your account</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
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

                <div class="form-control">
                    <label for="password" class="label">
                        <span class="label-text">Password</span>
                    </label>
                    <input id="password" type="password" name="password" required
                        class="input input-bordered w-full {{ $errors->has('password') ? 'input-error' : '' }}">
                    @error('password')
                        <p class="mt-1 text-sm text-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="link link-primary no-underline hover:underline">
                            Forgot password?
                        </a>
                    </div>
                </div>

                <div>
                    <button type="submit" class="btn btn-primary w-full">
                        Sign In
                    </button>
                </div>

                <div class="text-center mt-4">
                    <p class="text-sm text-base-content/60">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="link link-primary no-underline hover:underline">Create
                            Account</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
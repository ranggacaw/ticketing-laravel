@extends('layouts.app')

@section('content')
    <div class="card bg-base-100 shadow-xl border border-base-300">
        <div class="card-body">
            <div class="mb-8 text-center">
                <h1
                    class="text-3xl font-bold bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent mb-2">
                    Create Account</h1>
                <p class="text-base-content/60">Join to manage your tickets and payments</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div class="form-control">
                    <label for="name" class="label">
                        <span class="label-text">Full Name</span>
                    </label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="input input-bordered w-full {{ $errors->has('name') ? 'input-error' : '' }}">
                    @error('name')
                        <p class="mt-1 text-sm text-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-control">
                    <label for="email" class="label">
                        <span class="label-text">Email Address</span>
                    </label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="input input-bordered w-full {{ $errors->has('email') ? 'input-error' : '' }}">
                    @error('email')
                        <p class="mt-1 text-sm text-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-control">
                    <label for="phone" class="label">
                        <span class="label-text">Phone Number (Optional)</span>
                    </label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                        class="input input-bordered w-full {{ $errors->has('phone') ? 'input-error' : '' }}">
                    @error('phone')
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

                <div class="form-control">
                    <label for="password_confirmation" class="label">
                        <span class="label-text">Confirm Password</span>
                    </label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="input input-bordered w-full">
                </div>

                <div>
                    <button type="submit" class="btn btn-primary w-full">
                        Register
                    </button>
                </div>

                <div class="text-center mt-4">
                    <p class="text-sm text-base-content/60">
                        Already have an account?
                        <a href="{{ route('login') }}" class="link link-primary no-underline hover:underline">Sign
                            in</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
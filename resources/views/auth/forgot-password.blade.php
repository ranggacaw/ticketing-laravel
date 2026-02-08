@extends('layouts.app')

@section('content')
    <div class="glass p-8 rounded-2xl shadow-2xl border border-white/10 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-cyan-500"></div>

        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold gradient-text mb-2">Reset Password</h1>
            <p class="text-slate-400">Enter your email to receive reset instructions</p>
        </div>

        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-400 bg-green-900/20 p-3 rounded">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-slate-300 mb-1">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full px-4 py-3 rounded-lg bg-slate-800/50 border border-slate-700 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                @error('email')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <button type="submit"
                    class="w-full py-3 px-4 rounded-lg bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-500 hover:to-cyan-500 text-white font-medium shadow-lg shadow-blue-500/20 transform hover:-translate-y-0.5 transition-all duration-200">
                    Send Reset Link
                </button>
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('login') }}" class="text-sm text-slate-400 hover:text-white transition-colors">
                    Back to Login
                </a>
            </div>
        </form>
    </div>
@endsection
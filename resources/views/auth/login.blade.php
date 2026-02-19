@extends('layouts.app')

@section('content')
    <div class="card bg-white shadow-2xl shadow-slate-200/50 border border-slate-100 rounded-3xl overflow-hidden">
        <div class="card-body p-8 md:p-10">
            <div class="mb-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary-ref/10 mb-6">
                    <span class="material-symbols-outlined text-3xl text-primary-ref">lock</span>
                </div>
                <h1 class="text-3xl font-black font-display text-slate-900 mb-2">
                    Welcome Back!
                </h1>
                <p class="text-slate-500 font-medium font-sans">Enter your credentials to continue</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6" x-data="{ showPassword: false }">
                @csrf

                <div class="form-control hover:group">
                    <label for="email" class="label px-1">
                        <span class="label-text font-bold text-slate-700">Email Address</span>
                    </label>
                    <div class="relative group">
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            placeholder="name@example.com"
                            class="input w-full pl-12 bg-slate-50 border-slate-200 text-slate-900 placeholder:text-slate-400 rounded-lg focus:bg-white focus:border-primary-ref focus:ring-4 focus:ring-primary-ref/10 transition-all duration-300 {{ $errors->has('email') ? '!border-red-500 !bg-red-50' : '' }}">
                        <div
                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors duration-300 z-10">
                            <span
                                class="material-symbols-outlined text-[20px] text-slate-400 group-focus-within:text-primary-ref">mail</span>
                        </div>
                    </div>
                    @error('email')
                        <p class="mt-2 text-xs font-bold text-red-500 flex items-center">
                            <span class="material-symbols-outlined text-sm mr-1">error</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="form-control">
                    <label for="password" class="label px-1">
                        <span class="label-text font-bold text-slate-700">Password</span>
                    </label>
                    <div class="relative group">
                        <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required
                            placeholder="Enter your password"
                            class="input w-full pl-12 pr-12 bg-slate-50 border-slate-200 text-slate-900 placeholder:text-slate-400 rounded-lg focus:bg-white focus:border-primary-ref focus:ring-4 focus:ring-primary-ref/10 transition-all duration-300 {{ $errors->has('password') ? '!border-red-500 !bg-red-50' : '' }}">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                            <span
                                class="material-symbols-outlined text-[20px] text-slate-400 group-focus-within:text-primary-ref">key</span>
                        </div>
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors z-10">
                            <span class="material-symbols-outlined text-[20px]" x-show="!showPassword">visibility</span>
                            <span class="material-symbols-outlined text-[20px]" x-show="showPassword"
                                style="display: none;">visibility_off</span>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-2 text-xs font-bold text-red-500 flex items-center">
                            <span class="material-symbols-outlined text-sm mr-1">error</span>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="flex items-center justify-between px-1">
                    <label class="cursor-pointer inline-flex items-center gap-2 group">
                        <input type="checkbox" name="remember"
                            class="checkbox checkbox-xs rounded-md border-slate-300 checked:bg-primary-ref checked:border-primary-ref [--chkbg:theme(colors.primary-ref)]" />
                        <span
                            class="label-text text-sm font-bold text-slate-500 group-hover:text-slate-700 transition-colors">Remember
                            me</span>
                    </label>
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}"
                            class="text-primary-ref font-bold hover:text-red-700 transition-colors no-underline">
                            Forgot password?
                        </a>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="btn btn-block bg-primary-ref hover:bg-red-700 border-none text-white font-black text-base rounded-lg h-12 shadow-xl shadow-primary-ref/20 hover:shadow-2xl hover:shadow-primary-ref/30 hover:-translate-y-0.5 transition-all duration-300">
                        Sign In
                    </button>
                </div>

                <div class="text-center mt-8 pt-6 border-t border-slate-50">
                    <p class="text-sm text-slate-400 font-medium">
                        Don't have an account?
                        <a href="{{ route('register') }}"
                            class="text-primary-ref font-bold hover:text-red-700 hover:underline transition-colors ml-1">Create
                            Account</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
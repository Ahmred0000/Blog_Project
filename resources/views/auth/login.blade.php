@extends('layouts.app')
@section('title', __('login.Login'))

@section('content')
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('login.Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('login.Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('login.Remember_me') }}</span>
            </label>
        </div>

        <!-- Actions -->
        <div class="d-flex justify-content-between align-items-center mt-4">
            @if (Route::has('password.request'))
                <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                    {{ __('login.Forgot_your_password?') }}
                </a>
            @endif

            <div>
                <x-primary-button>
                    {{ __('login.Log_in') }}
                </x-primary-button>
                <a href="{{ route('register') }}" class="btn btn-outline-primary ms-2">
                    {{ __('login.Register') }}
                </a>
            </div>
        </div>
    </form>

    <!-- Social Logins -->
    <div class="mt-6 space-y-3">
        <a href="{{ route('login.google') }}"
           class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-600 transition duration-200">
            {{ __('navbar.login_google') }}
        </a>

        <a href="{{ route('login.github') }}"
           class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-800 text-white font-semibold rounded-lg shadow-md hover:bg-gray-900 transition duration-200">
            {{ __('navbar.login_github') }}
        </a>
    </div>
</x-guest-layout>
@endsection

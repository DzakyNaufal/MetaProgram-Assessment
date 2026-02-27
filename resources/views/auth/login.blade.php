@extends('layouts.auth')

@section('content')
    <div class="w-full max-w-md">
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <h2 class="mb-8 text-2xl font-bold text-center text-gray-800">Masuk ke Akun Anda</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" class="block mb-2 font-medium text-gray-700" />
                <x-text-input id="email"
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" class="block mb-2 font-medium text-gray-700" />

                <x-text-input id="password"
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    type="password" name="password" required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Remember Me -->
            <div class="block mb-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox"
                        class="text-blue-600 rounded shadow-sm border-gray-30 focus:ring-blue-500" name="remember">
                    <span class="text-sm text-gray-600 ms-2">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-6">
                @if (Route::has('password.request'))
                    <a class="text-sm text-blue-600 underline rounded-md hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                        href="{{ route('password.request') }}">
                        {{ __('Lupa Password?') }}
                    </a>
                @endif

                <x-primary-button
                    class="px-6 py-3 font-semibold text-white transition duration-300 ease-in-out transform bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 hover:scale-105">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>

            <div class="mt-6 text-center text-gray-600">
                Belum punya akun? <a href="{{ route('register') }}"
                    class="font-medium text-blue-600 hover:text-blue-800">Daftar di sini</a>
            </div>
        </form>
    </div>
@endsection

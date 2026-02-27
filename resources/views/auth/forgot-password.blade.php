@extends('layouts.auth')

@section('content')
    <div class="w-full max-w-md">
        <h2 class="mb-4 text-2xl font-bold text-center text-gray-800">Lupa Password?</h2>

        <div class="mb-6 text-sm text-gray-600 text-center">
            Masukkan email Anda dan kami akan mengirimkan link untuk mereset password.
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" class="block mb-2 font-medium text-gray-700" />
                <x-text-input id="email"
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    type="email" name="email" :value="old('email')" required autofocus autocomplete="email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
            </div>

            <div class="flex items-center justify-between mt-6">
                <a class="text-sm text-blue-600 underline rounded-md hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    href="{{ route('login') }}">
                    {{ __('Kembali ke Login') }}
                </a>

                <x-primary-button
                    class="px-6 py-3 font-semibold text-white transition duration-300 ease-in-out transform bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 hover:scale-105">
                    {{ __('Kirim Link Reset') }}
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection

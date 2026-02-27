@extends('layouts.auth')

@section('content')
    <div class="w-full max-w-md">
        <h2 class="mb-8 text-2xl font-bold text-center text-gray-800">Buat Akun Baru</h2>

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" class="block mb-2 font-medium text-gray-700" />
                <x-text-input id="name"
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    type="text" name="name" :value="old('name')" required autofocus autocomplete="name" pattern="[A-Za-z0-9]+" />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-red-600" />
                <p class="mt-1 text-xs text-gray-500">Hanya huruf (A-Z, a-z) dan angka (0-9)</p>
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" class="block mb-2 font-medium text-gray-700" />
                <x-text-input id="email"
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" class="block mb-2 font-medium text-gray-700" />

                <x-text-input id="password"
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    type="password" name="password" required autocomplete="new-password" minlength="8" />

                <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-600" />
                <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter: huruf (A-Z, a-z), angka (0-9), karakter khusus (!@#$%^&* dll)</p>
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="block mb-2 font-medium text-gray-700" />

                <x-text-input id="password_confirmation"
                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    type="password" name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-600" />
            </div>

            <div class="flex items-center justify-between mt-6">
                <a class="text-sm text-blue-600 underline rounded-md hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button
                    class="px-6 py-3 font-semibold text-white transition duration-300 ease-in-out transform bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 hover:scale-105">
                    {{ __('Register') }}
                </x-primary-button>
            </div>

            <div class="mt-6 text-center text-gray-600">
                Sudah punya akun? <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-800">Masuk
                    di sini</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            const nameInput = document.getElementById('name');
            const passwordInput = document.getElementById('password');
            const emailInput = document.getElementById('email');
            const passwordConfirmInput = document.getElementById('password_confirmation');

            form.addEventListener('submit', function(e) {
                let isValid = true;
                let errorMessage = '';

                // Clear previous errors
                document.querySelectorAll('.text-red-600').forEach(el => el.remove());
                document.querySelectorAll('.border-red-500').forEach(el => el.classList.remove('border-red-500'));

                // Validate name (only letters and numbers)
                const name = nameInput.value;
                const nameRegex = /^[A-Za-z0-9]+$/;
                if (!nameRegex.test(name)) {
                    showError(nameInput, 'Nama hanya boleh mengandung huruf (A-Z, a-z) dan angka (0-9).');
                    isValid = false;
                }

                // Validate password requirements
                const password = passwordInput.value;
                const errors = [];

                if (password.length < 8) {
                    errors.push('Password minimal harus 8 karakter.');
                }
                if (!/[a-z]/.test(password)) {
                    errors.push('Password harus mengandung huruf kecil (a-z).');
                }
                if (!/[A-Z]/.test(password)) {
                    errors.push('Password harus mengandung huruf kapital (A-Z).');
                }
                if (!/\d/.test(password)) {
                    errors.push('Password harus mengandung angka (0-9).');
                }
                if (!/[\W_]/.test(password)) {
                    errors.push('Password harus mengandung karakter khusus (!@#$%^&* dll).');
                }

                if (errors.length > 0) {
                    showError(passwordInput, errors.join(' '));
                    isValid = false;
                }

                // Validate password confirmation
                if (password !== passwordConfirmInput.value) {
                    showError(passwordConfirmInput, 'Konfirmasi password tidak cocok.');
                    isValid = false;
                }

                // Validate email format
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(emailInput.value)) {
                    showError(emailInput, 'Format email tidak valid.');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });

            function showError(input, message) {
                input.classList.add('border-red-500');
                const errorDiv = document.createElement('div');
                errorDiv.className = 'mt-2 text-sm text-red-600';
                errorDiv.textContent = message;
                input.parentNode.appendChild(errorDiv);
            }
        });
    </script>
@endsection

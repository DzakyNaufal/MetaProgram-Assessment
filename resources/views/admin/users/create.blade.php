@extends('layouts.admin')

@section('header', 'Tambah User')

@section('content')
    <div class="p-6">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="mb-8 overflow-hidden bg-white shadow-xl rounded-3xl">
                <div class="px-8 py-10 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-4xl font-extrabold text-white">Tambah User Baru</h1>
                            <p class="mt-2 text-lg text-blue-100">
                                Buat akun pengguna baru untuk Ur-BrainDevPro
                            </p>
                        </div>
                        <div class="p-5 bg-white/20 backdrop-blur-sm rounded-2xl">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="overflow-hidden bg-white shadow-xl rounded-3xl">
                <div class="p-8">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block mb-2 text-sm font-bold text-gray-700">
                                    <span class="mr-1 text-blue-600">👤</span>
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="w-full px-4 py-3 transition-all border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Masukkan nama lengkap">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block mb-2 text-sm font-bold text-gray-700">
                                    <span class="mr-1 text-blue-600">📧</span>
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="w-full px-4 py-3 transition-all border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="contoh@email.com">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block mb-2 text-sm font-bold text-gray-700">
                                    <span class="mr-1 text-blue-600">🔒</span>
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password" id="password"
                                    class="w-full px-4 py-3 transition-all border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Minimal 8 karakter">
                                @error('password')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block mb-2 text-sm font-bold text-gray-700">
                                    <span class="mr-1 text-blue-600">🔐</span>
                                    Konfirmasi Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="w-full px-4 py-3 transition-all border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Ulangi password">
                            </div>

                            <div>
                                <label for="role" class="block mb-2 text-sm font-bold text-gray-700">
                                    <span class="mr-1 text-blue-600">⚙️</span>
                                    Role <span class="text-red-500">*</span>
                                </label>
                                <select name="role" id="role"
                                    class="w-full px-4 py-3 transition-all border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                                @error('role')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end gap-4 pt-8 mt-10 border-t-2 border-gray-100">
                            <a href="{{ route('admin.users.index') }}"
                                class="px-6 py-3 text-sm font-bold text-gray-700 transition-all bg-gray-100 border border-gray-200 rounded-xl hover:bg-gray-200">
                                ✕ Batal
                            </a>
                            <button type="submit"
                                class="px-8 py-3 text-sm font-bold text-white transition-all shadow-lg bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 hover:shadow-xl hover:scale-105">
                                <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Buat User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

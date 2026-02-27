@extends('layouts.admin')

@section('header', 'Edit Rekening Bank')

@section('content')
    <div class="p-6">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="mb-8 overflow-hidden bg-white shadow-xl rounded-3xl">
                <div class="px-8 py-10 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-4xl font-extrabold text-white">Edit Rekening Bank</h1>
                            <p class="mt-2 text-lg text-blue-100">
                                Ubah data rekening bank: <span class="font-bold bg-white/20 px-3 py-1 rounded-lg">{{ $bankAccount->bank_name }}</span>
                            </p>
                        </div>
                        <div class="p-5 bg-white/20 backdrop-blur-sm rounded-2xl">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success Alert -->
            @if (session('success'))
                <div class="p-4 mb-6 text-white shadow-lg rounded-xl bg-gradient-to-r from-green-500 to-emerald-600">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <!-- Form Card -->
            <div class="overflow-hidden bg-white shadow-xl rounded-3xl">
                <div class="p-8">
                    <form action="{{ route('admin.bank-accounts.update', $bankAccount->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <label for="bank_name" class="block text-sm font-bold text-gray-700 mb-2">
                                    <span class="text-blue-600 mr-1">🏦</span>
                                    Nama Bank <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="bank_name" id="bank_name"
                                    value="{{ old('bank_name', $bankAccount->bank_name) }}" required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    placeholder="Contoh: BCA, Mandiri, BNI">
                                @error('bank_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="account_number" class="block text-sm font-bold text-gray-700 mb-2">
                                    <span class="text-blue-600 mr-1">💳</span>
                                    Nomor Rekening <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="account_number" id="account_number"
                                    value="{{ old('account_number', $bankAccount->account_number) }}" required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-mono"
                                    placeholder="Contoh: 1234567890">
                                @error('account_number')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="account_holder" class="block text-sm font-bold text-gray-700 mb-2">
                                    <span class="text-blue-600 mr-1">👤</span>
                                    Nama Pemilik Rekening <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="account_holder" id="account_holder"
                                    value="{{ old('account_holder', $bankAccount->account_holder) }}" required
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    placeholder="Nama lengkap pemilik rekening">
                                @error('account_holder')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Active Checkbox -->
                            <div class="p-4 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl border border-blue-200">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1"
                                        {{ old('is_active', $bankAccount->is_active) ? 'checked' : '' }}
                                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                    <span class="ml-3 font-bold text-gray-800">
                                        <span class="text-green-600 mr-1">✓</span>
                                        Aktifkan Rekening Ini
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end gap-4 pt-8 mt-10 border-t-2 border-gray-100">
                            <a href="{{ route('admin.bank-accounts.index') }}"
                                class="px-6 py-3 text-sm font-bold text-gray-700 transition-all bg-gray-100 rounded-xl hover:bg-gray-200 border border-gray-200">
                                ✕ Batal
                            </a>
                            <button type="submit"
                                class="px-8 py-3 text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg hover:from-blue-700 hover:to-blue-800 hover:shadow-xl hover:scale-105 transition-all">
                                <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('header', 'Tambah Rekening Bank')

@section('content')
    <div class="p-6">
        <div class="max-w-3xl mx-auto">
            <!-- Header -->
            <div class="mb-8 overflow-hidden bg-white shadow-xl rounded-3xl">
                <div class="px-8 py-10 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-4xl font-extrabold text-white">Tambah Rekening Bank</h1>
                            <p class="mt-2 text-lg text-blue-100">
                                Tambah rekening bank baru untuk pembayaran Ur-BrainDevPro
                            </p>
                        </div>
                        <div class="p-5 bg-white/20 backdrop-blur-sm rounded-2xl">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="overflow-hidden bg-white shadow-xl rounded-3xl">
                <div class="p-8">
                    <form action="{{ route('admin.bank-accounts.store') }}" method="POST">
                        @csrf

                        <div class="space-y-6">
                            <div>
                                <label for="bank_name" class="block mb-2 text-sm font-bold text-gray-700">
                                    <span class="mr-1 text-blue-600">🏦</span>
                                    Nama Bank <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="bank_name" id="bank_name" value="{{ old('bank_name') }}" required
                                    class="w-full px-4 py-3 transition-all border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Contoh: BCA, Mandiri, BNI">
                                @error('bank_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="account_number" class="block mb-2 text-sm font-bold text-gray-700">
                                    <span class="mr-1 text-blue-600">💳</span>
                                    Nomor Rekening <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="account_number" id="account_number" value="{{ old('account_number') }}"
                                    required
                                    class="w-full px-4 py-3 font-mono transition-all border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Contoh: 1234567890">
                                @error('account_number')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="account_holder" class="block mb-2 text-sm font-bold text-gray-700">
                                    <span class="mr-1 text-blue-600">👤</span>
                                    Nama Pemilik Rekening <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="account_holder" id="account_holder" value="{{ old('account_holder') }}"
                                    required
                                    class="w-full px-4 py-3 transition-all border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Nama lengkap pemilik rekening">
                                @error('account_holder')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Active Checkbox -->
                            <div class="p-4 border border-blue-200 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_active" value="1"
                                        {{ old('is_active', true) ? 'checked' : '' }}
                                        class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                    <span class="ml-3 font-bold text-gray-800">
                                        <span class="mr-1 text-green-600">✓</span>
                                        Aktifkan Rekening Ini
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end gap-4 pt-8 mt-10 border-t-2 border-gray-100">
                            <a href="{{ route('admin.bank-accounts.index') }}"
                                class="px-6 py-3 text-sm font-bold text-gray-700 transition-all bg-gray-100 border border-gray-200 rounded-xl hover:bg-gray-200">
                                ✕ Batal
                            </a>
                            <button type="submit"
                                class="px-8 py-3 text-sm font-bold text-white transition-all shadow-lg bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 hover:shadow-xl hover:scale-105">
                                <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Rekening
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.admin')

@section('header', 'Edit Kupon')

@section('content')
    <div class="p-6">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="mb-8 overflow-hidden bg-white shadow-xl rounded-3xl">
                <div class="px-8 py-10 bg-gradient-to-r from-blue-600 to-blue-700">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-4xl font-bold text-white">Edit Kupon</h1>
                            <p class="mt-2 text-lg text-blue-100">
                                Ubah detail kupon
                            </p>
                        </div>
                        <div class="p-5 bg-white/20 backdrop-blur-sm rounded-2xl">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="overflow-hidden bg-white shadow-xl rounded-3xl">
                <div class="px-8 py-8">
                    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <!-- Kode Kupon & Tipe -->
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="code" class="block text-sm font-bold text-gray-700 mb-2">
                                        <span class="text-blue-600 mr-1">🏷️</span>
                                        Kode Kupon <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="code" id="code" required
                                        value="{{ old('code', $coupon->code) }}"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all uppercase">
                                    @error('code')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="type" class="block text-sm font-bold text-gray-700 mb-2">
                                        <span class="text-blue-600 mr-1">📊</span>
                                        Tipe Diskon <span class="text-red-500">*</span>
                                    </label>
                                    <select name="type" id="type" required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                        <option value="percentage" {{ $coupon->type === 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                                        <option value="fixed" {{ $coupon->type === 'fixed' ? 'selected' : '' }}>Nominal Tetap (Rp)</option>
                                    </select>
                                    @error('type')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nilai Diskon -->
                            <div>
                                <label for="value" class="block text-sm font-bold text-gray-700 mb-2">
                                    <span class="text-blue-600 mr-1">💰</span>
                                    Nilai Diskon <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="value" id="value" required min="0" step="0.01"
                                    value="{{ old('value', $coupon->value) }}"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                @error('value')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Minimal Order -->
                            <div>
                                <label for="min_order_amount" class="block text-sm font-bold text-gray-700 mb-2">
                                    <span class="text-blue-600 mr-1">🛒</span>
                                    Minimal Order (Rp)
                                </label>
                                <input type="number" name="min_order_amount" id="min_order_amount" min="0" step="1000"
                                    value="{{ old('min_order_amount', $coupon->min_order_amount) }}"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                    placeholder="Kosongkan jika tidak ada minimal order">
                                @error('min_order_amount')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Maksimal Penggunaan & Status -->
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="max_uses" class="block text-sm font-bold text-gray-700 mb-2">
                                        <span class="text-blue-600 mr-1">👥</span>
                                        Maksimal Penggunaan
                                    </label>
                                    <input type="number" name="max_uses" id="max_uses" min="1"
                                        value="{{ old('max_uses', $coupon->max_uses) }}"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        placeholder="Kosongkan untuk tanpa batas">
                                    <p class="mt-2 text-sm text-gray-600">Sudah digunakan: {{ $coupon->used_count }} kali</p>
                                    @error('max_uses')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="is_active" class="block text-sm font-bold text-gray-700 mb-2">
                                        <span class="text-blue-600 mr-1">✅</span>
                                        Status Aktif
                                    </label>
                                    <label class="flex items-center cursor-pointer p-4 bg-gradient-to-r from-green-50 to-green-100 rounded-xl border border-green-200">
                                        <input type="checkbox" name="is_active" id="is_active" value="1"
                                            {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}
                                            class="w-6 h-6 text-green-600 border-gray-300 rounded focus:ring-2 focus:ring-green-500">
                                        <span class="ml-3 text-lg font-bold text-gray-800">
                                            Kupon Aktif
                                        </span>
                                    </label>
                                </div>
                            </div>

                            <!-- Masa Berlaku -->
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="valid_from" class="block text-sm font-bold text-gray-700 mb-2">
                                        <span class="text-blue-600 mr-1">📅</span>
                                        Tanggal Mulai
                                    </label>
                                    <input type="date" name="valid_from" id="valid_from"
                                        value="{{ old('valid_from', $coupon->valid_from ? $coupon->valid_from->format('Y-m-d') : '') }}"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    @error('valid_from')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="valid_until" class="block text-sm font-bold text-gray-700 mb-2">
                                        <span class="text-blue-600 mr-1">📅</span>
                                        Tanggal Berakhir
                                    </label>
                                    <input type="date" name="valid_until" id="valid_until"
                                        value="{{ old('valid_until', $coupon->valid_until ? $coupon->valid_until->format('Y-m-d') : '') }}"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                    @error('valid_until')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div>
                                <label for="description" class="block text-sm font-bold text-gray-700 mb-2">
                                    <span class="text-blue-600 mr-1">📝</span>
                                    Deskripsi
                                </label>
                                <textarea name="description" id="description" rows="3"
                                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none"
                                    placeholder="Deskripsi singkat tentang kupon ini...">{{ old('description', $coupon->description) }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tipe Course -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-3">
                                    <span class="text-blue-600 mr-1">🎓</span>
                                    Berlaku untuk Tipe Course
                                </label>
                                <div class="p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl border border-purple-200">
                                    <p class="mb-3 text-sm text-gray-600">Pilih tipe course yang bisa menggunakan kupon ini:</p>
                                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
                                        <label class="flex items-center p-3 bg-white rounded-lg border-2 border-purple-200 cursor-pointer hover:border-purple-400 transition-all">
                                            <input type="checkbox" name="course_types[]" value="basic"
                                                {{ (old('course_types', $coupon->course_types ?? []) && in_array('basic', old('course_types', $coupon->course_types ?? []))) ? 'checked' : '' }}
                                                class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-2 focus:ring-purple-500">
                                            <div class="ml-3">
                                                <span class="text-lg">⭐</span>
                                                <span class="ml-1 font-bold text-gray-800">Basic</span>
                                            </div>
                                        </label>
                                        <label class="flex items-center p-3 bg-white rounded-lg border-2 border-purple-200 cursor-pointer hover:border-purple-400 transition-all">
                                            <input type="checkbox" name="course_types[]" value="premium"
                                                {{ (old('course_types', $coupon->course_types ?? []) && in_array('premium', old('course_types', $coupon->course_types ?? []))) ? 'checked' : '' }}
                                                class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-2 focus:ring-purple-500">
                                            <div class="ml-3">
                                                <span class="text-lg">👑</span>
                                                <span class="ml-1 font-bold text-gray-800">Premium</span>
                                            </div>
                                        </label>
                                        <label class="flex items-center p-3 bg-white rounded-lg border-2 border-purple-200 cursor-pointer hover:border-purple-400 transition-all">
                                            <input type="checkbox" name="course_types[]" value="elite"
                                                {{ (old('course_types', $coupon->course_types ?? []) && in_array('elite', old('course_types', $coupon->course_types ?? []))) ? 'checked' : '' }}
                                                class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-2 focus:ring-purple-500">
                                            <div class="ml-3">
                                                <span class="text-lg">💎</span>
                                                <span class="ml-1 font-bold text-gray-800">Elite</span>
                                            </div>
                                        </label>
                                    </div>
                                    <p class="mt-3 text-xs text-gray-500">💡 Kosongkan semua agar kupon berlaku untuk semua tipe course</p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end gap-4 pt-8 mt-10 border-t-2 border-gray-200">
                            <a href="{{ route('admin.coupons.index') }}"
                                class="px-6 py-3 text-sm font-bold text-gray-700 transition-all bg-gray-100 rounded-xl hover:bg-gray-200 border border-gray-200">
                                ✕ Batal
                            </a>
                            <button type="submit"
                                class="px-8 py-3 text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all">
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

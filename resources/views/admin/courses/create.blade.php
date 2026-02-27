@extends('layouts.admin')

@section('header', 'Tambah Course')

@section('content')
    <div class="p-6">
        <div class="max-w-5xl mx-auto">
            <!-- Header -->
            <div class="mb-8 overflow-hidden bg-white shadow-xl rounded-3xl">
                <div class="px-8 py-10 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-4xl font-extrabold text-white">Tambah Course Baru</h1>
                            <p class="mt-2 text-lg text-blue-100">
                                Buat course pelatihan baru untuk Ur-BrainDevPro
                            </p>
                        </div>
                        <div class="p-5 bg-white/20 backdrop-blur-sm rounded-2xl">
                            <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4" />
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
                    <form action="{{ route('admin.courses.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">

                            <!-- Left Column -->
                            <div class="space-y-6">
                                <!-- Title -->
                                <div>
                                    <label for="title" class="block mb-2 text-sm font-bold text-gray-700">
                                        <span class="mr-1 text-blue-600">📚</span>
                                        Judul Course <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                        class="w-full px-4 py-3 transition-all border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Masukkan judul course">
                                    @error('title')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Slug -->
                                <div>
                                    <label for="slug" class="block mb-2 text-sm font-bold text-gray-700">
                                        <span class="mr-1 text-blue-600">🔗</span>
                                        Slug <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required
                                        placeholder="contoh: pengembangan-diri-2025"
                                        class="w-full px-4 py-3 transition-all border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('slug')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Type -->
                                <div>
                                    <label for="type" class="block mb-2 text-sm font-bold text-gray-700">
                                        <span class="mr-1 text-blue-600">🏷️</span>
                                        Tipe Course <span class="text-red-500">*</span>
                                    </label>
                                    <select name="type" id="type" required
                                        class="w-full px-4 py-3 transition-all border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="basic" {{ old('type', 'basic') === 'basic' ? 'selected' : '' }}>
                                            ⭐ Basic
                                        </option>
                                        <option value="premium" {{ old('type') === 'premium' ? 'selected' : '' }}>
                                            👑 Premium
                                        </option>
                                        <option value="elite" {{ old('type') === 'elite' ? 'selected' : '' }}>
                                            💎 Elite
                                        </option>
                                    </select>
                                    <p class="mt-2 text-sm text-gray-500">💡 Menentukan menu navigasi di halaman user</p>
                                    @error('type')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Kategori Meta Program -->
                                <div>
                                    <label for="kategori_meta_program_id" class="block mb-2 text-sm font-bold text-gray-700">
                                        <span class="mr-1 text-purple-600">📂</span>
                                        Kategori Meta Program
                                    </label>
                                    <select name="kategori_meta_program_id" id="kategori_meta_program_id"
                                        class="w-full px-4 py-3 transition-all border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                        <option value="">-- None (Full Assessment) --</option>
                                        @foreach(\App\Models\KategoriMetaProgram::orderBy('id')->get() as $kategori)
                                            <option value="{{ $kategori->id }}" {{ old('kategori_meta_program_id') == $kategori->id ? 'selected' : '' }}>
                                                {{ $kategori->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="mt-2 text-sm text-gray-500">💡 Pilih kategori untuk assessment per kategori (biarkan kosong untuk Full Assessment)</p>
                                    @error('kategori_meta_program_id')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Price -->
                                <div>
                                    <label for="price" class="block mb-2 text-sm font-bold text-gray-700">
                                        <span class="mr-1 text-blue-600">💰</span>
                                        Harga (Rp) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="price" id="price" value="{{ old('price', 0) }}" required min="0" step="0.01"
                                        placeholder="0"
                                        class="w-full px-4 py-3 transition-all border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <p class="mt-2 text-sm text-gray-500">💡 Masukkan 0 untuk course gratis</p>
                                    @error('price')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Thumbnail -->
                                <div>
                                    <label for="thumbnail" class="block mb-2 text-sm font-bold text-gray-700">
                                        <span class="mr-1 text-blue-600">🖼️</span>
                                        Thumbnail
                                    </label>
                                    <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                                        class="w-full px-4 py-3 transition-all border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <p class="mt-2 text-sm text-gray-500">Format: JPG, PNG, WEBP (Maks. 2MB)</p>
                                    @error('thumbnail')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-6">
                                <!-- Description -->
                                <div>
                                    <label for="description" class="block mb-2 text-sm font-bold text-gray-700">
                                        <span class="mr-1 text-blue-600">📝</span>
                                        Deskripsi Course
                                    </label>
                                    <textarea name="description" id="description" rows="5"
                                        placeholder="Jelaskan tujuan, materi, dan manfaat course ini..."
                                        class="w-full px-4 py-3 transition-all border-2 border-gray-200 resize-none rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Checkboxes -->
                                <div class="space-y-3">
                                    <!-- Active Checkbox -->
                                    <div class="p-4 border border-blue-200 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="checkbox" name="is_active" id="is_active" value="1"
                                                {{ old('is_active', '1') ? 'checked' : '' }}
                                                class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                                            <span class="ml-3 font-semibold text-gray-800">
                                                <span class="mr-1 text-green-600">✓</span>
                                                Aktifkan Course Sekarang
                                            </span>
                                        </label>
                                    </div>

                                    <!-- WhatsApp Checkbox -->
                                    <div class="p-4 border border-green-200 bg-gradient-to-r from-green-50 to-green-100 rounded-xl">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="checkbox" name="has_whatsapp_consultation" id="has_whatsapp_consultation" value="1"
                                                {{ old('has_whatsapp_consultation') ? 'checked' : '' }}
                                                class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-2 focus:ring-green-500">
                                            <span class="ml-3 font-semibold text-gray-800">
                                                <svg class="w-4 h-4 mr-1 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                                </svg>
                                                Konsultasi WhatsApp
                                            </span>
                                        </label>
                                    </div>

                                    <!-- Offline Coaching Checkbox -->
                                    <div class="p-4 border border-purple-200 bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="checkbox" name="has_offline_coaching" id="has_offline_coaching" value="1"
                                                {{ old('has_offline_coaching') ? 'checked' : '' }}
                                                class="w-5 h-5 text-purple-600 border-gray-300 rounded focus:ring-2 focus:ring-purple-500">
                                            <span class="ml-3 font-semibold text-gray-800">
                                                <svg class="w-4 h-4 mr-1 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                                Sesi Coaching Offline
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end gap-4 pt-8 mt-10 border-t-2 border-gray-100">
                            <a href="{{ route('admin.courses.index') }}"
                                class="px-6 py-3 text-sm font-bold text-gray-700 transition-all bg-gray-100 border border-gray-200 rounded-xl hover:bg-gray-200">
                                ✕ Batal
                            </a>
                            <button type="submit"
                                class="px-8 py-3 text-sm font-bold text-white transition-all shadow-lg bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 hover:shadow-xl hover:scale-105">
                                <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Simpan Course Baru
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

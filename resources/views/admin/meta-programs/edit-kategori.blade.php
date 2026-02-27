@extends('layouts.admin')

@section('header', 'Edit Kategori Meta Program')

@section('content')
    <div class="p-6">
        <div class="max-w-2xl mx-auto">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-3xl">
                <div class="p-8">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Edit Kategori Meta Program</h1>
                        <p class="text-gray-600 mt-1">Update kategori Meta Program</p>
                    </div>

                    <form action="{{ route('admin.meta-programs.update-kategori', $kategori) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Kategori</label>
                                <input type="text" name="name" id="name" required value="{{ $kategori->name }}"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea name="description" id="description" rows="3"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $kategori->description }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="timer_duration" class="block text-sm font-medium text-gray-700">
                                    Durasi Timer (menit)
                                </label>
                                <div class="mt-1 flex items-center gap-2">
                                    <input type="number" name="timer_duration" id="timer_duration"
                                        class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                        value="{{ $kategori->timer_duration ? $kategori->timer_duration / 60 : 30 }}"
                                        min="1" max="180" placeholder="30">
                                    <div class="flex-shrink-0 text-sm text-gray-500">
                                        <i class="fas fa-clock mr-1"></i>menit
                                    </div>
                                </div>
                                <p class="mt-1 text-xs text-gray-500">
                                    Waktu maksimal untuk mengerjakan kategori ini. Default: 30 menit. Kosongkan untuk tanpa batas waktu.
                                </p>
                                @error('timer_duration')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" {{ $kategori->is_active ? 'checked' : '' }}
                                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">Aktif</label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('admin.meta-programs.kategori.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

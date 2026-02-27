@extends('layouts.admin')

@section('header', 'Tambah Meta Program')

@section('content')
    <div class="p-6">
        <div class="max-w-2xl mx-auto">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-3xl">
                <div class="p-8">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Tambah Meta Program</h1>
                        <p class="text-gray-600 mt-1">Buat Meta Program baru</p>
                    </div>

                    <form action="{{ route('admin.meta-programs.store-meta') }}" method="POST">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <label for="kategori_meta_program_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                                <select name="kategori_meta_program_id" id="kategori_meta_program_id"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategoriMetaPrograms as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_meta_program_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Meta Program</label>
                                <input type="text" name="name" id="name" required
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Contoh: MP 1 - Chunk Size">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea name="description" id="description" rows="3"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Deskripsi singkat tentang Meta Program ini"></textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="scoring_type" class="block text-sm font-medium text-gray-700">Tipe Scoring</label>
                                <select name="scoring_type" id="scoring_type" required
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="inverse">Inverse (Skala dibalik untuk negatif)</option>
                                    <option value="multi">Multi (Beberapa opsi sub meta program)</option>
                                </select>
                                @error('scoring_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" checked
                                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <label for="is_active" class="ml-2 block text-sm text-gray-900">Aktif</label>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('admin.meta-programs.index') }}" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
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

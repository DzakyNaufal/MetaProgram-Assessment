@extends('layouts.admin')

@section('header', 'Tambah Pertanyaan')

@section('content')
    <div class="p-6">
        <div class="max-w-3xl mx-auto">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-3xl">
                <div class="p-8">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">Tambah Pertanyaan Meta Program</h1>
                        <p class="text-gray-600 mt-1">Buat pertanyaan baru untuk Meta Program</p>
                    </div>

                    <form action="{{ route('admin.meta-programs.store-pertanyaan') }}" method="POST">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <label for="meta_program_id" class="block text-sm font-medium text-gray-700">Meta Program</label>
                                <select name="meta_program_id" id="meta_program_id" required
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">-- Pilih Meta Program --</option>
                                    @foreach($metaPrograms as $mp)
                                        <option value="{{ $mp->id }}" {{ $selectedMetaProgramId == $mp->id ? 'selected' : '' }}>{{ $mp->name }}</option>
                                    @endforeach
                                </select>
                                @error('meta_program_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="sub_meta_program_id" class="block text-sm font-medium text-gray-700">Sub Meta Program (Opsional)</label>
                                <select name="sub_meta_program_id" id="sub_meta_program_id"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">-- Pilih Sub Meta Program --</option>
                                </select>
                                @error('sub_meta_program_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="pertanyaan" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                                <textarea name="pertanyaan" id="pertanyaan" rows="3" required
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Contoh: Saat belajar hal baru, saya lebih suka langsung memahami gambaran besar daripada detail kecil."></textarea>
                                @error('pertanyaan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Skala Likert (1-6)</label>
                                <div class="grid grid-cols-3 md:grid-cols-6 gap-3">
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Sangat Setuju (6)</label>
                                        <input type="number" name="skala_sangat_setuju" value="6" min="1" max="6" required
                                            class="block w-full rounded border-gray-300 text-center">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Setuju (5)</label>
                                        <input type="number" name="skala_setuju" value="5" min="1" max="6" required
                                            class="block w-full rounded border-gray-300 text-center">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Agak Setuju (4)</label>
                                        <input type="number" name="skala_agak_setuju" value="4" min="1" max="6" required
                                            class="block w-full rounded border-gray-300 text-center">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Agak Tidak (3)</label>
                                        <input type="number" name="skala_agak_tidak_setuju" value="3" min="1" max="6" required
                                            class="block w-full rounded border-gray-300 text-center">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Tidak Setuju (2)</label>
                                        <input type="number" name="skala_tidak_setuju" value="2" min="1" max="6" required
                                            class="block w-full rounded border-gray-300 text-center">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-600 mb-1">Sangat Tidak (1)</label>
                                        <input type="number" name="skala_sangat_tidak_setuju" value="1" min="1" max="6" required
                                            class="block w-full rounded border-gray-300 text-center">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan (untuk menentukan dominan)</label>
                                <textarea name="keterangan" id="keterangan" rows="2"
                                    class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Contoh: Semakin tinggi skor, semakin dominan Global"></textarea>
                                @error('keterangan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_negatif" id="is_negatif"
                                    class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <label for="is_negatif" class="ml-2 block text-sm text-gray-900">Pertanyaan Negatif (skala dibalik)</label>
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

    <script>
        const metaProgramSelect = document.getElementById('meta_program_id');
        const subSelect = document.getElementById('sub_meta_program_id');

        function loadSubMetaPrograms(metaProgramId) {
            if (!metaProgramId) {
                subSelect.innerHTML = '<option value="">-- Pilih Sub Meta Program --</option>';
                return;
            }

            // Fetch sub meta programs for selected meta program
            fetch(`/admin/meta-programs/sub-meta-programs/${metaProgramId}`)
                .then(response => response.json())
                .then(data => {
                    subSelect.innerHTML = '<option value="">-- Pilih Sub Meta Program --</option>';
                    data.forEach(sub => {
                        subSelect.innerHTML += `<option value="${sub.id}">${sub.name}</option>`;
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        // Load on change
        metaProgramSelect.addEventListener('change', function() {
            loadSubMetaPrograms(this.value);
        });

        // Load on page load if meta program is pre-selected
        @if($selectedMetaProgramId)
            loadSubMetaPrograms({{ $selectedMetaProgramId }});
        @endif
    </script>
@endsection

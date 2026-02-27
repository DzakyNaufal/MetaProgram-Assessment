@extends('layouts.admin')

@section('header', "Pertanyaan: {$metaProgram->name}")

@section('content')
    <div class="p-6">
        <div class="mb-6">
            <a href="{{ route('admin.meta-programs.pertanyaan.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Pertanyaan
            </a>
        </div>

        <div class="overflow-hidden bg-white shadow-xl sm:rounded-3xl">
            <div class="p-8">
                <div class="mb-8">
                    <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-blue-800">
                        {{ $metaProgram->name }}
                    </h1>
                    <p class="text-gray-600 mt-2">{{ $metaProgram->description ?? 'Tidak ada deskripsi' }}</p>
                    <div class="mt-4 flex items-center gap-4 text-sm text-gray-600">
                        <span>{{ $metaProgram->subMetaPrograms->count() }} Sub Meta Programs</span>
                        <span>{{ $metaProgram->pertanyaan->count() }} Pertanyaan</span>
                        @if($metaProgram->scoring_type === 'inverse')
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full">Inverse Scoring</span>
                        @else
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full">Multi Scoring</span>
                        @endif
                    </div>
                </div>

                <!-- Add Question Button -->
                <div class="mb-6">
                    <a href="{{ route('admin.meta-programs.create-pertanyaan') }}?meta_program={{ $metaProgram->id }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Pertanyaan
                    </a>
                </div>

                <!-- Sub Meta Programs -->
                @if($metaProgram->subMetaPrograms->isNotEmpty())
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Sub Meta Programs</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($metaProgram->subMetaPrograms as $sub)
                                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">{{ $sub->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Questions List -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Daftar Pertanyaan ({{ $metaProgram->pertanyaan->count() }})</h3>

                    @if($metaProgram->pertanyaan->isNotEmpty())
                        <div class="space-y-4">
                            @foreach($metaProgram->pertanyaan as $pertanyaan)
                                <div class="p-5 bg-gray-50 rounded-xl border border-gray-200 hover:shadow-md transition-shadow">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                @if($pertanyaan->subMetaProgram)
                                                    <span class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded text-xs">{{ $pertanyaan->subMetaProgram->name }}</span>
                                                @endif
                                                @if($pertanyaan->is_negatif)
                                                    <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded text-xs">Negatif</span>
                                                @endif
                                                @if(!$pertanyaan->is_active)
                                                    <span class="px-2 py-0.5 bg-gray-200 text-gray-600 rounded text-xs">Non-Aktif</span>
                                                @endif
                                            </div>
                                            <p class="text-gray-900 font-medium mb-3">{{ $pertanyaan->pertanyaan }}</p>

                                            <!-- Skala Values -->
                                            <div class="flex flex-wrap items-center gap-3 text-xs text-gray-600 mb-2">
                                                <span>Skala:</span>
                                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded">6: {{ $pertanyaan->skala_sangat_setuju }}</span>
                                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded">5: {{ $pertanyaan->skala_setuju }}</span>
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded">4: {{ $pertanyaan->skala_agak_setuju }}</span>
                                                <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded">3: {{ $pertanyaan->skala_agak_tidak_setuju }}</span>
                                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded">2: {{ $pertanyaan->skala_tidak_setuju }}</span>
                                                <span class="px-2 py-1 bg-red-200 text-red-800 rounded">1: {{ $pertanyaan->skala_sangat_tidak_setuju }}</span>
                                            </div>

                                            @if($pertanyaan->keterangan)
                                                <p class="text-sm text-gray-600 italic">"{{ $pertanyaan->keterangan }}"</p>
                                            @endif
                                        </div>

                                        <div class="flex items-center gap-2 ml-4">
                                            <a href="{{ route('admin.meta-programs.edit-pertanyaan', $pertanyaan) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <button type="button" x-data @click="$dispatch('open-delete-modal', { id: {{ $pertanyaan->id }}, title: '{{ Str::limit($pertanyaan->pertanyaan, 50) }}' })" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded-xl">
                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.72-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pertanyaan</h3>
                            <p class="text-gray-600 mb-4">Mulai dengan menambahkan pertanyaan untuk Meta Program ini</p>
                            <a href="{{ route('admin.meta-programs.create-pertanyaan') }}?meta_program={{ $metaProgram->id }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Tambah Pertanyaan Pertama
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{
        show: false,
        pertanyaanId: null,
        pertanyaanText: '',
        init() {
            window.addEventListener('open-delete-modal', (e) => {
                this.pertanyaanId = e.detail.id;
                this.pertanyaanText = e.detail.title;
                this.show = true;
            });
        },
        confirmDelete() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/meta-programs/pertanyaan/${this.pertanyaanId}`;

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';

            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';

            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
    }" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center" style="display: none;">
        <!-- Backdrop -->
        <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="show = false"></div>

        <!-- Modal Content -->
        <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
            <!-- Header with Warning Icon -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-5">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-12 h-12 bg-white/20 rounded-xl backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-white">Hapus Pertanyaan</h3>
                        <p class="text-sm text-red-100">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="px-6 py-5">
                <p class="text-gray-600 mb-3">Apakah Anda yakin ingin menghapus pertanyaan ini?</p>
                <div class="p-3 bg-red-50 border border-red-200 rounded-xl">
                    <p class="text-sm font-semibold text-red-800" x-text="pertanyaanText"></p>
                </div>
                <p class="mt-3 text-xs text-gray-500">Semua data terkait pertanyaan ini akan dihapus secara permanen.</p>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-gray-50 flex gap-3 justify-end">
                <button type="button" @click="show = false" class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all">
                    Batal
                </button>
                <button type="button" @click="confirmDelete()" class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-red-500 to-red-600 rounded-xl hover:from-red-600 hover:to-red-700 transition-all shadow-lg hover:shadow-xl">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Ya, Hapus
                    </span>
                </button>
            </div>
        </div>
    </div>
@endsection

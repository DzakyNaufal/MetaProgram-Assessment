@extends('layouts.admin')

@section('header', 'Kategori Meta Programs')

@section('content')
    <div class="p-6">
        <div class="overflow-hidden bg-white shadow-xl sm:rounded-3xl">
            <div class="p-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-blue-800">
                            Kategori Meta Programs
                        </h1>
                        <p class="text-gray-600 mt-1">Kelola kategori untuk mengelompokkan Meta Programs</p>
                    </div>
                    <a href="{{ route('admin.meta-programs.create-kategori') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Kategori
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($kategoris as $kategori)
                        <div class="p-6 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl border border-blue-200 hover:shadow-lg transition-all duration-300">
                            <div class="flex items-start justify-between mb-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($kategori->is_active)
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs">Aktif</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-200 text-gray-600 rounded-full text-xs">Non-Aktif</span>
                                    @endif
                                </div>
                            </div>
                            <h3 class="text-lg font-bold text-blue-900 mb-2">{{ $kategori->name }}</h3>
                            <div class="flex items-center gap-4 text-sm text-blue-700 mb-4">
                                <span>{{ $kategori->metaPrograms->count() }} Meta Programs</span>
                            </div>
                            @if($kategori->description)
                                <p class="text-sm text-gray-600 mb-4">{{ $kategori->description }}</p>
                            @endif
                            <div class="flex gap-2">
                                <a href="{{ route('admin.meta-programs.edit-kategori', $kategori) }}" class="flex-1 text-center px-3 py-2 text-blue-600 bg-white rounded-lg hover:bg-blue-50 transition-colors text-sm font-medium">
                                    Edit
                                </a>
                                <button type="button" x-data @click="$dispatch('open-delete-modal', { id: {{ $kategori->id }}, name: '{{ $kategori->name }}', count: {{ $kategori->metaPrograms->count() }} })" class="flex-1 text-center px-3 py-2 text-red-600 bg-white rounded-lg hover:bg-red-50 transition-colors text-sm font-medium">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($kategoris->isEmpty())
                    <div class="text-center py-16 bg-gray-50 rounded-2xl">
                        <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum ada kategori</h3>
                        <p class="text-gray-600 mb-6">Mulai dengan membuat kategori Meta Program pertama</p>
                        <a href="{{ route('admin.meta-programs.create-kategori') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Buat Kategori Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{
        show: false,
        kategoriId: null,
        kategoriName: '',
        metaCount: 0,
        init() {
            window.addEventListener('open-delete-modal', (e) => {
                this.kategoriId = e.detail.id;
                this.kategoriName = e.detail.name;
                this.metaCount = e.detail.count;
                this.show = true;
            });
        },
        confirmDelete() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/meta-programs/kategori/${this.kategoriId}`;

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
        <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-white rounded-3xl shadow-2xl max-w-lg w-full mx-4 overflow-hidden">
            <!-- Header with Warning Icon -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-5">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-12 h-12 bg-white/20 rounded-xl backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-white">Hapus Kategori</h3>
                        <p class="text-sm text-red-100">Peringatan: Penghapusan menyeluruh</p>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="px-6 py-5">
                <p class="text-gray-600 mb-3">Apakah Anda yakin ingin menghapus kategori ini?</p>
                <div class="p-3 bg-red-50 border border-red-200 rounded-xl mb-4">
                    <p class="text-sm font-semibold text-red-800" x-text="kategoriName"></p>
                </div>

                <!-- Cascade Warning -->
                <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl mb-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-amber-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-amber-800">Semua data terkait akan dihapus:</p>
                            <ul class="mt-2 text-xs text-amber-700 space-y-1">
                                <li class="flex items-center">
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span x-text="metaCount + ' Meta Program'"></span>
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Semua Sub Meta Program
                                </li>
                                <li class="flex items-center">
                                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Semua Pertanyaan
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <p class="text-xs text-gray-500">Tindakan ini tidak dapat dibatalkan. Semua data akan dihapus secara permanen.</p>
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
                        Ya, Hapus Semua
                    </span>
                </button>
            </div>
        </div>
    </div>
@endsection

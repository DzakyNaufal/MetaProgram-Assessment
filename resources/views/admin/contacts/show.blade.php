@extends('layouts.admin')

@section('header', 'Detail Pesan')

@section('content')
    <div class="p-6">
        <!-- Header -->
        <div class="mb-6 overflow-hidden bg-white shadow-xl rounded-3xl">
            <div class="px-8 py-6 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-extrabold text-white">Detail Pesan</h1>
                        <p class="mt-1 text-lg text-blue-100">
                            Lihat pesan dari pengunjung Ur-BrainDevPro
                        </p>
                    </div>
                    <div class="p-5 bg-white/20 backdrop-blur-sm rounded-2xl">
                        <svg class="text-white w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message Content -->
        <div class="bg-gradient-to-br from-gray-50 to-blue-50">
            <div class="max-w-4xl p-6 mx-auto">
                <div class="overflow-hidden bg-white shadow-xl rounded-3xl">
                    @if (session('success'))
                        <div class="p-4 mx-6 mt-6 text-white shadow-lg rounded-xl bg-gradient-to-r from-green-500 to-emerald-600">
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

                    <div class="p-8">
                        <!-- Sender Info -->
                        <div class="flex items-center p-6 mb-8 border border-blue-200 bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl">
                            <div
                                class="flex items-center justify-center flex-shrink-0 w-16 h-16 text-2xl font-bold text-white shadow-lg rounded-2xl bg-gradient-to-br from-blue-600 to-blue-700">
                                {{ strtoupper(substr($contactMessage->name, 0, 1)) }}
                            </div>
                            <div class="flex-1 ml-6">
                                <h3 class="text-2xl font-bold text-gray-900">{{ $contactMessage->name }}</h3>
                                <div class="flex items-center gap-4 mt-2">
                                    <p class="flex items-center gap-2 text-sm text-gray-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        {{ $contactMessage->email }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        {{ $contactMessage->created_at ? $contactMessage->created_at->format('M d, Y \a\t g:i A') : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Message Content -->
                        <div class="p-6 border border-gray-200 bg-gray-50 rounded-2xl">
                            <h4 class="flex items-center gap-2 mb-3 text-sm font-bold text-gray-700">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                                </svg>
                                Pesan:
                            </h4>
                            <div class="prose max-w-none">
                                <p class="leading-relaxed text-gray-700 whitespace-pre-wrap">{{ $contactMessage->message }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-between px-8 py-6 border-t border-gray-200 bg-gray-50">
                        <a href="{{ route('admin.contacts.index') }}"
                            class="inline-flex items-center px-6 py-3 font-bold text-gray-700 transition-all bg-white border border-gray-200 shadow-sm rounded-xl hover:bg-gray-50">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Daftar
                        </a>
                        <button type="button" x-data @click="$dispatch('open-delete-modal', { id: {{ $contactMessage->id }}, title: 'Pesan dari {{ $contactMessage->name }}' })"
                            class="inline-flex items-center px-6 py-3 font-bold text-white transition-all shadow-lg bg-gradient-to-r from-red-600 to-red-700 rounded-xl hover:from-red-700 hover:to-red-800 hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Pesan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{
        show: false,
        contactId: null,
        contactTitle: '',
        init() {
            window.addEventListener('open-delete-modal', (e) => {
                this.contactId = e.detail.id;
                this.contactTitle = e.detail.title;
                this.show = true;
            });
        },
        confirmDelete() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/contacts/${this.contactId}`;

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
        <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative w-full max-w-md mx-4 overflow-hidden bg-white shadow-2xl rounded-3xl">
            <!-- Header with Warning Icon -->
            <div class="px-6 py-5 bg-gradient-to-r from-red-500 to-red-600">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-12 h-12 bg-white/20 rounded-xl backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-white">Hapus Pesan</h3>
                        <p class="text-sm text-red-100">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="px-6 py-5">
                <p class="mb-3 text-gray-600">Apakah Anda yakin ingin menghapus pesan ini?</p>
                <div class="p-3 border border-red-200 bg-red-50 rounded-xl">
                    <p class="text-sm font-semibold text-red-800" x-text="contactTitle"></p>
                </div>
                <p class="mt-3 text-xs text-gray-500">Semua data terkait pesan ini akan dihapus secara permanen.</p>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-3 px-6 py-4 bg-gray-50">
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

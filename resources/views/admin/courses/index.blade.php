@extends('layouts.admin')

@section('header', 'Manajemen Assessment')

@section('content')
    <div class="p-6">
        <div class="overflow-hidden bg-white shadow-xl sm:rounded-3xl">
            <!-- Header -->
            <div class="px-8 py-10 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-extrabold text-white">Manajemen Assessment</h1>
                        <p class="mt-2 text-lg text-blue-100">
                            Kelola semua assessment di Ur-BrainDevPro
                        </p>
                    </div>
                    <div class="p-5 bg-white/20 backdrop-blur-sm rounded-2xl">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="p-8">
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

                <!-- Table Header -->
                <div class="flex flex-col gap-4 mb-6 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">Daftar Assessment</h2>
                        <p class="text-sm text-gray-500">Total {{ $courses->count() }} assessment</p>
                    </div>
                    <a href="{{ route('admin.courses.create') }}"
                        class="inline-flex items-center px-6 py-3 text-sm font-bold text-white transition-all shadow-lg bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 hover:shadow-xl hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Assessment
                    </a>
                </div>

                @if ($courses->count() > 0)
                    <div class="overflow-hidden border border-gray-200 rounded-2xl">
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead>
                                    <tr class="text-sm font-semibold text-left text-gray-700 uppercase bg-gradient-to-r from-gray-50 to-blue-50">
                                        <th class="px-6 py-4">No</th>
                                        <th class="px-6 py-4">Assessment</th>
                                        <th class="px-6 py-4">Tipe</th>
                                        <th class="px-6 py-4">Pertanyaan</th>
                                        <th class="px-6 py-4">Harga</th>
                                        <th class="px-6 py-4">Fitur</th>
                                        <th class="px-6 py-4">Status</th>
                                        <th class="px-6 py-4 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-gray-100">
                                    @foreach ($courses as $course)
                                        <tr class="transition-colors duration-200 hover:bg-blue-50/30">
                                            <!-- Nomor urut -->
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center justify-center w-8 h-8 text-sm font-bold text-white bg-blue-600 rounded-lg">
                                                    @if (method_exists($courses, 'firstItem'))
                                                        {{ $courses->firstItem() + $loop->index }}
                                                    @else
                                                        {{ $loop->iteration }}
                                                    @endif
                                                </span>
                                            </td>

                                            <td class="px-6 py-4">
                                                <div class="flex items-center">
                                                    @if ($course->thumbnail_url)
                                                        <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}"
                                                            class="object-cover w-16 h-16 mr-4 border-2 border-blue-100 shadow-sm rounded-xl">
                                                    @else
                                                        <div class="flex items-center justify-center w-16 h-16 mr-4 border border-blue-200 rounded-xl bg-gradient-to-br from-blue-100 to-blue-200">
                                                            <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <div class="text-sm font-bold text-gray-900">{{ $course->title }}</div>
                                                        @if ($course->description)
                                                            <p class="mt-1 text-xs text-gray-500 line-clamp-1">
                                                                {{ Str::limit($course->description, 60) }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="px-6 py-4">
                                                @if ($course->type === 'basic')
                                                    <span class="inline-flex items-center px-3 py-1.5 text-sm font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-full shadow">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                                        </svg>
                                                        Basic
                                                    </span>
                                                @elseif ($course->type === 'premium')
                                                    <span class="inline-flex items-center px-3 py-1.5 text-sm font-bold text-white bg-gradient-to-r from-amber-500 to-amber-600 rounded-full shadow">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5zm14 3c0 .6-.4 1-1 1H6c-.6 0-1-.4-1-1v-1h14v1z"/>
                                                        </svg>
                                                        Premium
                                                    </span>
                                                @elseif ($course->type === 'elite')
                                                    <span class="inline-flex items-center px-3 py-1.5 text-sm font-bold text-white bg-gradient-to-r from-purple-500 to-purple-600 rounded-full shadow">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                                        </svg>
                                                        Elite
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center px-3 py-1.5 text-sm font-bold text-purple-700 bg-purple-100 rounded-lg">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.72-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                    {{ $course->questions_count ?? 0 }}
                                                </span>
                                            </td>

                                            <td class="px-6 py-4">
                                                @if ($course->isFree())
                                                    <span class="inline-flex items-center px-3 py-1.5 text-sm font-bold text-white bg-gradient-to-r from-green-500 to-green-600 rounded-full shadow">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        Gratis
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1.5 text-sm font-bold text-white bg-gradient-to-r from-orange-500 to-orange-600 rounded-full shadow">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        {{ number_format($course->price, 0, ',', '.') }}
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="px-6 py-4">
                                                <div class="flex flex-wrap gap-1">
                                                    @if ($course->has_whatsapp_consultation)
                                                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded-lg" title="WhatsApp Consultation">
                                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                                            </svg>
                                                            WA
                                                        </span>
                                                    @endif
                                                    @if ($course->has_offline_coaching)
                                                        <span class="inline-flex items-center px-2 py-1 text-xs font-semibold text-white bg-purple-500 rounded-lg" title="Offline Coaching">
                                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                            </svg>
                                                            Coach
                                                        </span>
                                                    @endif
                                                    @if (!$course->has_whatsapp_consultation && !$course->has_offline_coaching)
                                                        <span class="text-xs text-gray-400">-</span>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full
                                                    {{ $course->is_active ? 'bg-gradient-to-r from-green-100 to-green-200 text-green-800' : 'bg-gradient-to-r from-red-100 to-red-200 text-red-800' }}">
                                                    <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $course->is_active ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                                    {{ $course->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </td>

                                            <td class="px-6 py-4">
                                                <div class="flex items-center justify-center gap-2">
                                                    <a href="{{ route('admin.courses.edit', $course) }}"
                                                        class="inline-flex items-center justify-center text-blue-600 transition-all rounded-lg w-9 h-9 bg-blue-50 hover:bg-blue-100"
                                                        title="Edit Assessment">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                        </svg>
                                                    </a>

                                                    <button type="button"
                                                        x-data
                                                        @click="$dispatch('open-delete-modal', { id: {{ $course->id }}, title: '{{ $course->title }}' })"
                                                        class="inline-flex items-center justify-center text-red-600 transition-all rounded-lg w-9 h-9 bg-red-50 hover:bg-red-100"
                                                        title="Hapus Assessment">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if(method_exists($courses, 'hasPages') && $courses->hasPages())
                        <div class="px-6 py-4 bg-gray-50 rounded-b-2xl">
                            {{ $courses->links() }}
                        </div>
                        @endif
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="py-20 text-center">
                        <div class="inline-flex items-center justify-center w-24 h-24 mb-6 rounded-full bg-gradient-to-br from-blue-100 to-blue-200">
                            <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Belum Ada Assessment</h3>
                        <p class="mt-3 text-gray-500">Mulai dengan menambahkan assessment pertama Anda.</p>
                        <a href="{{ route('admin.courses.create') }}" class="inline-flex items-center px-6 py-3 mt-6 text-sm font-bold text-white transition-all shadow-lg bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Assessment
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{
        show: false,
        courseId: null,
        courseTitle: '',
        init() {
            window.addEventListener('open-delete-modal', (e) => {
                this.courseId = e.detail.id;
                this.courseTitle = e.detail.title;
                this.show = true;
            });
        },
        confirmDelete() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/courses/${this.courseId}`;

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
                        <h3 class="text-xl font-bold text-white">Hapus Assessment</h3>
                        <p class="text-sm text-red-100">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="px-6 py-5">
                <p class="mb-3 text-gray-600">Apakah Anda yakin ingin menghapus assessment ini?</p>
                <div class="p-3 border border-red-200 bg-red-50 rounded-xl">
                    <p class="text-sm font-semibold text-red-800" x-text="courseTitle"></p>
                </div>
                <p class="mt-3 text-xs text-gray-500">Semua data terkait assessment ini akan dihapus secara permanen.</p>
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

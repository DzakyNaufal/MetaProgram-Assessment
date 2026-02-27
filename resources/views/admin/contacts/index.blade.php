@extends('layouts.admin')

@section('header', 'Pesan Masuk')

@section('content')
    <div class="p-6">
        <div class="overflow-hidden bg-white shadow-xl sm:rounded-3xl">
            <!-- Header -->
            <div class="px-8 py-10 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-extrabold text-white">Pesan Masuk</h1>
                        <p class="mt-2 text-lg text-blue-100">
                            Kelola semua pesan dari pengunjung Ur-BrainDevPro
                        </p>
                    </div>
                    <div class="p-5 bg-white/20 backdrop-blur-sm rounded-2xl">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages List Card -->
        <div class="mt-6 overflow-hidden bg-white shadow-xl rounded-3xl">
            <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-blue-100">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-800">
                        Daftar Pesan ({{ $contacts->count() }} total)
                    </h2>
                </div>
            </div>

            <!-- Messages List -->
            @if ($contacts->count() > 0)
                <div class="divide-y divide-gray-200 bg-gradient-to-br from-gray-50 to-blue-50">
                    @foreach ($contacts as $contact)
                        <a href="{{ route('admin.contacts.show', $contact) }}"
                            class="block transition-all duration-200 hover:bg-blue-50/50">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div
                                        class="flex items-center justify-center flex-shrink-0 w-12 h-12 text-lg font-bold text-white shadow-lg rounded-xl bg-gradient-to-br from-blue-600 to-blue-700">
                                        {{ strtoupper(substr($contact->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0 ml-4">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-bold text-gray-900 truncate">{{ $contact->name }}
                                            </p>
                                            <p class="text-xs font-semibold text-gray-500">
                                                {{ $contact->created_at ? $contact->created_at->format('M d') : 'N/A' }}
                                            </p>
                                        </div>
                                        <div class="flex items-center justify-between mt-1">
                                            <p class="flex items-center gap-1 text-xs text-gray-500 truncate">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                                {{ $contact->email }}
                                            </p>
                                            <p class="text-xs text-gray-500">
                                                {{ $contact->created_at ? $contact->created_at->diffForHumans() : 'N/A' }}
                                            </p>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-600 truncate">
                                            {{ Str::limit($contact->message, 100) }}
                                        </p>
                                    </div>
                                    <div class="flex-shrink-0 ml-4">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center py-20 bg-gradient-to-br from-gray-50 to-blue-50">
                    <div class="inline-flex items-center justify-center w-20 h-20 mb-6 rounded-full bg-gradient-to-br from-blue-100 to-blue-200">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Belum Ada Pesan</h3>
                    <p class="mt-2 text-gray-500">Tidak ada pesan yang masuk saat ini.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

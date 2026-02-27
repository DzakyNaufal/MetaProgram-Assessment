@extends('layouts.user')

@section('content')
    <div class="min-h-screen py-12 bg-gradient-to-br from-blue-50 via-slate-50 to-blue-100">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8 text-center">
                <h1 class="mb-4 text-4xl font-extrabold text-gray-900 md:text-5xl">
                    Jelajahi <span
                        class="text-transparent bg-gradient-to-r from-blue-600 to-blue-800 bg-clip-text">Assessment
                        Kami</span>
                </h1>
                <p class="max-w-2xl mx-auto text-lg text-gray-600">
                    Pilih assessment yang sesuai dengan kebutuhan Anda dan mulai belajar sekarang
                </p>
            </div>

            <!-- Assessment Navbar/Tabs & Courses Container -->
            <div x-data="{ activeTab: 'basic' }">
                <!-- Assessment Navbar/Tabs -->
                <div class="mb-10">
                    <div class="flex flex-wrap justify-center gap-3 p-2 bg-white shadow-lg rounded-2xl">
                        <button @click="activeTab = 'basic'"
                            :class="activeTab === 'basic' ? 'bg-blue-600 text-white shadow-lg scale-105' :
                                'text-gray-600 hover:bg-gray-100'"
                            class="flex items-center gap-2 px-6 py-3 font-semibold transition-all duration-300 rounded-xl">
                            <i class="fas fa-star"></i>
                            <span>Assessment - Basic</span>
                        </button>

                        <button @click="activeTab = 'premium'"
                            :class="activeTab === 'premium' ? 'bg-blue-600 text-white shadow-lg scale-105' :
                                'text-gray-600 hover:bg-gray-100'"
                            class="flex items-center gap-2 px-6 py-3 font-semibold transition-all duration-300 rounded-xl">
                            <i class="fas fa-crown"></i>
                            <span>Assessment - Premium</span>
                        </button>

                        <button @click="activeTab = 'elite'"
                            :class="activeTab === 'elite' ? 'bg-blue-600 text-white shadow-lg scale-105' :
                                'text-gray-600 hover:bg-gray-100'"
                            class="flex items-center gap-2 px-6 py-3 font-semibold transition-all duration-300 rounded-xl">
                            <i class="fas fa-gem"></i>
                            <span>Assessment - Elite</span>
                        </button>
                    </div>
                </div>

                <!-- Courses Grid -->
                <div class="flex flex-wrap justify-center gap-8">
                    @forelse ($courses as $course)
                        @php
                            $hasPurchased =
                                auth()->check() &&
                                auth()
                                    ->user()
                                    ->purchases()
                                    ->where('course_id', $course->id)
                                    ->where('status', 'confirmed')
                                    ->exists();

                            // Use course type from database
                            $courseType = $course->type ?? 'basic';
                        @endphp

                        <div x-show="activeTab === 'all' || activeTab === '{{ $courseType }}'" style="display: grid;"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            class="w-full max-w-sm group relative flex flex-col overflow-hidden rounded-2xl bg-white shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 @if ($hasPurchased) ring-2 ring-blue-500 @endif">
                            <!-- Status Badge -->
                            @if ($hasPurchased)
                                <div class="absolute z-10 right-4 top-4">
                                    <span
                                        class="flex items-center gap-1 px-3 py-1 text-xs font-semibold text-white bg-blue-500 rounded-full shadow-lg">
                                        <i class="fas fa-check"></i>
                                        Terdaftar
                                    </span>
                                </div>
                            @endif

                            <!-- Card Header with Thumbnail -->
                            <div
                                class="relative h-64 overflow-hidden bg-gradient-to-br from-blue-400 via-blue-500 to-blue-600">
                                @if ($course->thumbnail)
                                    <img src="/storage/{{ $course->thumbnail }}" alt="{{ $course->title }}"
                                        class="absolute inset-0 object-cover w-full h-full" loading="lazy">
                                @endif
                                <!-- Overlay for better text readability -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>

                                <!-- Price Badge -->
                                <div class="absolute bottom-4 left-4">
                                    @if ($course->isFree())
                                        <span
                                            class="rounded-full bg-white/95 px-4 py-1.5 text-sm font-bold text-green-600 backdrop-blur-sm shadow-md">
                                            <i class="mr-1 fas fa-gift"></i> GRATIS
                                        </span>
                                    @else
                                        <span
                                            class="rounded-full bg-white/95 px-4 py-1.5 text-sm font-bold text-blue-700 backdrop-blur-sm shadow-md">
                                            Rp {{ number_format($course->price, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Card Content -->
                            <div class="flex flex-col flex-1 p-6">
                                <h3 class="mb-3 text-xl font-bold text-gray-900 line-clamp-2">
                                    {{ $course->title }}
                                </h3>

                                <p class="mb-4 text-sm text-gray-600 line-clamp-3">
                                    {{ $course->description }}
                                </p>

                                <!-- Course Meta Info -->
                                <div class="flex-1 mb-6 space-y-3">
                                    @if ($course->questions_count > 0)
                                        <div class="flex items-center gap-3 text-sm">
                                            <div
                                                class="flex items-center justify-center flex-shrink-0 bg-blue-100 rounded-full h-9 w-9">
                                                <i class="text-blue-600 fas fa-question-circle"></i>
                                            </div>
                                            <span class="text-gray-700">{{ $course->questions_count }} pertanyaan</span>
                                        </div>
                                    @endif

                                    @if ($course->has_whatsapp_consultation)
                                        <div class="flex items-center gap-3 text-sm">
                                            <div
                                                class="flex items-center justify-center flex-shrink-0 bg-green-100 rounded-full h-9 w-9">
                                                <i class="text-green-600 fab fa-whatsapp"></i>
                                            </div>
                                            <span class="font-medium text-gray-700">Konsultasi WhatsApp</span>
                                        </div>
                                    @endif

                                    @if ($course->has_offline_coaching)
                                        <div class="flex items-center gap-3 text-sm">
                                            <div
                                                class="flex items-center justify-center flex-shrink-0 bg-blue-100 rounded-full h-9 w-9">
                                                <i class="text-blue-600 fas fa-chalkboard-teacher"></i>
                                            </div>
                                            <span class="font-medium text-gray-700">Coaching Offline</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Action Button - Always at bottom -->
                                <div class="mt-auto">
                                    @if ($hasPurchased)
                                        <a href="{{ route('courses.show', $course->slug) }}"
                                            class="flex items-center justify-center gap-2 w-full rounded-xl bg-gradient-to-r from-blue-500 to-blue-600 py-3.5 text-center font-bold text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105 hover:from-blue-600 hover:to-blue-700">
                                            <i class="fas fa-play"></i>
                                            <span>Mulai Kerjakan</span>
                                        </a>
                                    @else
                                        <a href="{{ route('courses.show', $course->slug) }}"
                                            class="flex items-center justify-center gap-2 w-full rounded-xl bg-gradient-to-r from-blue-500 to-blue-700 py-3.5 text-center font-bold text-white shadow-lg transition-all duration-300 hover:shadow-xl hover:scale-105 hover:from-blue-600 hover:to-blue-800">
                                            <i class="fas fa-arrow-right"></i>
                                            <span>Daftar Sekarang</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="w-full max-w-2xl p-12 text-center bg-white shadow-lg rounded-2xl">
                            <div class="flex items-center justify-center w-20 h-20 mx-auto mb-4 bg-blue-100 rounded-full">
                                <i class="text-3xl text-blue-600 fas fa-book-open"></i>
                            </div>
                            <h3 class="mb-2 text-xl font-bold text-gray-900">Belum Ada Assessment</h3>
                            <p class="text-gray-500">Assessment akan segera tersedia. Pantau terus halaman ini!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

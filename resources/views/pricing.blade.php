@extends('layouts.user')

@section('content')
    <main class="px-4 py-16 mx-auto max-w-7xl sm:px-6 lg:px-8 bg-gradient-to-b from-gray-50 to-white">
        <div class="mb-20 text-center">
            <h2 class="text-5xl font-extrabold text-gray-900 md:text-6xl">
                <span class="text-transparent bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text">
                    Pilih Assessment Anda
                </span>
            </h2>
            <p class="max-w-4xl mx-auto mt-6 text-xl leading-relaxed text-gray-600">
                Temukan assessment yang paling sesuai untuk mengungkap pola berpikir dan preferensi perilaku Anda melalui
                Meta Programs yang mendalam dan akurat.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3 lg:gap-8 items-stretch">
            @php
                $courses = \App\Models\Course::where('is_active', true)
                    ->orderBy('id')
                    ->get();
            @endphp

            @foreach ($courses as $course)
                <div class="relative group">
                    <div class="relative h-full flex flex-col overflow-hidden bg-white border-2 rounded-3xl shadow-lg transition-all duration-500 hover:shadow-2xl hover:border-blue-500 border-gray-200">
                        <div class="px-10 pt-16 pb-12 text-center flex flex-col flex-1">
                            <!-- Course Image -->
                            @if ($course->thumbnail_url)
                                <div class="mb-6">
                                    <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" class="w-full h-48 object-cover rounded-xl">
                                </div>
                            @endif

                            <!-- Course Name -->
                            <div class="h-16">
                                <h3 class="text-2xl font-bold text-gray-900">{{ $course->title }}</h3>
                            </div>

                            <!-- Category Badge -->
                            @if ($course->kategoriMetaProgram)
                                <div class="mt-4">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-purple-100 text-purple-800">
                                        {{ $course->kategoriMetaProgram->name }}
                                    </span>
                                </div>
                            @endif

                            <!-- Price section -->
                            <div class="mt-6">
                                @if ($course->isFree())
                                    <span class="text-4xl font-extrabold text-green-600">Gratis</span>
                                @else
                                    <span class="text-5xl font-extrabold text-gray-900">Rp
                                        {{ number_format($course->price, 0, ',', '.') }}</span>
                                @endif
                            </div>

                            <p class="mt-6 text-gray-600">{{ $course->description ? Str::limit($course->description, 150) : 'Assessment Meta Programs yang komprehensif' }}</p>

                            <!-- Features -->
                            <ul class="mt-10 mb-10 space-y-5 text-left flex-1">
                                @if ($course->has_whatsapp_consultation)
                                    <li class="flex items-start">
                                        <svg class="flex-shrink-0 text-green-500 w-7 h-7" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="ml-4 text-gray-700">Konsultasi WhatsApp</span>
                                    </li>
                                @endif

                                @if ($course->has_offline_coaching)
                                    <li class="flex items-start">
                                        <svg class="flex-shrink-0 text-blue-600 w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        <span class="ml-4 text-gray-700">Offline Coaching</span>
                                    </li>
                                @endif

                                <li class="flex items-start">
                                    <svg class="flex-shrink-0 text-purple-600 w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="ml-4 text-gray-700">Akses lifetime</span>
                                </li>
                            </ul>

                            <div class="mt-12">
                                @auth
                                    @php
                                        $hasPurchased = auth()->user()->purchases()->where('course_id', $course->id)->exists();
                                    @endphp
                                    @if ($hasPurchased || $course->isFree())
                                        <a href="{{ route('courses.show', $course->slug) }}"
                                            class="inline-block w-full py-5 text-xl font-bold text-center text-white transition duration-300 shadow-xl bg-gradient-to-r from-green-600 to-green-700 rounded-2xl hover:shadow-2xl hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-4 focus:ring-green-300">
                                            Mulai Sekarang
                                        </a>
                                    @else
                                        <a href="{{ route('courses.show', $course->slug) }}"
                                            class="inline-block w-full py-5 text-xl font-bold text-center text-white transition duration-300 shadow-xl bg-gradient-to-r from-primary-600 to-primary-800 rounded-2xl hover:shadow-2xl hover:from-primary-700 hover:to-primary-900 focus:outline-none focus:ring-4 focus:ring-primary-300">
                                            Daftar Sekarang
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('register') }}"
                                        class="inline-block w-full py-5 text-xl font-bold text-center text-white transition duration-300 shadow-xl bg-gradient-to-r from-primary-600 to-primary-800 rounded-2xl hover:shadow-2xl hover:from-primary-700 hover:to-primary-900 focus:outline-none focus:ring-4 focus:ring-primary-300">
                                        Daftar Sekarang
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
@endsection

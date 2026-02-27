@extends('layouts.user')

@section('content')
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center mb-8">
                        <div class="flex items-center justify-center w-16 h-16 text-2xl font-bold text-white rounded-full"
                            style="background-color: {{ $category->color }}">
                            {{ strtoupper(substr($category->name, 0, 1)) }}
                        </div>
                        <h1 class="ml-4 text-3xl font-bold">{{ $category->name }}</h1>
                    </div>

                    <p class="mb-8 text-gray-60">{{ $category->description }}</p>

                    <h2 class="mb-6 text-2xl font-semibold">Course dalam Kategori Ini</h2>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($courses as $course)
                            <div
                                class="p-6 transition-shadow duration-300 border rounded-lg border-gray-20 hover:shadow-md">
                                <h3 class="mb-2 text-xl font-semibold">{{ $course->title }}</h3>
                                <p class="mb-4 text-gray-60">{{ Str::limit($course->description, 100) }}</p>

                                <div class="flex items-center justify-end">
                                    @if (!$course->isFree())
                                        <div class="text-right">
                                            <span class="block text-sm font-semibold text-blue-600">Rp
                                                {{ number_format($course->price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    @else
                                        <span
                                            class="inline-block px-2 py-1 text-xs font-semibold text-white bg-green-500 rounded-full">
                                            Gratis
                                        </span>
                                    @endif
                                </div>

                                @if (!$course->isFree())
                                    @php
                                        $hasAccess = Auth::check() && Auth::user()
                                            ->purchases()
                                            ->where('course_id', $course->id)
                                            ->where('status', 'confirmed')
                                            ->where(function ($query) {
                                                $query->whereNull('expired_at')->orWhere('expired_at', '>', now());
                                            })
                                            ->exists();
                                    @endphp

                                    @if ($hasAccess)
                                        <a href="{{ route('courses.show', ['categorySlug' => $category->slug, 'courseSlug' => $course->slug]) }}"
                                            class="block px-4 py-2 mt-4 font-bold text-center text-white transition-colors duration-300 bg-blue-500 rounded hover:bg-blue-70">
                                            Mulai Asesmen
                                        </a>
                                    @else
                                        <a href="{{ route('courses.show', ['categorySlug' => $category->slug, 'courseSlug' => $course->slug]) }}"
                                            class="block px-4 py-2 mt-4 font-bold text-center text-white transition-colors duration-300 bg-orange-500 rounded hover:bg-orange-700">
                                            Beli Course
                                        </a>
                                    @endif
                                @else
                                    <a href="{{ route('courses.show', ['categorySlug' => $category->slug, 'courseSlug' => $course->slug]) }}"
                                        class="block px-4 py-2 mt-4 font-bold text-center text-white transition-colors duration-300 bg-blue-500 rounded hover:bg-blue-70">
                                        Mulai Asesmen
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

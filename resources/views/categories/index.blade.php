@extends('layouts.user')

@section('content')
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-8 text-3xl font-bold text-center">Kategori Asesmen Bakat</h1>

                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($categories as $category)
                            <div class="p-6 transition-shadow duration-300 border rounded-lg border-gray-20 hover:shadow-lg">
                                <div class="flex items-center mb-4">
                                    <div class="flex items-center justify-center w-12 h-12 text-lg font-bold text-white rounded-full"
                                        style="background-color: {{ $category->color }}">
                                        {{ strtoupper(substr($category->name, 0, 1)) }}
                                    </div>
                                    <h2 class="ml-4 text-xl font-semibold">{{ $category->name }}</h2>
                                </div>

                                <p class="mb-4 text-gray-60">{{ $category->description }}</p>

                                @php
                                    // Check if any course in this category is paid (not free)
                                    $hasPaidCourse = $category->courses->where('price', '>', 0)->count() > 0;
                                @endphp

                                <div class="flex items-center justify-between">
                                    <a href="{{ route('categories.show', $category->slug) }}"
                                        class="inline-block px-4 py-2 font-bold text-white transition-colors duration-300 bg-blue-500 rounded hover:bg-blue-70">
                                        Lihat Course
                                    </a>

                                    @if ($hasPaidCourse)
                                        <span class="px-2 py-1 text-xs font-semibold text-white bg-orange-500 rounded-full">
                                            Berisi Course Berbayar
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.user')

@section('content')
    <div class="min-h-screen py-12 bg-gradient-to-br from-blue-50 via-slate-50 to-blue-100">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-10 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 mb-4 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 shadow-xl shadow-blue-500/30">
                    <i class="text-3xl text-white fas fa-star"></i>
                </div>
                <h1 class="mb-3 text-4xl font-extrabold text-gray-900 md:text-5xl">
                    {{ $course->title }}
                </h1>
                <p class="max-w-2xl mx-auto text-lg text-gray-600">
                    {{ $course->description }}
                </p>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($categories as $category)
                    <div class="group relative overflow-hidden bg-white rounded-2xl shadow-lg transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
                        <!-- Header with Color -->
                        <div class="h-24 p-6 bg-gradient-to-br" style="background-color: {{ $category->color }}20;">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="flex items-center justify-center w-12 h-12 rounded-xl" style="background-color: {{ $category->color }};">
                                        @if ($category->icon === 'star')
                                            <i class="text-xl text-white fas fa-star"></i>
                                        @elseif ($category->icon === 'user')
                                            <i class="text-xl text-white fas fa-user"></i>
                                        @elseif ($category->icon === 'briefcase')
                                            <i class="text-xl text-white fas fa-briefcase"></i>
                                        @elseif ($category->icon === 'message-circle')
                                            <i class="text-xl text-white fas fa-comment"></i>
                                        @elseif ($category->icon === 'users')
                                            <i class="text-xl text-white fas fa-users"></i>
                                        @elseif ($category->icon === 'trending-up')
                                            <i class="text-xl text-white fas fa-chart-line"></i>
                                        @else
                                            <i class="text-xl text-white fas fa-book"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800">{{ $category->name }}</h3>
                                    </div>
                                </div>
                                @if ($category->price > 0)
                                    <div class="text-right">
                                        <div class="text-xs text-gray-500">Harga</div>
                                        <div class="text-lg font-bold" style="color: {{ $category->color }};">
                                            Rp {{ number_format($category->price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                @else
                                    <div class="px-3 py-1 text-sm font-bold text-green-600 bg-green-100 rounded-full">
                                        GRATIS
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="p-6">
                            <p class="mb-6 text-sm text-gray-600">{{ $category->description }}</p>

                            <!-- Questions Count -->
                            @php
                                $questionCount = \App\Models\Question::where('category_id', $category->id)->count();
                            @endphp
                            @if ($questionCount > 0)
                                <div class="flex items-center gap-2 mb-6 text-sm text-gray-500">
                                    <i class="fas fa-question-circle"></i>
                                    <span>{{ $questionCount }} pertanyaan</span>
                                </div>
                            @endif

                            <!-- Action Button -->
                            @if ($category->price > 0)
                                @php
                                    $hasPurchased = auth()->check() &&
                                        auth()->user()->purchases()
                                            ->where('course_id', $course->id)
                                            ->where('category_id', $category->id)
                                            ->where('status', 'confirmed')
                                            ->exists();
                                @endphp
                                @if ($hasPurchased)
                                    <a href="{{ route('courses.category-start', [$course->slug, $category->slug]) }}"
                                        class="flex items-center justify-center gap-2 w-full px-6 py-3 text-center font-bold text-white bg-gradient-to-r from-green-500 to-green-600 rounded-xl hover:from-green-600 hover:to-green-700 transition-all shadow-lg hover:shadow-xl">
                                        <i class="fas fa-play"></i>
                                        <span>Mulai Assessment</span>
                                    </a>
                                @else
                                    <a href="{{ route('courses.category-purchase', [$course->slug, $category->slug]) }}"
                                        class="flex items-center justify-center gap-2 w-full px-6 py-3 text-center font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all shadow-lg hover:shadow-xl">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span>Beli Sekarang</span>
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('courses.category-start', [$course->slug, $category->slug]) }}"
                                    class="flex items-center justify-center gap-2 w-full px-6 py-3 text-center font-bold text-white bg-gradient-to-r from-green-500 to-green-600 rounded-xl hover:from-green-600 hover:to-green-700 transition-all shadow-lg hover:shadow-xl">
                                    <i class="fas fa-play"></i>
                                    <span>Mulai Gratis</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Back Button -->
            <div class="mt-10 text-center">
                <a href="{{ route('courses.index') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 text-gray-600 bg-white rounded-xl hover:bg-gray-50 transition-all shadow-md hover:shadow-lg">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali ke Daftar Course</span>
                </a>
            </div>
        </div>
    </div>
@endsection

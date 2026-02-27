@extends('layouts.user')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-8 text-center">
                        <h1 class="mb-2 text-3xl font-bold">Hasil: {{ $course->title }}</h1>
                        @if($quizAttempt->category)
                            <p class="text-gray-600">{{ $quizAttempt->category->name }}</p>
                        @else
                            <p class="text-gray-600">Asesmen</p>
                        @endif
                    </div>

                    @if($mpConfig && $dominantSideName)
                        <!-- Meta Program Result -->
                        <div class="mb-10">
                            <h2 class="mb-6 text-2xl font-semibold text-center">Hasil Meta Program</h2>

                            <div class="p-8 text-center rounded-lg bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200">
                                <div class="mb-4">
                                    <span class="text-lg font-medium text-gray-600">{{ $mpConfig['name'] ?? '' }}</span>
                                </div>

                                <div class="mb-6">
                                    <span class="text-xl font-semibold text-gray-700">{{ $mpConfig['title'] ?? '' }}</span>
                                </div>

                                @if($otherSideName)
                                    <!-- Binary MP Result -->
                                    <div class="mb-8">
                                        <div class="mb-2 text-sm text-gray-600">Tipe Dominan Anda:</div>
                                        <div class="mb-6 text-4xl font-bold text-blue-600">
                                            {{ $dominantSideName }}
                                        </div>

                                        <!-- Progress Bar -->
                                        <div class="mb-6 max-w-md mx-auto">
                                            <div class="flex h-14 overflow-hidden rounded-full bg-gray-200 shadow-inner">
                                                @php
                                                    $firstSide = array_key_first($allSides);
                                                    $isFirstDominant = ($quizAttempt->dominant_type === $firstSide);
                                                @endphp

                                                @if($isFirstDominant)
                                                    <div class="flex items-center justify-center text-sm font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 transition-all duration-500 shadow-sm"
                                                         style="width: {{ $dominantPercentage }}%">
                                                        {{ $dominantSideName }}
                                                    </div>
                                                    <div class="flex items-center justify-center text-xs font-medium text-gray-500 bg-gray-100 transition-all duration-500"
                                                         style="width: {{ $otherPercentage }}%">
                                                        {{ $otherSideName }}
                                                    </div>
                                                @else
                                                    <div class="flex items-center justify-center text-xs font-medium text-gray-500 bg-gray-100 transition-all duration-500"
                                                         style="width: {{ $otherPercentage }}%">
                                                        {{ $otherSideName }}
                                                    </div>
                                                    <div class="flex items-center justify-center text-sm font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 transition-all duration-500 shadow-sm"
                                                         style="width: {{ $dominantPercentage }}%">
                                                        {{ $dominantSideName }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Percentage Display -->
                                        <div class="flex justify-center gap-10 mb-6">
                                            <div class="text-center">
                                                <div class="text-3xl font-bold text-blue-600">{{ number_format($dominantPercentage, 0) }}%</div>
                                                <div class="text-sm font-semibold text-gray-700 mt-1">{{ $dominantSideName }}</div>
                                            </div>
                                            <div class="text-center">
                                                <div class="text-3xl font-bold text-gray-400">{{ number_format($otherPercentage, 0) }}%</div>
                                                <div class="text-sm font-medium text-gray-500 mt-1">{{ $otherSideName }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Multi-option MP Result -->
                                    <div class="mb-6">
                                        <div class="mb-2 text-sm text-gray-600">Tipe Dominan Anda:</div>
                                        <div class="text-4xl font-bold text-blue-600">
                                            {{ $dominantSideName }}
                                        </div>
                                    </div>
                                @endif

                                <!-- Descriptions -->
                                <div class="mt-8 grid grid-cols-1 gap-4">
                                    @foreach($allSides as $key => $side)
                                        <div class="p-5 rounded-xl transition-all @if($quizAttempt->dominant_type === $key) bg-gradient-to-r from-blue-100 to-blue-50 border-2 border-blue-400 shadow-md @else bg-white border border-gray-200 shadow-sm @endif">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="text-lg font-bold @if($quizAttempt->dominant_type === $key) text-blue-700 @else text-gray-700 @endif">
                                                    {{ $side['name'] }}
                                                </div>
                                                @if($quizAttempt->dominant_type === $key)
                                                    <span class="px-3 py-1 text-xs font-bold bg-blue-500 text-white rounded-full">DOMINAN</span>
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-600 leading-relaxed">
                                                {{ $side['description'] }}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Score Detail -->
                        <div class="mb-10 p-6 bg-gray-50 rounded-xl border border-gray-200">
                            <h3 class="mb-4 text-lg font-semibold text-gray-800">Detail Skor</h3>
                            <div class="grid grid-cols-1 gap-4 text-center">
                                <div class="p-4 bg-white rounded-lg shadow-sm">
                                    <div class="text-sm text-gray-600 mb-1">Total Skor</div>
                                    <div class="text-3xl font-bold text-gray-700">{{ $quizAttempt->total_score }}</div>
                                    <div class="text-xs text-gray-500 mt-1">@if(isset($individualScores)) {{ count($individualScores) }} @endif pertanyaan</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Legacy/Fallback Result -->
                        <div class="mb-10">
                            <h2 class="mb-6 text-2xl font-semibold text-center">Hasil Asesmen</h2>

                            <div class="p-8 text-center rounded-lg bg-gray-50">
                                <div class="mb-4">
                                    <div class="text-sm text-gray-600">Total Skor</div>
                                    <div class="text-4xl font-bold text-blue-600">{{ $quizAttempt->total_score }}</div>
                                </div>
                                <div class="text-sm text-gray-500">@if(isset($individualScores)) {{ count($individualScores) }} @endif pertanyaan</div>
                            </div>
                        </div>
                    @endif

                    <!-- Navigation -->
                    <div class="flex justify-center gap-4">
                        <a href="{{ route('courses.index') }}"
                            class="px-6 py-3 font-semibold text-blue-600 border-2 border-blue-600 rounded-lg hover:bg-blue-50 transition-colors">
                            Lihat Course Lain
                        </a>
                        <a href="{{ route('dashboard') }}"
                            class="px-6 py-3 font-bold text-white transition-colors duration-300 bg-blue-600 rounded-lg hover:bg-blue-700">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

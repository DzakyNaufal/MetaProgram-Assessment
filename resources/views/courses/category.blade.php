@extends('layouts.user')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Breadcrumb / Back -->
                    <div class="mb-6">
                        <a href="{{ route('courses.show', $course->slug) }}"
                            class="inline-flex items-center text-sm font-medium text-[#0369a1] hover:text-[#0c4a6e]">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali ke Daftar Kategori
                        </a>
                    </div>

                    <!-- Category Header -->
                    <div class="mb-8">
                        @if ($category->icon)
                            <span class="inline-block mb-3 text-4xl" style="color: {{ $category->color ?? '#6b7280' }}">
                                <i class="fas fa-{{ $category->icon }}"></i>
                            </span>
                        @endif
                        <h1 class="mb-2 text-3xl font-bold" style="color: {{ $category->color ?? '#374151' }}">
                            {{ $category->name }}
                        </h1>
                        <p class="text-gray-600">
                            <i class="mr-1 fas fa-book-open"></i> {{ $category->questions->count() }} pertanyaan
                            <span class="mx-2">•</span>
                            <i class="mr-1 fas fa-book"></i> {{ $course->title }}
                        </p>
                    </div>

                    @if ($category->description)
                        <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                            <p class="text-gray-700">{{ $category->description }}</p>
                        </div>
                    @endif

                    <!-- Questions Form -->
                    @if ($category->questions->count() > 0)
                        <form id="quiz-form" method="POST" action="{{ route('courses.category.submit', [$course->slug, $category->slug]) }}">
                            @csrf

                            <div class="space-y-8">
                                @foreach ($category->questions as $question)
                                    <div class="pb-6 border-b border-gray-200 last:border-0">
                                        <h3 class="mb-4 text-lg font-medium text-gray-900">
                                            <span class="inline-flex items-center justify-center w-8 h-8 mr-3 text-sm font-bold text-white bg-[#0369a1] rounded-full">
                                                {{ $loop->iteration }}
                                            </span>
                                            {{ $question->question_text }}
                                        </h3>

                                        <div class="space-y-3 ml-11">
                                            @foreach ($question->options as $option)
                                                <label class="flex items-start p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-[#0369a1] hover:bg-[#0369a1]/5 transition-all">
                                                    <input
                                                        id="question_{{ $question->id }}_option_{{ $option->id }}"
                                                        name="answers[{{ $question->id }}]"
                                                        type="radio"
                                                        value="{{ $option->id }}"
                                                        required
                                                        class="w-5 h-5 mt-0.5 text-[#0369a1] border-gray-300 focus:ring-[#0369a1]">
                                                    <div class="ml-3">
                                                        <span class="text-sm font-medium text-gray-700">{{ $option->option_text }}</span>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-10">
                                <button type="submit"
                                    class="w-full px-6 py-4 text-lg font-bold text-white transition-all duration-300 bg-gradient-to-r from-[#0369a1] to-[#0c4a6e] rounded-xl hover:shadow-xl hover:scale-[1.02]">
                                    <i class="mr-2 fas fa-paper-plane"></i>Submit Jawaban
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="py-16 text-center bg-gray-50 rounded-xl">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8.228 9c.549-1.165 2.03-2 3.72-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <h3 class="text-xl font-bold text-gray-900">Belum Ada Pertanyaan</h3>
                            <p class="mt-2 text-gray-500">Kategori ini belum memiliki pertanyaan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Include the quiz JavaScript -->
    <script src="{{ asset('js/quiz.js') }}"></script>
@endsection

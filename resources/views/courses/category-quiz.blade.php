@extends('layouts.user')

@section('content')
    <div class="min-h-screen py-12 bg-gradient-to-br from-blue-50 via-slate-50 to-blue-100">
        <div class="px-4 mx-auto max-w-5xl sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <a href="{{ route('courses.show', $course->slug) }}"
                    class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition-colors mb-4">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
                <div class="p-6 bg-white rounded-2xl shadow-lg">
                    <div class="flex items-center gap-4">
                        <div class="flex items-center justify-center w-16 h-16 rounded-xl" style="background-color: {{ $category->color }}20;">
                            @if ($category->icon === 'star')
                                <i class="text-2xl fas fa-star" style="color: {{ $category->color }};"></i>
                            @elseif ($category->icon === 'user')
                                <i class="text-2xl fas fa-user" style="color: {{ $category->color }};"></i>
                            @elseif ($category->icon === 'briefcase')
                                <i class="text-2xl fas fa-briefcase" style="color: {{ $category->color }};"></i>
                            @elseif ($category->icon === 'message-circle')
                                <i class="text-2xl fas fa-comment" style="color: {{ $category->color }};"></i>
                            @elseif ($category->icon === 'users')
                                <i class="text-2xl fas fa-users" style="color: {{ $category->color }};"></i>
                            @elseif ($category->icon === 'trending-up')
                                <i class="text-2xl fas fa-chart-line" style="color: {{ $category->color }};"></i>
                            @else
                                <i class="text-2xl fas fa-book" style="color: {{ $category->color }};"></i>
                            @endif
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $category->name }}</h1>
                            <p class="text-gray-600">{{ $course->title }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quiz Content -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                @if ($existingAttempt)
                    <!-- Already Completed -->
                    <div class="p-12 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 mb-6 rounded-full bg-green-100">
                            <i class="text-4xl text-green-500 fas fa-check"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Anda Sudah Menyelesaikan Assessment Ini</h2>
                        <p class="text-gray-600 mb-6">Anda telah menyelesaikan {{ $category->name }} pada {{ $existingAttempt->created_at->format('d M Y H:i') }}.</p>
                        <a href="{{ route('results.index') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl hover:from-blue-600 hover:to-blue-700">
                            <i class="fas fa-chart-bar"></i>
                            <span>Lihat Hasil</span>
                        </a>
                    </div>
                @elseif ($questions->isEmpty())
                    <!-- No Questions -->
                    <div class="p-12 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 mb-6 rounded-full bg-gray-100">
                            <i class="text-4xl text-gray-400 fas fa-question"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Pertanyaan</h2>
                        <p class="text-gray-600">Assessment ini belum memiliki pertanyaan.</p>
                    </div>
                @else
                    <!-- Start Quiz -->
                    <div id="start-quiz-screen" class="p-12 text-center">
                        <div class="max-w-xl mx-auto">
                            <div class="inline-flex items-center justify-center w-20 h-20 mb-6 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 shadow-lg">
                                <i class="text-4xl text-white fas fa-play"></i>
                            </div>
                            <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ $category->name }}</h2>
                            <p class="text-gray-600 mb-8">{{ $questions->count() }} pertanyaan • Waktu tidak terbatas</p>

                            <div class="p-6 mb-8 bg-gray-50 rounded-xl text-left">
                                <h3 class="font-semibold text-gray-800 mb-3">Petunjuk:</h3>
                                <ul class="space-y-2 text-sm text-gray-600">
                                    <li class="flex items-start gap-2">
                                        <i class="text-green-500 fas fa-check mt-1"></i>
                                        <span>Pilih satu jawaban yang paling sesuai dengan diri Anda</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="text-green-500 fas fa-check mt-1"></i>
                                        <span>Anda dapat mengubah jawaban sebelum submit</span>
                                    </li>
                                    <li class="flex items-start gap-2">
                                        <i class="text-red-500 fas fa-times mt-1"></i>
                                        <span>Pastikan koneksi internet stabil</span>
                                    </li>
                                </ul>
                            </div>

                            <button type="button" id="start-quiz-btn"
                                class="w-full px-8 py-4 text-lg font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl hover:from-blue-600 hover:to-blue-700 shadow-lg hover:shadow-xl transition-all">
                                <i class="mr-2 fas fa-play"></i>
                                Mulai Mengerjakan
                            </button>
                        </div>
                    </div>

                    <!-- Quiz Form (Hidden Initially) -->
                    <form id="quizForm" action="{{ route('courses.submit-category-quiz', [$course->slug, $category->slug]) }}" method="POST" class="hidden">
                        @csrf
                        <div id="questions-container" class="p-8 space-y-6">
                            @foreach ($questions as $index => $question)
                                <div class="p-6 bg-gray-50 rounded-xl">
                                    <div class="flex items-start gap-4 mb-4">
                                        <span class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-blue-500 text-white rounded-lg font-bold">
                                            {{ $index + 1 }}
                                        </span>
                                        <p class="flex-1 text-lg font-semibold text-gray-800">
                                            {{ $question->question_text }}
                                        </p>
                                    </div>

                                    <div class="space-y-3 ml-14">
                                        @foreach ($question->options->sortBy('order') as $option)
                                            <label class="flex items-center p-4 bg-white border-2 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all option-label">
                                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}"
                                                    class="hidden" required>
                                                <div class="w-6 h-6 mr-4 border-2 rounded-full border-gray-300 option-radio"></div>
                                                <span class="flex-1 text-gray-700 option-text">{{ $option->option_text }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Submit Button -->
                        <div class="p-6 bg-gray-50 border-t">
                            <button type="submit"
                                class="w-full px-8 py-4 text-lg font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl hover:from-blue-600 hover:to-blue-700 shadow-lg hover:shadow-xl transition-all">
                                <i class="mr-2 fas fa-paper-plane"></i>
                                Submit Jawaban
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startBtn = document.getElementById('start-quiz-btn');
            const startScreen = document.getElementById('start-quiz-screen');
            const quizForm = document.getElementById('quizForm');

            // Start quiz
            if (startBtn) {
                startBtn.addEventListener('click', function() {
                    startScreen.style.display = 'none';
                    quizForm.classList.remove('hidden');
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }

            // Option selection styling
            const optionLabels = document.querySelectorAll('.option-label');
            optionLabels.forEach(function(label) {
                label.addEventListener('click', function() {
                    // Get all labels in the same question
                    const questionContainer = this.closest('.space-y-3');
                    const allLabels = questionContainer.querySelectorAll('.option-label');

                    // Reset all labels in this question
                    allLabels.forEach(function(l) {
                        l.classList.remove('border-blue-500', 'bg-blue-50');
                        l.classList.add('border-gray-300');
                        l.querySelector('.option-radio').classList.remove('border-blue-500', 'bg-blue-500');
                        l.querySelector('.option-radio').innerHTML = '';
                        l.querySelector('.option-text').classList.remove('text-blue-700');
                    });

                    // Style selected label
                    this.classList.remove('border-gray-300');
                    this.classList.add('border-blue-500', 'bg-blue-50');
                    const radio = this.querySelector('.option-radio');
                    radio.classList.remove('border-gray-300');
                    radio.classList.add('border-blue-500', 'bg-blue-500');
                    radio.innerHTML = '<div class="w-2.5 h-2.5 bg-white rounded-full"></div>';
                    this.querySelector('.option-text').classList.add('text-blue-700');
                });
            });

            // Form validation before submit
            quizForm.addEventListener('submit', function(e) {
                const totalQuestions = {{ $questions->count() }};
                const answeredQuestions = document.querySelectorAll('input[type="radio"]:checked').length;

                if (answeredQuestions < totalQuestions) {
                    e.preventDefault();
                    alert('Mohon jawab semua pertanyaan sebelum submit.');
                }
            });
        });
    </script>
@endsection

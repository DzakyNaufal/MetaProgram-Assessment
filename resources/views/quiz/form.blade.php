@extends('layouts.app')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        <div class="max-w-6xl mx-auto">
            <div class="mb-8 text-center">
                <h1 class="mb-2 text-3xl font-bold text-gray-800">Kuis Talent Mapping</h1>
                <p class="text-gray-600">Temukan tipe bakat terbaikmu dalam memperoleh informasi baru</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Main Content - Questions -->
                <div class="flex-1">
                    <div class="p-6 bg-white rounded-lg shadow-md">
                        <form id="quiz-form" action="{{ route('quiz.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="current_page" id="current_page" value="1">
                            <input type="hidden" name="total_questions" id="total_questions" value="{{ count($questions) }}">

                            <div class="mb-6">
                                <div class="p-4 border-l-4 border-blue-500 rounded bg-blue-50">
                                    <p class="font-medium text-blue-700">Petunjuk:</p>
                                    <p class="text-sm text-blue-600">Pilih satu jawaban yang paling sesuai dengan kebiasaan dan kemampuanmu dalam memperoleh informasi baru.</p>
                                    <p class="mt-2 text-sm text-blue-600">Setiap halaman berisi 5 soal. Anda tidak dapat kembali ke soal sebelumnya setelah lanjut.</p>
                                </div>
                            </div>

                            <!-- Questions Container -->
                            <div id="questions-container">
                                @php
                                    $perPage = 5;
                                    $totalPages = ceil(count($questions) / $perPage);
                                @endphp

                                @foreach ($questions as $index => $question)
                                    @php
                                        $pageNum = intdiv($index, $perPage) + 1;
                                    @endphp

                                    <div class="p-6 mb-8 border border-gray-200 rounded-lg question-card bg-gray-50"
                                         data-page="{{ $pageNum }}" data-question-index="{{ $index }}">
                                        <div class="flex items-center mb-4">
                                            <span class="flex items-center justify-center w-8 h-8 mr-3 text-white bg-blue-500 rounded-full">
                                                {{ $index + 1 }}
                                            </span>
                                            <h3 class="text-lg font-semibold text-gray-800">
                                                Pertanyaan {{ $index + 1 }} dari {{ count($questions) }}
                                            </h3>
                                        </div>

                                        <p class="mb-4 text-lg text-gray-700">{{ $question->question_text }}</p>

                                        <div class="space-y-3">
                                            @foreach ($question->options as $option)
                                                <label class="flex items-start p-3 transition-colors border border-gray-200 rounded cursor-pointer hover:bg-blue-50">
                                                    <input type="radio"
                                                           name="answers[{{ $question->id }}]"
                                                           value="{{ $option->id }}"
                                                           class="mt-1 mr-3"
                                                           data-question-index="{{ $index }}"
                                                           required>
                                                    <span class="text-gray-700">{{ $option->option_text }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Navigation Buttons -->
                            <div class="mt-8 flex justify-between items-center">
                                <div class="text-gray-600">
                                    Halaman <span id="page-indicator">1</span> dari {{ $totalPages }}
                                </div>
                                <button type="button" id="next-btn" class="px-6 py-3 font-bold text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                                    Lanjut
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Sidebar - Question Numbers -->
                <div class="w-full lg:w-64">
                    <div class="p-4 bg-white rounded-lg shadow-md sticky top-4">
                        <h3 class="mb-4 text-lg font-semibold text-gray-800 text-center">Nomor Soal</h3>
                        <div id="question-grid" class="grid grid-cols-5 gap-2">
                            @for ($i = 1; $i <= count($questions); $i++)
                                <div class="question-number-box flex items-center justify-center w-10 h-10 mx-auto text-sm font-medium rounded cursor-pointer transition-colors
                                    {{ $i <= 5 ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-600' }}"
                                    data-question-num="{{ $i }}">
                                    {{ $i }}
                                </div>
                            @endfor
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex items-center justify-center gap-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 bg-blue-500 rounded"></div>
                                    <span class="text-gray-600">Aktif</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 bg-green-500 rounded"></div>
                                    <span class="text-gray-600">Terjawab</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-4 h-4 bg-gray-200 rounded"></div>
                                    <span class="text-gray-600">Belum</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const perPage = 5;
            const totalQuestions = parseInt(document.getElementById('total_questions').value);
            const totalPages = Math.ceil(totalQuestions / perPage);
            let currentPage = 1;

            const questionsContainer = document.getElementById('questions-container');
            const questionCards = document.querySelectorAll('.question-card');
            const questionNumberBoxes = document.querySelectorAll('.question-number-box');
            const nextBtn = document.getElementById('next-btn');
            const pageIndicator = document.getElementById('page-indicator');
            const quizForm = document.getElementById('quiz-form');

            // Initialize - show only first page
            showPage(1);

            // Function to show a specific page
            function showPage(page) {
                const startIndex = (page - 1) * perPage;
                const endIndex = Math.min(startIndex + perPage, totalQuestions);

                // Hide all question cards
                questionCards.forEach(card => {
                    card.style.display = 'none';
                });

                // Show current page questions
                for (let i = startIndex; i < endIndex; i++) {
                    if (questionCards[i]) {
                        questionCards[i].style.display = 'block';
                    }
                }

                // Update question number boxes
                updateQuestionNumberBoxes();

                // Update page indicator
                pageIndicator.textContent = page;

                // Update button text
                if (page >= totalPages) {
                    nextBtn.textContent = 'Submit Jawaban';
                    nextBtn.type = 'submit';
                } else {
                    nextBtn.textContent = 'Lanjut';
                    nextBtn.type = 'button';
                }

                // Scroll to top
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }

            // Function to update question number boxes
            function updateQuestionNumberBoxes() {
                const startIndex = (currentPage - 1) * perPage;
                const endIndex = Math.min(startIndex + perPage, totalQuestions);

                questionNumberBoxes.forEach((box, index) => {
                    const questionNum = index + 1;

                    // Remove all classes
                    box.classList.remove('bg-blue-500', 'bg-green-500', 'bg-gray-200', 'text-white', 'text-gray-600');

                    // Check if question is answered
                    const radioInputs = document.querySelectorAll(`input[data-question-index="${index}"]`);
                    let isAnswered = false;
                    radioInputs.forEach(input => {
                        if (input.checked) {
                            isAnswered = true;
                        }
                    });

                    if (questionNum >= startIndex + 1 && questionNum <= endIndex) {
                        // Current page - blue
                        box.classList.add('bg-blue-500', 'text-white');
                    } else if (isAnswered) {
                        // Answered - green
                        box.classList.add('bg-green-500', 'text-white');
                    } else {
                        // Not answered and not on current page - gray
                        box.classList.add('bg-gray-200', 'text-gray-600');
                    }
                });
            }

            // Next button click handler
            nextBtn.addEventListener('click', function(e) {
                if (nextBtn.type === 'button') {
                    e.preventDefault();

                    // Validate all questions on current page are answered
                    const startIndex = (currentPage - 1) * perPage;
                    const endIndex = Math.min(startIndex + perPage, totalQuestions);
                    let allAnswered = true;

                    for (let i = startIndex; i < endIndex; i++) {
                        const radioInputs = document.querySelectorAll(`input[data-question-index="${i}"]`);
                        let questionAnswered = false;
                        radioInputs.forEach(input => {
                            if (input.checked) {
                                questionAnswered = true;
                            }
                        });
                        if (!questionAnswered) {
                            allAnswered = false;
                            break;
                        }
                    }

                    if (!allAnswered) {
                        alert('Mohon jawab semua soal pada halaman ini sebelum lanjut.');
                        return;
                    }

                    // Move to next page
                    currentPage++;
                    showPage(currentPage);
                }
            });

            // Update boxes when answer is selected
            quizForm.addEventListener('change', function(e) {
                if (e.target.type === 'radio') {
                    updateQuestionNumberBoxes();
                }
            });
        });
    </script>
@endsection

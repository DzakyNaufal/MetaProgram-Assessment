@extends('layouts.user')

@push('styles')
<style>
    /* Hide navigation when quiz is active */
    body.quiz-active header nav,
    body.quiz-active [role="navigation"],
    body.quiz-active .back-button {
        display: none !important;
        opacity: 0 !important;
        pointer-events: none !important;
    }

    /* Prevent scrolling during quiz */
    body.quiz-active {
        overflow-x: hidden;
    }
</style>
@endpush

@section('content')
    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if($existingAttempt)
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="flex-1">
                            <p class="font-semibold text-green-800">Anda sudah menyelesaikan assessment ini!</p>
                            <p class="text-sm text-green-700">Silakan cek hasil assessment Anda di menu Results.</p>
                        </div>
                        <a href="{{ route('results.index', ['attemptId' => $existingAttempt->id]) }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors duration-200">
                            Lihat Hasil
                        </a>
                    </div>
                </div>
            @endif

            @if(!isset($existingAttempt) || !$existingAttempt)
            <!-- Kategori Info -->
            <div class="mb-6 bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
                <div class="p-5 border-b border-blue-100 bg-gradient-to-r from-blue-500 to-blue-600">
                    <h1 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        {{ $course->title }}
                    </h1>
                </div>
                <div class="p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Kategori Meta Program</p>
                            <p class="font-bold text-gray-800 text-lg">{{ $kategori->name }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-600">Jumlah Pertanyaan</p>
                            <p class="font-bold text-gray-800 text-lg">{{ $questions->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Main Content - Questions -->
                <div class="flex-1">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <!-- Start Quiz Screen -->
                            <div id="start-quiz-screen" class="py-16">
                                <div class="max-w-2xl mx-auto text-center">
                                    <div class="mb-8">
                                        <div class="inline-flex items-center justify-center w-24 h-24 mb-6 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 shadow-xl shadow-blue-500/30">
                                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Assessment {{ $kategori->name }}</h2>
                                        <p class="text-gray-600">Silakan mulai mengerjakan soal-soal berikut</p>
                                    </div>

                                    <!-- Instructions -->
                                    <div class="mb-8 p-6 bg-gray-50 rounded-xl text-left">
                                        <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Petunjuk Pengerjaan
                                        </h3>
                                        <ul class="space-y-2 text-sm text-gray-600">
                                            <li class="flex items-start gap-2">
                                                <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                                <span>Pilih satu jawaban yang paling sesuai dengan diri Anda</span>
                                            </li>
                                            <li class="flex items-start gap-2">
                                                <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                                <span>Setiap halaman berisi 5 soal. Tidak dapat kembali ke soal sebelumnya</span>
                                            </li>
                                            <li class="flex items-start gap-2">
                                                <svg class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                <span>Pastikan koneksi internet stabil</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Start Button -->
                                    @if(!$existingAttempt)
                                        <button type="button" id="start-quiz-btn"
                                            class="px-12 py-4 text-lg font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl hover:from-blue-600 hover:to-blue-700 shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200 flex items-center gap-3 mx-auto">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Mulai Mengerjakan
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Quiz Form (Hidden Initially) -->
                            @if ($questions->count() > 0 && !$existingAttempt)
                                <form id="quizForm"
                                      action="{{ route('courses.single-kategori.submit', $course->slug) }}"
                                      method="POST" class="hidden">
                                    @csrf
                                    <input type="hidden" name="total_questions" id="total_questions" value="{{ $questions->count() }}">

                                    <div id="questions-container">
                                        @php
                                            $perPage = 5;
                                            $totalPages = ceil($questions->count() / $perPage);
                                            // Calculate current page based on saved answers - show next page with unanswered questions
                                            $answeredCount = $savedAnswers ? count($savedAnswers) : 0;
                                            $currentPage = $answeredCount > 0 ? min(intdiv($answeredCount, $perPage) + 1, $totalPages) : 1;
                                        @endphp

                                        @foreach ($questions as $index => $question)
                                            @php
                                                $pageNum = intdiv($index, $perPage) + 1;
                                                $isAnswered = isset($savedAnswers[$question->id]) && $savedAnswers[$question->id] != '';
                                                // Build options from skala columns (6-point Likert scale)
                                                // Value comes from database (numbers 1-6), Text is descriptive
                                                $options = [
                                                    ['value' => $question->skala_sangat_tidak_setuju, 'text' => 'Sangat Tidak Setuju'],
                                                    ['value' => $question->skala_tidak_setuju, 'text' => 'Tidak Setuju'],
                                                    ['value' => $question->skala_agak_tidak_setuju, 'text' => 'Agak Tidak Setuju'],
                                                    ['value' => $question->skala_agak_setuju, 'text' => 'Agak Setuju'],
                                                    ['value' => $question->skala_setuju, 'text' => 'Setuju'],
                                                    ['value' => $question->skala_sangat_setuju, 'text' => 'Sangat Setuju'],
                                                ];
                                            @endphp

                                            <div class="p-6 mb-8 border border-blue-100 rounded-xl question-card bg-gradient-to-br from-white to-blue-50/30 shadow-sm"
                                                 data-page="{{ $pageNum }}" data-question-index="{{ $index }}"
                                                 @if($pageNum !== $currentPage) style="display: none;" @endif>
                                                <div class="flex items-start gap-3 mb-4">
                                                    <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-blue-500 text-white rounded-lg font-bold text-sm">{{ $index + 1 }}</span>
                                                    <p class="flex-1 font-semibold text-gray-800 text-lg leading-relaxed">{{ $question->pertanyaan }}</p>
                                                </div>

                                                <div class="space-y-2">
                                                    @foreach ($options as $option)
                                                        @php
                                                            $isSelected = isset($savedAnswers[$question->id]) && $savedAnswers[$question->id] == $option['value'];
                                                        @endphp
                                                        <label class="flex items-center p-4 bg-white border-2 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50/50 transition-all duration-200 group @if($isSelected) border-blue-500 bg-blue-50 ring-2 ring-blue-200 @else border-gray-200 @endif">
                                                            <input type="radio"
                                                                name="answers[{{ $question->id }}]"
                                                                value="{{ $option['value'] }}"
                                                                class="hidden"
                                                                data-question-index="{{ $index }}"
                                                                data-answered="{{ $isAnswered ? '1' : '0' }}"
                                                                @if($isSelected) checked @endif
                                                                required>
                                                            <div class="flex items-center justify-between w-full gap-3">
                                                                <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center flex-shrink-0 @if($isSelected) border-blue-500 bg-blue-500 @else border-gray-300 group-hover:border-blue-400 @endif transition-all duration-200">
                                                                    @if($isSelected)<div class="w-2.5 h-2.5 bg-white rounded-full"></div>@endif
                                                                </div>
                                                                <span class="flex-1 text-sm font-medium text-gray-700 @if($isSelected) text-blue-700 @endif">{{ $option['text'] }}</span>
                                                            </div>
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Navigation Buttons -->
                                    <div class="mt-8 flex justify-between items-center p-4 bg-white rounded-xl shadow-sm border border-blue-100">
                                        <div class="flex items-center gap-2 text-gray-600">
                                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span class="font-medium">Halaman <span id="page-indicator" class="text-blue-600 font-bold">{{ $currentPage }}</span> dari <span class="text-blue-600">{{ $totalPages }}</span></span>
                                        </div>
                                        <button type="button" id="next-btn"
                                            class="px-8 py-3 font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl hover:from-blue-600 hover:to-blue-700 hover:shadow-lg hover:shadow-blue-500/30 transition-all duration-200 flex items-center gap-2">
                                            <span>Lanjut</span>
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar - Question Numbers -->
                @if ($questions->count() > 0 && !$existingAttempt)
                <div class="w-full lg:w-64 space-y-4">
                    <!-- Countdown Timer Card -->
                    <div class="p-4 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg">
                        <div class="text-center mb-3">
                            <p class="text-xs text-blue-100 font-medium mb-1">Sisa Waktu</p>
                            <p id="timer-display" class="text-3xl font-bold text-white">--:--</p>
                        </div>
                        <div class="w-full bg-white/20 rounded-full h-2 mb-3">
                            <div id="timer-progress" class="bg-white h-2 rounded-full transition-all duration-1000" style="width: 100%"></div>
                        </div>
                        <div class="flex items-center justify-between text-xs text-blue-100">
                            <span>Mulai: <span id="start-time-display" class="font-semibold">--:--</span></span>
                            <span>{{ $questions->count() }} menit</span>
                        </div>
                    </div>

                    <!-- Question Numbers Card -->
                    <div class="p-5 bg-white rounded-xl shadow-md border border-blue-100">
                        <h3 class="mb-4 text-lg font-bold text-gray-800 text-center flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Nomor Soal
                        </h3>
                        <div id="question-grid" class="grid grid-cols-5 gap-2">
                            @for ($i = 1; $i <= $questions->count(); $i++)
                                @php
                                    $pageNum = intdiv($i - 1, $perPage) + 1;
                                    $isActivePage = ($pageNum === $currentPage);
                                @endphp
                                <div class="question-number-box flex items-center justify-center w-10 h-10 mx-auto text-sm font-medium rounded-lg cursor-pointer transition-all duration-200
                                    {{ $isActivePage && $i <= ($currentPage * $perPage) && $i > (($currentPage - 1) * $perPage) ? 'bg-blue-500 text-white shadow-md shadow-blue-500/30' : 'bg-gray-100 text-gray-600 hover:bg-blue-100 hover:text-blue-600' }}"
                                    data-question-num="{{ $i }}">
                                    {{ $i }}
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if($questions->count() > 0 && !$existingAttempt)
                const perPage = 5;
                const totalQuestions = parseInt(document.getElementById('total_questions').value);
                const totalPages = Math.ceil(totalQuestions / perPage);
                let currentPage = {{ $currentPage }};  // Use calculated current page from saved progress
                const courseSlug = '{{ $course->slug }}';

                const questionCards = document.querySelectorAll('.question-card');
                const questionNumberBoxes = document.querySelectorAll('.question-number-box');
                const nextBtn = document.getElementById('next-btn');
                const pageIndicator = document.getElementById('page-indicator');
                const quizForm = document.getElementById('quizForm');
                let isSubmitting = false;

                // ==================== COUNTDOWN TIMER ====================
                // Calculate timer duration based on actual question count (1 minute per question)
                const TIMER_DURATION = {{ $questions->count() * 60 }};

                // Get kategori ID for localStorage key
                const kategoriId = '{{ $kategori->id }}';
                const storageKey = `quiz_timer_${courseSlug}_${kategoriId}`;
                const startTimeKey = `quiz_start_${courseSlug}_${kategoriId}`;
                const timerStartedKey = `quiz_timer_started_${courseSlug}_${kategoriId}`;
                const quizStartedKey = `quiz_started_${courseSlug}_${kategoriId}`;

                // LocalStorage keys for answers (backup in case AJAX fails)
                const answersStorageKey = `quiz_answers_${courseSlug}_${kategoriId}`;

                // Timer always starts fresh - NO restoration from localStorage
                let timeRemaining = TIMER_DURATION;
                let timerInterval = null;
                let timerStarted = false;
                let quizActive = false;  // Global flag to track quiz state

                // ==================== CLEANUP OLD DATA ====================
                // Clear all old quiz-related localStorage data on page load
                // This ensures users start fresh every time they visit
                (function cleanUpOldData() {
                    // Clear timer-related keys
                    localStorage.removeItem(storageKey);
                    localStorage.removeItem(startTimeKey);
                    localStorage.removeItem(timerStartedKey);
                    localStorage.removeItem(quizStartedKey);

                    // Clear old answers from localStorage (server is source of truth)
                    localStorage.removeItem(answersStorageKey);

                    console.log('=== CLEANUP: Cleared old quiz data from localStorage ===');
                })();
                // ==================== END CLEANUP ====================

                // Display start time
                function displayStartTime() {
                    const startTime = localStorage.getItem(startTimeKey);
                    if (startTime) {
                        const startDate = new Date(parseInt(startTime));
                        const hours = startDate.getHours().toString().padStart(2, '0');
                        const minutes = startDate.getMinutes().toString().padStart(2, '0');
                        const seconds = startDate.getSeconds().toString().padStart(2, '0');
                        document.getElementById('start-time-display').textContent = `${hours}:${minutes}:${seconds}`;
                    } else {
                        document.getElementById('start-time-display').textContent = '--:--';
                    }
                }

                // Update timer display
                function updateTimerDisplay() {
                    // Show time even when timer hasn't started yet
                    const minutes = Math.floor(timeRemaining / 60);
                    const seconds = timeRemaining % 60;
                    const display = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                    document.getElementById('timer-display').textContent = display;

                    // Update progress bar
                    const progressPercent = (timeRemaining / TIMER_DURATION) * 100;
                    document.getElementById('timer-progress').style.width = progressPercent + '%';

                    // Change color when time is running low (less than 5 minutes)
                    if (timeRemaining <= 300) {
                        document.getElementById('timer-display').classList.add('text-red-300');
                        document.getElementById('timer-progress').classList.add('bg-red-300');
                        document.getElementById('timer-progress').classList.remove('bg-white');
                    }
                }

                // Clear timer when leaving page
                function clearTimer() {
                    if (timerInterval) {
                        clearInterval(timerInterval);
                        timerInterval = null;
                    }
                    quizActive = false;  // Mark quiz as inactive
                    timerStarted = false;
                    stopBlockingBack(); // Stop blocking back button
                    localStorage.removeItem(storageKey);
                    localStorage.removeItem(startTimeKey);
                    localStorage.removeItem(timerStartedKey);
                    localStorage.removeItem(quizStartedKey);
                    document.body.classList.remove('quiz-active');  // Show navigation again
                }

                // Initialize display
                displayStartTime();
                updateTimerDisplay();

                // Auto-save answers every 30 seconds while on page (NOT timer)
                setInterval(function() {
                    if (timerStarted) {
                        saveProgressNow();
                    }
                }, 30000);

                // Clear timer when form is submitted
                quizForm.addEventListener('submit', function(e) {
                    e.preventDefault(); // Prevent normal form submission
                    isSubmitting = true;
                    quizActive = false;  // Mark quiz as inactive
                    document.body.classList.remove('quiz-active');  // Show navigation again
                    clearTimer();
                    stopBlockingBack(); // Stop blocking back button

                    // Submit via AJAX
                    const formData = new FormData(quizForm);

                    fetch(quizForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Submit response:', data);
                        // Clear localStorage answers after successful submission
                        localStorage.removeItem(answersStorageKey);

                        // Redirect to history page
                        if (data.redirect_url) {
                            window.location.href = data.redirect_url;
                        }
                    })
                    .catch(error => {
                        console.error('Error submitting quiz:', error);
                        alert('Terjadi kesalahan saat mengirim jawaban. Silakan coba lagi.');
                        isSubmitting = false;
                        quizActive = true;
                        startBlockingBack();
                    });
                });

                // ==================== END COUNTDOWN TIMER ====================

                // Debug: Log saved answers from PHP
                const savedAnswersFromPHP = {{ json_encode($savedAnswers) }};
                console.log('=== DEBUG INFO ===');
                console.log('Saved answers from PHP:', savedAnswersFromPHP);
                console.log('Number of saved answers:', Object.keys(savedAnswersFromPHP).length);
                console.log('Current page (from PHP):', {{ $currentPage }});
                console.log('Total questions:', {{ $questions->count() }});

                // ==================== SAVE PROGRESS ====================
                // Function to save progress immediately
                function saveProgressNow() {
                    console.log('=== SAVING PROGRESS ===');
                    const formData = new FormData(quizForm);
                    const answers = {};
                    let answeredCount = 0;

                    // Debug: Log all formData entries
                    console.log('FormData entries:');
                    for (let [key, value] of formData.entries()) {
                        console.log('  ', key, '=', value);
                        if (key.startsWith('answers[')) {
                            const match = key.match(/\d+/);
                            if (match) {
                                const questionId = match[0];
                                // Store the value (include non-empty values)
                                answers[questionId] = value;
                                answeredCount++;
                            }
                        }
                    }

                    console.log('Answers extracted:', answers);
                    console.log('Answered count:', answeredCount);

                    // Save to localStorage IMMEDIATELY (backup)
                    localStorage.setItem(answersStorageKey, JSON.stringify(answers));
                    console.log('Saved to localStorage:', answersStorageKey);

                    // Calculate current question index based on answered count
                    const currentQuestionIndex = answeredCount > 0 ? answeredCount : 0;

                    const payload = {
                        answers: answers,
                        current_question_index: currentQuestionIndex,
                        total_questions: totalQuestions
                    };

                    console.log('Sending payload to server:', JSON.stringify(payload, null, 2));

                    // Also save to server (primary storage)
                    fetch(`/courses/${courseSlug}/single-kategori/save-progress`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('=== SAVE RESPONSE (SERVER) ===');
                        console.log('Success:', data.success);
                        console.log('Answered count (server):', data.answered_count);
                        console.log('Total questions:', data.total_questions);
                    })
                    .catch(error => {
                        console.error('=== SAVE ERROR (SERVER) ===');
                        console.error('Error saving to server, using localStorage only:', error);
                    });
                }

                // Function to restore saved answers to form
                function restoreSavedAnswers() {
                    console.log('=== RESTORING ANSWERS ===');
                    console.log('savedAnswersFromPHP (from server):', savedAnswersFromPHP);
                    console.log('Has saved answers from PHP:', savedAnswersFromPHP && Object.keys(savedAnswersFromPHP).length > 0);

                    // Try to get answers from localStorage (backup)
                    const localStorageAnswers = localStorage.getItem(answersStorageKey);
                    console.log('localStorage answers:', localStorageAnswers);

                    // Use PHP answers first, fall back to localStorage
                    let answersToRestore = savedAnswersFromPHP || {};
                    if ((!answersToRestore || Object.keys(answersToRestore).length === 0) && localStorageAnswers) {
                        try {
                            answersToRestore = JSON.parse(localStorageAnswers);
                            console.log('Using localStorage answers as backup:', answersToRestore);
                        } catch (e) {
                            console.error('Error parsing localStorage answers:', e);
                            answersToRestore = {};
                        }
                    }

                    if (!answersToRestore || Object.keys(answersToRestore).length === 0) {
                        console.log('No saved answers to restore');
                        return;
                    }

                    console.log('Starting to restore', Object.keys(answersToRestore).length, 'answers');

                    let restoredCount = 0;
                    let notFoundCount = 0;

                    // Restore each saved answer
                    for (const [questionId, answerValue] of Object.entries(answersToRestore)) {
                        // Find the radio input with matching question ID and value
                        const radioInput = document.querySelector(`input[name="answers[${questionId}]"][value="${answerValue}"]`);
                        if (radioInput) {
                            radioInput.checked = true;
                            restoredCount++;
                            console.log('✓ Restored answer for question', questionId, ':', answerValue);
                        } else {
                            notFoundCount++;
                            console.warn('✗ Radio input NOT found for question', questionId, 'value:', answerValue);
                        }
                    }

                    console.log('Restore complete:', restoredCount, 'restored,', notFoundCount, 'not found');

                    // Update question number boxes to show answered questions
                    updateQuestionNumberBoxes();
                }
                // ==================== END SAVE PROGRESS ====================

                // Check if there's saved progress to update start button text
                const hasSavedProgress = {{ $savedAnswers && count($savedAnswers) > 0 ? 'true' : 'false' }};
                const savedAnswersCount = {{ $savedAnswers ? count($savedAnswers) : 0 }};

                if (hasSavedProgress) {
                    // Update button text for resume
                    document.getElementById('start-quiz-btn').innerHTML = `
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Lanjutkan Mengerjakan
                    `;

                    // Update title and description for resume
                    document.querySelector('#start-quiz-screen h2').textContent = 'Lanjutkan Assessment';
                    document.querySelector('#start-quiz-screen p').textContent = 'Anda dapat melanjutkan mengerjakan soal-soal sebelumnya';

                    // Add progress info
                    const instructionsDiv = document.querySelector('#start-quiz-screen .bg-gray-50 ul');
                    const progressInfo = document.createElement('li');
                    progressInfo.className = 'flex items-start gap-2';
                    progressInfo.innerHTML = `
                        <svg class="w-4 h-4 text-blue-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                        <span>Anda sudah menjawab <strong>${savedAnswersCount}</strong> dari <strong>${totalQuestions}</strong> soal</span>
                    `;
                    instructionsDiv.appendChild(progressInfo);
                }

                // ==================== QUIZ PROTECTION ====================
                // Push multiple states to create a buffer against multiple back presses
                function pushHistoryStates() {
                    for (let i = 0; i < 10; i++) {
                        history.pushState({ quizActive: true, depth: i }, '', location.href);
                    }
                }

                // Force stay on quiz page - continuously push states
                let blockBackInterval;
                function startBlockingBack() {
                    // Push states every 100ms to overwhelm any back attempts
                    blockBackInterval = setInterval(function() {
                        if (quizActive && !isSubmitting) {
                            history.pushState({ quizActive: true, blocked: true }, '', location.href);
                        }
                    }, 100);
                }

                function stopBlockingBack() {
                    if (blockBackInterval) {
                        clearInterval(blockBackInterval);
                        blockBackInterval = null;
                    }
                }

                // Block all navigation clicks during quiz
                function blockNavigationLinks() {
                    // Use event delegation to intercept all clicks
                    document.addEventListener('click', function(e) {
                        if (!quizActive || isSubmitting) return;

                        // Find closest anchor tag
                        const anchor = e.target.closest('a');
                        if (!anchor) return;

                        const href = anchor.getAttribute('href');

                        // Block internal navigation links (not # or javascript:)
                        if (href && href !== '#' && !href.startsWith('javascript:')) {
                            // Check if it's an external link or same-origin
                            if (href.startsWith('/') || href.startsWith(window.location.origin)) {
                                e.preventDefault();
                                e.stopPropagation();
                                alert('Anda tidak dapat berpindah halaman saat sedang mengerjakan assessment. Silakan selesaikan assessment terlebih dahulu.');
                                return false;
                            }
                        }
                    }, true); // Use capture phase to intercept early
                }

                // Prevent back button navigation
                window.addEventListener('popstate', function(event) {
                    if (quizActive && !isSubmitting) {
                        // Immediately push state back WITHOUT alert (alert causes delay)
                        history.pushState({ quizActive: true, blocked: true }, '', location.href);
                        history.go(1); // Force forward
                        return false;
                    }
                });

                // Handle page show (when user navigates back to the page)
                window.addEventListener('pageshow', function(event) {
                    if (event.persisted && quizActive && !isSubmitting) {
                        pushHistoryStates();
                    }
                });

                // Warn when trying to leave during quiz (DON'T auto-save timer state)
                window.addEventListener('beforeunload', function(e) {
                    if (quizActive && !isSubmitting && timerStarted) {
                        // Only save ANSWERS, NOT timer state
                        saveProgressNow();

                        // Show warning message
                        const message = 'Anda sedang mengerjakan assessment. Jika Anda menutup browser, timer akan RESET ke awal. Progress jawaban akan tersimpan. Lanjutkan?';
                        e.preventDefault();
                        e.returnValue = message;
                        return message;
                    }
                });

                // Clear timer from localStorage when timer starts (ALWAYS fresh start)
                function startTimer() {
                    // Only prevent starting if interval is already running (not if just timerStarted flag)
                    if (timerInterval) return;

                    // Set quizActive flag
                    quizActive = true;

                    // ALWAYS clear old timer state - timer always starts fresh when browser is closed
                    console.log('Starting timer - clearing any old timer state for fresh start');
                    localStorage.removeItem(storageKey);
                    localStorage.removeItem(startTimeKey);
                    localStorage.removeItem(timerStartedKey);
                    localStorage.removeItem(quizStartedKey);

                    // Reset to full duration
                    timeRemaining = TIMER_DURATION;

                    timerStarted = true;
                    localStorage.setItem(timerStartedKey, 'true');
                    localStorage.setItem(quizStartedKey, 'true');

                    // Set start time
                    const startTime = Date.now();
                    localStorage.setItem(startTimeKey, startTime.toString());
                    displayStartTime();

                    // Update display immediately with current timeRemaining
                    updateTimerDisplay();

                    timerInterval = setInterval(function() {
                        timeRemaining--;
                        updateTimerDisplay();

                        if (timeRemaining <= 0) {
                            // Time's up!
                            clearInterval(timerInterval);
                            timerInterval = null;
                            localStorage.removeItem(timerStartedKey);
                            localStorage.removeItem(quizStartedKey);

                            // Auto submit the form
                            alert('Waktu habis! Jawaban Anda akan otomatis dikumpulkan.');
                            quizForm.submit();
                        }
                        // Note: Timer is NO LONGER saved to localStorage every 5 seconds
                        // So when user closes browser and comes back, timer resets to beginning
                    }, 1000);

                    console.log('Timer started fresh with', timeRemaining, 'seconds (', timeRemaining / 60, 'minutes)');
                }

                // Prevent tab switch during quiz (optional - Chrome might block this)
                document.addEventListener('visibilitychange', function() {
                    if (document.hidden && quizActive) {
                        console.log('User switched away from quiz');
                        // Save progress when user switches tabs (only answers, not timer)
                        if (timerStarted) {
                            saveProgressNow();
                        }
                    }
                });
                // ==================== END QUIZ PROTECTION ====================

                // Start quiz - hide start screen, show form, start timer
                document.getElementById('start-quiz-btn').addEventListener('click', function() {
                    document.getElementById('start-quiz-screen').style.display = 'none';
                    quizForm.classList.remove('hidden');

                    // Mark quiz as active
                    quizActive = true;
                    document.body.classList.add('quiz-active');  // Hide navigation

                    // Push multiple history states to prevent back button
                    pushHistoryStates();

                    // Start continuous blocking
                    startBlockingBack();

                    // Block navigation link clicks
                    blockNavigationLinks();

                    // Restore saved answers before starting
                    restoreSavedAnswers();

                    startTimer();  // Start the countdown timer
                });

                // Initialize - show current page based on progress
                showPage(currentPage);

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
                        nextBtn.innerHTML = `
                            <span>Submit Jawaban</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        `;
                        nextBtn.type = 'submit';
                    } else {
                        nextBtn.innerHTML = `
                            <span>Lanjut</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        `;
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
                        const radioInput = document.querySelector(`input[data-question-index="${index}"]:checked`);
                        const isAnswered = radioInput || document.querySelector(`input[data-question-index="${index}"]`)?.getAttribute('data-answered') === '1';

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
                        let unansweredCount = 0;

                        for (let i = startIndex; i < endIndex; i++) {
                            const radioInput = document.querySelector(`input[data-question-index="${i}"]:checked`);
                            if (!radioInput) {
                                allAnswered = false;
                                unansweredCount++;
                            }
                        }

                        if (!allAnswered) {
                            alert(`Mohon jawab semua soal pada halaman ini sebelum lanjut.\n\n${unansweredCount} soal belum dijawab.`);
                            return;
                        }

                        // Move to next page
                        currentPage++;
                        showPage(currentPage);
                    } else if (nextBtn.type === 'submit') {
                        // Final submission validation
                        const formData = new FormData(quizForm);
                        let answeredCount = 0;
                        for (let entry of formData.entries()) {
                            if (entry[0].startsWith('answers[') && entry[1]) {
                                answeredCount++;
                            }
                        }

                        if (answeredCount < totalQuestions) {
                            alert(`Mohon jawab semua pertanyaan sebelum submit.\n\n${totalQuestions - answeredCount} pertanyaan belum dijawab.`);
                            e.preventDefault();
                            return;
                        }

                        isSubmitting = true;
                    }
                });

                // Add click handlers for radio options
                quizForm.addEventListener('change', function(e) {
                    if (e.target.type === 'radio') {
                        // Get the question index
                        const questionIndex = e.target.getAttribute('data-question-index');

                        // Update styling for all options in this question
                        const questionContainer = e.target.closest('.space-y-2');
                        questionContainer.querySelectorAll('label').forEach(label => {
                            // Remove active styling
                            label.classList.remove('border-blue-500', 'bg-blue-50', 'ring-2', 'ring-blue-200');
                            label.classList.add('border-gray-200');

                            // Update text color
                            const textSpan = label.querySelector('span.flex-1');
                            if (textSpan) {
                                textSpan.classList.remove('text-blue-700');
                                textSpan.classList.add('text-gray-700');
                            }

                            // Reset radio circle
                            const circle = label.querySelector('div.rounded-full');
                            if (circle) {
                                circle.classList.remove('border-blue-500', 'bg-blue-500');
                                circle.classList.add('border-gray-300');
                                circle.innerHTML = '';
                            }
                        });

                        // Add active styling to selected option
                        if (e.target.checked) {
                            const label = e.target.closest('label');
                            label.classList.remove('border-gray-200');
                            label.classList.add('border-blue-500', 'bg-blue-50', 'ring-2', 'ring-blue-200');

                            // Update text color
                            const textSpan = label.querySelector('span.flex-1');
                            if (textSpan) {
                                textSpan.classList.remove('text-gray-700');
                                textSpan.classList.add('text-blue-700');
                            }

                            // Update radio circle
                            const circle = label.querySelector('div.rounded-full');
                            if (circle) {
                                circle.classList.remove('border-gray-300');
                                circle.classList.add('border-blue-500', 'bg-blue-500');
                                circle.innerHTML = '<div class="w-2.5 h-2.5 bg-white rounded-full"></div>';
                            }

                            // Update data-answered attribute for all radios with this question index
                            const allRadiosWithSameIndex = document.querySelectorAll(`input[data-question-index="${questionIndex}"]`);
                            allRadiosWithSameIndex.forEach(radio => {
                                radio.setAttribute('data-answered', '1');
                            });
                        }

                        // Update question number boxes
                        updateQuestionNumberBoxes();

                        // AUTO-SAVE progress immediately when answer is selected
                        saveProgressNow();
                    }
                });
            @endif
        });
    </script>
@endsection

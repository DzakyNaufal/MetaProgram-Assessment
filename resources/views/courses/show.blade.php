@extends('layouts.user')

@push('styles')
<style>
    /* Hide navigation when quiz is active */
    body.quiz-active header nav,
    body.quiz-active [role="navigation"],
    body.quiz-active .back-button,
    body.quiz-active .kategori-navbar {
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
            <!-- Completion Message for Full Assessment -->
            @if(isset($existingAttempt) && $existingAttempt && !$isSingleKategori)
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

            <!-- Kategori Meta Program Navbar -->
            @if($kategoriMetaPrograms->isNotEmpty() && (!isset($existingAttempt) || !$existingAttempt))
                <div class="mb-6 kategori-navbar bg-gradient-to-br from-white to-blue-50/50 rounded-2xl shadow-lg border border-blue-100 overflow-hidden">
                    <div class="p-5 border-b border-blue-100 bg-gradient-to-r from-blue-500 to-blue-600">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                            Kategori Meta Program
                        </h3>
                    </div>
                    <div class="p-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                            @foreach($kategoriMetaPrograms as $kategori)
                                @php
                                    $progress = $kategoriProgresses[$kategori->id] ?? null;
                                    $isActive = $activeKategori && $activeKategori->id === $kategori->id;
                                    $isAllowed = $allowedKategori && $allowedKategori->id === $kategori->id;
                                    $isLocked = in_array($kategori->id, $lockedKategoris ?? []);
                                    $isCompleted = $progress && $progress->is_completed;
                                    $progressPercent = $progress ? min(100, ($progress->current_question_index / max(1, $progress->total_questions)) * 100) : 0;
                                    $hasStarted = $progress && $progress->current_question_index > 0;
                                @endphp

                                <a href="{{ !$isLocked ? route('courses.kategori', [$course->slug, $kategori->slug]) : '#' }}"
                                   data-locked="{{ $isLocked ? '1' : '0' }}"
                                   data-kategori-name="{{ $kategori->name }}"
                                   class="kategori-nav-item group relative overflow-hidden rounded-xl border-2 transition-all duration-300
                                          {{ $isActive ? 'border-blue-500 bg-gradient-to-br from-blue-50 to-blue-100 shadow-lg shadow-blue-500/30 scale-105' : 'border-gray-200 bg-white hover:border-blue-300 hover:shadow-md' }}
                                          {{ $isLocked ? 'opacity-50 cursor-not-allowed grayscale' : 'cursor-pointer' }}
                                          {{ $isCompleted && !$isActive ? 'border-green-400 bg-gradient-to-br from-green-50 to-emerald-50' : '' }}">

                                    <div class="p-4">
                                        <!-- Header with Name and Status -->
                                        <div class="mb-3">
                                            <div class="flex items-start justify-between gap-2">
                                                <h4 class="font-bold text-gray-800 text-sm leading-tight flex-1 @if($isActive) text-blue-700 @endif">
                                                    {{ $kategori->name }}
                                                </h4>
                                                <!-- Status Badge -->
                                                @if($isLocked)
                                                    <div class="flex-shrink-0 w-6 h-6 bg-gray-200 rounded-full flex items-center justify-center">
                                                        <i class="fas fa-lock text-gray-500 text-xs"></i>
                                                    </div>
                                                @elseif($isCompleted)
                                                    <div class="flex-shrink-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center shadow-md">
                                                        <i class="fas fa-check text-white text-xs"></i>
                                                    </div>
                                                @elseif($isActive)
                                                    <span class="flex-shrink-0 px-2 py-1 bg-blue-500 text-white text-xs font-bold rounded-full shadow-md shadow-blue-500/30">AKTIF</span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Progress Section -->
                                        @if($progress && $progress->total_questions > 0)
                                            <div class="space-y-2">
                                                <div class="flex items-center justify-between text-xs">
                                                    <span class="font-medium @if($isCompleted) text-green-600 @elseif($isActive) text-blue-600 @else text-gray-500 @endif">
                                                        @if($isCompleted)
                                                            <i class="fas fa-check-circle mr-1"></i>Selesai
                                                        @elseif($hasStarted)
                                                            <i class="fas fa-spinner mr-1"></i>Sedang dikerjakan
                                                        @else
                                                            <i class="far fa-circle mr-1"></i>Belum dimulai
                                                        @endif
                                                    </span>
                                                    <span class="font-bold @if($isCompleted) text-green-700 @elseif($isActive) text-blue-700 @else text-gray-600 @endif">
                                                        {{ $progress->current_question_index }}/{{ $progress->total_questions }}
                                                    </span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                                    <div class="h-full rounded-full transition-all duration-500 ease-out
                                                         @if($isCompleted) bg-gradient-to-r from-green-400 to-green-500 @elseif($isActive) bg-gradient-to-r from-blue-400 to-blue-500 @else bg-gray-400 @endif"
                                                         style="width: {{ $progressPercent }}%"></div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="space-y-2">
                                                <div class="flex items-center text-xs text-gray-500">
                                                    <i class="far fa-circle mr-1"></i>
                                                    <span>Belum dimulai</span>
                                                </div>
                                                <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                                    <div class="h-full bg-gray-300 rounded-full" style="width: 0%"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>

                        <!-- Info Message -->
                        @if(!empty($lockedKategoris))
                            <div class="mt-4 p-4 bg-gradient-to-r from-orange-50 to-amber-50 border border-orange-200 rounded-xl flex items-start gap-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-lock text-orange-500 text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-orange-800 font-medium">
                                        Kategori harus dikerjakan secara berurutan
                                    </p>
                                    <p class="text-xs text-orange-700 mt-1">
                                        Selesaikan <strong>{{ $allowedKategori->name ?? '' }}</strong> terlebih dahulu sebelum melanjutkan ke kategori berikutnya.
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="mt-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl flex items-start gap-3">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-blue-800 font-medium">
                                        Kerjakan kategori secara berurutan
                                    </p>
                                    <p class="text-xs text-blue-700 mt-1">
                                        Mulai dari kategori pertama. Setelah menyelesaikan satu kategori, Anda dapat melanjutkan ke kategori berikutnya.
                                    </p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if(!isset($existingAttempt) || !$existingAttempt)
            @php
                // Define default values for quiz variables
                $perPage = 5;
                $totalPages = $questions->count() > 0 ? ceil($questions->count() / $perPage) : 1;
                $startIndex = $activeProgress ? $activeProgress->current_question_index : 0;
                $currentPage = min($totalPages, intdiv($startIndex, $perPage) + 1);
                $totalQuestions = $questions->count() ?? 0;
            @endphp
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Main Content - Questions -->
                <div class="flex-1">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <div class="mb-8">
                                @if (!$course->isFree())
                                    @php
                                        $hasPurchased = auth()->check() && auth()->user()->purchases()
                                            ->where('course_id', $course->id)
                                            ->where('status', 'confirmed')
                                            ->exists();
                                    @endphp

                                    @if (!$hasPurchased)
                                        <div class="inline-block px-4 py-2 mt-2 text-yellow-800 bg-yellow-100 rounded-lg">
                                            <i class="mr-2 fas fa-star"></i>Course berbayar - Rp {{ number_format($course->price, 0, ',', '.') }}
                                        </div>
                                    @endif
                                @endif

                                @if ($course->has_whatsapp_consultation)
                                    <div class="inline-block px-4 py-2 mt-2 ml-2 text-green-800 bg-green-100 rounded-lg">
                                        <i class="mr-2 fab fa-whatsapp"></i>Konsultasi WhatsApp tersedia
                                    </div>
                                @endif

                                @if ($course->has_offline_coaching)
                                    <div class="inline-block px-4 py-2 mt-2 ml-2 text-purple-800 bg-purple-100 rounded-lg">
                                        <i class="mr-2 fas fa-chalkboard-teacher"></i>Coaching Offline tersedia
                                    </div>
                                @endif
                            </div>

                            <!-- Start Quiz Screen -->
                            <div id="start-quiz-screen" class="py-16">
                                <div class="max-w-2xl mx-auto text-center">
                                    <div class="mb-8">
                                        <div class="inline-flex items-center justify-center w-24 h-24 mb-6 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 shadow-xl shadow-blue-500/30">
                                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <h2 class="text-3xl font-bold text-gray-900 mb-2">Assessment {{ $activeKategori->name }}</h2>
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
                                                <span>Pilih satu jawaban yang paling sesuai dengan kebiasaan dan kemampuan Anda</span>
                                            </li>
                                            <li class="flex items-start gap-2">
                                                <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                                <span>Setiap halaman berisi 5 soal. Tidak dapat kembali ke soal sebelumnya</span>
                                            </li>
                                            <li class="flex items-start gap-2">
                                                <svg class="w-4 h-4 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                </svg>
                                                <span>Waktu akan mulai berjalan setelah tombol "Mulai Mengerjakan" diklik</span>
                                            </li>
                                            <li class="flex items-start gap-2">
                                                <svg class="w-4 h-4 text-red-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                <span>Pastikan koneksi internet stabil. Jika waktu habis, jawaban akan otomatis dikumpulkan</span>
                                            </li>
                                        </ul>
                                    </div>

                                    <!-- Start Button -->
                                    <button type="button" id="start-quiz-btn"
                                        class="px-12 py-4 text-lg font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl hover:from-blue-600 hover:to-blue-700 shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200 flex items-center gap-3 mx-auto">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Mulai Mengerjakan
                                    </button>

                                    <!-- Reset Progress Button (Hidden by default) -->
                                    <form id="reset-progress-form" action="{{ route('courses.reset-progress', $course->slug) }}" method="POST" class="mt-4 hidden">
                                        @csrf
                                        <button type="submit"
                                                onclick="return confirm('Apakah Anda yakin ingin mereset progress course ini? Semua jawaban dan hasil akan dihapus.')"
                                                class="px-6 py-2 text-sm font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 hover:border-red-300 transition-all duration-200 flex items-center gap-2 mx-auto">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                            </svg>
                                            Reset Progress Course
                                        </button>
                                    </form>
                                </div>
                            </div>

                            <!-- Quiz Form (Hidden Initially) -->
                            @if ($questions->count() > 0)
                                <form id="quizForm"
                                      action="@if($isSingleKategori ?? false) {{ route('courses.single-kategori.submit', $course->slug) }} @else {{ route('courses.submit-kategori', [$course->slug, $selectedKategoriSlug]) }} @endif"
                                      method="POST" class="hidden">
                                    @csrf
                                    <input type="hidden" name="total_questions" id="total_questions" value="{{ $questions->count() }}">

                                    <div id="questions-container">
                                        @php
                                            $perPage = 5;
                                            $totalPages = ceil($questions->count() / $perPage);
                                            $startIndex = ($activeProgress ? $activeProgress->current_question_index : 0);
                                            $currentPage = min($totalPages, intdiv($startIndex, $perPage) + 1);
                                        @endphp

                                        @foreach ($questions as $index => $question)
                                            @php
                                                $pageNum = intdiv($index, $perPage) + 1;
                                                $isAnswered = isset($savedAnswers[$question->id]) && $savedAnswers[$question->id] != '';
                                            @endphp

                                            <div class="p-6 mb-8 border border-blue-100 rounded-xl question-card bg-gradient-to-br from-white to-blue-50/30 shadow-sm"
                                                 data-page="{{ $pageNum }}" data-question-index="{{ $index }}"
                                                 @if($pageNum !== $currentPage) style="display: none;" @endif>
                                                <div class="flex items-start gap-3 mb-4">
                                                    <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center bg-blue-500 text-white rounded-lg font-bold text-sm">{{ $index + 1 }}</span>
                                                    <p class="flex-1 font-semibold text-gray-800 text-lg leading-relaxed">{{ $question->question_text }}</p>
                                                </div>

                                                <div class="space-y-2">
                                                    @foreach ($question->options->sortBy('order') as $option)
                                                        @php
                                                            $isSelected = isset($savedAnswers[$question->id]) && $savedAnswers[$question->id] == $option->id;
                                                        @endphp
                                                        <label class="flex items-center p-4 bg-white border-2 rounded-xl cursor-pointer hover:border-blue-400 hover:bg-blue-50/50 transition-all duration-200 group @if($isSelected) border-blue-500 bg-blue-50 ring-2 ring-blue-200 @else border-gray-200 @endif">
                                                            <input type="radio"
                                                                id="answer_{{ $question->id }}_{{ $option->id }}"
                                                                name="answers[{{ $question->id }}]"
                                                                value="{{ $option->id }}"
                                                                class="hidden"
                                                                data-question-index="{{ $index }}"
                                                                data-answered="{{ $isAnswered ? '1' : '0' }}"
                                                                @if($isSelected) checked @endif
                                                                required>
                                                            <div class="flex items-center justify-between w-full gap-3">
                                                                <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center flex-shrink-0 @if($isSelected) border-blue-500 bg-blue-500 @else border-gray-300 group-hover:border-blue-400 @endif transition-all duration-200">
                                                                    @if($isSelected)<div class="w-2.5 h-2.5 bg-white rounded-full"></div>@endif
                                                                </div>
                                                                <span class="flex-1 text-sm font-medium text-gray-700 @if($isSelected) text-blue-700 @endif">{{ $option->option_text }}</span>
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
                            @elseif($activeKategori && $activeProgress && $activeProgress->is_completed)
                                <div class="py-16 text-center bg-gradient-to-br from-green-50 to-blue-50 rounded-xl border border-green-200">
                                    <div class="inline-flex items-center justify-center w-20 h-20 mb-4 rounded-full bg-gradient-to-br from-green-400 to-green-500 shadow-lg shadow-green-500/30">
                                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900">Kategori Selesai!</h3>
                                    <p class="mt-2 text-gray-600">Anda telah menyelesaikan semua pertanyaan di kategori <span class="font-semibold text-blue-600">{{ $activeKategori->name }}</span>.</p>
                                    <a href="{{ route('courses.show', $course->slug) }}" class="inline-flex items-center gap-2 mt-6 px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl hover:from-blue-600 hover:to-blue-700 hover:shadow-lg hover:shadow-blue-500/30 transition-all duration-200">
                                        <span>Lanjut ke Kategori Berikutnya</span>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </a>
                                </div>
                            @else
                                <div class="py-16 text-center bg-gray-50 rounded-xl">
                                    <div class="inline-flex items-center justify-center w-20 h-20 mb-4 rounded-full bg-[#0369a1]/10">
                                        <svg class="w-10 h-10 text-[#0369a1]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900">Belum Ada Pertanyaan</h3>
                                    <p class="mt-2 text-gray-500">Kategori {{ $activeKategori->name ?? '' }} ini belum memiliki pertanyaan.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar - Question Numbers -->
                @if ($questions->count() > 0)
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
                            <span>{{ $activeKategori->timer_duration ? intdiv($activeKategori->timer_duration, 60) : 30 }} menit</span>
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
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <div class="flex flex-wrap items-center justify-center gap-3 text-xs">
                                <div class="flex items-center gap-1.5">
                                    <div class="w-4 h-4 bg-blue-500 rounded shadow-sm shadow-blue-500/30"></div>
                                    <span class="text-gray-600 font-medium">Aktif</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <div class="w-4 h-4 bg-green-500 rounded shadow-sm shadow-green-500/30"></div>
                                    <span class="text-gray-600 font-medium">Terjawab</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <div class="w-4 h-4 bg-gray-100 rounded border border-gray-200"></div>
                                    <span class="text-gray-600 font-medium">Belum</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>

    @if(!isset($existingAttempt) || !$existingAttempt)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if($questions->count() > 0 && $activeKategori && (!isset($existingAttempt) || !$existingAttempt))
                const perPage = 5;
                const totalQuestions = parseInt(document.getElementById('total_questions').value);
                const totalPages = Math.ceil(totalQuestions / perPage);
                let currentPage = {{ $currentPage }};
                const kategoriSlug = '{{ $selectedKategoriSlug }}';
                const courseSlug = '{{ $course->slug }}';

                const questionCards = document.querySelectorAll('.question-card');
                const questionNumberBoxes = document.querySelectorAll('.question-number-box');
                const nextBtn = document.getElementById('next-btn');
                const pageIndicator = document.getElementById('page-indicator');
                const quizForm = document.getElementById('quizForm');

                // ==================== COUNTDOWN TIMER ====================
                // Calculate timer duration based on total questions (1 minute per question)
                const TIMER_DURATION = {{ $totalQuestions ?? 30 }} * 60;
                let timeRemaining = TIMER_DURATION;
                let timerInterval = null;
                let timerStarted = false;
                let quizActive = false;  // Global flag to track quiz state
                let isSubmitting = false;  // Flag to prevent beforeunload popup during submit

                // Get kategori ID for localStorage key
                const kategoriId = '{{ $activeKategori->id }}';
                const storageKey = `quiz_timer_${courseSlug}_${kategoriId}`;
                const startTimeKey = `quiz_start_${courseSlug}_${kategoriId}`;
                const timerStartedKey = `quiz_timer_started_${courseSlug}_${kategoriId}`;
                const quizStartedKey = `quiz_started_${courseSlug}_${kategoriId}`;

                // LocalStorage key for answers (backup in case AJAX fails)
                const answersStorageKey = `quiz_answers_${courseSlug}_${kategoriId}`;

                // Timer ALWAYS starts fresh - NO restoration from localStorage
                // When user closes browser and comes back, timer resets to beginning

                // ==================== CLEANUP OLD DATA ====================
                // Clear all old quiz-related localStorage data on page load
                // This ensures users start fresh every time they visit
                (function cleanUpOldData() {
                    // Clear timer-related keys
                    localStorage.removeItem(storageKey);
                    localStorage.removeItem(startTimeKey);
                    localStorage.removeItem(timerStartedKey);
                    localStorage.removeItem(quizStartedKey);

                    // Clear old answers from localStorage
                    localStorage.removeItem(answersStorageKey);

                    // Clear saved answers from server session (on page load)
                    fetch(`/courses/${courseSlug}/${kategoriSlug}/clear-progress`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(() => {
                        console.log('=== CLEANUP: Cleared old quiz data from server session ===');
                    }).catch(err => {
                        console.error('=== CLEANUP: Failed to clear server session ===', err);
                    });

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

                // Start countdown timer - ALWAYS starts fresh
                function startTimer(resume = false) {
                    // Don't start if already running
                    if (timerStarted || timerInterval) return;

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

                // Start quiz - hide start screen, show form, start timer
                function startQuiz(isResume = false) {
                    const startScreen = document.getElementById('start-quiz-screen');
                    const quizForm = document.getElementById('quizForm');

                    // Hide start screen
                    startScreen.style.display = 'none';

                    // Show quiz form
                    quizForm.classList.remove('hidden');

                    // Hide navigation by adding class to body
                    document.body.classList.add('quiz-active');

                    // Push multiple history states to prevent back button
                    pushHistoryStates();

                    // Start continuous blocking
                    startBlockingBack();

                    // Block navigation link clicks
                    blockNavigationLinks();

                    // Mark quiz as started
                    localStorage.setItem(quizStartedKey, 'true');

                    // Start timer (always fresh start, no resume)
                    startTimer();
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
                // ==================== END QUIZ PROTECTION ====================

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
                    // Show navigation again
                    document.body.classList.remove('quiz-active');
                }

                // Initialize display
                displayStartTime();
                updateTimerDisplay();

                // Always show start screen
                document.getElementById('start-quiz-screen').style.display = 'block';
                document.getElementById('quizForm').classList.add('hidden');

                // Start button click handler
                const startBtn = document.getElementById('start-quiz-btn');
                startBtn.addEventListener('click', function() {
                    startQuiz(false);  // Always start fresh
                });

                // Clear timer on page unload - DON'T save timer state (timer resets)
                window.addEventListener('beforeunload', function() {
                    // Don't save if form is being submitted
                    if (isSubmitting) {
                        return;
                    }
                    if (timerStarted && timeRemaining > 0) {
                        // Only save ANSWERS, NOT timer state
                        // Timer will reset when user comes back
                        // Note: Add saveProgressNow() call here if you have answer saving logic
                    }
                });

                // Clear timer when form is submitted
                quizForm.addEventListener('submit', function() {
                    isSubmitting = true;  // Set flag to prevent beforeunload popup
                    clearTimer();
                    // Clear localStorage answers after successful submission
                    localStorage.removeItem(answersStorageKey);
                });

                // ==================== END COUNTDOWN TIMER ====================

                // Initialize - show current page based on progress
                showPage(currentPage);

                // Update question numbers after DOM is fully rendered (to ensure saved answers are reflected)
                setTimeout(function() {
                    updateQuestionNumberBoxes();
                }, 100);

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

                // Function to save progress immediately
                function saveProgressNow() {
                    const formData = new FormData(quizForm);
                    const answers = {};
                    let answeredCount = 0;

                    for (let [key, value] of formData.entries()) {
                        if (key.startsWith('answers[')) {
                            const match = key.match(/\d+/);
                            if (match) {
                                const questionId = match[0];
                                if (value && value !== '') {
                                    answers[questionId] = parseInt(value);
                                    answeredCount++;
                                }
                            }
                        }
                    }

                    // Calculate current question index based on answered count
                    const currentQuestionIndex = answeredCount > 0 ? answeredCount : 0;

                    // Use different endpoint for single-kategori courses
                    const saveUrl = @if($isSingleKategori ?? false)
                        `/courses/${courseSlug}/single-kategori/save-progress`;
                    @else
                        `/courses/${courseSlug}/${kategoriSlug}/save-progress`;
                    @endif

                    fetch(saveUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            answers: answers,
                            current_question_index: currentQuestionIndex,
                            total_questions: totalQuestions
                        })
                    })
                    .then(response => {
                        // Check if response is ok
                        if (!response.ok) {
                            // Try to get error message from response
                            return response.text().then(text => {
                                console.error('Server error:', text);
                                throw new Error(`Server error: ${response.status}`);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Progress saved:', data);
                        // If category is completed, show notification and reload page
                        if (data.success && data.is_completed) {
                            showNotification('Semua pertanyaan telah dijawab! Klik "Submit Jawaban" untuk menyelesaikan kategori ini.', 'success');
                        }
                    })
                    .catch(error => {
                        console.error('Error saving progress:', error);
                        // Don't show notification for save errors to avoid annoying the user
                        // Progress will be saved again on next answer or final submit
                    });
                }

                // Function to update question number boxes
                function updateQuestionNumberBoxes() {
                    const startIndex = (currentPage - 1) * perPage;
                    const endIndex = Math.min(startIndex + perPage, totalQuestions);

                    questionNumberBoxes.forEach((box, index) => {
                        const questionNum = index + 1;

                        // Remove all classes
                        box.classList.remove('bg-blue-500', 'bg-green-500', 'bg-gray-200', 'text-white', 'text-gray-600');

                        // Check if question is answered - check ALL radios with this question index
                        const radioInputs = document.querySelectorAll(`input[data-question-index="${index}"]`);
                        let isAnswered = false;
                        radioInputs.forEach(input => {
                            // Check if radio is checked OR has data-answered attribute from saved answers
                            if (input.checked || input.getAttribute('data-answered') === '1') {
                                isAnswered = true;
                            }
                        });

                        if (questionNum >= startIndex + 1 && questionNum <= endIndex) {
                            // Current page - blue (regardless of answered status)
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
                        let unansweredQuestions = [];

                        for (let i = startIndex; i < endIndex; i++) {
                            const radioInput = document.querySelector(`input[data-question-index="${i}"]:checked`);
                            if (!radioInput) {
                                allAnswered = false;
                                const questionCard = document.querySelector(`input[data-question-index="${i}"]`).closest('.question-card');
                                const questionText = questionCard.querySelector('p').textContent;
                                unansweredQuestions.push(questionText.substring(0, 50) + '...');
                            }
                        }

                        if (!allAnswered) {
                            alert('Mohon jawab semua soal pada halaman ini sebelum lanjut.\n\nPertanyaan yang belum dijawab:\n' + unansweredQuestions.join('\n'));
                            return;
                        }

                        // Move to next page
                        currentPage++;
                        showPage(currentPage);
                    } else if (nextBtn.type === 'submit') {
                        // Handle form submission via AJAX
                        e.preventDefault();
                        submitForm();
                    }
                });

                // Form submission function
                function submitForm() {
                    isSubmitting = true;  // Set flag to prevent beforeunload popup
                    const submitBtn = document.getElementById('next-btn');

                    // Validate all questions are answered before final submission
                    const formData = new FormData(quizForm);
                    const answers = {};
                    for (let [key, value] of formData.entries()) {
                        if (key.startsWith('answers[')) {
                            const match = key.match(/\d+/);
                            if (match) {
                                const questionId = match[0];
                                answers[questionId] = parseInt(value);
                            }
                        }
                    }

                    // Check if all questions have answers
                    let unansweredQuestions = [];
                    const totalQuestionCards = document.querySelectorAll('.question-card');
                    totalQuestionCards.forEach((card, index) => {
                        const radioInput = card.querySelector(`input[data-question-index="${index}"]:checked`);
                        if (!radioInput) {
                            const questionText = card.querySelector('p').textContent;
                            unansweredQuestions.push(`Soal ${index + 1}: ${questionText.substring(0, 40)}...`);
                        }
                    });

                    if (unansweredQuestions.length > 0) {
                        alert('Mohon jawab semua pertanyaan sebelum submit.\n\nPertanyaan yang belum dijawab:\n' + unansweredQuestions.slice(0, 5).join('\n') + (unansweredQuestions.length > 5 ? '\n...dan lainnya' : ''));
                        return;
                    }

                    // Show loading state
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="mr-2 fas fa-spinner fa-spin"></i>Memproses...';

                    fetch(`/courses/${courseSlug}/${kategoriSlug}/submit`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ answers: answers })
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(err.error || 'Server error');
                            }).catch(() => {
                                throw new Error('Server error: ' + response.status);
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            if (data.is_all_completed) {
                                // All assessments completed - show completion message and redirect to results
                                showNotification('Anda sudah menyelesaikan assessment ini! Silakan cek hasil assessment Anda.', 'success');
                                setTimeout(() => {
                                    window.location.href = data.redirect_url;
                                }, 3000);
                            } else {
                                // Show success notification for single kategori
                                showNotification(data.message || 'Kategori berhasil diselesaikan!', 'success');
                            }

                            if (!data.is_all_completed) {
                                // Show next category notification
                                const nextKategoriMsg = data.next_kategori_name
                                    ? `Kategori berikutnya telah terbuka: "${data.next_kategori_name}"`
                                    : 'Kategori berikutnya telah terbuka!';

                                showNotification(`${nextKategoriMsg}\n(${data.remaining_count} kategori tersisa)`, 'info');

                                // Auto-reload to show next kategori
                                setTimeout(() => {
                                    window.location.href = data.next_kategori_url;
                                }, 3000);
                            }
                        } else {
                            showNotification(data.error || 'Terjadi kesalahan. Silakan coba lagi.', 'error');
                            if (data.redirect_url) {
                                setTimeout(() => {
                                    window.location.href = data.redirect_url;
                                }, 2000);
                            } else {
                                submitBtn.disabled = false;
                                submitBtn.textContent = 'Submit Jawaban';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification(error.message || 'Terjadi kesalahan. Silakan coba lagi.', 'error');
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Submit Jawaban';
                    });
                }

                // Notification function
                function showNotification(message, type = 'info') {
                    // Remove existing notification if any
                    const existingNotification = document.querySelector('.custom-notification');
                    if (existingNotification) {
                        existingNotification.remove();
                    }

                    const notification = document.createElement('div');
                    notification.className = 'custom-notification fixed top-4 right-4 max-w-md p-4 rounded-lg shadow-xl z-50 transform transition-all duration-300 translate-x-full';

                    const bgColor = {
                        'success': 'bg-green-500',
                        'error': 'bg-red-500',
                        'info': 'bg-blue-500'
                    }[type] || 'bg-blue-500';

                    const icon = {
                        'success': 'fa-check-circle',
                        'error': 'fa-exclamation-circle',
                        'info': 'fa-info-circle'
                    }[type] || 'fa-info-circle';

                    notification.classList.add(bgColor);
                    notification.innerHTML = `
                        <div class="flex items-start text-white">
                            <i class="fas ${icon} mt-1 mr-3 text-xl"></i>
                            <div class="flex-1">
                                <p class="text-sm font-medium whitespace-pre-line">${message}</p>
                            </div>
                            <button class="ml-3 text-white hover:text-gray-200" onclick="this.parentElement.parentElement.remove()">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `;

                    document.body.appendChild(notification);

                    // Animate in
                    setTimeout(() => {
                        notification.classList.remove('translate-x-full');
                    }, 10);

                    // Auto-remove after 5 seconds (unless it's an error)
                    if (type !== 'error') {
                        setTimeout(() => {
                            notification.classList.add('translate-x-full');
                            setTimeout(() => {
                                notification.remove();
                            }, 300);
                        }, 5000);
                    }
                }

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

                            // Update data-answered attribute for ALL radios with this question index
                            const allRadiosWithSameIndex = document.querySelectorAll(`input[data-question-index="${questionIndex}"]`);
                            allRadiosWithSameIndex.forEach(radio => {
                                radio.setAttribute('data-answered', '1');
                            });
                        }

                        // Update question number boxes
                        updateQuestionNumberBoxes();

                        // DO NOT AUTO-SAVE - answers are lost if browser is closed
                        // saveProgressNow(); // DISABLED
                    }
                });
            @endif

            // Handle kategori navigation - prevent clicking locked categories (sequential order)
            const kategoriNavItems = document.querySelectorAll('.kategori-nav-item');
            kategoriNavItems.forEach(function(item) {
                item.addEventListener('click', function(e) {
                    const isLocked = this.getAttribute('data-locked') === '1';
                    if (isLocked) {
                        e.preventDefault();
                        alert('Kategori harus dikerjakan secara berurutan. Selesaikan kategori yang tersedia saat ini terlebih dahulu sebelum melanjutkan ke kategori berikutnya.');
                        return false;
                    }
                });
            });

            // Prevent leaving page if course is in progress (not all kategoris completed)
            @php
                $hasInProgress = false;
                if(auth()->check()) {
                    $completedCount = \App\Models\UserKategoriProgress::where('user_id', auth()->id())
                        ->where('course_id', $course->id)
                        ->where('is_completed', true)
                        ->count();
                    $totalCount = \App\Models\KategoriMetaProgram::count();
                    $hasInProgress = $completedCount > 0 && $completedCount < $totalCount;
                }
            @endphp

            @if($hasInProgress)
                const inProgress = true;

                // Prevent navigation away from page
                const navigationLinks = document.querySelectorAll('a[href]');
                navigationLinks.forEach(function(link) {
                    link.addEventListener('click', function(e) {
                        const href = this.getAttribute('href');
                        // Allow links within the same course page
                        if (href && href !== '#' && href !== 'javascript:void(0)') {
                            // Check if link is to same course page (kategori navigation is OK)
                            if (!href.includes('/courses/{{ $course->slug }}')) {
                                e.preventDefault();
                                if (confirm('Anda sedang mengerjakan assessment. Anda harus menyelesaikan semua kategori ({{ \App\Models\KategoriMetaProgram::count() }} kategori) terlebih dahulu sebelum keluar.\\n\\nApakah Anda yakin ingin keluar? Progres Anda akan hilang.')) {
                                    window.location.href = '/courses/{{ $course->slug }}';
                                } else {
                                    return false;
                                }
                            }
                        }
                    });
                });

                // Prevent browser back button
                window.addEventListener('popstate', function(e) {
                    if (inProgress) {
                        e.preventDefault();
                        window.history.pushState(null, null, window.location.href);
                        alert('Anda harus menyelesaikan semua kategori terlebih dahulu sebelum keluar dari halaman ini.');
                    }
                });

                // Prevent browser tab close
                window.addEventListener('beforeunload', function(e) {
                    // Don't show popup if form is being submitted
                    if (isSubmitting) {
                        return;
                    }
                    if (inProgress) {
                        e.preventDefault();
                        e.returnValue = 'Anda harus menyelesaikan semua kategori terlebih dahulu. Progres Anda akan hilang jika keluar.';
                        return e.returnValue;
                    }
                });

                // Push state to handle back button
                window.history.pushState(null, null, window.location.href);
            @endif
        });
    </script>
    @endif
@endsection

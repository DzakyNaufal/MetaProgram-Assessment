<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\QuizResult;
use App\Models\QuestionOption;
use App\Models\KategoriMetaProgram;
use App\Models\UserKategoriProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of all courses.
     */
    public function index()
    {
        $courses = Course::where('is_active', true)
            ->orderBy('id')
            ->get();

        // Calculate question count and estimated time for each course
        foreach ($courses as $course) {
            if ($course->isSingleKategori()) {
                // Single kategori course - count questions for this kategori
                $kategori = $course->kategoriMetaProgram;
                if ($kategori) {
                    $mpIds = \App\Models\MetaProgram::where('kategori_meta_program_id', $kategori->id)
                        ->where('is_active', true)
                        ->pluck('id');

                    $questionCount = \App\Models\PertanyaanMetaProgram::whereIn('meta_program_id', $mpIds)
                        ->where('is_active', true)
                        ->count();

                    // Add dynamic attributes
                    $course->questions_count = $questionCount;
                    $course->estimated_time = $questionCount; // 1 minute per question
                }
            } else {
                // Full assessment course - count all questions from all kategoris
                $allMpIds = \App\Models\MetaProgram::where('is_active', true)->pluck('id');
                $questionCount = \App\Models\PertanyaanMetaProgram::whereIn('meta_program_id', $allMpIds)
                    ->where('is_active', true)
                    ->count();

                $course->questions_count = $questionCount;
                $course->estimated_time = $questionCount; // 1 minute per question
            }
        }

        return view('courses.index', compact('courses'));
    }

    /**
     * Display the specified resource for quiz taking.
     */
    public function show($courseSlug, $kategoriSlug = null)
    {
        $course = Course::where('slug', $courseSlug)
            ->where('is_active', true)
            ->firstOrFail();

        // Check if this is a single kategori course (e.g., Assessment Kategori 1, 2, 3, 4, 5)
        if ($course->isSingleKategori()) {
            return $this->showSingleKategoriCourse($course);
        }

        // Check if this is a parent course (free course with categories that have prices)
        if ($course->isFree() && $course->categories()->whereNotNull('price')->where('price', '>', 0)->exists()) {
            // This is a parent course - show category options
            $categories = $course->categories()
                ->where('is_active', true)
                ->orderBy('id')
                ->get();

            return view('courses.show-parent', compact('course', 'categories'));
        }

        // Check if user can access this course
        if (!Auth::user()->canAccessCourse($course)) {
            return redirect()->route('courses.purchase', $course->slug)
                ->with('error', 'Anda perlu membeli course ini untuk mengaksesnya.');
        }

        // CHECK: For full assessment, if user has already completed (has QuizAttempt), show completion message
        // This is similar to single-kategori course behavior
        $existingAttempt = \App\Models\QuizAttempt::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->first();

        // Check if user has started this course - if yes, they MUST complete all kategoris before leaving
        $hasStartedCourse = UserKategoriProgress::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->exists();

        if ($hasStartedCourse) {
            // Count completed kategoris
            $completedCount = UserKategoriProgress::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->where('is_completed', true)
                ->count();

            $totalKategoris = KategoriMetaProgram::count();

            // If started but not completed all kategoris, force stay on this page
            if ($completedCount < $totalKategoris) {
                // Allow access to this course page, but store a flag to prevent leaving
                session()->put('must_complete_course_' . $course->id, true);
            } else {
                // All completed, clear the flag
                session()->forget('must_complete_course_' . $course->id);
            }
        }

        // Get all kategori meta programs
        $kategoriMetaPrograms = KategoriMetaProgram::orderBy('order')->get();

        // Get or initialize user progress for all kategoris
        $userId = Auth::id();
        $kategoriProgresses = [];

        // Initialize progress for all kategoris if not exists
        foreach ($kategoriMetaPrograms as $kategori) {
            $progress = UserKategoriProgress::firstOrCreate(
                [
                    'user_id' => $userId,
                    'course_id' => $course->id,
                    'kategori_meta_program_id' => $kategori->id,
                ],
                [
                    'current_question_index' => 0,
                    'total_questions' => 0, // Will be calculated below
                    'is_completed' => false,
                ]
            );

            // Calculate total questions for this kategori using PertanyaanMetaProgram
            // Get all meta program IDs for this kategori
            $metaProgramIds = \App\Models\MetaProgram::where('kategori_meta_program_id', $kategori->id)
                ->where('is_active', true)
                ->pluck('id');

            // Count pertanyaan meta programs for this kategori
            $totalQuestions = \App\Models\PertanyaanMetaProgram::whereIn('meta_program_id', $metaProgramIds)
                ->where('is_active', true)
                ->count();

            if ($progress->total_questions != $totalQuestions) {
                $progress->total_questions = $totalQuestions;
                $progress->save();
            }

            $kategoriProgresses[$kategori->id] = $progress;
        }

        // Find the FIRST incomplete kategori (sequential order - must complete in order)
        $allowedKategori = null;
        $lockedKategoris = []; // Track which kategoris are locked

        foreach ($kategoriMetaPrograms as $kategori) {
            $progress = $kategoriProgresses[$kategori->id];
            // If this kategori is not completed, it's the first incomplete one
            if (!$progress->is_completed && !$allowedKategori) {
                $allowedKategori = $kategori;
                break; // Stop at first incomplete
            }
        }

        // If all completed, the first one is allowed (for review)
        $allCompleted = false;
        if (!$allowedKategori && $kategoriMetaPrograms->isNotEmpty()) {
            $allCompleted = true;
            foreach ($kategoriMetaPrograms as $kategori) {
                if (!$kategoriProgresses[$kategori->id]->is_completed) {
                    $allCompleted = false;
                    break;
                }
            }
            if ($allCompleted) {
                $allowedKategori = $kategoriMetaPrograms->first();
            }
        }

        // CHECK: If all kategoris are completed for full assessment, mark as completed
        // Similar to single-kategori course behavior
        if ($allCompleted && $kategoriMetaPrograms->isNotEmpty()) {
            // If no quiz attempt exists but all kategoris are completed, create one to mark completion
            if (!$existingAttempt) {
                // Create a quiz attempt to mark the full assessment as completed
                $existingAttempt = \App\Models\QuizAttempt::create([
                    'user_id' => Auth::id(),
                    'course_id' => $course->id,
                    'category_id' => null,
                    'answers' => [],
                    'scores' => json_encode([
                        'full_assessment_completed' => true,
                        'completed_at' => now()->toDateTimeString(),
                    ]),
                    'dominant_type' => 'Full Assessment',
                    'total_score' => 0,
                ]);
            }
        }

        // Determine the active kategori
        $activeKategori = null;
        $selectedKategoriSlug = $kategoriSlug;
        $canAccessKategori = true;

        if ($selectedKategoriSlug) {
            $requestedKategori = $kategoriMetaPrograms->where('slug', $selectedKategoriSlug)->first();

            // User can only access the allowed kategori (first incomplete)
            if ($requestedKategori && $allowedKategori && $requestedKategori->id !== $allowedKategori->id) {
                $canAccessKategori = false;
                $activeKategori = $allowedKategori; // Show the allowed kategori instead
                $selectedKategoriSlug = $allowedKategori->slug;
            } else {
                $activeKategori = $requestedKategori ?? $allowedKategori;
            }
        } else {
            // No kategori selected - show the allowed one (first incomplete)
            $activeKategori = $allowedKategori;
            if ($activeKategori) {
                $selectedKategoriSlug = $activeKategori->slug;
            }
        }

        // Build locked kategoris list (all except the allowed one)
        foreach ($kategoriMetaPrograms as $kategori) {
            if ($allowedKategori && $kategori->id !== $allowedKategori->id) {
                $lockedKategoris[] = $kategori->id;
            }
        }

        // Get questions for the selected kategori
        $questions = collect();
        $activeProgress = null;

        if ($activeKategori) {
            $activeProgress = $kategoriProgresses[$activeKategori->id];

            // Get all meta programs in this kategori
            $metaProgramIds = \App\Models\MetaProgram::where('kategori_meta_program_id', $activeKategori->id)
                ->where('is_active', true)
                ->pluck('id');

            \Log::info("Active Kategori: " . $activeKategori->name);
            \Log::info("Meta Program IDs: " . json_encode($metaProgramIds));

            if ($metaProgramIds->isNotEmpty()) {
                // Use PertanyaanMetaProgram (same as per-kategori)
                $pertanyaanList = \App\Models\PertanyaanMetaProgram::whereIn('meta_program_id', $metaProgramIds)
                    ->where('is_active', true)
                    ->with('metaProgram')
                    ->orderBy('id')
                    ->get();

                \Log::info("Pertanyaan found: " . $pertanyaanList->count());

                // Map to format expected by view (convert to Question-like structure)
                $questions = $pertanyaanList->map(function($pertanyaan) {
                    // Create a Question-like object from PertanyaanMetaProgram
                    $question = new \stdClass();
                    $question->id = $pertanyaan->id;
                    $question->question_text = $pertanyaan->pertanyaan;
                    $question->order = $pertanyaan->order;
                    $question->is_reverse = $pertanyaan->is_negatif ?? false;

                    // Create options from skala columns (6-point Likert scale)
                    $options = collect([
                        (object)['id' => $pertanyaan->skala_sangat_tidak_setuju, 'option_text' => 'Sangat Tidak Setuju', 'order' => 1, 'score' => $pertanyaan->skala_sangat_tidak_setuju],
                        (object)['id' => $pertanyaan->skala_tidak_setuju, 'option_text' => 'Tidak Setuju', 'order' => 2, 'score' => $pertanyaan->skala_tidak_setuju],
                        (object)['id' => $pertanyaan->skala_agak_tidak_setuju, 'option_text' => 'Agak Tidak Setuju', 'order' => 3, 'score' => $pertanyaan->skala_agak_tidak_setuju],
                        (object)['id' => $pertanyaan->skala_agak_setuju, 'option_text' => 'Agak Setuju', 'order' => 4, 'score' => $pertanyaan->skala_agak_setuju],
                        (object)['id' => $pertanyaan->skala_setuju, 'option_text' => 'Setuju', 'order' => 5, 'score' => $pertanyaan->skala_setuju],
                        (object)['id' => $pertanyaan->skala_sangat_setuju, 'option_text' => 'Sangat Setuju', 'order' => 6, 'score' => $pertanyaan->skala_sangat_setuju],
                    ]);

                    $question->options = $options;
                    return $question;
                });

                \Log::info("Questions after mapping: " . $questions->count());
            }
        }

        // Get saved answers from session for this kategori
        $savedAnswers = [];
        if ($activeKategori) {
            $sessionKey = "quiz_answers_{$course->id}_{$activeKategori->id}";
            $savedAnswers = session($sessionKey, []);
        }

        // Check if this is a single kategori course
        $isSingleKategori = $course->isSingleKategori();

        return view('courses.show', compact(
            'course',
            'questions',
            'kategoriMetaPrograms',
            'kategoriProgresses',
            'activeKategori',
            'activeProgress',
            'selectedKategoriSlug',
            'allowedKategori',
            'lockedKategoris',
            'canAccessKategori',
            'savedAnswers',
            'isSingleKategori',
            'existingAttempt'
        ));
    }

    /**
     * Display the purchase page for a course.
     */
    public function purchase($courseSlug)
    {
        $course = Course::where('slug', $courseSlug)
            ->where('is_active', true)
            ->firstOrFail();

        // Free courses don't need purchase
        if ($course->isFree()) {
            return redirect()->route('courses.show', $course->slug);
        }

        // Check if user already has access
        if (Auth::user()->canAccessCourse($course)) {
            return redirect()->route('courses.show', $course->slug);
        }

        $bankAccounts = \App\Models\BankAccount::where('is_active', true)->get();

        // Get active coupons that are currently valid
        $activeCoupons = \App\Models\Coupon::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('valid_from')
                    ->orWhere('valid_from', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('valid_until')
                    ->orWhere('valid_until', '>=', now());
            })
            ->where(function ($query) {
                $query->whereNull('max_uses')
                    ->orWhereRaw('used_count < max_uses');
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->filter(function ($coupon) use ($course) {
                // Filter by course type using the model method
                return $coupon->isApplicableForCourseType($course->type);
            });

        return view('courses.purchase', compact('course', 'bankAccounts', 'activeCoupons'));
    }

    /**
     * Save current question progress.
     */
    public function saveProgress(Request $request, $courseSlug, $kategoriSlug)
    {
        try {
            // Validate required fields
            $answers = $request->input('answers', []);
            $currentQuestionIndex = (int) $request->input('current_question_index', 0);
            $totalQuestions = (int) $request->input('total_questions', 0);

            if (!is_array($answers)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Format answers tidak valid.'
                ], 400);
            }

            $course = Course::where('slug', $courseSlug)->firstOrFail();
            $kategori = KategoriMetaProgram::where('slug', $kategoriSlug)->firstOrFail();
            $userId = Auth::id();

            // Get or create progress
            $progress = UserKategoriProgress::firstOrCreate(
                [
                    'user_id' => $userId,
                    'course_id' => $course->id,
                    'kategori_meta_program_id' => $kategori->id,
                ]
            );

            // Update progress
            $progress->current_question_index = $currentQuestionIndex;

            // Use the larger of provided total_questions or count of answers
            $actualTotal = max($totalQuestions, count($answers));
            $progress->total_questions = $actualTotal > 0 ? $actualTotal : $progress->total_questions;

            // Check if all questions are answered
            $allAnswered = true;
            $answeredCount = 0;
            foreach ($answers as $questionId => $optionId) {
                if ($optionId && $optionId !== '') {
                    $answeredCount++;
                } else {
                    $allAnswered = false;
                }
            }

            // Only mark as completed if ALL questions are answered
            if ($allAnswered && $currentQuestionIndex >= $progress->total_questions && $progress->total_questions > 0) {
                $progress->is_completed = true;
                $progress->completed_at = now();
            }

            $progress->save();

            // Store answers in session temporarily (filter out empty values)
            $filteredAnswers = array_filter($answers, function($value) {
                return $value !== null && $value !== '';
            });
            session()->put("quiz_answers_{$course->id}_{$kategori->id}", $filteredAnswers);

            return response()->json([
                'success' => true,
                'progress' => [
                    'current_question_index' => $progress->current_question_index,
                    'total_questions' => $progress->total_questions,
                    'is_completed' => $progress->is_completed,
                ],
                'is_completed' => $progress->is_completed,
                'answered_count' => $answeredCount,
                'total_questions' => $progress->total_questions,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Save progress - Model not found: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Course atau kategori tidak ditemukan.'
            ], 404);
        } catch (\Exception $e) {
            \Log::error('Save progress error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'error' => 'Gagal menyimpan progress.'
            ], 500);
        }
    }

    /**
     * Clear saved progress for a kategori.
     * Called when page loads to ensure users start fresh.
     */
    public function clearProgress(Request $request, $courseSlug, $kategoriSlug)
    {
        try {
            $course = Course::where('slug', $courseSlug)->firstOrFail();
            $kategori = KategoriMetaProgram::where('slug', $kategoriSlug)->firstOrFail();

            // Clear session storage
            session()->forget("quiz_answers_{$course->id}_{$kategori->id}");

            return response()->json([
                'success' => true,
                'message' => 'Progress cleared successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => 'Failed to clear progress.'
            ], 500);
        }
    }

    /**
     * Store quiz answers and calculate results for a kategori.
     */
    public function submitKategoriQuiz(Request $request, $courseSlug, $kategoriSlug)
    {
        try {
            // Validate answers array exists
            if (!$request->has('answers') || !is_array($request->answers)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Format jawaban tidak valid.'
                ], 400);
            }

            // Validate all answers are provided (no empty values)
            foreach ($request->answers as $questionId => $answerValue) {
                if (empty($answerValue) && $answerValue !== '0' && $answerValue !== 0) {
                    return response()->json([
                        'success' => false,
                        'error' => "Semua pertanyaan harus dijawab. Pertanyaan #{$questionId} belum dijawab."
                    ], 400);
                }
            }

            // Convert all answer values to integers (from skala columns)
            $answers = [];
            foreach ($request->answers as $questionId => $answerValue) {
                $answers[$questionId] = (int) $answerValue;
            }

            // Note: No need to validate option IDs since we're using skala values (1-6) from PertanyaanMetaProgram

            $course = Course::where('slug', $courseSlug)->firstOrFail();
            $kategori = KategoriMetaProgram::where('slug', $kategoriSlug)->firstOrFail();

            // Check if user can access this course
            if (!Auth::user()->canAccessCourse($course)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Anda perlu membeli course ini untuk mengaksesnya.',
                    'redirect_url' => route('courses.purchase', $course->slug)
                ], 403);
            }

            // Calculate total score using skala values (1-6) directly from answers
            $totalScore = 0;
            $scores = [];

            // Get all PertanyaanMetaProgram with their is_negatif status
            $questionIds = array_keys($answers);
            $pertanyaan = \App\Models\PertanyaanMetaProgram::whereIn('id', $questionIds)
                ->get()
                ->keyBy('id');

            foreach ($answers as $questionId => $answerValue) {
                // The answer value is the skala value (1-6) directly
                $score = (int) $answerValue;

                // Apply reverse scoring if question is marked as negative
                // For 6-point scale: 1→6, 2→5, 3→4, 4→3, 5→2, 6→1
                $pertanyaanItem = $pertanyaan->get($questionId);
                if ($pertanyaanItem && $pertanyaanItem->is_negatif) {
                    $score = 7 - $score;  // Reverse the score
                }

                $totalScore += $score;
                $scores[$questionId] = $score;
            }

            // Calculate average score
            $averageScore = count($scores) > 0 ? array_sum($scores) / count($scores) : 0;

            // Update progress to completed
            $progress = UserKategoriProgress::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'course_id' => $course->id,
                    'kategori_meta_program_id' => $kategori->id,
                ],
                [
                    'current_question_index' => count($scores),
                    'total_questions' => count($scores),
                    'is_completed' => true,
                    'completed_at' => now(),
                ]
            );

            // Store quiz attempt for this kategori (temporary storage)
            session()->put("kategori_quiz_{$course->id}_{$kategori->id}", [
                'answers' => $answers,
                'scores' => [
                    'average' => $averageScore,
                    'individual' => $scores,
                ],
                'total_score' => $totalScore,
                'completed_at' => now(),
            ]);

            // Clear saved answers session
            session()->forget("quiz_answers_{$course->id}_{$kategori->id}");

            // Check if all kategoris are completed
            $allKategorisCompleted = UserKategoriProgress::where('user_id', Auth::id())
                ->where('course_id', $course->id)
                ->where('is_completed', true)
                ->count();

            $totalKategoris = KategoriMetaProgram::count();

            // Get next incomplete kategori info
            $nextKategori = null;
            $remainingCount = $totalKategoris - $allKategorisCompleted;

            if ($allKategorisCompleted < $totalKategoris) {
                try {
                    $nextKategori = KategoriMetaProgram::whereDoesntHave('kategoriProgresses', function($query) use ($course) {
                        $query->where('user_id', Auth::id())
                              ->where('course_id', $course->id)
                              ->where('is_completed', true);
                    })->orderBy('id')->first();
                } catch (\Exception $e) {
                    \Log::warning('Could not get next kategori: ' . $e->getMessage());
                }
            }

            if ($allKategorisCompleted >= $totalKategoris) {
                // All kategoris completed, create final quiz attempt
                return $this->createFinalQuizAttempt($course, $request);
            }

            return response()->json([
                'success' => true,
                'message' => "Selamat! Kategori '{$kategori->name}' berhasil diselesaikan!",
                'is_all_completed' => false,
                'next_kategori_url' => route('courses.show', [$course->slug]),
                'next_kategori_name' => $nextKategori ? $nextKategori->name : null,
                'remaining_count' => $remainingCount,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Quiz submission - Model not found: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Course atau kategori tidak ditemukan.'
            ], 404);
        } catch (\Exception $e) {
            \Log::error('Quiz submission error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan saat menyimpan jawaban. Silakan coba lagi.'
            ], 500);
        }
    }

    /**
     * Create final quiz attempt after all kategoris are completed.
     */
    private function createFinalQuizAttempt($course, $request)
    {
        // Get all kategori quiz data from session
        $kategoriQuizData = [];
        $allAnswers = [];
        $allScores = [];

        $kategoriMetaPrograms = KategoriMetaProgram::orderBy('order')->get();

        foreach ($kategoriMetaPrograms as $kategori) {
            $quizData = session()->get("kategori_quiz_{$course->id}_{$kategori->id}");
            if ($quizData) {
                $kategoriQuizData[$kategori->id] = $quizData;
                // Use + operator instead of array_merge to preserve integer keys (question IDs)
                $allAnswers = $allAnswers + $quizData['answers'];
                $allScores = $allScores + ($quizData['scores']['individual'] ?? []);
            }
        }

        // Calculate final average score
        $finalAverageScore = count($allScores) > 0 ? array_sum($allScores) / count($allScores) : 0;
        $finalTotalScore = array_sum(array_values($allScores));

        // Create the final quiz attempt
        $quizAttempt = QuizAttempt::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'category_id' => null,
            'answers' => $allAnswers,
            'scores' => json_encode(['average' => $finalAverageScore, 'individual' => $allScores, 'kategori_breakdown' => $kategoriQuizData]),
            'dominant_type' => null, // Will be calculated based on all answers
            'total_score' => $finalTotalScore,
        ]);

        // Note: QuizResult records are no longer created since QuizAttempt already stores
        // all answers and scores in JSON format. The QuizResult model referenced the
        // wrong table (questions instead of pertanyaan_meta_program).

        // Clear session data
        foreach ($kategoriMetaPrograms as $kategori) {
            session()->forget("kategori_quiz_{$course->id}_{$kategori->id}");
            session()->forget("quiz_answers_{$course->id}_{$kategori->id}");
        }

        return response()->json([
            'success' => true,
            'quiz_attempt_id' => $quizAttempt->id,
            'redirect_url' => route('results.index'),
            'message' => 'Selamat! Anda telah menyelesaikan semua Meta Programs.',
            'is_all_completed' => true,
        ]);
    }

    /**
     * Store quiz answers and calculate results (legacy method for backward compatibility).
     */
    public function submitQuiz(Request $request, $courseSlug)
    {
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|integer|exists:question_options,id',
        ]);

        $course = Course::where('slug', $courseSlug)->firstOrFail();

        // Check if user can access this course
        if (!Auth::user()->canAccessCourse($course)) {
            return response()->json([
                'success' => false,
                'error' => 'Anda perlu membeli course ini untuk mengaksesnya.',
                'redirect_url' => route('courses.purchase', $course->slug)
            ], 403);
        }

        // Calculate total score (sum of all Likert scale answers)
        $totalScore = 0;
        $scores = [];

        foreach ($request->answers as $questionId => $optionId) {
            $option = QuestionOption::find($optionId);
            if ($option) {
                $totalScore += $option->order; // order field contains Likert score (1-6)
                $scores[$questionId] = $option->order;
            }
        }

        // Calculate average score
        $averageScore = count($scores) > 0 ? array_sum($scores) / count($scores) : 0;

        // For Meta Programs assessment - store individual quiz results
        $quizAttempt = QuizAttempt::create([
            'user_id' => Auth::id(),
            'course_id' => $course->id,
            'category_id' => $course->category_id ?? null,
            'answers' => $request->answers,
            'scores' => json_encode(['average' => $averageScore, 'individual' => $scores]),
            'dominant_type' => null,
            'total_score' => $totalScore,
            'completed_at' => now(),
        ]);

        // Note: QuizResult records are no longer created since QuizAttempt already stores
        // all answers and scores in JSON format.

        return response()->json([
            'success' => true,
            'quiz_attempt_id' => $quizAttempt->id,
            'redirect_url' => route('results.index'),
            'message' => 'Quiz berhasil disubmit!',
        ]);
    }

    /**
     * Show quiz results.
     */
    public function showResult($quizAttemptId)
    {
        $quizAttempt = QuizAttempt::where('id', $quizAttemptId)
            ->where('user_id', Auth::id())
            ->with(['course'])
            ->firstOrFail();

        $course = $quizAttempt->course;
        $course->load('kategoriMetaProgram'); // Load kategori meta program relationship

        // Check if this is a full assessment course (no kategori) or single kategori course (has kategori_meta_program_id)
        // Single kategori courses have kategori_meta_program_id set, full assessment courses don't
        $isFullAssessment = !$course->isSingleKategori();

        if ($isFullAssessment) {
            // Full Assessment Course - redirect to results.index which shows radar chart (Jaring Laba-Laba) and bar charts
            // Pass the specific attempt ID so we show the correct attempt, not just the latest
            return redirect()->route('results.index', ['attemptId' => $quizAttemptId]);
        }

        // Single-kategori course - show detailed single kategori results (only for this kategori, NOT radar chart)

        // Parse scores
        $scoresData = json_decode($quizAttempt->scores, true);
        $averageScore = $scoresData['average'] ?? 0;
        $individualScores = $scoresData['individual'] ?? [];

        // Debug: Log individual scores
        \Log::info('=== SHOW RESULT DEBUG (SINGLE KATEGORI) ===');
        \Log::info('Quiz Attempt ID: ' . $quizAttempt->id);
        \Log::info('Course ID: ' . $course->id);
        \Log::info('Individual Scores:', $individualScores);
        \Log::info('Individual Scores count: ' . count($individualScores));

        // Get kategori name for single-kategori courses
        $kategoriName = $scoresData['kategori_name'] ?? '';

        // Get the dominant type from the attempt
        $dominantType = $quizAttempt->dominant_type;

        // Calculate Sub-MP breakdown for this kategori - grouped by Meta Program with pairs
        $kategori = $course->kategoriMetaProgram;
        $metaProgramPairs = []; // For stacked bar chart

        if ($kategori) {
            // Get all meta programs in this kategori
            $metaPrograms = \App\Models\MetaProgram::where('kategori_meta_program_id', $kategori->id)
                ->where('is_active', true)
                ->with('subMetaPrograms')
                ->orderBy('id')
                ->get();

            \Log::info('Kategori: ' . $kategori->name);
            \Log::info('Meta Programs count: ' . $metaPrograms->count());

            $subMpScores = [];

            // First, collect all scores by Sub-MP
            foreach ($metaPrograms as $mp) {
                // Get pertanyaan for this meta program
                $pertanyaanList = \App\Models\PertanyaanMetaProgram::where('meta_program_id', $mp->id)
                    ->where('is_active', true)
                    ->get();

                \Log::info('Meta Program: ' . $mp->name . ' (ID: ' . $mp->id . ')');
                \Log::info('Pertanyaan count: ' . $pertanyaanList->count());

                foreach ($pertanyaanList as $pertanyaan) {
                    // Find the answer from individual scores (check both string and integer keys)
                    $questionId = $pertanyaan->id;
                    $answer = null;

                    // Check if key exists (handles both string and integer keys)
                    if (isset($individualScores[$questionId])) {
                        $answer = $individualScores[$questionId];
                    } elseif (isset($individualScores[(string)$questionId])) {
                        $answer = $individualScores[(string)$questionId];
                    }

                    \Log::info('Pertanyaan ID: ' . $questionId . ', Answer: ' . ($answer ?? 'NOT FOUND'));

                    if ($answer !== null) {
                        // Get sub meta program
                        $subMp = $pertanyaan->subMetaProgram;
                        if ($subMp) {
                            if (!isset($subMpScores[$subMp->id])) {
                                $subMpScores[$subMp->id] = [
                                    'name' => $subMp->name,
                                    'slug' => $subMp->slug,
                                    'total_score' => 0,
                                    'count' => 0,
                                    'meta_program_id' => $mp->id,
                                    'meta_program_name' => $mp->name,
                                ];
                            }
                            $subMpScores[$subMp->id]['total_score'] += (int)$answer;
                            $subMpScores[$subMp->id]['count']++;
                            \Log::info('  -> Sub-MP: ' . $subMp->name . ', Score: ' . (int)$answer);
                        }
                    }
                }
            }

            // Group by Meta Program and create pairs
            foreach ($metaPrograms as $mp) {
                // Get Sub-MPs for this Meta Program
                $mpSubMps = $mp->subMetaPrograms->sortBy('order');
                $mpSubMpScores = [];

                foreach ($mpSubMps as $subMp) {
                    if (isset($subMpScores[$subMp->id])) {
                        $data = $subMpScores[$subMp->id];
                        $average = $data['count'] > 0 ? $data['total_score'] / $data['count'] : 3;
                        // Percentage based on answered count (not score)
                        $totalQuestions = $mp->pertanyaan->where('sub_meta_program_id', $subMp->id)->count();
                        $percentage = $totalQuestions > 0 ? ($data['count'] / $totalQuestions) * 100 : 0;

                        // Calculate score percentage (score out of max)
                        $maxScore = $totalQuestions * 6; // Each question max 6 points
                        $scorePercentage = $maxScore > 0 ? ($data['total_score'] / $maxScore) * 100 : 0;

                        $mpSubMpScores[] = [
                            'id' => $subMp->id,
                            'name' => $data['name'],
                            'slug' => $data['slug'],
                            'average' => round($average, 0),
                            'total_score' => round($data['total_score'], 1),
                            'max_score' => $maxScore,
                            'percentage' => round($percentage, 0),
                            'score_percentage' => round($scorePercentage, 0),
                        ];
                    }
                }

                // Create pairs - same logic as full assessment (sequential pairing)
                usort($mpSubMpScores, function($a, $b) {
                    return $a['id'] - $b['id'];
                });

                // Create pairs - pair Sub-MPs sequentially (0-1, 2-3, 4-5, etc.)
                $pairs = [];
                $count = count($mpSubMpScores);

                for ($i = 0; $i < $count; $i += 2) {
                    if (isset($mpSubMpScores[$i])) {
                        $side1 = $mpSubMpScores[$i];
                        $side2 = isset($mpSubMpScores[$i + 1]) ? $mpSubMpScores[$i + 1] : null;

                        $pairs[] = [
                            'side1' => $side1,
                            'side2' => $side2,
                        ];
                    }
                }

                if (!empty($pairs)) {
                    $metaProgramPairs[] = [
                        'meta_program_name' => $mp->name,
                        'meta_program_slug' => $mp->slug,
                        'pairs' => $pairs,
                    ];
                }
            }
        }

        // Also keep subMpResults for individual display
        $subMpResults = [];
        foreach ($metaProgramPairs as $mpp) {
            foreach ($mpp['pairs'] as $pair) {
                if ($pair['side1']) $subMpResults[] = $pair['side1'];
                if ($pair['side2']) $subMpResults[] = $pair['side2'];
            }
        }

        // Find highest scoring sub-MP
        $highestSubMp = null;
        $highestScore = -1;
        $subMpScoresList = [];

        foreach ($metaProgramPairs as $mp) {
            foreach ($mp['pairs'] as $pair) {
                if (isset($pair['side1'])) {
                    $score = $pair['side1']['total_score'] ?? 0;
                    $subMpScoresList[] = [
                        'name' => $pair['side1']['name'],
                        'score' => $score,
                    ];
                    if ($score > $highestScore) {
                        $highestScore = $score;
                    }
                }
                if (isset($pair['side2'])) {
                    $score = $pair['side2']['total_score'] ?? 0;
                    $subMpScoresList[] = [
                        'name' => $pair['side2']['name'],
                        'score' => $score,
                    ];
                    if ($score > $highestScore) {
                        $highestScore = $score;
                    }
                }
            }
        }

        // Find all sub-MPs with the highest score (for ties)
        $highestSubMps = [];
        foreach ($subMpScoresList as $subMp) {
            if ($subMp['score'] == $highestScore && $highestScore > 0) {
                $highestSubMps[] = $subMp['name'];
            }
        }

        // For single-kategori courses, we show the kategori name, score, and Sub-MP breakdown
        return view('courses.result-single', array_merge(
            compact(
                'quizAttempt',
                'course',
                'averageScore',
                'individualScores',
                'kategoriName',
                'dominantType',
                'subMpResults',
                'metaProgramPairs'
            ),
            ['highestSubMpDisplay' => $highestSubMps]
        ));
    }

    /**
     * Show user dashboard with quiz history.
     */
    public function dashboard()
    {
        $quizAttempts = QuizAttempt::where('user_id', Auth::id())
            ->with(['course'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact('quizAttempts'));
    }

    /**
     * Show user history with quiz attempts.
     * Filter: Single kategori courses show only their kategori attempts,
     * Full assessment courses show all attempts.
     */
    public function userHistory()
    {
        // Get all quiz attempts with courses and their kategori meta program
        $allAttempts = QuizAttempt::where('user_id', Auth::id())
            ->with(['course', 'course.kategoriMetaProgram'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Separate attempts by course type
        $singleKategoriAttempts = collect();
        $fullAssessmentAttempts = collect();

        foreach ($allAttempts as $attempt) {
            if ($attempt->course && $attempt->course->isSingleKategori()) {
                $singleKategoriAttempts->push($attempt);
            } else {
                $fullAssessmentAttempts->push($attempt);
            }
        }

        return view('user.history', compact(
            'singleKategoriAttempts',
            'fullAssessmentAttempts'
        ));
    }

    /**
     * Reset user progress for a specific course.
     */
    public function resetCourseProgress(Request $request, $courseSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();

        // Verify user owns this course
        if (!Auth::user()->canAccessCourse($course)) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke course ini.');
        }

        $userId = Auth::id();

        // Delete quiz attempts and results for this course
        $quizAttempts = QuizAttempt::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->get();

        foreach ($quizAttempts as $attempt) {
            // Delete related quiz results
            QuizResult::where('quiz_attempt_id', $attempt->id)->delete();
            // Delete the attempt
            $attempt->delete();
        }

        // Reset user kategori progress for this course
        UserKategoriProgress::where('user_id', $userId)
            ->where('course_id', $course->id)
            ->delete();

        // Clear session flag
        session()->forget('must_complete_course_' . $course->id);

        return redirect()->route('courses.show', $course->slug)
            ->with('success', 'Progress course berhasil direset. Anda dapat memulai dari awal.');
    }

    /**
     * Display the purchase page for a specific category.
     */
    public function categoryPurchase($courseSlug, $categorySlug)
    {
        $course = Course::where('slug', $courseSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $category = Category::where('slug', $categorySlug)
            ->where('course_id', $course->id)
            ->firstOrFail();

        if (!$category->price || $category->price <= 0) {
            return redirect()->route('courses.show', $course->slug);
        }

        $bankAccounts = \App\Models\BankAccount::where('is_active', true)->get();

        return view('courses.category-purchase', compact('course', 'category', 'bankAccounts'));
    }

    /**
     * Start a specific category assessment.
     */
    public function categoryStart($courseSlug, $categorySlug)
    {
        $course = Course::where('slug', $courseSlug)
            ->where('is_active', true)
            ->firstOrFail();

        $category = Category::where('slug', $categorySlug)
            ->where('course_id', $course->id)
            ->firstOrFail();

        // Check if user has purchased this category (if it has a price)
        if ($category->price > 0) {
            $hasPurchased = auth()->user()->purchases()
                ->where('course_id', $course->id)
                ->where('category_id', $category->id)
                ->where('status', 'confirmed')
                ->exists();

            if (!$hasPurchased) {
                return redirect()->route('courses.category-purchase', [$course->slug, $category->slug])
                    ->with('error', 'Anda perlu membeli kategori ini untuk mengaksesnya.');
            }
        }

        // Get questions for this category
        $questions = Question::where('category_id', $category->id)
            ->where('is_active', true)
            ->with(['options' => function ($query) {
                $query->orderBy('id');
            }])
            ->orderBy('id')
            ->get();

        // Check if user has already completed this category
        $existingAttempt = QuizAttempt::where('user_id', auth()->id())
            ->where('course_id', $course->id)
            ->where('category_id', $category->id)
            ->first();

        return view('courses.category-quiz', compact('course', 'category', 'questions', 'existingAttempt'));
    }

    /**
     * Submit category quiz and create result.
     */
    public function submitCategoryQuiz(Request $request, $courseSlug, $categorySlug)
    {
        try {
            // Validate answers
            $request->validate([
                'answers' => 'required|array',
                'answers.*' => 'required|integer|exists:question_options,id',
            ]);

            $course = Course::where('slug', $courseSlug)->firstOrFail();
            $category = Category::where('slug', $categorySlug)
                ->where('course_id', $course->id)
                ->firstOrFail();

            // Verify user has purchased this category (if it has a price)
            if ($category->price > 0) {
                $hasPurchased = auth()->user()->purchases()
                    ->where('course_id', $course->id)
                    ->where('category_id', $category->id)
                    ->where('status', 'confirmed')
                    ->exists();

                if (!$hasPurchased) {
                    return redirect()->route('courses.category-purchase', [$course->slug, $category->slug])
                        ->with('error', 'Anda perlu membeli kategori ini untuk mengaksesnya.');
                }
            }

            $answers = $request->answers;

            // Calculate talent type counts
            $talentCounts = [
                'RES' => 0,  // Resourceful
                'ANA' => 0,  // Analytical
                'EXP' => 0,  // Experiential
                'CON' => 0,  // Conservative
            ];

            foreach ($answers as $questionId => $optionId) {
                $option = QuestionOption::find($optionId);
                if ($option && $option->talent_type) {
                    $talentCounts[$option->talent_type]++;
                }
            }

            // Find dominant type
            arsort($talentCounts);
            $dominantType = array_key_first($talentCounts);

            // Create quiz attempt
            $quizAttempt = QuizAttempt::create([
                'user_id' => auth()->id(),
                'course_id' => $course->id,
                'category_id' => $category->id,
                'answers' => $answers,
                'scores' => json_encode([
                    'talent_counts' => $talentCounts,
                    'dominant_type' => $dominantType,
                ]),
                'dominant_type' => $dominantType,
                'total_score' => array_sum($talentCounts),
            ]);

            // Note: QuizResult records are no longer created since QuizAttempt already stores
            // all answers and scores in JSON format.

            return redirect()->route('results.index')
                ->with('success', "Selamat! Anda telah menyelesaikan {$category->name}.");
        } catch (\Exception $e) {
            \Log::error('Submit category quiz error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat menyimpan jawaban. Silakan coba lagi.');
        }
    }

    /**
     * Show single kategori course (assessment per kategori).
     */
    protected function showSingleKategoriCourse($course)
    {
        // Check if user can access this course
        if (!Auth::user()->canAccessCourse($course)) {
            return redirect()->route('courses.purchase', $course->slug)
                ->with('error', 'Anda perlu membeli course ini untuk mengaksesnya.');
        }

        // Get the single kategori for this course
        $kategori = $course->kategoriMetaProgram;

        if (!$kategori) {
            return redirect()->route('courses.index')
                ->with('error', 'Kategori meta program tidak ditemukan.');
        }

        // Get all pertanyaan meta programs for this kategori
        // Get all meta programs that belong to this kategori
        $metaProgramIds = \App\Models\MetaProgram::where('kategori_meta_program_id', $kategori->id)
            ->where('is_active', true)
            ->pluck('id');

        // Get all pertanyaan for these meta programs
        $questions = \App\Models\PertanyaanMetaProgram::whereIn('meta_program_id', $metaProgramIds)
            ->where('is_active', true)
            ->with('metaProgram')
            ->orderBy('id')
            ->get();

        // Check if user has already completed this course
        $existingAttempt = QuizAttempt::where('user_id', Auth::id())
            ->where('course_id', $course->id)
            ->first();

        // Get saved answers from session
        $sessionKey = "quiz_answers_single_{$course->id}";
        $savedAnswers = session($sessionKey, []);

        // Debug: Log saved answers
        \Log::info("Single Kategori - Saved answers for course {$course->id}: " . json_encode($savedAnswers));

        return view('courses.show-single-kategori', compact(
            'course',
            'kategori',
            'questions',
            'savedAnswers',
            'existingAttempt'
        ));
    }

    /**
     * Save current question progress for single kategori.
     */
    public function saveProgressSingleKategori(Request $request, $courseSlug)
    {
        try {
            // Log all request data for debugging
            \Log::info('=== SAVE PROGRESS REQUEST ===');
            \Log::info('All input:', $request->all());
            \Log::info('Answers (raw):', $request->input('answers', []));

            // Validate required fields
            $answers = $request->input('answers', []);
            $currentQuestionIndex = (int) $request->input('current_question_index', 0);
            $totalQuestions = (int) $request->input('total_questions', 0);

            \Log::info('Answers type:', gettype($answers));
            \Log::info('Answers count:', is_array($answers) ? count($answers) : 'not array');

            if (!is_array($answers)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Format answers tidak valid.'
                ], 400);
            }

            $course = Course::where('slug', $courseSlug)->firstOrFail();
            $userId = Auth::id();

            \Log::info('Course ID:', $course->id);
            \Log::info('User ID:', $userId);

            // Check if this is a single kategori course
            if (!$course->isSingleKategori()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Course ini bukan single kategori course.'
                ], 400);
            }

            // Store answers in session (filter out null values only, keep empty strings)
            $filteredAnswers = array_filter($answers, function($value) {
                return $value !== null;
            });

            \Log::info('Filtered answers:', $filteredAnswers);
            \Log::info('Filtered count:', count($filteredAnswers));

            $sessionKey = "quiz_answers_single_{$course->id}";
            \Log::info('Session key:', $sessionKey);

            session()->put($sessionKey, $filteredAnswers);

            // Verify it was saved
            $saved = session($sessionKey, []);
            \Log::info('Verified saved answers:', $saved);
            \Log::info('Verified saved count:', count($saved));

            return response()->json([
                'success' => true,
                'answered_count' => count($filteredAnswers),
                'total_questions' => $totalQuestions,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            \Log::error('Save progress single kategori - Model not found: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Course tidak ditemukan.'
            ], 404);
        } catch (\Exception $e) {
            \Log::error('Save progress single kategori error: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'error' => 'Gagal menyimpan progress.'
            ], 500);
        }
    }

    /**
     * Submit single kategori quiz and create result.
     */
    public function submitSingleKategoriQuiz(Request $request, $courseSlug)
    {
        try {
            // Validate answers - accept string or integer values
            $request->validate([
                'answers' => 'required|array',
                'answers.*' => 'required|string',  // Accept string values from skala columns
            ]);

            $course = Course::where('slug', $courseSlug)->firstOrFail();

            // Verify this is a single kategori course
            if (!$course->isSingleKategori()) {
                return response()->json([
                    'success' => false,
                    'error' => 'Course ini bukan single kategori course.'
                ], 400);
            }

            // Check if user can access this course
            if (!Auth::user()->canAccessCourse($course)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Anda perlu membeli course ini untuk mengaksesnya.',
                    'redirect_url' => route('courses.purchase', $course->slug)
                ], 403);
            }

            $answers = $request->answers;
            $totalQuestions = count($answers);

            // Calculate average score - convert string values to integers
            $totalScore = 0;
            foreach ($answers as $answerValue) {
                $totalScore += (int)$answerValue;
            }
            $averageScore = $totalQuestions > 0 ? $totalScore / $totalQuestions : 0;

            // Get the kategori meta program
            $kategori = $course->kategoriMetaProgram;

            // Create quiz attempt
            $quizAttempt = QuizAttempt::create([
                'user_id' => auth()->id(),
                'course_id' => $course->id,
                'category_id' => null,
                'answers' => $answers,
                'scores' => json_encode([
                    'average' => $averageScore,
                    'individual' => $answers,
                    'kategori_name' => $kategori->name ?? '',
                ]),
                'dominant_type' => $kategori->name ?? '',
                'total_score' => $totalScore,
            ]);

            // Note: QuizResult records are no longer created since QuizAttempt already stores
            // all answers and scores in JSON format.

            // Clear session data
            session()->forget("quiz_answers_single_{$course->id}");

            return response()->json([
                'success' => true,
                'quiz_attempt_id' => $quizAttempt->id,
                'redirect_url' => route('user.history'),
                'message' => "Selamat! Anda telah menyelesaikan {$kategori->name}.",
            ]);
        } catch (\Exception $e) {
            \Log::error('Submit single kategori quiz error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan saat menyimpan jawaban. Silakan coba lagi.',
            ], 500);
        }
    }
}

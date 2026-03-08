<?php

namespace App\Http\Controllers;

use App\Models\QuizAttempt;
use App\Models\QuizResult;
use App\Models\Category;
use App\Models\Course;
use App\Models\Question;
use App\Models\Purchase;
use App\Models\User;
use App\Services\GeminiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use setasign\Fpdi\Fpdi;
use Smalot\PdfParser\Parser as PdfParser;

class ResultController extends Controller
{
    // Middleware will be handled by route definitions

    public function index(Request $request)
    {
        // Get specific quiz attempt if attemptId is provided in query string, otherwise get latest
        $attemptId = $request->query('attemptId');
        if ($attemptId) {
            $latestAttempt = QuizAttempt::with(['course', 'category'])
                ->where('id', $attemptId)
                ->where('user_id', Auth::id())
                ->firstOrFail();
        } else {
            $latestAttempt = QuizAttempt::with(['course', 'category'])
                ->where('user_id', Auth::id())
                ->latest()
                ->first();
        }

        if (!$latestAttempt) {
            return redirect()->route('courses.index')->with('error', 'You need to complete the assessment first.');
        }

        // Check if user has access to this course (free or confirmed purchase)
        $hasAccess = Auth::user()->canAccessCourse($latestAttempt->course);
        if (!$hasAccess) {
            return redirect()->route('courses.purchase', $latestAttempt->course->slug)
                ->with('error', 'Please purchase the course to access the results.');
        }

        $course = $latestAttempt->course;

        // Determine if this is a full assessment course (no category) or single MP course (has category)
        $isFullAssessment = !$course->category || !$course->category->slug;

        if ($isFullAssessment) {
            // Full Assessment Course (Basic/Premium/Coaching) - calculate all 51 MP scores
            // First, check if we have QuizResult records (old system) or JSON scores (new system)
            $hasQuizResults = $latestAttempt->quizResults()->exists();

            if ($hasQuizResults) {
                // Use QuizResult records (old system)
                $questions = $course->questions()->where('is_active', true)->get();
                $questionsPerMp = 5;
                $mpScores = [];
                $mpAverages = [];

                // Get all Meta Programs for names
                $allMetaPrograms = \App\Models\MetaProgram::orderBy('id')->get()->keyBy('id');

                foreach ($questions as $index => $question) {
                    $mpIndex = intdiv($index, $questionsPerMp);

                    if (!isset($mpScores[$mpId])) {
                        $mpScores[$mpId] = [
                            'mp_number' => $mpIndex + 1,
                            'total_score' => 0,
                            'count' => 0,
                        ];
                    }

                    $quizResult = $latestAttempt->quizResults()
                        ->where('question_id', $question->id)
                        ->first();

                    if ($quizResult) {
                        $mpScores[$mpId]['total_score'] += $quizResult->answer;
                        $mpScores[$mpId]['count']++;
                    }
                }

                foreach ($mpScores as $mpIndex => $mpData) {
                    $average = $mpData['count'] > 0 ? round($mpData['total_score'] / $mpData['count'], 0) : 3;
                    $maxScore = $mpData['count'] * 6; // Each question max 6 points
                    $scorePercentage = $maxScore > 0 ? ($mpData['total_score'] / $maxScore) * 100 : 0;

                    // Get MP name from database
                    $mpId = $mpIndex + 1;
                    $mpName = $allMetaPrograms->has($mpId) ? $allMetaPrograms->get($mpId)->name : 'MP ' . $mpId;

                    $mpAverages[$mpIndex + 1] = [
                        'name' => $mpName,
                        'average' => $average,
                        'total_score' => $mpData['total_score'],
                        'max_score' => $maxScore,
                        'percentage' => round($scorePercentage, 0)
                    ];
                }
            } else {
                // Use JSON scores (new system - PertanyaanMetaProgram based)
                $scoresData = json_decode($latestAttempt->scores, true);
                $individualScores = $scoresData['individual'] ?? [];

                // Calculate MP averages from individual scores
                $mpAverages = [];
                $mpScores = [];

                // Get all pertanyaan meta programs with their meta program and sub meta program names
                $allPertanyaan = \App\Models\PertanyaanMetaProgram::where('is_active', true)
                    ->with(['metaProgram', 'subMetaProgram'])
                    ->orderBy('id')
                    ->get();

                // Group by actual meta_program_id (not by index division)
                foreach ($allPertanyaan as $pertanyaan) {
                    $mpId = $pertanyaan->meta_program_id;

                    if (!isset($mpScores[$mpId])) {
                        $mpScores[$mpId] = [
                            'mp_id' => $mpId,
                            'mp_name' => $pertanyaan->metaProgram ? $pertanyaan->metaProgram->name : 'MP ' . $mpId,
                            'total_score' => 0,
                            'count' => 0,
                            'sub_mp_scores' => [], // Store sub-MP scores for this MP
                        ];
                    }

                    // Get answer from individual scores (check both string and integer keys)
                    $questionId = $pertanyaan->id;
                    $answer = null;

                    if (isset($individualScores[$questionId])) {
                        $answer = $individualScores[$questionId];
                    } elseif (isset($individualScores[(string)$questionId])) {
                        $answer = $individualScores[(string)$questionId];
                    }

                    if ($answer !== null) {
                        $mpScores[$mpId]['total_score'] += (int)$answer;
                        $mpScores[$mpId]['count']++;

                        // Track sub-MP scores
                        $subMpId = $pertanyaan->sub_meta_program_id;
                        $subMpName = $pertanyaan->subMetaProgram ? $pertanyaan->subMetaProgram->name : 'Unknown';

                        if (!isset($mpScores[$mpId]['sub_mp_scores'][$subMpId])) {
                            $mpScores[$mpId]['sub_mp_scores'][$subMpId] = [
                                'name' => $subMpName,
                                'total_score' => 0,
                                'count' => 0
                            ];
                        }
                        $mpScores[$mpId]['sub_mp_scores'][$subMpId]['total_score'] += (int)$answer;
                        $mpScores[$mpId]['sub_mp_scores'][$subMpId]['count']++;
                    }
                }

                foreach ($mpScores as $mpId => $mpData) {
                    // Calculate MP using Sub-MP level data (same as report calculation)
                    // First calculate Sub-MP metrics, then aggregate
                    $subMpAverages = [];
                    $subMpTotalScores = [];
                    $subMpPercentages = [];

                    if (isset($mpData['sub_mp_scores']) && !empty($mpData['sub_mp_scores'])) {
                        foreach ($mpData['sub_mp_scores'] as $subMpId => $subMpData) {
                            // Sub-MP average (rounded, same as report line 283)
                            $subMpAverage = $subMpData['count'] > 0 ? round($subMpData['total_score'] / $subMpData['count'], 0) : 3;
                            $subMpAverages[] = $subMpAverage;

                            // Sub-MP total score
                            $subMpTotalScores[] = $subMpData['total_score'];

                            // Sub-MP percentage (same as report line 277: score_percentage)
                            $maxScore = $subMpData['count'] * 6;
                            $scorePercentage = $maxScore > 0 ? ($subMpData['total_score'] / $maxScore) * 100 : 0;
                            $subMpPercentages[] = $scorePercentage;
                        }
                    }

                    // MP average = average of Sub-MP averages
                    $average = !empty($subMpAverages) ? round(array_sum($subMpAverages) / count($subMpAverages), 0) : 3;

                    // Total score from Sub-MP level
                    $totalScore = array_sum($subMpTotalScores);

                    // Percentage = average of Sub-MP percentages (matches report calculation)
                    $scorePercentage = !empty($subMpPercentages) ? array_sum($subMpPercentages) / count($subMpPercentages) : 0;

                    // Find dominant Sub-MP for this MP
                    $dominantSubMp = null;
                    $dominantSubMpScore = 0;
                    if (isset($mpData['sub_mp_scores']) && !empty($mpData['sub_mp_scores'])) {
                        foreach ($mpData['sub_mp_scores'] as $subMpId => $subMpData) {
                            $subMpAverage = $subMpData['count'] > 0 ? $subMpData['total_score'] / $subMpData['count'] : 0;
                            if ($subMpAverage > $dominantSubMpScore) {
                                $dominantSubMpScore = $subMpAverage;
                                $dominantSubMp = $subMpData['name'];
                            }
                        }
                    }

                    $mpAverages[$mpId] = [
                        'name' => $mpData['mp_name'] ?? 'MP ' . $mpId,
                        'dominant_sub_mp' => $dominantSubMp,
                        'average' => $average,
                        'total_score' => $totalScore,
                        'percentage' => round($scorePercentage, 0)
                    ];
                }
            }

            // Calculate overall average from the new structure
            $overallAverage = 0;
            $avgCount = 0;
            foreach ($mpAverages as $mpData) {
                if (is_array($mpData) && isset($mpData['average'])) {
                    $overallAverage += $mpData['average'];
                    $avgCount++;
                }
            }
            $overallAverage = $avgCount > 0 ? round($overallAverage / $avgCount, 2) : 0;

            // Get Sub-MP breakdown per kategori - with Meta Program pairs (same as single kategori)
            $kategoriMetaPrograms = \App\Models\KategoriMetaProgram::orderBy('order')->get();
            $kategoriBreakdown = [];

            foreach ($kategoriMetaPrograms as $kategori) {
                // Get all meta programs in this kategori
                $metaPrograms = \App\Models\MetaProgram::where('kategori_meta_program_id', $kategori->id)
                    ->where('is_active', true)
                    ->with('subMetaPrograms')
                    ->orderBy('id')
                    ->get();

                $subMpScores = [];

                // First, collect all scores by Sub-MP (using individualScores from JSON)
                foreach ($metaPrograms as $mp) {
                    // Get pertanyaan for this meta program
                    $pertanyaanList = \App\Models\PertanyaanMetaProgram::where('meta_program_id', $mp->id)
                        ->where('is_active', true)
                        ->get();

                    foreach ($pertanyaanList as $pertanyaan) {
                        // Find the answer from individual scores (check both string and integer keys)
                        $questionId = $pertanyaan->id;
                        $answer = null;

                        if (isset($individualScores[$questionId])) {
                            $answer = $individualScores[$questionId];
                        } elseif (isset($individualScores[(string)$questionId])) {
                            $answer = $individualScores[(string)$questionId];
                        }

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
                                        'meta_program_slug' => $mp->slug,
                                    ];
                                }
                                $subMpScores[$subMp->id]['total_score'] += (int)$answer;
                                $subMpScores[$subMp->id]['count']++;
                            }
                        }
                    }
                }

                // Group Sub-MP scores by their Meta Program
                $mpSubMpGroups = [];
                foreach ($subMpScores as $subMpId => $data) {
                    $mpId = $data['meta_program_id'];
                    $mpName = $data['meta_program_name'];
                    $mpSlug = $data['meta_program_slug'];

                    if (!isset($mpSubMpGroups[$mpId])) {
                        $mpSubMpGroups[$mpId] = [
                            'meta_program_name' => $mpName,
                            'meta_program_slug' => $mpSlug,
                            'sub_mp_scores' => [],
                        ];
                    }

                    $average = $data['count'] > 0 ? $data['total_score'] / $data['count'] : 3;

                    // Find the MP to get total questions count for this Sub-MP
                    $mp = $metaPrograms->firstWhere('id', $mpId);
                    $totalQuestions = $mp ? $mp->pertanyaan->where('sub_meta_program_id', $subMpId)->count() : 0;
                    $percentage = $totalQuestions > 0 ? ($data['count'] / $totalQuestions) * 100 : 0;
                    $maxScore = $totalQuestions * 6;
                    $scorePercentage = $maxScore > 0 ? ($data['total_score'] / $maxScore) * 100 : 0;

                    $mpSubMpGroups[$mpId]['sub_mp_scores'][] = [
                        'id' => $subMpId,
                        'name' => $data['name'],
                        'slug' => $data['slug'],
                        'average' => round($average, 0),
                        'total_score' => round($data['total_score'], 1),
                        'max_score' => $maxScore,
                        'percentage' => round($percentage, 0),
                        'score_percentage' => round($scorePercentage, 0),
                    ];
                }

                // Create pairs for each MP
                $metaProgramPairs = [];

                foreach ($mpSubMpGroups as $mpId => $mpGroup) {
                    $mpSubMpScores = $mpGroup['sub_mp_scores'];
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
                            'meta_program_name' => $mpGroup['meta_program_name'],
                            'meta_program_slug' => $mpGroup['meta_program_slug'],
                            'pairs' => $pairs,
                        ];
                        \Log::info('MP Pairs Added', [
                            'mp_name' => $mpGroup['meta_program_name'],
                            'pairs_count' => count($pairs),
                            'pairs' => $pairs
                        ]);
                    }
                }

                // Find highest scoring sub-MP in this kategori
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

                // Add period at the end if there are multiple highest sub-MPs
                $highestSubMpDisplay = null;
                if (!empty($highestSubMps)) {
                    $highestSubMpDisplay = implode(', ', $highestSubMps);
                    if (count($highestSubMps) > 1) {
                        $highestSubMpDisplay .= '.';
                    }
                }

                $kategoriBreakdown[] = [
                    'id' => $kategori->id,
                    'name' => $kategori->name,
                    'slug' => $kategori->slug,
                    'meta_program_pairs' => $metaProgramPairs,
                    'highest_sub_mp' => $highestSubMpDisplay,
                ];
            }

            // Find dominant Meta Programs based on kategori breakdown (using Sub-MP scores)
            // Collect all Sub-MP scores with their Meta Program names
            $allMpScores = [];
            foreach ($kategoriBreakdown as $kategori) {
                if (isset($kategori['meta_program_pairs'])) {
                    foreach ($kategori['meta_program_pairs'] as $mpPair) {
                        $mpName = $mpPair['meta_program_name'];
                        $mpSlug = $mpPair['meta_program_slug'];

                        if (!isset($allMpScores[$mpName])) {
                            $allMpScores[$mpName] = [
                                'name' => $mpName,
                                'slug' => $mpSlug,
                                'total_score' => 0,
                                'count' => 0
                            ];
                        }

                        // Calculate score from pairs
                        foreach ($mpPair['pairs'] as $pair) {
                            if (isset($pair['side1'])) {
                                $allMpScores[$mpName]['total_score'] += $pair['side1']['total_score'] ?? 0;
                                $allMpScores[$mpName]['count']++;
                            }
                            if (isset($pair['side2'])) {
                                $allMpScores[$mpName]['total_score'] += $pair['side2']['total_score'] ?? 0;
                                $allMpScores[$mpName]['count']++;
                            }
                        }
                    }
                }
            }

            // Calculate average score for each MP
            foreach ($allMpScores as $mpName => &$mpData) {
                $mpData['average'] = $mpData['count'] > 0 ? $mpData['total_score'] / $mpData['count'] : 0;
            }

            // Find dominant MPs (highest average score)
            $maxMpScore = 0;
            foreach ($allMpScores as $mpName => $mpData) {
                if ($mpData['average'] > $maxMpScore) {
                    $maxMpScore = $mpData['average'];
                }
            }

            // Get all MP names with the highest score
            $dominantMpNames = [];
            foreach ($allMpScores as $mpName => $mpData) {
                if ($mpData['average'] == $maxMpScore && $maxMpScore > 0) {
                    $dominantMpNames[] = $mpName;
                }
            }

            $dominantMpDisplay = !empty($dominantMpNames) ? implode(', ', $dominantMpNames) : null;

            // Create global MP numbering (same order as stacked bar charts outside radar)
            // This ensures consistency: all charts use the same MP 1, MP 2, etc.
            $mpNameToNumber = [];
            $mpNumber = 1;

            foreach ($kategoriBreakdown as $kategori) {
                if (isset($kategori['meta_program_pairs'])) {
                    foreach ($kategori['meta_program_pairs'] as $mpPair) {
                        $mpName = $mpPair['meta_program_name'];
                        if (!isset($mpNameToNumber[$mpName])) {
                            $mpNameToNumber[$mpName] = $mpNumber++;
                        }
                    }
                }
            }

            // Prepare MP level data for radar chart - showing dominant Sub-MP only
            // Order follows kategoriBreakdown, labels use global MP numbers
            $mpRadarData = [];

            foreach ($kategoriBreakdown as $kategori) {
                if (isset($kategori['meta_program_pairs'])) {
                    foreach ($kategori['meta_program_pairs'] as $mpPair) {
                        $mpName = $mpPair['meta_program_name'];
                        $mpNumber = $mpNameToNumber[$mpName];

                        // Find dominant Sub-MP for this MP (highest total_score)
                        $dominantSubMp = null;
                        $highestScore = -1;

                        foreach ($mpPair['pairs'] as $pair) {
                            if (isset($pair['side1']) && $pair['side1']['total_score'] > $highestScore) {
                                $highestScore = $pair['side1']['total_score'];
                                $dominantSubMp = $pair['side1'];
                            }
                            if (isset($pair['side2']) && $pair['side2']['total_score'] > $highestScore) {
                                $highestScore = $pair['side2']['total_score'];
                                $dominantSubMp = $pair['side2'];
                            }
                        }

                        if ($dominantSubMp) {
                            $mpRadarData[] = [
                                'label' => $mpName,  // Use original MP name (e.g., "MP 4 & 5 — Information Gathering Sort")
                                'mp_number' => $mpNumber,  // Sequential number for sorting
                                'sub_mp_name' => $dominantSubMp['name'],
                                'total_score' => $dominantSubMp['total_score'],
                                'percentage' => $dominantSubMp['score_percentage'],
                            ];
                        }
                    }
                }
            }

            return view('results.index-full', compact(
                'latestAttempt',
                'course',
                'mpScores',
                'mpAverages',
                'overallAverage',
                'kategoriBreakdown',
                'dominantMpDisplay',
                'mpRadarData'
            ));
        } else {
            // Single MP Course - show dominant side with bar chart
            $scoresData = json_decode($latestAttempt->scores, true);
            $individualScores = $scoresData['individual'] ?? [];
            $averageScore = $scoresData['average'] ?? 0;

            $allQuizResults = $latestAttempt->quizResults;
            $overallAverage = $allQuizResults->avg('answer');

            // Get MP config based on course category
            $mpConfig = null;
            $dominantSideName = null;
            $otherSideName = null;
            $allSides = [];
            $dominantPercentage = 0;
            $otherPercentage = 0;

            // Prepare kategoriBreakdown using same approach as full assessment
            $kategoriBreakdown = [];

            if ($course->category) {
                $kategori = $course->category;

                // Get all meta programs in this kategori (same as full assessment)
                $metaPrograms = \App\Models\MetaProgram::where('kategori_meta_program_id', $kategori->id)
                    ->where('is_active', true)
                    ->with('subMetaPrograms')
                    ->orderBy('id')
                    ->get();

                $subMpScores = [];

                // Collect all scores by Sub-MP (same as full assessment)
                foreach ($metaPrograms as $mp) {
                    // Get pertanyaan for this meta program
                    $pertanyaanList = \App\Models\PertanyaanMetaProgram::where('meta_program_id', $mp->id)
                        ->where('is_active', true)
                        ->get();

                    foreach ($pertanyaanList as $pertanyaan) {
                        $questionId = $pertanyaan->id;
                        $answer = null;

                        if (isset($individualScores[$questionId])) {
                            $answer = $individualScores[$questionId];
                        } elseif (isset($individualScores[(string)$questionId])) {
                            $answer = $individualScores[(string)$questionId];
                        }

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
                                        'meta_program_slug' => $mp->slug,
                                    ];
                                }
                                $subMpScores[$subMp->id]['total_score'] += (int)$answer;
                                $subMpScores[$subMp->id]['count']++;
                            }
                        }
                    }
                }

                // Group by Meta Program and create pairs (same logic as full assessment)
                $metaProgramPairs = [];

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
                        \Log::info('MP Pairs Added', [
                            'mp_name' => $mp->name,
                            'pairs_count' => count($pairs),
                            'pairs' => $pairs
                        ]);
                    }
                }

                // Find highest scoring sub-MP in this kategori
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

                // Add period at the end if there are multiple highest sub-MPs
                $highestSubMpDisplay = null;
                if (!empty($highestSubMps)) {
                    $highestSubMpDisplay = implode(', ', $highestSubMps);
                    if (count($highestSubMps) > 1) {
                        $highestSubMpDisplay .= '.';
                    }
                }

                $kategoriBreakdown[] = [
                    'id' => $kategori->id,
                    'name' => $kategori->name,
                    'slug' => $kategori->slug,
                    'meta_program_pairs' => $metaProgramPairs,
                    'highest_sub_mp' => $highestSubMpDisplay,
                ];
            }

            return view('results.index', compact(
                'latestAttempt',
                'course',
                'averageScore',
                'overallAverage',
                'mpConfig',
                'dominantSideName',
                'otherSideName',
                'allSides',
                'dominantPercentage',
                'otherPercentage',
                'kategoriBreakdown'
            ));
        }
    }

    public function show($id)
    {
        $attempt = QuizAttempt::with(['user', 'course.questions', 'quizResults'])->findOrFail($id);

        // Check if user has access to this result
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if user has confirmed purchase
        $hasConfirmedPurchase = Purchase::where('user_id', Auth::id())->where('status', 'confirmed')->exists();

        if (!$hasConfirmedPurchase) {
            return redirect()->route('purchases.create')->with('error', 'Please purchase a tier to access the results.');
        }

        // Get all questions for the course
        $course = $attempt->course;
        $questions = $course->questions()->where('is_active', true)->get();

        // Calculate scores for each question group (51 Meta Programs, 5 questions each)
        $mpScores = [];
        $questionsPerMp = 5;

        foreach ($questions as $index => $question) {
            $mpIndex = intdiv($index, $questionsPerMp); // Group questions by MP (0-50)

            if (!isset($mpScores[$mpId])) {
                $mpScores[$mpId] = [
                    'mp_number' => $mpIndex + 1,
                    'total_score' => 0,
                    'count' => 0,
                ];
            }

            // Get user's answer for this question
            $quizResult = $attempt->quizResults()
                ->where('question_id', $question->id)
                ->first();

            if ($quizResult) {
                $mpScores[$mpId]['total_score'] += $quizResult->answer;
                $mpScores[$mpId]['count']++;
            }
        }

        // Calculate average scores for each MP
        $mpAverages = [];
        foreach ($mpScores as $mpIndex => $mpData) {
            $mpAverages[$mpIndex + 1] = $mpData['count'] > 0 ? $mpData['total_score'] / $mpData['count'] : 3;
        }

        // Get user's purchase information
        $purchase = Purchase::where('user_id', Auth::id())->where('status', 'confirmed')->latest()->first();

        return view('results.show', compact(
            'attempt',
            'mpScores',
            'mpAverages',
            'purchase'
        ));
    }

    public function redirectToWhatsApp($id)
    {
        $attempt = QuizAttempt::with(['user', 'course.questions', 'quizResults'])->findOrFail($id);

        // Check if user has access to this result
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if the course has WhatsApp consultation feature
        if (!$attempt->course->has_whatsapp_consultation) {
            return redirect()->route('courses.index')->with('error', 'Kursus ini tidak memiliki fitur konsultasi WhatsApp.');
        }

        // Check if user has access to this course (confirmed purchase or free course)
        $hasAccess = Auth::user()->canAccessCourse($attempt->course);
        if (!$hasAccess) {
            return redirect()->route('courses.purchase', $attempt->course->slug)
                ->with('error', 'Anda perlu membeli kursus Premium untuk mengakses konsultasi WhatsApp.');
        }

        // Assuming the admin WhatsApp number is stored in config or environment
        $adminWhatsAppNumber = config('app.whatsapp_admin_number', env('WHATSAPP_ADMIN_NUMBER', '6281234567890'));

        // Create WhatsApp message
        $message = "Hello, saya {$attempt->user->name} ingin konsultasi tentang hasil penilaian Meta Programs saya.";

        $whatsappUrl = "https://wa.me/{$adminWhatsAppNumber}?text=" . urlencode($message);

        return redirect()->away($whatsappUrl);
    }

    public function downloadPdf($id)
    {
        $attempt = QuizAttempt::with(['user', 'course', 'quizResults'])->findOrFail($id);

        // Check if user has access to this result
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if user has confirmed purchase
        $hasConfirmedPurchase = Purchase::where('user_id', Auth::id())->where('status', 'confirmed')->exists();

        if (!$hasConfirmedPurchase) {
            return redirect()->route('purchases.create')->with('error', 'Please purchase a tier to download the report.');
        }

        $course = $attempt->course;
        $scoresData = json_decode($attempt->scores, true);
        $individualScores = $scoresData['individual'] ?? [];

        // Check if this is a single category quiz or full assessment
        $isSingleCategory = $attempt->category_id !== null;

        // Get kategori meta programs - filter by course category or get all
        if ($isSingleCategory) {
            // Single category quiz - only get that category
            $kategoriMetaPrograms = \App\Models\KategoriMetaProgram::where('id', $attempt->category_id)
                ->with(['metaPrograms.subMetaPrograms'])
                ->get();
        } else {
            // Full assessment - get all categories
            $kategoriMetaPrograms = \App\Models\KategoriMetaProgram::with(['metaPrograms.subMetaPrograms'])
                ->orderBy('id')
                ->get();
        }

        $kategoriBreakdown = [];

        foreach ($kategoriMetaPrograms as $kategori) {
            $metaPrograms = \App\Models\MetaProgram::where('kategori_meta_program_id', $kategori->id)
                ->where('is_active', true)
                ->with('subMetaPrograms')
                ->orderBy('id')
                ->get();

            $subMpScores = [];

            // Collect all scores by Sub-MP
            foreach ($metaPrograms as $mp) {
                $pertanyaanList = \App\Models\PertanyaanMetaProgram::where('meta_program_id', $mp->id)
                    ->where('is_active', true)
                    ->get();

                foreach ($pertanyaanList as $pertanyaan) {
                    $questionId = $pertanyaan->id;
                    $answer = null;

                    if (isset($individualScores[$questionId])) {
                        $answer = $individualScores[$questionId];
                    } elseif (isset($individualScores[(string)$questionId])) {
                        $answer = $individualScores[(string)$questionId];
                    }

                    if ($answer !== null) {
                        $subMp = $pertanyaan->subMetaProgram;
                        if ($subMp) {
                            if (!isset($subMpScores[$subMp->id])) {
                                $subMpScores[$subMp->id] = [
                                    'name' => $subMp->name,
                                    'slug' => $subMp->slug,
                                    'description' => $subMp->description,
                                    'total_score' => 0,
                                    'count' => 0,
                                    'meta_program_id' => $mp->id,
                                    'meta_program_name' => $mp->name,
                                    'meta_program_description' => $mp->description,
                                ];
                            }
                            $subMpScores[$subMp->id]['total_score'] += (int)$answer;
                            $subMpScores[$subMp->id]['count']++;
                        }
                    }
                }
            }

            // Group by Meta Program and create pairs
            $metaProgramPairs = [];

            foreach ($metaPrograms as $mp) {
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
                            'description' => $data['description'],
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
                        'meta_program_description' => $mp->description,
                        'pairs' => $pairs,
                    ];
                }
            }

            // Find highest scoring sub-MP in this kategori
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

            $kategoriBreakdown[] = [
                'id' => $kategori->id,
                'name' => $kategori->name,
                'slug' => $kategori->slug,
                'description' => $kategori->description,
                'meta_program_pairs' => $metaProgramPairs,
                'highest_sub_mps' => $highestSubMps, // Store as array (per category)
            ];
        }

        // Build GLOBAL sorted list of ALL sub-MPs from ALL categories
        $globalSubMpList = [];
        foreach ($kategoriBreakdown as $kategori) {
            foreach ($kategori['meta_program_pairs'] as $mp) {
                foreach ($mp['pairs'] as $pair) {
                    if (isset($pair['side1'])) {
                        $globalSubMpList[] = [
                            'name' => $pair['side1']['name'],
                            'score' => $pair['side1']['total_score'] ?? 0,
                        ];
                    }
                    if (isset($pair['side2'])) {
                        $globalSubMpList[] = [
                            'name' => $pair['side2']['name'],
                            'score' => $pair['side2']['total_score'] ?? 0,
                        ];
                    }
                }
            }
        }

        // Sort by score descending (highest first)
        usort($globalSubMpList, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        // Group by score to find ties
        $scoreGroups = [];
        foreach ($globalSubMpList as $subMp) {
            $score = $subMp['score'];
            if (!isset($scoreGroups[$score])) {
                $scoreGroups[$score] = [];
            }
            $scoreGroups[$score][] = $subMp['name'];
        }

        // Build final list with period for ties
        $sortedHighestSubMps = [];
        foreach ($globalSubMpList as $subMp) {
            $score = $subMp['score'];
            $name = $subMp['name'];

            // Check if this score has ties (more than 1 sub-MP with same score)
            if (count($scoreGroups[$score]) > 1) {
                // Add period for ties
                $nameWithPeriod = $name . '.';
                // Only add if not already added
                if (!in_array($nameWithPeriod, $sortedHighestSubMps)) {
                    $sortedHighestSubMps[] = $nameWithPeriod;
                }
            } else {
                // No tie, add without period
                if (!in_array($name, $sortedHighestSubMps)) {
                    $sortedHighestSubMps[] = $name;
                }
            }
        }

        // Get user's purchase information
        $purchase = Purchase::where('user_id', Auth::id())->where('status', 'confirmed')->latest()->first();

        // Generate PDF using DomPDF
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('results.pdf-report', compact(
            'attempt',
            'course',
            'kategoriBreakdown',
            'purchase',
            'sortedHighestSubMps' // Pass the global sorted list
        ));

        // Set paper size to A4
        $pdf->setPaper('a4');

        // Set options for better rendering
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => false,
            'defaultFont' => 'Arial',
        ]);

        // Generate the new PDF content to a temporary file
        $newPdfContent = $pdf->output();
        $newPdfPath = storage_path('app/temp_new_report_' . $attempt->id . '.pdf');

        // Ensure storage/app directory exists and is writable
        $storageDir = storage_path('app');
        if (!is_dir($storageDir)) {
            mkdir($storageDir, 0755, true);
        }

        $bytesWritten = file_put_contents($newPdfPath, $newPdfContent);
        if ($bytesWritten === false) {
            \Log::error('Failed to write temp PDF file', ['path' => $newPdfPath]);
            abort(500, 'Failed to generate PDF file');
        }

        // Path ke PDF yang sudah ada - "REPORT Ur-BrainDevPro.pdf"
        // Cek di storage/app/ dulu (fallback ke base_path)
        $existingPdfPath = storage_path('app/REPORT Ur-BrainDevPro.pdf');

        // Fallback ke root jika tidak ada di storage
        if (!file_exists($existingPdfPath)) {
            $existingPdfPath = base_path('REPORT Ur-BrainDevPro.pdf');
        }

        // Check if existing PDF exists
        if (!file_exists($existingPdfPath)) {
            \Log::error('Template PDF not found', ['path' => $existingPdfPath]);
            abort(500, 'PDF template not found');
        }

        if (file_exists($existingPdfPath)) {
            // Use FPDI to merge PDFs
            $fpdi = new Fpdi();

            // Count pages in existing PDF
            $pageCount = $fpdi->setSourceFile($existingPdfPath);

            // Page 4 is blank, skip it and replace with new content
            $blankPageNum = 4;

            // Import pages BEFORE the blank page (pages 1-3)
            for ($i = 1; $i < $blankPageNum && $i <= $pageCount; $i++) {
                $templateId = $fpdi->importPage($i);
                $size = $fpdi->getTemplateSize($templateId);
                $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $fpdi->useTemplate($templateId);

                // Add user name on page 1 (at bottom center in blue footer)
                if ($i == 1) {
                    $userName = $attempt->user->name ?? '';
                    $fpdi->SetFont('Arial', 'B', 18);
                    $fpdi->SetTextColor(255, 255, 255); // White color

                    // Center the text horizontally on the page
                    $fpdi->SetXY(0, 235); // Position in blue footer area (Y in mm)
                    $fpdi->Cell(210, 10, $userName, 0, 0, 'C'); // Full width, centered
                }
            }

            // Add new PDF content to replace the blank page 4
            $fpdi->setSourceFile($newPdfPath);
            $newPageCount = $fpdi->setSourceFile($newPdfPath);

            for ($i = 1; $i <= $newPageCount; $i++) {
                $templateId = $fpdi->importPage($i);
                $size = $fpdi->getTemplateSize($templateId);
                $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $fpdi->useTemplate($templateId);
            }

            // IMPORTANT: Set source back to existing PDF for remaining pages
            $fpdi->setSourceFile($existingPdfPath);

            // Import remaining pages AFTER the blank page (skip page 4, start from page 5)
            for ($i = $blankPageNum + 1; $i <= $pageCount; $i++) {
                $templateId = $fpdi->importPage($i);
                $size = $fpdi->getTemplateSize($templateId);
                $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $fpdi->useTemplate($templateId);
            }

            // Clean up temp file
            unlink($newPdfPath);

            // Output the merged PDF
            return $fpdi->Output('D', 'braindevpro-report-' . $attempt->id . '.pdf');
        } else {
            // If no existing PDF, just download the new one
            unlink($newPdfPath);
            return $pdf->download('braindevpro-report-' . $attempt->id . '.pdf');
        }
    }

    /**
     * Generate AI-powered personal report using Gemini
     */
    public function generatePersonalReport($id)
    {
        $attempt = QuizAttempt::with(['user', 'course'])->findOrFail($id);

        // Check if user has access
        if ($attempt->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if user has confirmed purchase
        $hasConfirmedPurchase = Purchase::where('user_id', Auth::id())->where('status', 'confirmed')->exists();

        if (!$hasConfirmedPurchase) {
            return redirect()->route('purchases.create')->with('error', 'Please purchase a tier to generate the personal report.');
        }

        try {
            $geminiService = new GeminiService();

            // Prepare data for prompt
            $course = $attempt->course;
            $scoresData = json_decode($attempt->scores, true);
            $individualScores = $scoresData['individual'] ?? [];

            // Get kategori breakdown (reuse logic from downloadPdf)
            $kategoriMetaPrograms = \App\Models\KategoriMetaProgram::with(['metaPrograms.subMetaPrograms'])
                ->orderBy('id')
                ->get();

            $kategoriBreakdown = [];

            foreach ($kategoriMetaPrograms as $kategori) {
                $metaPrograms = \App\Models\MetaProgram::where('kategori_meta_program_id', $kategori->id)
                    ->where('is_active', true)
                    ->with('subMetaPrograms')
                    ->orderBy('id')
                    ->get();

                $subMpScores = [];

                foreach ($metaPrograms as $mp) {
                    $pertanyaanList = \App\Models\PertanyaanMetaProgram::where('meta_program_id', $mp->id)
                        ->where('is_active', true)
                        ->get();

                    foreach ($pertanyaanList as $pertanyaan) {
                        $questionId = $pertanyaan->id;
                        $answer = null;

                        if (isset($individualScores[$questionId])) {
                            $answer = $individualScores[$questionId];
                        } elseif (isset($individualScores[(string)$questionId])) {
                            $answer = $individualScores[(string)$questionId];
                        }

                        if ($answer !== null) {
                            $subMp = $pertanyaan->subMetaProgram;
                            if ($subMp) {
                                if (!isset($subMpScores[$subMp->id])) {
                                    $subMpScores[$subMp->id] = [
                                        'name' => $subMp->name,
                                        'slug' => $subMp->slug,
                                        'description' => $subMp->description,
                                        'total_score' => 0,
                                        'count' => 0,
                                        'meta_program_id' => $mp->id,
                                        'meta_program_name' => $mp->name,
                                        'meta_program_description' => $mp->description,
                                    ];
                                }
                                $subMpScores[$subMp->id]['total_score'] += (int)$answer;
                                $subMpScores[$subMp->id]['count']++;
                            }
                        }
                    }
                }

                // Group by Meta Program and create pairs
                $metaProgramPairs = [];

                foreach ($metaPrograms as $mp) {
                    $mpSubMps = $mp->subMetaPrograms->sortBy('order');
                    $mpSubMpScores = [];

                    foreach ($mpSubMps as $subMp) {
                        if (isset($subMpScores[$subMp->id])) {
                            $data = $subMpScores[$subMp->id];
                            $average = $data['count'] > 0 ? $data['total_score'] / $data['count'] : 3;
                            // Percentage based on answered count (not score)
                            $totalQuestions = $mp->pertanyaan->where('sub_meta_program_id', $subMp->id)->count();
                            $percentage = $totalQuestions > 0 ? ($data['count'] / $totalQuestions) * 100 : 0;
                            $mpSubMpScores[] = [
                                'id' => $subMp->id,
                                'name' => $data['name'],
                                'slug' => $data['slug'],
                                'description' => $data['description'],
                                'average' => round($average, 0),
                                'percentage' => round($percentage, 0),
                            ];
                        }
                    }

                    // Create pairs based on count
                    $pairs = [];
                    $count = count($mpSubMpScores);

                    if ($count == 2) {
                        $pairs[] = [
                            'side1' => $mpSubMpScores[0],
                            'side2' => $mpSubMpScores[1],
                            'dominant' => $mpSubMpScores[0]['percentage'] >= $mpSubMpScores[1]['percentage']
                                ? $mpSubMpScores[0]
                                : $mpSubMpScores[1],
                        ];
                    } elseif ($count == 3) {
                        $pairs[] = [
                            'side1' => $mpSubMpScores[0],
                            'side2' => $mpSubMpScores[2],
                            'dominant' => $mpSubMpScores[0]['percentage'] >= $mpSubMpScores[2]['percentage']
                                ? $mpSubMpScores[0]
                                : $mpSubMpScores[2],
                        ];
                    } elseif ($count == 4) {
                        $slug1 = $mpSubMpScores[0]['slug'] ?? '';
                        $slug3 = $mpSubMpScores[2]['slug'] ?? '';

                        if (in_array('kinesthetic', [$slug1, $mpSubMpScores[1]['slug'] ?? '', $slug3, $mpSubMpScores[3]['slug'] ?? ''])) {
                            $kinesthetic = null;
                            $visual = null;
                            foreach ($mpSubMpScores as $smp) {
                                if ($smp['slug'] === 'kinesthetic') $kinesthetic = $smp;
                                if ($smp['slug'] === 'visual') $visual = $smp;
                            }
                            if ($kinesthetic && $visual) {
                                $pairs[] = [
                                    'side1' => $kinesthetic,
                                    'side2' => $visual,
                                    'dominant' => $kinesthetic['percentage'] >= $visual['percentage']
                                        ? $kinesthetic
                                        : $visual,
                                ];
                            }
                            $remaining = array_filter($mpSubMpScores, function ($smp) {
                                return !in_array($smp['slug'], ['kinesthetic', 'visual']);
                            });
                            $remaining = array_values($remaining);
                            if (count($remaining) >= 2) {
                                $pairs[] = [
                                    'side1' => $remaining[0],
                                    'side2' => $remaining[1],
                                    'dominant' => $remaining[0]['percentage'] >= $remaining[1]['percentage']
                                        ? $remaining[0]
                                        : $remaining[1],
                                ];
                            }
                        } else {
                            $pairs[] = [
                                'side1' => $mpSubMpScores[0],
                                'side2' => $mpSubMpScores[1],
                                'dominant' => $mpSubMpScores[0]['percentage'] >= $mpSubMpScores[1]['percentage']
                                    ? $mpSubMpScores[0]
                                    : $mpSubMpScores[1],
                            ];
                            if (isset($mpSubMpScores[2]) && isset($mpSubMpScores[3])) {
                                $pairs[] = [
                                    'side1' => $mpSubMpScores[2],
                                    'side2' => $mpSubMpScores[3],
                                    'dominant' => $mpSubMpScores[2]['percentage'] >= $mpSubMpScores[3]['percentage']
                                        ? $mpSubMpScores[2]
                                        : $mpSubMpScores[3],
                                ];
                            }
                        }
                    } elseif ($count >= 1) {
                        $pairs[] = [
                            'side1' => $mpSubMpScores[0],
                            'side2' => null,
                            'dominant' => $mpSubMpScores[0],
                        ];
                    }

                    if (!empty($pairs)) {
                        $metaProgramPairs[] = [
                            'meta_program_name' => $mp->name,
                            'meta_program_slug' => $mp->slug,
                            'meta_program_description' => $mp->description,
                            'pairs' => $pairs,
                        ];
                    }
                }

                $kategoriBreakdown[] = [
                    'id' => $kategori->id,
                    'name' => $kategori->name,
                    'slug' => $kategori->slug,
                    'description' => $kategori->description,
                    'meta_program_pairs' => $metaProgramPairs,
                ];
            }

            // Prepare data for Gemini
            $assessmentData = [
                'user_name' => $attempt->user->name,
                'kategori_breakdown' => $kategoriBreakdown,
            ];

            // Generate report using Gemini
            $personalReport = $geminiService->generatePersonalReport($assessmentData);

            // Store report in session or database
            session(['personal_report_' . $attempt->id => $personalReport]);

            return view('results.personal-report', [
                'attempt' => $attempt,
                'personalReport' => $personalReport,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal mengenerate personal report: ' . $e->getMessage());
        }
    }

    /**
     * Generate dummy assessment data for testing.
     */
    public function generateDummyData()
    {
        // Get the logged-in user
        $user = Auth::user();

        // Check if user is logged in
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        try {
            // Get the Meta Programs course
            $course = Course::where('slug', 'meta-programs-assessment')->first();

            if (!$course) {
                return redirect()->route('courses.index')->with('error', 'Course Meta Programs tidak ditemukan.');
            }

            // Delete existing data for this user
            QuizAttempt::where('user_id', $user->id)->delete();
            QuizResult::where('user_id', $user->id)->delete();
            UserKategoriProgress::where('user_id', $user->id)->where('course_id', $course->id)->delete();

            // Create dummy scores for all 51 Meta Programs
            $allScores = [];
            $allAnswers = [];

            // Generate realistic scores for 51 MPs
            for ($mpIndex = 1; $mpIndex <= 51; $mpIndex++) {
                // Random score between 1 and 5 for each question
                for ($q = 0; $q < 5; $q++) {
                    $questionNum = ($mpIndex - 1) * 5 + $q + 1;
                    $questionScore = rand(1, 5);
                    $allScores[$questionNum] = $questionScore;
                    // Get a random option ID (1-6)
                    $allAnswers[$questionNum] = rand(1, 6);
                }
            }

            // Calculate final average
            $finalAverageScore = count($allScores) > 0 ? array_sum($allScores) / count($allScores) : 0;
            $finalTotalScore = array_sum($allScores);

            // Create the quiz attempt
            $quizAttempt = QuizAttempt::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'category_id' => null,
                'answers' => $allAnswers,
                'scores' => json_encode([
                    'average' => $finalAverageScore,
                    'individual' => $allScores
                ]),
                'dominant_type' => null,
                'total_score' => $finalTotalScore,
                'completed_at' => now(),
            ]);

            // Create individual QuizResult records for each answer
            // Get the questions from the course
            $questions = $course->questions()->where('is_active', true)->get();

            foreach ($questions as $index => $question) {
                $questionNum = $index + 1;
                if (isset($allScores[$questionNum])) {
                    QuizResult::create([
                        'user_id' => $user->id,
                        'quiz_attempt_id' => $quizAttempt->id,
                        'question_id' => $question->id,
                        'answer' => $allScores[$questionNum],
                    ]);
                }
            }

            // Mark all kategoris as completed
            $kategoriMetaPrograms = \App\Models\KategoriMetaProgram::orderBy('order')->get();
            foreach ($kategoriMetaPrograms as $kategori) {
                UserKategoriProgress::create([
                    'user_id' => $user->id,
                    'course_id' => $course->id,
                    'kategori_meta_program_id' => $kategori->id,
                    'current_question_index' => 15, // Assume ~15 questions per kategori
                    'total_questions' => 15,
                    'is_completed' => true,
                    'completed_at' => now(),
                ]);
            }

            return redirect()->route('results.index')
                ->with('success', 'Data dummy assessment berhasil dibuat! Anda dapat melihat hasil assessment.');
        } catch (\Exception $e) {
            return redirect()->route('courses.index')
                ->with('error', 'Gagal membuat data dummy: ' . $e->getMessage());
        }
    }

    /**
     * Find the page number that contains specific text in PDF
     *
     * @param string $pdfPath Path to PDF file
     * @param array $searchTexts Array of text strings to search for
     * @return int Page number (0 if not found)
     */
    private function findPageWithText($pdfPath, $searchTexts = [])
    {
        try {
            $parser = new PdfParser();
            $pdf = $parser->parseFile($pdfPath);

            // Get the actual page count using FPDI to verify
            $fpdiCheck = new Fpdi();
            $actualPageCount = $fpdiCheck->setSourceFile($pdfPath);

            $pages = $pdf->getPages();
            $foundPage = 0;

            foreach ($pages as $pageIndex => $page) {
                // Only check pages within the actual page count
                if ($pageIndex >= $actualPageCount) {
                    break;
                }

                $pageText = $page->getText();

                // Check if any of the search texts exist in this page
                foreach ($searchTexts as $searchText) {
                    if (stripos($pageText, $searchText) !== false) {
                        // Return page number (1-indexed), but never exceed actual page count
                        $foundPage = min($pageIndex + 1, $actualPageCount);
                        return $foundPage;
                    }
                }
            }

            return 0; // Not found
        } catch (\Exception $e) {
            // If parsing fails, return 0 (will use default)
            return 0;
        }
    }
}

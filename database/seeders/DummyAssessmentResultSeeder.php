<?php

namespace Database\Seeders;

use App\Models\QuizAttempt;
use App\Models\QuizResult;
use App\Models\Course;
use App\Models\User;
use App\Models\UserKategoriProgress;
use App\Models\KategoriMetaProgram;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class DummyAssessmentResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a test user
        $user = User::first();
        if (!$user) {
            $this->command->error('No user found. Please create a user first.');
            return;
        }

        // Get the Meta Programs course
        $course = Course::where('slug', 'meta-programs-assessment')->first();
        if (!$course) {
            $this->command->error('Meta Programs course not found. Please run MetaProgramSeeder first.');
            return;
        }

        // Delete existing dummy data for this user
        QuizAttempt::where('user_id', $user->id)->delete();
        QuizResult::where('user_id', $user->id)->delete();
        UserKategoriProgress::where('user_id', $user->id)->delete();

        $this->command->info('Creating dummy assessment data for user: ' . $user->email);

        // Create dummy scores for all 51 Meta Programs
        // Each MP has 2 sides, score 1-5
        $allScores = [];
        $allAnswers = [];

        // Generate realistic scores for 51 MPs (questions 1-255, 5 questions per MP)
        for ($mpIndex = 1; $mpIndex <= 51; $mpIndex++) {
            // Random score between 1 and 5 for each MP
            $mpScore = rand(20, 28) / 5; // Average of 5 questions, 1-5 scale each

            // Calculate individual question scores (1-5 each)
            for ($q = 0; $q < 5; $q++) {
                $questionNum = ($mpIndex - 1) * 5 + $q + 1;
                $questionScore = rand(1, 5);
                $allScores[$questionNum] = $questionScore;
                $allAnswers[$questionNum] = rand(1, 6); // Random option ID
            }
        }

        // Calculate final average
        $finalAverageScore = array_sum($allScores) / count($allScores);
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

        $this->command->info('Created QuizAttempt ID: ' . $quizAttempt->id);

        // Create individual QuizResult records for each answer
        foreach ($allAnswers as $questionId => $optionId) {
            QuizResult::create([
                'user_id' => $user->id,
                'quiz_attempt_id' => $quizAttempt->id,
                'question_id' => $questionId,
                'answer' => $allScores[$questionId] ?? 3,
            ]);
        }

        $this->command->info('Created ' . count($allAnswers) . ' QuizResult records');

        // Mark all kategoris as completed
        $kategoriMetaPrograms = KategoriMetaProgram::orderBy('order')->get();
        foreach ($kategoriMetaPrograms as $kategori) {
            UserKategoriProgress::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'kategori_meta_program_id' => $kategori->id,
                'current_question_index' => rand(10, 20), // Random progress
                'total_questions' => rand(10, 20),
                'is_completed' => true,
                'completed_at' => now(),
            ]);
        }

        $this->command->info('Marked all ' . $kategoriMetaPrograms->count() . ' kategoris as completed');
        $this->command->info('Dummy assessment data created successfully!');
        $this->command->info('You can now visit the results page.');
    }
}

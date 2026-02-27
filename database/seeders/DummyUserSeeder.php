<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Course;
use App\Models\Purchase;
use App\Models\QuizAttempt;
use App\Models\QuizResult;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DummyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Get or create user
        $user = User::where('email', 'wbb000000@gmail.com')->first();

        if (!$user) {
            $user = User::create([
                'name' => 'Wilbert Test User',
                'email' => 'wbb000000@gmail.com',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]);
            $this->command->info('User created: wbb000000@gmail.com');
        } else {
            $this->command->info('User found: wbb000000@gmail.com');
        }

        // Get Course 1 (Basic)
        $course = Course::where('slug', 'meta-programs-basic')->first();

        if (!$course) {
            $this->error('Course Basic not found!');
            return;
        }

        $this->command->info('Course found: ' . $course->title);

        // Check if user already has purchase for this course
        $existingPurchase = Purchase::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingPurchase) {
            $this->command->info('Purchase already exists. Deleting old data...');
            // Delete old attempts and results
            QuizResult::whereHas('quizAttempt', function ($q) use ($existingPurchase) {
                $q->where('id', $existingPurchase->quiz_attempt_id);
            })->delete();
            QuizAttempt::where('id', $existingPurchase->quiz_attempt_id)->delete();
            $existingPurchase->delete();
        }

        // Create confirmed purchase
        $purchase = Purchase::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'amount' => 999000,
            'payment_method' => 'Transfer Bank BCA',
            'payment_proof' => null,
            'status' => 'confirmed',
            'expired_at' => null, // Lifetime access
            'quiz_attempt_id' => null, // Will be updated after quiz
            'admin_id' => 1,
            'confirmed_at' => now(),
        ]);

        $this->command->info('Purchase created (ID: ' . $purchase->id . ')');

        // Get all questions for the course
        $questions = Question::where('course_id', $course->id)->get();

        if ($questions->isEmpty()) {
            $this->error('No questions found for this course!');
            return;
        }

        $this->command->info('Found ' . $questions->count() . ' questions');

        // Create quiz attempt
        $quizAttempt = QuizAttempt::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'category_id' => null,
            'answers' => [],
            'scores' => json_encode([
                'average' => 3.8,
                'individual' => []
            ]),
            'dominant_type' => null,
            'total_score' => 0,
            'completed_at' => now(),
        ]);

        $this->command->info('Quiz attempt created (ID: ' . $quizAttempt->id . ')');

        // Update purchase with quiz_attempt_id
        $purchase->update(['quiz_attempt_id' => $quizAttempt->id]);

        // Create quiz results for all questions (random Likert scores 1-5)
        $totalScore = 0;
        $individualScores = [];

        foreach ($questions as $question) {
            // Random score between 1-5 with bias toward 3-5
            $score = rand(1, 5);
            $totalScore += $score;
            $individualScores[$question->id] = $score;

            QuizResult::create([
                'user_id' => $user->id,
                'quiz_attempt_id' => $quizAttempt->id,
                'question_id' => $question->id,
                'answer' => $score,
            ]);
        }

        $averageScore = $totalScore / $questions->count();

        // Update quiz attempt with scores
        $quizAttempt->update([
            'scores' => json_encode([
                'average' => round($averageScore, 2),
                'individual' => $individualScores
            ]),
            'total_score' => $totalScore,
        ]);

        $this->command->info('Created ' . $questions->count() . ' quiz results');
        $this->command->info('Average score: ' . round($averageScore, 2));
        $this->command->info('Total score: ' . $totalScore);

        $this->command->newLine();
        $this->command->info('✅ Dummy data created successfully!');
        $this->command->info('Email: wbb000000@gmail.com');
        $this->command->info('Password: password123');
        $this->command->info('Course: ' . $course->title);
        $this->command->info('Status: Confirmed & Completed');
    }
}

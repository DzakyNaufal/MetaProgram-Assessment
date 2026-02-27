<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\PertanyaanMetaProgram;
use App\Models\QuizAttempt;
use App\Models\QuizResult;
use App\Models\UserKategoriProgress;
use App\Models\Purchase;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TwoCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Clear existing data (in correct order due to foreign keys)
        QuestionOption::query()->delete();
        QuizResult::query()->delete();
        QuizAttempt::query()->delete();
        UserKategoriProgress::query()->delete();
        Purchase::query()->delete();
        Question::query()->delete();
        Course::query()->delete();

        // Enable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Get all pertanyaan from Meta Programs
        $pertanyaanMetaPrograms = PertanyaanMetaProgram::with(['metaProgram', 'subMetaProgram'])
            ->orderBy('order')
            ->get();

        $totalPertanyaan = $pertanyaanMetaPrograms->count();

        // Create 3 Courses
        $courses = [
            [
                'title' => 'Meta Programs Assessment - Basic',
                'slug' => 'meta-programs-basic',
                'description' => "Tes Meta Programs lengkap dengan {$totalPertanyaan} pertanyaan untuk memahami profil kepribadian Anda. Termasuk laporan hasil assessment.",
                'thumbnail' => null,
                'estimated_time' => 90,
                'price' => 999000,
                'is_active' => true,
                'has_whatsapp_consultation' => false,
                'has_offline_coaching' => false,
                'order' => 1,
            ],
            [
                'title' => 'Meta Programs Assessment - Premium',
                'slug' => 'meta-programs-premium',
                'description' => "Tes Meta Programs lengkap dengan {$totalPertanyaan} pertanyaan untuk memahami profil kepribadian Anda. Termasuk laporan hasil assessment dan konsultasi via WhatsApp.",
                'thumbnail' => null,
                'estimated_time' => 90,
                'price' => 1500000,
                'is_active' => true,
                'has_whatsapp_consultation' => true,
                'has_offline_coaching' => false,
                'order' => 2,
            ],
            [
                'title' => 'Assessment Konsultasi dan Coaching',
                'slug' => 'assessment-coaching',
                'description' => "Tes Meta Programs lengkap dengan {$totalPertanyaan} pertanyaan PLUS sesi konsultasi dan coaching offline dengan expert. Termasuk laporan assessment detail, sesi coaching 1-on-1, dan akses WhatsApp untuk follow-up consultation.",
                'thumbnail' => null,
                'estimated_time' => 120,
                'price' => 3000000,
                'is_active' => true,
                'has_whatsapp_consultation' => true,
                'has_offline_coaching' => true,
                'order' => 3,
            ],
        ];

        $createdCourses = [];
        foreach ($courses as $courseData) {
            $course = Course::create($courseData);
            $createdCourses[] = $course;
        }

        // Create questions for ALL courses from Meta Programs
        foreach ($createdCourses as $course) {
            foreach ($pertanyaanMetaPrograms as $index => $pertanyaanMP) {
                $metaProgram = $pertanyaanMP->metaProgram;
                $subMetaProgram = $pertanyaanMP->subMetaProgram;

                // Extract clean name (remove "MP X —" prefix if exists)
                $metaProgramName = $metaProgram ? preg_replace('/^MP\s+\d+\s+—\s*/', '', $metaProgram->name) : 'Unknown';
                $metaProgramOrder = $metaProgram ? $metaProgram->order : 0;
                $subMetaProgramName = $subMetaProgram ? $subMetaProgram->name : '';

                $questionText = $pertanyaanMP->pertanyaan;

                // Add MP info to question for reference - use ORDER not index
                // Format: [MP {order} — {meta_program_name} - {sub_meta_program_name}]
                $questionTextWithRef = "[MP {$metaProgramOrder} — {$metaProgramName}] " . $questionText;
                if ($subMetaProgramName) {
                    $questionTextWithRef = "[MP {$metaProgramOrder} — {$metaProgramName} - {$subMetaProgramName}] " . $questionText;
                }

                $question = Question::create([
                    'category_id' => null, // No category
                    'course_id' => $course->id,
                    'question_text' => $questionTextWithRef,
                    'order' => $index + 1,
                    'is_active' => true,
                ]);

                // Create Likert scale options (6 options - sesuai dengan Meta Programs)
                $likertOptions = [
                    ['Sangat Tidak Setuju', 1],
                    ['Tidak Setuju', 2],
                    ['Agak Tidak Setuju', 3],
                    ['Agak Setuju', 4],
                    ['Setuju', 5],
                    ['Sangat Setuju', 6],
                ];

                foreach ($likertOptions as $optionData) {
                    QuestionOption::create([
                        'question_id' => $question->id,
                        'option_text' => $optionData[0],
                        'talent_type' => '', // Not used for Likert scale
                        'order' => $optionData[1], // Use score as order
                    ]);
                }
            }
        }

        $this->command->info("Successfully seeded 3 courses with {$totalPertanyaan} questions each (Basic: 999K, Premium: 1.5M, Coaching: 3M).");
        $this->command->info("Questions loaded from Meta Programs database.");
    }
}

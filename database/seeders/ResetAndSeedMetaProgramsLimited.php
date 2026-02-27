<?php

namespace Database\Seeders;

use App\Models\KategoriMetaProgram;
use App\Models\MetaProgram;
use App\Models\SubMetaProgram;
use App\Models\PertanyaanMetaProgram;
use App\Models\Course;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResetAndSeedMetaProgramsLimited extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting limited reseed (20 questions per category)...');

        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Delete existing data
        $this->command->info('Deleting existing data...');

        $course = Course::where('slug', 'meta-programs-basic')->first();
        if ($course) {
            $course->questions()->delete();
        }

        // Also delete SubMetaPrograms and related data
        PertanyaanMetaProgram::truncate();
        SubMetaProgram::truncate();
        QuestionOption::truncate();
        Question::truncate();
        MetaProgram::truncate();
        KategoriMetaProgram::truncate();

        $this->command->info('Existing data deleted.');

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create Kategoris
        $this->command->info('Creating Kategoris...');

        $kategoris = [
            ['name' => 'THE MENTAL META-PROGRAMS', 'slug' => 'mental', 'order' => 1],
            ['name' => 'THE EMOTIONAL META-PROGRAMS', 'slug' => 'emotional', 'order' => 2],
            ['name' => 'THE VOLITIONAL META-PROGRAMS', 'slug' => 'volitional', 'order' => 3],
            ['name' => 'COMMUNICATION META-PROGRAMS', 'slug' => 'communication', 'order' => 4],
            ['name' => 'HIGHER META-PROGRAM', 'slug' => 'higher', 'order' => 5],
        ];

        $kategoriMap = [];
        foreach ($kategoris as $kat) {
            $model = KategoriMetaProgram::create([
                'name' => $kat['name'],
                'slug' => $kat['slug'],
                'description' => $kat['name'],
                'order' => $kat['order'],
                'is_active' => true,
            ]);
            $kategoriMap[$kat['name']] = $model;
            $this->command->info("  Created: {$kat['name']}");
        }

        // Create Meta Programs in exact order from Excel
        $this->command->info('Creating Meta Programs...');

        $metaPrograms = [
            // THE MENTAL META-PROGRAMS
            ['name' => 'MP 1 — Chunk Size', 'slug' => 'mp-1', 'order' => 1],
            ['name' => 'MP 10 — Philosophical Direction', 'slug' => 'mp-10', 'order' => 2],
            ['name' => 'MP 11 — Reality Structure Sort', 'slug' => 'mp-11', 'order' => 3],
            ['name' => 'MP 17 — Convincer Sort', 'slug' => 'mp-17', 'order' => 4],
            ['name' => 'MP 21 — Adaptation Style', 'slug' => 'mp-21', 'order' => 5],
            ['name' => 'MP 22 — Adaptation Sort', 'slug' => 'mp-22', 'order' => 6],
            ['name' => 'MP 2 — Relationship Sort', 'slug' => 'mp-2', 'order' => 7],
            ['name' => 'MP 3 — Representational System Processing', 'slug' => 'mp-3', 'order' => 8],
            ['name' => 'MP 35 – Comparison Sort', 'slug' => 'mp-35', 'order' => 9],
            ['name' => 'MP 36 – Knowledge Source', 'slug' => 'mp-36', 'order' => 10],
            ['name' => 'MP 37 – Closure Sort', 'slug' => 'mp-37', 'order' => 11],
            ['name' => 'MP 4 & 5 — Information Gathering Sort', 'slug' => 'mp-4-5', 'order' => 12],
            ['name' => 'MP 6 — Perceptual Sort', 'slug' => 'mp-6', 'order' => 13],
            ['name' => 'MP 9 — Focus Sort', 'slug' => 'mp-9', 'order' => 14],

            // THE EMOTIONAL META-PROGRAMS
            ['name' => 'MP 13 — Stress Coping Sort', 'slug' => 'mp-13', 'order' => 15],
            ['name' => 'MP 15 — Emotional State', 'slug' => 'mp-15', 'order' => 16],
            ['name' => 'MP 18 — Emotional Direction Sort', 'slug' => 'mp-18', 'order' => 17],
            ['name' => 'MP 19 — Emotional Intensity Sort', 'slug' => 'mp-19', 'order' => 18],
            ['name' => 'MP 42 – Self-Esteem', 'slug' => 'mp-42', 'order' => 19],
            ['name' => 'MP 43 — State Sort', 'slug' => 'mp-43', 'order' => 20],
            ['name' => 'MP 49 — Ego Strength', 'slug' => 'mp-49', 'order' => 21],
            ['name' => 'MP 7 — Attribution Sort', 'slug' => 'mp-7', 'order' => 22],
            ['name' => 'MP 8 — Perceptual Durability Sort', 'slug' => 'mp-8', 'order' => 23],

            // THE VOLITIONAL META-PROGRAMS
            ['name' => 'MP 20 — Motivation Direction', 'slug' => 'mp-20', 'order' => 24],
            ['name' => 'MP 23 — Modal Operators', 'slug' => 'mp-23', 'order' => 25],
            ['name' => 'MP 24 — Preference Sort', 'slug' => 'mp-24', 'order' => 26],
            ['name' => 'MP 25 — Goal Striving Sort', 'slug' => 'mp-25', 'order' => 27],
            ['name' => 'MP 26 — Buying Sort', 'slug' => 'mp-26', 'order' => 28],
            ['name' => 'MP 27 — Responsibility Sort', 'slug' => 'mp-27', 'order' => 29],
            ['name' => 'MP 29 — Rejuvenation of Battery', 'slug' => 'mp-29', 'order' => 30],
            ['name' => 'MP 34 – Work Preference', 'slug' => 'mp-34', 'order' => 31],
            ['name' => 'MP 39 – Hierarchical Dominance', 'slug' => 'mp-39', 'order' => 32],
            ['name' => 'MP 40 – Value Sort', 'slug' => 'mp-40', 'order' => 33],
            ['name' => 'MP 41 – Temper to Instruction', 'slug' => 'mp-41', 'order' => 34],
            ['name' => 'MP 50 — Morality Sort', 'slug' => 'mp-50', 'order' => 35],

            // COMMUNICATION META-PROGRAMS
            ['name' => 'MP 12 — Communication Channel Preference', 'slug' => 'mp-12', 'order' => 36],
            ['name' => 'MP 14 — Referencing Style', 'slug' => 'mp-14', 'order' => 37],
            ['name' => 'MP 16 — Somatic Response Style', 'slug' => 'mp-16', 'order' => 38],
            ['name' => 'MP 28 — People Convincer Sort', 'slug' => 'mp-28', 'order' => 39],
            ['name' => 'MP 30 – Affiliation & Management', 'slug' => 'mp-30', 'order' => 40],
            ['name' => 'MP 31 – Communication Stance', 'slug' => 'mp-31', 'order' => 41],
            ['name' => 'MP 33 – Somatic Response', 'slug' => 'mp-33', 'order' => 42],
            ['name' => 'MP 38 – Social Presentation', 'slug' => 'mp-38', 'order' => 43],

            // HIGHER META-PROGRAM
            ['name' => 'MP 32 – General Response', 'slug' => 'mp-32', 'order' => 44],
            ['name' => 'MP 44 — Status Sort', 'slug' => 'mp-44', 'order' => 45],
            ['name' => 'MP 45 – Self-Integrity', 'slug' => 'mp-45', 'order' => 46],
            ['name' => 'MP 46 – Time Processing', 'slug' => 'mp-46', 'order' => 47],
            ['name' => 'MP 47 – Time Experience', 'slug' => 'mp-47', 'order' => 48],
            ['name' => 'MP 48 — Time Access Sort', 'slug' => 'mp-48', 'order' => 49],
            ['name' => 'MP 51 — Causation Sort', 'slug' => 'mp-51', 'order' => 50],
        ];

        // Map MPs to their categories
        $mpKategoriMap = [
            // THE MENTAL META-PROGRAMS (1-14)
            'MP 1 — Chunk Size' => 'THE MENTAL META-PROGRAMS',
            'MP 10 — Philosophical Direction' => 'THE MENTAL META-PROGRAMS',
            'MP 11 — Reality Structure Sort' => 'THE MENTAL META-PROGRAMS',
            'MP 17 — Convincer Sort' => 'THE MENTAL META-PROGRAMS',
            'MP 21 — Adaptation Style' => 'THE MENTAL META-PROGRAMS',
            'MP 22 — Adaptation Sort' => 'THE MENTAL META-PROGRAMS',
            'MP 2 — Relationship Sort' => 'THE MENTAL META-PROGRAMS',
            'MP 3 — Representational System Processing' => 'THE MENTAL META-PROGRAMS',
            'MP 35 – Comparison Sort' => 'THE MENTAL META-PROGRAMS',
            'MP 36 – Knowledge Source' => 'THE MENTAL META-PROGRAMS',
            'MP 37 – Closure Sort' => 'THE MENTAL META-PROGRAMS',
            'MP 4 & 5 — Information Gathering Sort' => 'THE MENTAL META-PROGRAMS',
            'MP 6 — Perceptual Sort' => 'THE MENTAL META-PROGRAMS',
            'MP 9 — Focus Sort' => 'THE MENTAL META-PROGRAMS',

            // THE EMOTIONAL META-PROGRAMS (15-23)
            'MP 13 — Stress Coping Sort' => 'THE EMOTIONAL META-PROGRAMS',
            'MP 15 — Emotional State' => 'THE EMOTIONAL META-PROGRAMS',
            'MP 18 — Emotional Direction Sort' => 'THE EMOTIONAL META-PROGRAMS',
            'MP 19 — Emotional Intensity Sort' => 'THE EMOTIONAL META-PROGRAMS',
            'MP 42 – Self-Esteem' => 'THE EMOTIONAL META-PROGRAMS',
            'MP 43 — State Sort' => 'THE EMOTIONAL META-PROGRAMS',
            'MP 49 — Ego Strength' => 'THE EMOTIONAL META-PROGRAMS',
            'MP 7 — Attribution Sort' => 'THE EMOTIONAL META-PROGRAMS',
            'MP 8 — Perceptual Durability Sort' => 'THE EMOTIONAL META-PROGRAMS',

            // THE VOLITIONAL META-PROGRAMS (24-35)
            'MP 20 — Motivation Direction' => 'THE VOLITIONAL META-PROGRAMS',
            'MP 23 — Modal Operators' => 'THE VOLITIONAL META-PROGRAMS',
            'MP 24 — Preference Sort' => 'THE VOLITIONAL META-PROGRAMS',
            'MP 25 — Goal Striving Sort' => 'THE VOLITIONAL META-PROGRAMS',
            'MP 26 — Buying Sort' => 'THE VOLITIONAL META-PROGRAMS',
            'MP 27 — Responsibility Sort' => 'THE VOLITIONAL META-PROGRAMS',
            'MP 29 — Rejuvenation of Battery' => 'THE VOLITIONAL META-PROGRAMS',
            'MP 34 – Work Preference' => 'THE VOLITIONAL META-PROGRAMS',
            'MP 39 – Hierarchical Dominance' => 'THE VOLITIONAL META-PROGRAMS',
            'MP 40 – Value Sort' => 'THE VOLITIONAL META-PROGRAMS',
            'MP 41 – Temper to Instruction' => 'THE VOLITIONAL META-PROGRAMS',
            'MP 50 — Morality Sort' => 'THE VOLITIONAL META-PROGRAMS',

            // COMMUNICATION META-PROGRAMS (36-43)
            'MP 12 — Communication Channel Preference' => 'COMMUNICATION META-PROGRAMS',
            'MP 14 — Referencing Style' => 'COMMUNICATION META-PROGRAMS',
            'MP 16 — Somatic Response Style' => 'COMMUNICATION META-PROGRAMS',
            'MP 28 — People Convincer Sort' => 'COMMUNICATION META-PROGRAMS',
            'MP 30 – Affiliation & Management' => 'COMMUNICATION META-PROGRAMS',
            'MP 31 – Communication Stance' => 'COMMUNICATION META-PROGRAMS',
            'MP 33 – Somatic Response' => 'COMMUNICATION META-PROGRAMS',
            'MP 38 – Social Presentation' => 'COMMUNICATION META-PROGRAMS',

            // HIGHER META-PROGRAM (44-50)
            'MP 32 – General Response' => 'HIGHER META-PROGRAM',
            'MP 44 — Status Sort' => 'HIGHER META-PROGRAM',
            'MP 45 – Self-Integrity' => 'HIGHER META-PROGRAM',
            'MP 46 – Time Processing' => 'HIGHER META-PROGRAM',
            'MP 47 – Time Experience' => 'HIGHER META-PROGRAM',
            'MP 48 — Time Access Sort' => 'HIGHER META-PROGRAM',
            'MP 51 — Causation Sort' => 'HIGHER META-PROGRAM',
        ];

        $mpMap = [];
        foreach ($metaPrograms as $mp) {
            $kategoriName = $mpKategoriMap[$mp['name']] ?? 'THE MENTAL META-PROGRAMS';
            $kategori = $kategoriMap[$kategoriName];

            $model = MetaProgram::create([
                'name' => $mp['name'],
                'slug' => $mp['slug'],
                'kategori_meta_program_id' => $kategori->id,
                'order' => $mp['order'],
            ]);
            $mpMap[$mp['name']] = $model;
            $this->command->info("  Created: {$mp['name']} (ID: {$model->id})");
        }

        $this->command->info('Total Meta Programs created: ' . count($mpMap));

        // Import Sub Meta Programs from JSON file
        $this->command->info('Creating Sub Meta Programs...');

        $completeJsonPath = database_path('seeders/complete_data.json');

        if (file_exists($completeJsonPath)) {
            $completeData = json_decode(file_get_contents($completeJsonPath), true);
            $this->importSubMetaProgramsFromJSON($completeData, $mpMap);
        } else {
            $this->command->warn('complete_data.json not found.');
        }

        // Import LIMITED Questions from JSON file (20 per category)
        $this->command->info('Creating Questions (20 per category)...');

        if (file_exists($completeJsonPath)) {
            $questionsData = json_decode(file_get_contents($completeJsonPath), true);
            $this->importLimitedQuestionsFromJSON($questionsData, $course, $mpMap, 20);
        } else {
            $this->command->warn('complete_data.json not found.');
        }

        $this->command->info('Meta Programs seeding completed!');
    }

    private function importSubMetaProgramsFromJSON($data, $mpMap)
    {
        $subMetaCount = 0;
        $skippedCount = 0;

        foreach ($data['sub_metas'] as $smData) {
            $mpName = $smData['meta_program'];
            $mp = $mpMap[$mpName] ?? null;

            if (!$mp) {
                $skippedCount++;
                if ($skippedCount <= 5) {
                    $this->command->warn("  MP not found for SubMeta: {$mpName}");
                }
                continue;
            }

            // Create Sub Meta Program
            SubMetaProgram::create([
                'meta_program_id' => $mp->id,
                'name' => $smData['name'],
                'slug' => $smData['slug'],
                'description' => $smData['description'] ?? '',
                'order' => $smData['order'],
                'is_active' => true,
            ]);

            $subMetaCount++;
        }

        $this->command->info("Total Sub Meta Programs created: {$subMetaCount}");
        if ($skippedCount > 0) {
            $this->command->warn("Skipped Sub Metas (MP not found): {$skippedCount}");
        }
    }

    private function importLimitedQuestionsFromJSON($data, $course, $mpMap, $limitPerCategory = 20)
    {
        // Group questions by kategori
        $questionsByKategori = [];

        foreach ($data['questions'] as $qData) {
            $kategoriName = $qData['kategori'];
            if (!isset($questionsByKategori[$kategoriName])) {
                $questionsByKategori[$kategoriName] = [];
            }
            $questionsByKategori[$kategoriName][] = $qData;
        }

        $questionCount = 0;
        $skippedCount = 0;

        // Import only first N questions per kategori
        foreach ($questionsByKategori as $kategoriName => $questions) {
            $this->command->info("Processing kategori: {$kategoriName}");

            // Take only first N questions
            $limitedQuestions = array_slice($questions, 0, $limitPerCategory);

            foreach ($limitedQuestions as $qData) {
                $mpName = $qData['meta_program'];
                $mp = $mpMap[$mpName] ?? null;

                if (!$mp) {
                    $skippedCount++;
                    if ($skippedCount <= 5) {
                        $this->command->warn("  MP not found: {$mpName}");
                    }
                    continue;
                }

                // Create question with format [MP N — Name — Sub]
                $questionText = "[{$mpName} — {$qData['sub_meta']}] {$qData['pertanyaan']}";

                $question = Question::create([
                    'course_id' => $course->id,
                    'question_text' => $questionText,
                    'scale_description' => $qData['keterangan'] ?? '',
                    'order' => $qData['order'],
                    'is_active' => true,
                ]);

                // Create options with scores from Excel
                $options = [
                    ['text' => 'Sangat Setuju', 'order' => 6, 'score' => $qData['skala']['sangat_setuju'] ?? 6],
                    ['text' => 'Setuju', 'order' => 5, 'score' => $qData['skala']['setuju'] ?? 5],
                    ['text' => 'Agak Setuju', 'order' => 4, 'score' => $qData['skala']['agak_setuju'] ?? 4],
                    ['text' => 'Agak Tidak Setuju', 'order' => 3, 'score' => $qData['skala']['agak_tidak_setuju'] ?? 3],
                    ['text' => 'Tidak Setuju', 'order' => 2, 'score' => $qData['skala']['tidak_setuju'] ?? 2],
                    ['text' => 'Sangat Tidak Setuju', 'order' => 1, 'score' => $qData['skala']['sangat_tidak_setuju'] ?? 1],
                ];

                foreach ($options as $opt) {
                    QuestionOption::create([
                        'question_id' => $question->id,
                        'option_text' => $opt['text'],
                        'order' => $opt['order'],
                        'score' => $opt['score'],
                        'talent_type' => '',
                    ]);
                }

                $questionCount++;
            }

            $this->command->info("  Imported " . count($limitedQuestions) . " questions for {$kategoriName}");
        }

        $this->command->info("Total questions created: {$questionCount}");
        if ($skippedCount > 0) {
            $this->command->warn("Skipped questions (MP not found): {$skippedCount}");
        }
    }
}

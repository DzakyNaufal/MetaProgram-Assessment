<?php

namespace Database\Seeders;

use App\Models\KategoriMetaProgram;
use App\Models\MetaProgram;
use App\Models\SubMetaProgram;
use App\Models\PertanyaanMetaProgram;
use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CreateQuestionsFromExcelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Load Excel data
        $spreadsheet = IOFactory::load(base_path('Question MP_Formatted.xlsx'));
        $worksheet = $spreadsheet->getActiveSheet();
        $dataArray = $worksheet->toArray();

        // Get kategori and sub MP mapping
        $kategoriModels = KategoriMetaProgram::all()->keyBy('name');
        $subMpModels = SubMetaProgram::with('metaProgram')->get()->keyBy(function($item) {
            return strtolower(trim($item->name));
        });

        // Create a mapping from Excel Meta Program names to our new names
        $mpNameMapping = [
            'MP 1 — Chunk Size' => 'Chunk Size',
            'MP 3 — Representational System Processing' => 'Representational System Processing',
            'MP 4 & 5 — Information Gathering Sort' => 'Information Gathering Sort',
            'MP 6 — Perceptual Sort' => 'Perceptual Sort',
            'MP 9 — Focus Sort' => 'Focus Sort',
            'MP 10 — Philosophical Direction' => 'Philosophical Direction',
            'MP 11 — Reality Structure Sort' => 'Reality Structure Sort',
            'MP 31 — Comparison Sort' => 'Comparison Sort',
            'MP 37 — Perceptual Sort (Internal vs. External Reference)' => 'Perceptual Sort Internal vs External Reference',
            'MP 38 — Perceptual Sort (Self vs. Other)' => 'Perceptual Sort Self vs Other',
            'MP 46 — Time Orientation' => 'Time Orientation',
            'MP 47 — Time Tense' => 'Time Tense',
            'MP 48 — Time Access Sort' => 'Time Access Sort',
            'MP 51 — Causation Sort' => 'Causation Sort',
            'MP 7 — Attribution Sort' => 'Attribution Sort',
            'MP 8 — Perceptual Durability Sort' => 'Perceptual Durability Sort',
            'MP 13 — Stress Coping Sort' => 'Stress Coping Sort',
            'MP 15 — Emotional State' => 'Emotional State',
            'MP 18 — Emotional Direction Sort' => 'Emotional Direction Sort',
            'MP 19 — Emotional Intensity Sort' => 'Emotional Intensity Sort',
            'MP 36 — Association Sort' => 'Association Sort',
            'MP 40 — Emotional Intensity Level' => 'Emotional Intensity Level',
            'MP 45 — Self-Esteem Sort' => 'Self-Esteem Sort',
            'MP 49 — Ego Strength' => 'Ego Strength',
            'MP 20 — Motivation Direction' => 'Motivation Direction',
            'MP 21 — Adaptation Style' => 'Adaptation Style',
            'MP 22 — Adaptation Sort' => 'Adaptation Sort',
            'MP 23 — Modal Operators' => 'Modal Operators',
            'MP 24 — Preference Sort' => 'Preference Sort',
            'MP 25 — Goal Striving Sort' => 'Goal Striving Sort',
            'MP 41 — Decision Sort' => 'Decision Sort',
            'MP 43 — State Sort' => 'State Sort',
            'MP 50 — Morality Sort' => 'Morality Sort',
            'MP 2 — Relationship Sort' => 'Relationship Sort',
            'MP 12 — Communication Channel Preference' => 'Communication Channel Preference',
            'MP 14 — Referencing Style' => 'Referencing Style',
            'MP 28 — People Convincer Sort' => 'People Convincer Sort',
            'MP 32 — Authority Sort' => 'Authority Sort',
            'MP 33 — Rapport Sort' => 'Rapport Sort',
            'MP 34 — Knowledge / Competency Sort' => 'Knowledge Competency Sort',
            'MP 39 — Relationship Context' => 'Relationship Context',
            'MP 16 — Somatic Response Style' => 'Somatic Response Style',
            'MP 17 — Convincer Sort' => 'Convincer Sort',
            'MP 26 — Buying Sort' => 'Buying Sort',
            'MP 27 — Responsibility Sort' => 'Responsibility Sort',
            'MP 29 — Rejuvenation of Battery' => 'Rejuvenation of Battery',
            'MP 30 — Affiliation / Management Sort' => 'Affiliation Management Sort',
            'MP 35 — Activity Level Sort' => 'Activity Level Sort',
            'MP 42 — Action Sort' => 'Action Sort',
            'MP 44 — Status Sort' => 'Status Sort',
        ];

        // Group questions by kategori
        $kategoriQuestions = [];
        foreach ($dataArray as $i => $row) {
            if ($i === 0) continue;

            $kategori = $row[0] ?? 'Unknown';
            $mpNameExcel = $row[1] ?? 'Unknown';
            $subMetaProgram = $row[2] ?? '';
            $pertanyaan = $row[3] ?? '';
            $keterangan = $row[10] ?? '';

            if (!isset($kategoriQuestions[$kategori])) {
                $kategoriQuestions[$kategori] = [];
            }

            $kategoriQuestions[$kategori][] = [
                'mpExcel' => $mpNameExcel,
                'subMetaProgram' => $subMetaProgram,
                'pertanyaan' => $pertanyaan,
                'keterangan' => $keterangan
            ];
        }

        // Create 20 questions per kategori
        $totalCreated = 0;

        foreach ($kategoriQuestions as $kategoriName => $questions) {
            $kategoriId = $kategoriModels[$kategoriName]->id;

            // Take only first 20 questions
            $selectedQuestions = array_slice($questions, 0, 20);

            $this->command->info("Kategori {$kategoriName} (ID: {$kategoriId})");

            foreach ($selectedQuestions as $q) {
                $mpNameExcel = $q['mpExcel'];
                $subName = $q['subMetaProgram'];
                $pertanyaanText = $q['pertanyaan'];
                $keterangan = $q['keterangan'];

                // Get the new MP name
                $mpNameNew = $mpNameMapping[$mpNameExcel] ?? $mpNameExcel;

                // Find Meta Program
                $metaProgram = MetaProgram::where('kategori_meta_program_id', $kategoriId)
                    ->where('name', $mpNameNew)
                    ->first();

                if (!$metaProgram) {
                    $this->command->warn("  WARNING: MP not found: {$mpNameNew}");
                    continue;
                }

                // Find SubMP (by name, case insensitive)
                $subMp = SubMetaProgram::where('meta_program_id', $metaProgram->id)
                    ->whereRaw('LOWER(name) = ?', [strtolower($subName)])
                    ->first();

                if (!$subMp) {
                    $this->command->warn("  WARNING: SubMP not found: {$subName}");
                    continue;
                }

                // Check if question is negatif
                $isNegatif = strpos($keterangan, 'negatif') !== false;

                PertanyaanMetaProgram::create([
                    'meta_program_id' => $metaProgram->id,
                    'sub_meta_program_id' => $subMp->id,
                    'pertanyaan' => $pertanyaanText,
                    'keterangan' => $keterangan,
                    'is_negatif' => $isNegatif,
                    'is_active' => true
                ]);

                $totalCreated++;
            }

            $this->command->info("  Created: " . count($selectedQuestions) . " questions");
            $this->command->newLine();
        }

        $this->command->info('=== SUMMARY ===');
        $this->command->info("Total questions created: {$totalCreated}");
    }
}

<?php

namespace Database\Seeders;

use App\Models\KategoriMetaProgram;
use App\Models\MetaProgram;
use App\Models\SubMetaProgram;
use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CreateMetaProgramsFromExcelSeeder extends Seeder
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

        // Get kategori models
        $kategoriModels = KategoriMetaProgram::all()->keyBy('name');

        // Group by kategori and meta program
        $kategoriData = [];
        foreach ($dataArray as $i => $row) {
            if ($i === 0) continue; // Skip header

            $kategori = $row[0] ?? 'Unknown';
            $metaProgram = $row[1] ?? 'Unknown';
            $subMetaProgram = $row[2] ?? '';

            if (!isset($kategoriData[$kategori])) {
                $kategoriData[$kategori] = [];
            }
            if (!isset($kategoriData[$kategori][$metaProgram])) {
                $kategoriData[$kategori][$metaProgram] = [];
            }

            if (!in_array($subMetaProgram, $kategoriData[$kategori][$metaProgram])) {
                $kategoriData[$kategori][$metaProgram][] = $subMetaProgram;
            }
        }

        $mpSlugMap = [];
        $totalMP = 0;
        $totalSubMP = 0;

        foreach ($kategoriData as $kategoriName => $metaPrograms) {
            $kategoriId = $kategoriModels[$kategoriName]->id;
            $mpSlugMap[$kategoriId] = [];
            $mpCounter = 1;

            foreach ($metaPrograms as $mpNameWithPrefix => $subMps) {
                // Remove "MP" prefix and numbers (e.g., "MP 1 — " or "MP 3 — ")
                $mpName = preg_replace('/^MP\s*\d+\s*[—-]\s*/', '', $mpNameWithPrefix);
                $mpName = trim($mpName);

                // Create MP slug
                $baseSlug = strtolower(str_replace([' ', '.', '/'], '-', $mpName));
                $baseSlug = preg_replace('/-+/', '-', trim($baseSlug, '-'));
                $mpSlug = $baseSlug;
                $suffix = 1;
                while (isset($mpSlugMap[$kategoriId][$mpSlug])) {
                    $mpSlug = $baseSlug . '-' . $suffix++;
                }
                $mpSlugMap[$kategoriId][$mpSlug] = true;

                $metaProgram = MetaProgram::create([
                    'kategori_meta_program_id' => $kategoriId,
                    'name' => $mpName,
                    'slug' => $mpSlug,
                    'description' => 'Meta Program ' . $mpCounter++ . ' untuk ' . $kategoriName,
                    'scoring_type' => 'multi',
                    'is_active' => true
                ]);

                $this->command->info("Kategori {$kategoriId} - MP: {$mpName} (ID: {$metaProgram->id})");
                $totalMP++;

                $subCounter = 1;
                foreach ($subMps as $subName) {
                    $subSlug = strtolower(str_replace([' ', '–', '—'], '-', $subName));
                    $subSlug = preg_replace('/-+/', '-', trim($subSlug, '-'));

                    SubMetaProgram::create([
                        'meta_program_id' => $metaProgram->id,
                        'name' => $subName,
                        'slug' => $subSlug,
                        'description' => 'Sub Meta Program ' . $subCounter++ . ': ' . $subName,
                        'is_active' => true
                    ]);

                    $totalSubMP++;
                }
            }
        }

        $this->command->newLine();
        $this->command->info('=== SUMMARY ===');
        $this->command->info("Total Meta Programs: {$totalMP}");
        $this->command->info("Total Sub Meta Programs: {$totalSubMP}");
    }
}

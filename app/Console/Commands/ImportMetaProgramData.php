<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\KategoriMetaProgram;
use App\Models\MetaProgram;
use App\Models\SubMetaProgram;
use App\Models\PertanyaanMetaProgram;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportMetaProgramData extends Command
{
    protected $signature = 'meta-program:import {file=Question MP.xlsx : Path to Excel file} {--force : Skip confirmation and delete old data}';

    protected $description = 'Import meta program data from Excel file';

    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("File not found: {$file}");
            return 1;
        }

        $this->info("Reading file: {$file}");

        try {
            $spreadsheet = IOFactory::load($file);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            $this->info("Found " . (count($rows) - 2) . " rows of data");

            // Skip first 2 rows (headers and scale headers)
            $headers = array_shift($rows);
            $scaleHeaders = array_shift($rows);

            $this->info("Headers: " . implode(', ', array_filter($headers)));

            if (!$this->option('force') && !$this->confirm('Do you want to delete all existing meta program data before importing?')) {
                $this->info('Import cancelled.');
                return 0;
            }

            // Delete old data
            $this->info('Deleting old data...');
            PertanyaanMetaProgram::query()->delete();
            SubMetaProgram::query()->delete();
            MetaProgram::query()->delete();
            KategoriMetaProgram::query()->delete();
            $this->info('Old data deleted.');

            $this->newLine();

            // Parse and import data
            $this->importData($rows);

            $this->newLine();
            $this->info('✅ Import completed successfully!');

            return 0;

        } catch (\Exception $e) {
            $this->error("Error importing data: " . $e->getMessage());
            $this->error($e->getTraceAsString());
            return 1;
        }
    }

    private function importData(array $rows)
    {
        // Column indices based on Excel structure
        // 0: Kategori Meta Program
        // 1: Meta Program
        // 2: Sub Meta Program
        // 3: Pertanyaan
        // 4: Skala Sangat Setuju (6)
        // 5: Skala Setuju (5)
        // 6: Skala Agak Setuju (4)
        // 7: Skala Agak Tidak Setuju (3)
        // 8: Skala Tidak Setuju (2)
        // 9: Skala Sangat Tidak Setuju (1)
        // 10: Keterangan

        $categories = [];
        $metaPrograms = [];
        $subMetaPrograms = [];

        $this->info('Processing rows...');

        $bar = $this->output->createProgressBar(count($rows));
        $bar->start();

        // Track current values for fill-down
        $currentKategori = null;
        $currentMeta = null;
        $currentSub = null;

        $kategoriOrder = 0;
        $metaOrder = 0;
        $subOrder = 0;
        $pertanyaanOrder = 0;

        // First pass: collect all unique items with their relationships
        foreach ($rows as $row) {
            // Skip completely empty rows
            if (empty(array_filter($row))) {
                continue;
            }

            $kategoriName = !empty($row[0]) ? trim($row[0]) : null;
            $metaName = !empty($row[1]) ? trim($row[1]) : null;
            $subName = !empty($row[2]) ? trim($row[2]) : null;
            $pertanyaan = !empty($row[3]) ? trim($row[3]) : null;

            // Update current values (fill-down behavior)
            if ($kategoriName) $currentKategori = $kategoriName;
            if ($metaName) $currentMeta = $metaName;
            if ($subName) $currentSub = $subName;

            // Only process rows with questions
            if ($pertanyaan) {
                // Store category
                if ($currentKategori && !isset($categories[$currentKategori])) {
                    $categories[$currentKategori] = null;
                }

                // Store meta program with its category
                if ($currentMeta && !isset($metaPrograms[$currentMeta])) {
                    $metaPrograms[$currentMeta] = [
                        'kategori' => $currentKategori,
                        'id' => null,
                        'subs' => []
                    ];
                }

                // Store sub meta program with its meta program
                if ($currentSub && $currentMeta && !isset($metaPrograms[$currentMeta]['subs'][$currentSub])) {
                    $key = $currentMeta . '|' . $currentSub;
                    $subMetaPrograms[$key] = [
                        'meta' => $currentMeta,
                        'name' => $currentSub,
                        'id' => null
                    ];
                }
            }
        }

        // Create categories
        foreach ($categories as $kategoriName => &$id) {
            $kategoriOrder++;
            $slug = $this->generateSlug($kategoriName);
            $kategori = KategoriMetaProgram::create([
                'name' => $kategoriName,
                'slug' => $slug,
                'description' => null,
                'order' => $kategoriOrder,
                'is_active' => true,
            ]);
            $id = $kategori->id;
        }

        // Create meta programs
        foreach ($metaPrograms as $metaName => &$metaData) {
            $metaOrder++;
            $slug = $this->generateSlug($metaName);
            $kategoriId = $categories[$metaData['kategori']] ?? null;

            $meta = MetaProgram::create([
                'kategori_meta_program_id' => $kategoriId,
                'name' => $metaName,
                'slug' => $slug,
                'description' => null,
                'scoring_type' => 'inverse',
                'order' => $metaOrder,
                'is_active' => true,
            ]);
            $metaData['id'] = $meta->id;
        }

        // Create sub meta programs
        foreach ($subMetaPrograms as &$subData) {
            $subOrder++;
            $slug = $this->generateSlug($subData['name']);
            $metaProgramId = $metaPrograms[$subData['meta']]['id'] ?? null;

            $sub = SubMetaProgram::create([
                'meta_program_id' => $metaProgramId,
                'name' => $subData['name'],
                'slug' => $slug,
                'description' => null,
                'order' => $subOrder,
                'is_active' => true,
            ]);
            $subData['id'] = $sub->id;
        }

        // Reset for second pass
        $currentKategori = null;
        $currentMeta = null;
        $currentSub = null;

        // Second pass: create questions
        foreach ($rows as $row) {
            $bar->advance();

            // Skip completely empty rows
            if (empty(array_filter($row))) {
                continue;
            }

            $kategoriName = !empty($row[0]) ? trim($row[0]) : null;
            $metaName = !empty($row[1]) ? trim($row[1]) : null;
            $subName = !empty($row[2]) ? trim($row[2]) : null;
            $pertanyaan = !empty($row[3]) ? trim($row[3]) : null;
            $keterangan = !empty($row[10]) ? trim($row[10]) : null;

            // Update current values (fill-down behavior)
            if ($kategoriName) $currentKategori = $kategoriName;
            if ($metaName) $currentMeta = $metaName;
            if ($subName) $currentSub = $subName;

            // Only process rows with questions
            if (!$pertanyaan || !$currentMeta) {
                continue;
            }

            $pertanyaanOrder++;
            $metaProgramId = $metaPrograms[$currentMeta]['id'] ?? null;

            // Find sub meta program ID
            $subKey = $currentMeta . '|' . $currentSub;
            $subMetaProgramId = null;
            if ($currentSub && isset($subMetaPrograms[$subKey])) {
                $subMetaProgramId = $subMetaPrograms[$subKey]['id'];
            }

            // Check if negative based on keterangan
            $isNegatif = stripos($keterangan, 'negatif') !== false ||
                         stripos($keterangan, 'negative') !== false ||
                         stripos($keterangan, 'inverse') !== false;

            // Get scale values from columns
            $skalaSangatSetuju = (int)($row[4] ?? 6);
            $skalaSetuju = (int)($row[5] ?? 5);
            $skalaAgakSetuju = (int)($row[6] ?? 4);
            $skalaAgakTidakSetuju = (int)($row[7] ?? 3);
            $skalaTidakSetuju = (int)($row[8] ?? 2);
            $skalaSangatTidakSetuju = (int)($row[9] ?? 1);

            // If marked as negatif and scale values look normal, invert is_negatif flag
            // The scale values in the Excel are already correct for each sub meta program
            // So is_negatif should be true if the scale is inverted (1-6 instead of 6-1)

            PertanyaanMetaProgram::create([
                'meta_program_id' => $metaProgramId,
                'sub_meta_program_id' => $subMetaProgramId,
                'pertanyaan' => $pertanyaan,
                'skala_sangat_setuju' => $skalaSangatSetuju,
                'skala_setuju' => $skalaSetuju,
                'skala_agak_setuju' => $skalaAgakSetuju,
                'skala_agak_tidak_setuju' => $skalaAgakTidakSetuju,
                'skala_tidak_setuju' => $skalaTidakSetuju,
                'skala_sangat_tidak_setuju' => $skalaSangatTidakSetuju,
                'keterangan' => $keterangan,
                'is_negatif' => $isNegatif,
                'order' => $pertanyaanOrder,
                'is_active' => true,
            ]);
        }

        $bar->finish();

        $this->newLine();
        $this->info("Summary:");
        $this->info("- Categories: " . count($categories));
        $this->info("- Meta Programs: " . count($metaPrograms));
        $this->info("- Sub Meta Programs: " . count($subMetaPrograms));

        $pertanyaanCount = PertanyaanMetaProgram::count();
        $this->info("- Questions: {$pertanyaanCount}");
    }

    private function generateSlug(string $string): string
    {
        $slug = strtolower($string);
        $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
        $slug = trim($slug, '-');

        if (empty($slug)) {
            $slug = 'slug-' . uniqid();
        }

        return $slug;
    }
}

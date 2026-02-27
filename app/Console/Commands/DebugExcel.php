<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DebugExcel extends Command
{
    protected $signature = 'debug:excel {file=Question MP.xlsx}';

    protected $description = 'Debug Excel file structure';

    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("File not found: {$file}");
            return 1;
        }

        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $rows = $worksheet->toArray();

        $this->info("Total rows: " . count($rows));
        $this->newLine();

        // Show first 20 rows
        $this->info("=== FIRST 20 ROWS ===");
        foreach (array_slice($rows, 0, 20) as $i => $row) {
            $this->info("Row " . ($i + 1) . ": " . json_encode($row, JSON_UNESCAPED_UNICODE));
        }

        $this->newLine();
        $this->info("=== ROWS WITH QUESTIONS (PERTANYAAN) ===");

        $questionCount = 0;
        $metaPrograms = [];
        $subMetaPrograms = [];

        foreach ($rows as $i => $row) {
            // Find column with "Pertanyaan"
            $pertanyaanCol = null;
            foreach ($row as $colIndex => $value) {
                if (stripos($value, 'ertanyaan') !== false && $i === 0) {
                    $pertanyaanCol = $colIndex;
                }
            }

            if ($i > 0 && $pertanyaanCol !== null && !empty($row[$pertanyaanCol])) {
                $questionCount++;
                $this->info("Row " . ($i + 1) . ": " . trim($row[$pertanyaanCol]));
            }
        }

        $this->newLine();
        $this->info("Total questions found: {$questionCount}");

        return 0;
    }
}

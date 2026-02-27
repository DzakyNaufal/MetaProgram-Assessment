<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

echo "=== DEBUGGING SINGLE-KATEGORI COURSE ===\n\n";

$courseSlug = 'assessment-kategori-5-pertumbuhan';

$course = \App\Models\Course::where('slug', $courseSlug)->first();

if ($course) {
    echo "Course: " . $course->title . "\n";
    echo "ID: " . $course->id . "\n";
    echo "Type: " . $course->type . "\n";
    echo "kategori_meta_program_id: " . ($course->kategori_meta_program_id ?? 'NULL') . "\n";
    echo "isSingleKategori(): " . ($course->isSingleKategori() ? 'TRUE' : 'FALSE') . "\n\n";

    // Check kategori
    $kategori = $course->kategoriMetaProgram;
    if ($kategori) {
        echo "Kategori: " . $kategori->name . " (slug: " . $kategori->slug . ")\n\n";
    }

    // Check questions
    echo "Checking questions for this course's kategori...\n";
    $metaProgramIds = \App\Models\MetaProgram::where('kategori_meta_program_id', $course->kategori_meta_program_id)
        ->where('is_active', true)
        ->pluck('id');

    echo "Meta Program IDs: " . json_encode($metaProgramIds->toArray()) . "\n";

    $pertanyaan = \App\Models\PertanyaanMetaProgram::whereIn('meta_program_id', $metaProgramIds)
        ->where('is_active', true)
        ->get();

    echo "Total Pertanyaan: " . $pertanyaan->count() . "\n\n";

    if ($pertanyaan->count() > 0) {
        echo "Sample pertanyaan:\n";
        foreach ($pertanyaan->take(3) as $p) {
            echo "- QID: " . $p->id . " - " . substr($p->pertanyaan, 0, 50) . "...\n";
        }
    }
} else {
    echo "Course not found!\n";
}

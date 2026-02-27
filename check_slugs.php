<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== SUB META PROGRAMS FOR REPRESENTATIONAL SYSTEM (ID: 104) ===\n";
$subs = App\Models\SubMetaProgram::where('meta_program_id', 104)
    ->orderBy('id')
    ->get(['id', 'name', 'slug']);

foreach ($subs as $s) {
    echo "ID: {$s->id} | Name: {$s->name} | Slug: {$s->slug}\n";
}

// Cek apakah ada data attempt untuk user
echo "\n=== CEK ATTEMPT ID 4 SCORES ===\n";
$attempt = App\Models\QuizAttempt::find(4);
$scores = json_decode($attempt->scores, true);
$individualScores = $scores['individual'] ?? [];

// Cek jawaban untuk pertanyaan Representational System (P207-P218)
echo "\nJawaban untuk P207-P218:\n";
for ($i = 207; $i <= 218; $i++) {
    $answer = $individualScores[$i] ?? 'NO ANSWER';
    echo "  P{$i}: {$answer}\n";
}

// Hitung per sub-MP
echo "\n=== PER SUB-MP CALCULATION ===\n";
$pertanyaan = App\Models\PertanyaanMetaProgram::with('subMetaProgram')
    ->where('meta_program_id', 104)
    ->where('is_active', true)
    ->orderBy('id')
    ->get();

$subScores = [];
foreach ($pertanyaan as $p) {
    $subName = $p->subMetaProgram ? $p->subMetaProgram->name : 'NO SUB';
    $subSlug = $p->subMetaProgram ? $p->subMetaProgram->slug : '';
    $answer = $individualScores[$p->id] ?? null;

    if ($answer !== null) {
        if (!isset($subScores[$subSlug])) {
            $subScores[$subSlug] = ['name' => $subName, 'total' => 0, 'count' => 0];
        }
        $subScores[$subSlug]['total'] += (int)$answer;
        $subScores[$subSlug]['count']++;
    }
}

foreach ($subScores as $slug => $data) {
    $avg = $data['count'] > 0 ? $data['total'] / $data['count'] : 0;
    echo "{$data['name']} ({$slug}): total={$data['total']}, count={$data['count']}, avg=" . round($avg, 2) . "\n";
}

<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Simulate ResultController logic
$attempt = App\Models\QuizAttempt::find(4);
$scoresData = json_decode($attempt->scores, true);
$individualScores = $scoresData['individual'] ?? [];

// Get kategori THE MENTAL META-PROGRAMS
$kategori = App\Models\KategoriMetaProgram::where('name', 'THE MENTAL META-PROGRAMS')->first();

echo "=== KATEGORI: {$kategori->name} ===\n";

// Get all meta programs in this kategori
$metaPrograms = App\Models\MetaProgram::where('kategori_meta_program_id', $kategori->id)
    ->where('is_active', true)
    ->with('subMetaPrograms')
    ->orderBy('id')
    ->get();

$subMpScores = [];

// First, collect all scores by Sub-MP
foreach ($metaPrograms as $mp) {
    echo "\nMP: {$mp->name} (ID: {$mp->id})\n";

    $pertanyaanList = App\Models\PertanyaanMetaProgram::where('meta_program_id', $mp->id)
        ->where('is_active', true)
        ->get();

    foreach ($pertanyaanList as $pertanyaan) {
        $questionId = $pertanyaan->id;
        $answer = $individualScores[$questionId] ?? null;

        if ($answer !== null) {
            $subMp = $pertanyaan->subMetaProgram;
            if ($subMp) {
                if (!isset($subMpScores[$subMp->id])) {
                    $subMpScores[$subMp->id] = [
                        'name' => $subMp->name,
                        'slug' => $subMp->slug,
                        'total_score' => 0,
                        'count' => 0,
                        'meta_program_id' => $mp->id,
                        'meta_program_name' => $mp->name,
                    ];
                }
                $subMpScores[$subMp->id]['total_score'] += (int)$answer;
                $subMpScores[$subMp->id]['count']++;
            }
        }
    }
}

echo "\n=== SUB MP SCORES ===\n";
foreach ($subMpScores as $id => $data) {
    echo "{$data['name']} ({$data['slug']}): count={$data['count']}, total={$data['total_score']}\n";
}

// Group by Meta Program and create pairs
$metaProgramPairs = [];

foreach ($metaPrograms as $mp) {
    echo "\n--- Processing MP: {$mp->name} ---\n";

    $mpSubMps = $mp->subMetaPrograms->sortBy('order');
    echo "Sub MPs count: " . $mpSubMps->count() . "\n";

    $mpSubMpScores = [];

    foreach ($mpSubMps as $subMp) {
        if (isset($subMpScores[$subMp->id])) {
            $data = $subMpScores[$subMp->id];
            $average = $data['count'] > 0 ? $data['total_score'] / $data['count'] : 3;
            $totalQuestions = $mp->pertanyaan->where('sub_meta_program_id', $subMp->id)->count();
            $percentage = $totalQuestions > 0 ? ($data['count'] / $totalQuestions) * 100 : 0;
            $maxScore = $totalQuestions * 6;
            $scorePercentage = $maxScore > 0 ? ($data['total_score'] / $maxScore) * 100 : 0;

            $mpSubMpScores[] = [
                'id' => $subMp->id,
                'name' => $data['name'],
                'slug' => $data['slug'],
                'average' => round($average, 0),
                'total_score' => round($data['total_score'], 1),
                'max_score' => $maxScore,
                'percentage' => round($percentage, 0),
                'score_percentage' => round($scorePercentage, 0),
            ];
            echo "  Added: {$data['name']} (avg=" . round($average, 0) . ")\n";
        } else {
            echo "  Skipped: {$subMp->name} (no data)\n";
        }
    }

    // Create pairs
    $pairs = [];
    $count = count($mpSubMpScores);
    echo "  Creating pairs from {$count} items\n";

    if ($count == 4) {
        // Four items: check for specific pairings
        $slug1 = $mpSubMpScores[0]['slug'] ?? '';
        $slug3 = $mpSubMpScores[2]['slug'] ?? '';

        // Special handling for Representational System
        if (in_array('kinesthetic', [$slug1, $mpSubMpScores[1]['slug'] ?? '', $slug3, $mpSubMpScores[3]['slug'] ?? ''])) {
            echo "  Using Representational System pairing\n";
            $kinesthetic = null;
            $visual = null;
            foreach ($mpSubMpScores as $smp) {
                if ($smp['slug'] === 'kinesthetic') $kinesthetic = $smp;
                if ($smp['slug'] === 'visual') $visual = $smp;
            }
            if ($kinesthetic && $visual) {
                $pairs[] = ['side1' => $kinesthetic, 'side2' => $visual];
                echo "    Pair 1: {$kinesthetic['name']} vs {$visual['name']}\n";
            }
            $remaining = array_filter($mpSubMpScores, function($smp) {
                return !in_array($smp['slug'], ['kinesthetic', 'visual']);
            });
            if (count($remaining) >= 2) {
                $pairs[] = ['side1' => array_values($remaining)[0], 'side2' => array_values($remaining)[1]];
                echo "    Pair 2: " . array_values($remaining)[0]['name'] . " vs " . array_values($remaining)[1]['name'] . "\n";
            }
        } else {
            // Default: pair adjacent
            $pairs[] = [
                'side1' => $mpSubMpScores[0],
                'side2' => $mpSubMpScores[1],
            ];
            echo "    Pair 1 (default): {$mpSubMpScores[0]['name']} vs {$mpSubMpScores[1]['name']}\n";
            if (isset($mpSubMpScores[2]) && isset($mpSubMpScores[3])) {
                $pairs[] = [
                    'side1' => $mpSubMpScores[2],
                    'side2' => $mpSubMpScores[3],
                ];
                echo "    Pair 2 (default): {$mpSubMpScores[2]['name']} vs {$mpSubMpScores[3]['name']}\n";
            }
        }
    }

    if (count($pairs) > 0) {
        $metaProgramPairs[] = [
            'meta_program_id' => $mp->id,
            'meta_program_name' => $mp->name,
            'pairs' => $pairs,
        ];
    }
}

echo "\n=== FINAL META PROGRAM PAIRS ===\n";
foreach ($metaProgramPairs as $mpp) {
    echo "\nMP: {$mpp['meta_program_name']}\n";
    foreach ($mpp['pairs'] as $idx => $pair) {
        echo "  Pair " . ($idx + 1) . ": ";
        echo $pair['side1']['name'] . " ({$pair['side1']['slug']}) vs ";
        echo $pair['side2']['name'] . " ({$pair['side2']['slug']})\n";
    }
}

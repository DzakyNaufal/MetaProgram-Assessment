<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== PERTANYAAN REPRESENTATIONAL SYSTEM PROCESSING ===\n";
$pertanyaan = App\Models\PertanyaanMetaProgram::with('subMetaProgram')
    ->where('meta_program_id', 104)
    ->where('is_active', true)
    ->orderBy('id')
    ->get();

echo "Total pertanyaan: " . $pertanyaan->count() . "\n";
foreach ($pertanyaan as $p) {
    $subName = $p->subMetaProgram ? $p->subMetaProgram->name : 'NO SUB';
    echo "  P{$p->id}: sub_meta_program_id={$p->sub_meta_program_id}, Sub={$subName}\n";
}

echo "\n=== CEK STRUKTUR TABEL ===\n";
echo "Cek kolom sub_meta_program_id di pertanyaan_meta_programs...\n";
$schema = \DB::select("DESCRIBE pertanyaan_meta_programs");
foreach ($schema as $col) {
    if (strpos($col->Field, 'sub') !== false || strpos($col->Field, 'meta') !== false) {
        echo "  {$col->Field} ({$col->Type})\n";
    }
}

<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== KATEGORI META PROGRAMS ===\n";
$kategoris = App\Models\KategoriMetaProgram::orderBy('order')->get();
foreach ($kategoris as $kat) {
    echo "\nKategori: {$kat->name} (ID: {$kat->id}, Order: {$kat->order})\n";

    $mps = App\Models\MetaProgram::where('kategori_meta_program_id', $kat->id)
        ->where('is_active', true)
        ->orderBy('id')
        ->get();

    foreach ($mps as $mp) {
        echo "  MP: {$mp->name} (ID: {$mp->id}, is_active: {$mp->is_active})\n";

        $subMps = App\Models\SubMetaProgram::where('meta_program_id', $mp->id)
            ->orderBy('id')
            ->get();

        foreach ($subMps as $sub) {
            echo "    Sub: {$sub->name} (ID: {$sub->id}, is_active: {$sub->is_active})\n";
        }
    }
}

echo "\n\n=== PERTANYAAN META PROGRAMS ===\n";
$pertanyaan = App\Models\PertanyaanMetaProgram::with('metaProgram')
    ->where('is_active', true)
    ->orderBy('id')
    ->get();

echo "Total pertanyaan aktif: " . $pertanyaan->count() . "\n";

foreach ($pertanyaan as $p) {
    $mpName = $p->metaProgram ? $p->metaProgram->name : 'NO MP';
    echo "  P{$p->id}: MP={$mpName}\n";
}

<?php

namespace Database\Seeders;

use App\Models\KategoriMetaProgram;
use App\Models\MetaProgram;
use App\Models\SubMetaProgram;
use App\Models\PertanyaanMetaProgram;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetaProgramTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Read JSON data
        $json = file_get_contents(database_path('seeders/meta_programs_data.json'));
        $data = json_decode($json, true);

        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing data
        PertanyaanMetaProgram::query()->delete();
        SubMetaProgram::query()->delete();
        MetaProgram::query()->delete();
        KategoriMetaProgram::query()->delete();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Track slugs to IDs
        $kategoriSlugMap = [];
        $metaProgramSlugMap = [];
        $subMetaProgramSlugMap = [];

        // Insert Kategori Meta Programs
        foreach ($data['kategori_meta_programs'] as $kategori) {
            $model = KategoriMetaProgram::create([
                'name' => $kategori['name'],
                'slug' => $kategori['slug'],
                'description' => $kategori['description'],
                'order' => $kategori['order'],
                'is_active' => $kategori['is_active'],
            ]);
            $kategoriSlugMap[$kategori['slug']] = $model->id;
        }

        // Insert Meta Programs
        foreach ($data['meta_programs'] as $mp) {
            $kategoriId = $kategoriSlugMap[$mp['kategori_slug']] ?? null;

            $model = MetaProgram::create([
                'kategori_meta_program_id' => $kategoriId,
                'name' => $mp['name'],
                'slug' => $mp['slug'],
                'description' => $mp['description'],
                'scoring_type' => $mp['scoring_type'],
                'order' => $mp['order'],
                'is_active' => $mp['is_active'],
            ]);
            $metaProgramSlugMap[$mp['slug']] = $model->id;
        }

        // Insert Sub Meta Programs
        foreach ($data['sub_meta_programs'] as $subMp) {
            $metaProgramId = $metaProgramSlugMap[$subMp['meta_program_slug']] ?? null;

            $model = SubMetaProgram::create([
                'meta_program_id' => $metaProgramId,
                'name' => $subMp['name'],
                'slug' => $subMp['slug'],
                'description' => $subMp['description'],
                'order' => $subMp['order'],
                'is_active' => $subMp['is_active'],
            ]);
            $subMetaProgramSlugMap[$subMp['slug']] = $model->id;
        }

        // Insert Pertanyaan Meta Programs
        foreach ($data['pertanyaan_meta_programs'] as $pertanyaan) {
            $metaProgramId = $metaProgramSlugMap[$pertanyaan['meta_program_slug']] ?? null;
            $subMetaProgramId = null;

            if (!empty($pertanyaan['sub_meta_program_slug'])) {
                $subMetaProgramId = $subMetaProgramSlugMap[$pertanyaan['sub_meta_program_slug']] ?? null;
            }

            PertanyaanMetaProgram::create([
                'meta_program_id' => $metaProgramId,
                'sub_meta_program_id' => $subMetaProgramId,
                'pertanyaan' => $pertanyaan['pertanyaan'],
                'skala_sangat_setuju' => $pertanyaan['skala_sangat_setuju'],
                'skala_setuju' => $pertanyaan['skala_setuju'],
                'skala_agak_setuju' => $pertanyaan['skala_agak_setuju'],
                'skala_agak_tidak_setuju' => $pertanyaan['skala_agak_tidak_setuju'],
                'skala_tidak_setuju' => $pertanyaan['skala_tidak_setuju'],
                'skala_sangat_tidak_setuju' => $pertanyaan['skala_sangat_tidak_setuju'],
                'keterangan' => $pertanyaan['keterangan'],
                'is_negatif' => $pertanyaan['is_negatif'],
                'order' => $pertanyaan['order'],
                'is_active' => $pertanyaan['is_active'],
            ]);
        }

        $this->command->info('Successfully seeded Meta Programs data from Excel.');
        $this->command->info('Kategori: ' . count($data['kategori_meta_programs']));
        $this->command->info('Meta Programs: ' . count($data['meta_programs']));
        $this->command->info('Sub Meta Programs: ' . count($data['sub_meta_programs']));
        $this->command->info('Pertanyaan: ' . count($data['pertanyaan_meta_programs']));
    }
}

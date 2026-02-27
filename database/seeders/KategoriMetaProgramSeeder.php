<?php

namespace Database\Seeders;

use App\Models\KategoriMetaProgram;
use Illuminate\Database\Seeder;

class KategoriMetaProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        KategoriMetaProgram::query()->delete();

        $kategori = [
            [
                'name' => 'THE MENTAL META-PROGRAMS',
                'slug' => 'mental-meta-programs',
                'description' => 'Meta programs yang terkait dengan cara proses mental, berpikir, dan kognitif',
                'order' => 1,
                'is_active' => true,
                'timer_duration' => 50,
            ],
            [
                'name' => 'THE EMOTIONAL META-PROGRAMS',
                'slug' => 'emotional-meta-programs',
                'description' => 'Meta programs yang terkait dengan pola emosional dan respon emosi',
                'order' => 2,
                'is_active' => true,
                'timer_duration' => 45,
            ],
            [
                'name' => 'THE VOLITIONAL META-PROGRAMS',
                'slug' => 'volitional-meta-programs',
                'description' => 'Meta programs yang terkait dengan motivasi, keinginan, dan kemauan',
                'order' => 3,
                'is_active' => true,
                'timer_duration' => 40,
            ],
            [
                'name' => 'COMMUNICATION META-PROGRAMS',
                'slug' => 'communication-meta-programs',
                'description' => 'Meta programs yang terkait dengan gaya komunikasi dan interaksi',
                'order' => 4,
                'is_active' => true,
                'timer_duration' => 50,
            ],
            [
                'name' => 'HIGHER META-PROGRAMS',
                'slug' => 'higher-meta-programs',
                'description' => 'Meta programs tingkat tinggi yang mencakup orientasi waktu, realitas, dan kesadaran diri',
                'order' => 5,
                'is_active' => true,
                'timer_duration' => 45,
            ],
        ];

        foreach ($kategori as $kat) {
            KategoriMetaProgram::create($kat);
        }

        $this->command->info('Successfully seeded ' . count($kategori) . ' Kategori Meta Programs.');
    }
}

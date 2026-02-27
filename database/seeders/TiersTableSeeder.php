<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Tier;

class TiersTableSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama jika ada - dengan menangani constraint
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Tier::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Buat data dummy tier
        $tiers = [
            [
                'name' => 'Free',
                'price' => 0,
                'description' => 'Akses gratis ke beberapa course pilihan',
                'features' => json_encode([
                    'Akses beberapa course gratis',
                    'Quiz dasar',
                    'Laporan sederhana'
                ]),
                'is_recommended' => false,
                'is_active' => true,
                'duration_days' => null, // lifetime
            ],
            [
                'name' => 'Standard',
                'price' => 99000,
                'description' => 'Akses semua course + konsultasi WhatsApp',
                'features' => json_encode([
                    'Akses semua course',
                    'Akses semua pertanyaan',
                    'Konsultasi via WhatsApp',
                    'Report lengkap',
                    'Support email'
                ]),
                'is_recommended' => true,
                'is_active' => true,
                'duration_days' => 30, // 30 hari
            ],
            [
                'name' => 'Premium',
                'price' => 299000,
                'description' => 'Akses lifetime semua fitur',
                'features' => json_encode([
                    'Akses lifetime semua course',
                    'Konsultasi prioritas WhatsApp',
                    'Report premium dengan detail analisis',
                    'Support prioritas',
                    'Update konten gratis selamanya'
                ]),
                'is_recommended' => false,
                'is_active' => true,
                'duration_days' => null, // lifetime
            ]
        ];

        foreach ($tiers as $tier) {
            Tier::create($tier);
        }
    }
}

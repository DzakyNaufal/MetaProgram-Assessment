<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get category IDs
        $categories = [
            'pengambilan-keputusan' => \App\Models\Category::where('slug', 'pengambilan-keputusan')->first()->id,
            'komunikasi' => \App\Models\Category::where('slug', 'komunikasi')->first()->id,
            'kerja-sama-tim' => \App\Models\Category::where('slug', 'kerja-sama-tim')->first()->id,
            'pemecahan-masalah' => \App\Models\Category::where('slug', 'pemecahan-masalah')->first()->id,
            'kepemimpinan' => \App\Models\Category::where('slug', 'kepemimpinan')->first()->id,
            'inovasi' => \App\Models\Category::where('slug', 'inovasi')->first()->id,
        ];

        // Get tier IDs
        $tiers = [
            'free' => null, // For free courses
            'basic' => \App\Models\Tier::where('name', 'Basic')->first()->id,
            'premium' => \App\Models\Tier::where('name', 'Premium')->first()->id,
            'enterprise' => \App\Models\Tier::where('name', 'Enterprise')->first()->id,
        ];

        $courses = [
            // Category: Pengambilan Keputusan
            [
                'category_id' => $categories['pengambilan-keputusan'],
                'tier_id' => $tiers['free'],
                'title' => 'Talenta Cara Memperoleh Informasi',
                'slug' => 'talenta-cara-memperoleh-informasi',
                'description' => 'Assessment untuk mengetahui bagaimana seseorang memperoleh dan memproses informasi dalam pengambilan keputusan',
                'thumbnail' => 'thumbnails/decision-making-info.jpg',
                'estimated_time' => 15,
                'is_active' => true,
            ],
            [
                'category_id' => $categories['pengambilan-keputusan'],
                'tier_id' => $tiers['premium'],
                'title' => 'Talenta Proses Pengambilan Keputusan',
                'slug' => 'talenta-proses-pengambilan-keputusan',
                'description' => 'Assessment untuk mengetahui bagaimana seseorang memproses informasi dan membuat keputusan',
                'thumbnail' => 'thumbnails/decision-making-process.jpg',
                'estimated_time' => 15,
                'is_active' => true,
            ],
            [
                'category_id' => $categories['pengambilan-keputusan'],
                'tier_id' => $tiers['premium'],
                'title' => 'Talenta Gaya Analisis',
                'slug' => 'talenta-gaya-analisis',
                'description' => 'Assessment untuk mengetahui gaya analisis seseorang dalam menghadapi masalah',
                'thumbnail' => 'thumbnails/analysis-style.jpg',
                'estimated_time' => 15,
                'is_active' => true,
            ],

            // Category: Komunikasi
            [
                'category_id' => $categories['komunikasi'],
                'tier_id' => $tiers['free'],
                'title' => 'Talenta Gaya Komunikasi',
                'slug' => 'talenta-gaya-komunikasi',
                'description' => 'Assessment untuk mengetahui gaya komunikasi seseorang dalam berinteraksi',
                'thumbnail' => 'thumbnails/communication-style.jpg',
                'estimated_time' => 15,
                'is_active' => true,
            ],
            [
                'category_id' => $categories['komunikasi'],
                'tier_id' => $tiers['premium'],
                'title' => 'Talenta Presentasi',
                'slug' => 'talenta-presentasi',
                'description' => 'Assessment untuk mengetahui kemampuan seseorang dalam menyampaikan informasi secara lisan',
                'thumbnail' => 'thumbnails/presentation.jpg',
                'estimated_time' => 15,
                'is_active' => true,
            ],
            [
                'category_id' => $categories['komunikasi'],
                'tier_id' => $tiers['premium'],
                'title' => 'Talenta Negosiasi',
                'slug' => 'talenta-negosiasi',
                'description' => 'Assessment untuk mengetahui kemampuan seseorang dalam bernegosiasi',
                'thumbnail' => 'thumbnails/negotiation.jpg',
                'estimated_time' => 15,
                'is_active' => true,
            ],

            // Category: Kerja Sama Tim
            [
                'category_id' => $categories['kerja-sama-tim'],
                'tier_id' => $tiers['free'],
                'title' => 'Talenta Peran dalam Tim',
                'slug' => 'talenta-peran-dalam-tim',
                'description' => 'Assessment untuk mengetahui peran yang paling sesuai dalam tim',
                'thumbnail' => 'thumbnails/team-role.jpg',
                'estimated_time' => 15,
                'is_active' => true,
            ],
            [
                'category_id' => $categories['kerja-sama-tim'],
                'tier_id' => $tiers['premium'],
                'title' => 'Talenta Kolaborasi',
                'slug' => 'talenta-kolaborasi',
                'description' => 'Assessment untuk mengetahui kemampuan seseorang dalam berkolaborasi',
                'thumbnail' => 'thumbnails/collaboration.jpg',
                'estimated_time' => 15,
                'is_active' => true,
            ],
            [
                'category_id' => $categories['kerja-sama-tim'],
                'tier_id' => $tiers['premium'],
                'title' => 'Talenta Konflik Tim',
                'slug' => 'talenta-konflik-tim',
                'description' => 'Assessment untuk mengetahui cara seseorang menangani konflik dalam tim',
                'thumbnail' => 'thumbnails/team-conflict.jpg',
                'estimated_time' => 15,
                'is_active' => true,
            ],

            // Category: Pemecahan Masalah
            [
                'category_id' => $categories['pemecahan-masalah'],
                'tier_id' => $tiers['free'],
                'title' => 'Talenta Kreativitas',
                'slug' => 'talenta-kreativitas',
                'description' => 'Assessment untuk mengetahui kemampuan seseorang dalam berpikir kreatif',
                'thumbnail' => 'thumbnails/creativity.jpg',
                'estimated_time' => 15,
                'is_active' => true,
            ],
            [
                'category_id' => $categories['pemecahan-masalah'],
                'tier_id' => $tiers['premium'],
                'title' => 'Talenta Analisis Masalah',
                'slug' => 'talenta-analisis-masalah',
                'description' => 'Assessment untuk mengetahui kemampuan seseorang dalam menganalisis masalah',
                'thumbnail' => 'thumbnails/problem-analysis.jpg',
                'estimated_time' => 15,
                'is_active' => true,
            ],
            [
                'category_id' => $categories['pemecahan-masalah'],
                'tier_id' => $tiers['premium'],
                'title' => 'Talenta Solusi Inovatif',
                'slug' => 'talenta-solusi-inovatif',
                'description' => 'Assessment untuk mengetahui kemampuan seseorang dalam mencari solusi inovatif',
                'thumbnail' => 'thumbnails/innovative-solutions.jpg',
                'estimated_time' => 15,
                'is_active' => true,
            ],

            // Category: Kepemimpinan
            [
                'category_id' => $categories['kepemimpinan'],
                'tier_id' => $tiers['free'],
                'title' => 'Talenta Gaya Kepemimpinan',
                'slug' => 'talenta-gaya-kepemimpinan',
                'description' => 'Assessment untuk mengetahui gaya kepemimpinan yang paling sesuai',
                'thumbnail' => 'thumbnails/leadership-style.jpg',
                'estimated_time' => 15,
                'is_active' => true,
            ],
            [
                'category_id' => $categories['kepemimpinan'],
                'tier_id' => $tiers['premium'],
                'title' => 'Talenta Pengambilan Risiko',
                'slug' => 'talenta-pengambilan-risiko',
                'description' => 'Assessment untuk mengetahui sikap seseorang terhadap pengambilan risiko',
                'thumbnail' => 'thumbnails/risk-taking.jpg',
                'estimated_time' => 15,
                'is_active' => true,
            ],
            [
                'category_id' => $categories['kepemimpinan'],
                'tier_id' => $tiers['premium'],
                'title' => 'Talenta Motivasi',
                'slug' => 'talenta-motivasi',
                'description' => 'Assessment untuk mengetahui kemampuan seseorang dalam memotivasi diri sendiri dan orang lain',
                'thumbnail' => 'thumbnails/motivation.jpg',
                'estimated_time' => 15,
                'is_active' => true,
            ],
        ];

        foreach ($courses as $course) {
            \App\Models\Course::updateOrCreate(
                ['slug' => $course['slug']],
                $course
            );
        }

        // Update existing courses that might not have tier_id set
        \App\Models\Course::whereNull('tier_id')
            ->where('title', 'like', '%Premium%')
            ->update(['tier_id' => $tiers['premium']]);

        \App\Models\Course::whereNull('tier_id')
            ->where('title', 'like', '%Advanced%')
            ->orWhere('title', 'like', '%Pro%')
            ->update(['tier_id' => $tiers['premium']]);
    }
}

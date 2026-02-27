<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Pengambilan Keputusan',
                'slug' => 'pengambilan-keputusan',
                'description' => 'Kemampuan membuat keputusan yang tepat berdasarkan informasi dan situasi yang ada',
                'icon' => 'decision-making',
                'color' => '#3498db',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Komunikasi',
                'slug' => 'komunikasi',
                'description' => 'Kemampuan menyampaikan informasi dengan jelas dan efektif',
                'icon' => 'communication',
                'color' => '#e74c3c',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Kerja Sama Tim',
                'slug' => 'kerja-sama-tim',
                'description' => 'Kemampuan bekerja sama dalam tim untuk mencapai tujuan bersama',
                'icon' => 'teamwork',
                'color' => '#2ecc71',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Pemecahan Masalah',
                'slug' => 'pemecahan-masalah',
                'description' => 'Kemampuan mengidentifikasi dan menyelesaikan masalah secara kreatif',
                'icon' => 'problem-solving',
                'color' => '#f39c12',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Kepemimpinan',
                'slug' => 'kepemimpinan',
                'description' => 'Kemampuan memimpin dan menginspirasi orang lain',
                'icon' => 'leadership',
                'color' => '#9b59b6',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Inovasi',
                'slug' => 'inovasi',
                'description' => 'Kemampuan berpikir kreatif dan mengembangkan ide-ide baru',
                'icon' => 'innovation',
                'color' => '#1abc9c',
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}

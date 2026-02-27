<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $testimonials = [
            [
                'quote' => 'Luar biasa! Saya akhirnya memahami potensi tersembunyi saya.',
                'author' => 'Budi Santoso'
            ],
            [
                'quote' => 'Alat assessment yang sangat akurat dan membantu dalam pengambilan keputusan.',
                'author' => 'Siti Aminah'
            ],
            [
                'quote' => 'Pengalaman pengguna yang luar biasa dan laporan yang sangat detail.',
                'author' => 'Ahmad Fauzi'
            ]
        ];

        $faqs = [
            [
                'question' => 'Apa itu Talent Mapping?',
                'answer' => 'Talent Mapping adalah proses mengidentifikasi dan menganalisis potensi serta kemampuan individu untuk mencocokkan mereka dengan peran yang paling sesuai.'
            ],
            [
                'question' => 'Berapa lama proses assessment?',
                'answer' => 'Proses assessment biasanya memakan waktu sekitar 30-60 menit tergantung pada kompleksitas dan kedalaman analisis yang dibutuhkan.'
            ],
            [
                'question' => 'Apakah hasil assessment dapat diandalkan?',
                'answer' => 'Ya, hasil assessment kami didasarkan pada metodologi ilmiah dan telah divalidasi secara statistik untuk memastikan akurasi dan keandalannya.'
            ]
        ];

        return view('home', compact('testimonials', 'faqs'));
    }
}

<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('GEMINI_API_KEY');
    }

    /**
     * Generate personal report using Gemini AI
     */
    public function generatePersonalReport(array $assessmentData): string
    {
        $prompt = $this->buildPrompt($assessmentData);

        try {
            $response = $this->client->post(
                "https://openrouter.ai/api/v1/chat/completions",
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $this->apiKey,
                        'HTTP-Referer' => request()->getHost(),
                        'X-Title' => 'Ur-BrainDevPro',
                    ],
                    'json' => [
                        'model' => 'google/gemini-2.0-flash-exp:free',
                        'messages' => [
                            [
                                'role' => 'user',
                                'content' => $prompt
                            ]
                        ],
                        'temperature' => 0.7,
                        'max_tokens' => 8192,
                    ]
                ]
            );

            $body = json_decode($response->getBody(), true);

            if (isset($body['choices'][0]['message']['content'])) {
                return $body['choices'][0]['message']['content'];
            }

            return 'Gagal mengenerate report. Silakan coba lagi.';

        } catch (\Exception $e) {
            Log::error('OpenRouter API Error: ' . $e->getMessage());
            return 'Terjadi kesalahan saat mengenerate report: ' . $e->getMessage();
        }
    }

    /**
     * Build prompt for Gemini AI
     */
    private function buildPrompt(array $data): string
    {
        $userName = $data['user_name'] ?? 'Peserta';
        $kategoriBreakdown = $data['kategori_breakdown'] ?? [];

        // Format assessment results for the prompt
        $assessmentText = "HASIL ASSESSMENT META-PROGRAMS\n\n";
        $assessmentText .= "Nama: {$userName}\n";
        $assessmentText .= "Tanggal: " . now()->format('d F Y') . "\n\n";

        foreach ($kategoriBreakdown as $kategori) {
            $assessmentText .= "=== {$kategori['name']} ===\n";
            $assessmentText .= "{$kategori['description']}\n\n";

            foreach ($kategori['meta_program_pairs'] as $mp) {
                $assessmentText .= "\n{$mp['meta_program_name']}\n";
                $assessmentText .= "{$mp['meta_program_description']}\n\n";

                foreach ($mp['pairs'] as $pair) {
                    if ($pair['side1']) {
                        $assessmentText .= "- {$pair['side1']['name']}: {$pair['side1']['average']} ({$pair['side1']['percentage']}%)";
                        if (isset($pair['dominant']) && $pair['dominant']['slug'] === $pair['side1']['slug']) {
                            $assessmentText .= " [DOMINAN]";
                        }
                        $assessmentText .= "\n";
                    }
                    if ($pair['side2']) {
                        $assessmentText .= "- {$pair['side2']['name']}: {$pair['side2']['average']} ({$pair['side2']['percentage']}%)";
                        if (isset($pair['dominant']) && $pair['dominant']['slug'] === $pair['side2']['slug']) {
                            $assessmentText .= " [DOMINAN]";
                        }
                        $assessmentText .= "\n";
                    }
                }
                $assessmentText .= "\n";
            }
        }

        $prompt = <<<EOT
Anda adalah seorang konselor karir dan coach profesional yang ahli dalam Meta-Programs. Tugas Anda adalah membuat laporan personal yang mendalam dan personal berdasarkan hasil assessment Meta-Programs.

{$assessmentText}

Buatlah laporan personal dengan format sebagai berikut:

# LAPORAN PERSONAL META-PROGRAMS

## Informasi Dasar
- Nama: {$userName}
- Tanggal Assessment: {$this->formatTanggal(now())}

## Ringkasan Profil
Jelaskan secara singkat profil umum dari hasil assessment ini dalam 2-3 paragraf.

## Kekuatan Utama
Identifikasi 5-7 kekuatan utama berdasarkan pola-pola Meta-Program yang dominan. Jelaskan bagaimana kekuatan ini dapat dimanfaatkan dalam kehidupan sehari-hari, karir, dan hubungan.

## Area Pengembangan
Identifikasi 3-5 area yang perlu dikembangkan berdasarkan pola Meta-Program yang kurang dominan. Berikan saran konkret untuk pengembangan.

## Rekomendasi Karir
Berdasarkan kombinasi Meta-Programs, berikan 5-7 rekomendasi karir atau bidang pekerjaan yang paling sesuai. Jelaskan alasan untuk setiap rekomendasi.

## Gaya Belajar Ideal
Jelaskan gaya belajar yang paling efektif untuk individu ini, termasuk:
- Cara terbaik untuk menyerap informasi baru
- Jenis materi yang paling mudah dipahami
- Lingkungan belajar yang optimal
- Metode evaluasi yang paling sesuai

## Strategi Pengembangan Diri
Berikan 5 strategi praktis untuk pengembangan diri yang dipersonalisasi berdasarkan profil Meta-Programs ini.

## Tips Komunikasi
Jelaskan cara terbaik untuk berkomunikasi dengan individu ini, termasuk:
- Gaya bahasa yang efektif
- Pendekatan yang disukai
- Hal yang perlu dihindari

## Saran Keseimbangan Hidup
Berikan saran untuk mencapai keseimbangan antara pekerjaan, relasi, dan pengembangan diri.

---
Catatan: Gunakan bahasa yang personal, motivatif, dan actionable. Hindari bahasa teknis yang terlalu kompleks. Fokus pada insight praktis yang bisa langsung diterapkan.

EOT;

        return $prompt;
    }

    private function formatTanggal($date): string
    {
        $bulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        return $date->format('d') . ' ' . $bulan[$date->format('n')] . ' ' . $date->format('Y');
    }
}

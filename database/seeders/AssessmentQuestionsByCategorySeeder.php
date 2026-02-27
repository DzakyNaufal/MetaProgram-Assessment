<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class AssessmentQuestionsByCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Course IDs untuk setiap kategori
        $courses = [
            26, // Assessment Kategori 1 - THE MENTAL META-PROGRAMS
            27, // Assessment Kategori 2 - THE EMOTIONAL META-PROGRAMS
            28, // Assessment Kategori 3 - THE VOLITIONAL META-PROGRAMS
            29, // Assessment Kategori 4 - COMMUNICATION META-PROGRAMS
            30, // Assessment Kategori 5 - HIGHER META-PROGRAM
        ];

        // KATEGORI 1: THE MENTAL META-PROGRAMS
        $kategori1Questions = [
            'Saya lebih suka melihat gambaran besar (big picture) daripada detail kecil.',
            'Saya cenderung fokus pada detail spesifik ketika menganalisis masalah.',
            'Saya lebih tertarik pada masa depan dan kemungkinan-kemungkinan baru.',
            'Saya lebih suka berkaca pada pengalaman masa lalu untuk belajar.',
            'Saya cenderung mencari pola dan keterkaitan antar hal.',
            'Saya suka mengorganisir informasi dalam kategori yang jelas.',
            'Saya lebih mudah memahami sesuatu melalui gambar/diagram.',
            'Saya lebih mudah memahami sesuatu melalui penjelasan tertulis.',
            'Saya lebih mudah memahami sesuatu melalui pendengaran/penjelasan lisan.',
            'Saya lebih mudah memahami sesuatu melalui praktik langsung.',
            'Saya membutuhkan banyak informasi sebelum membuat keputusan.',
            'Saya bisa membuat keputusan dengan informasi minim.',
            'Saya cenderung mencari perbedaan antar hal.',
            'Saya cenderung mencari persamaan antar hal.',
            'Saya percaya kemampuan orang bisa dikembangkan (growth mindset).',
            'Saya percaya kemampuan orang bersifat tetap (fixed mindset).',
            'Saya butuh bukti konkret sebelum yakin pada sesuatu.',
            'Saya bisa percaya berdasarkan intuisi saja.',
            'Saya lebih suka mencoba hal baru dan beradaptasi.',
            'Saya lebih suka rutinitas yang sudah terbiasa.',
        ];

        // KATEGORI 2: THE EMOTIONAL META-PROGRAMS
        $kategori2Questions = [
            'Dalam situasi stres, saya tetap tenang dan fokus pada solusi.',
            'Dalam situasi stres, saya cenderung merasa tertekan.',
            'Saya menyadari emosi saya saat ini.',
            'Saya bisa mengontrol emosi saya dengan baik.',
            'Saya cenderung melihat sisi positif dari setiap situasi.',
            'Saya cenderung melihat sisi negatif dari setiap situasi.',
            'Saya termotivasi oleh pencapaian dan kesuksesan.',
            'Saya termotivasi untuk menghindari kegagalan.',
            'Saya merasa percaya diri dalam kemampuan diri sendiri.',
            'Saya sering merasa ragu dengan kemampuan diri sendiri.',
            'Saya mudah beradaptasi dengan perubahan emosi.',
            'Emosi saya cenderung stabil sepanjang hari.',
            'Saya mengambil tanggung jawab atas hasil yang saya dapatkan.',
            'Saya cenderung menyalahkan keadaan di luar kendili.',
            'Saya percaya kesulitan bersifat sementara.',
            'Saya percaya kesulitan akan terus berlanjut.',
            'Saya merasa optimis tentang masa depan.',
            'Saya merasa pesimis tentang masa depan.',
            'Saya bisa pulih dengan cepat dari kekecewaan.',
            'Saya butuh waktu lama untuk pulih dari kekecewaan.',
        ];

        // KATEGORI 3: THE VOLITIONAL META-PROGRAMS
        $kategori3Questions = [
            'Saya termotivasi untuk mencapai tujuan dan target.',
            'Saya termotivasi untuk menghindari masalah.',
            'Saya menyukai tantangan baru.',
            'Saya lebih nyaman dengan zona nyaman.',
            'Saya suka membuat rencana dan strategi.',
            'Saya lebih suka bertindak spontan.',
            'Saya menyelesaikan tugas tepat waktu.',
            'Saya cenderung menunda-nunda tugas.',
            'Saya bekerja lebih baik dengan tekanan deadline.',
            'Saya bekerja lebih baik tanpa tekanan.',
            'Saya memegang teguh komitmen saya.',
            'Saya fleksibel dengan komitmen saya.',
            'Saya suka bekerja secara mandiri.',
            'Saya suka bekerja dalam tim.',
            'Saya membutuhkan instruksi yang jelas.',
            'Saya suka menemukan cara sendiri.',
            'Saya termotivasi oleh hadiah/insentif eksternal.',
            'Saya termotivasi oleh kepuasan internal.',
            'Saya menikmati proses mencapai tujuan.',
            'Saya hanya fokus pada hasil akhir.',
        ];

        // KATEGORI 4: COMMUNICATION META-PROGRAMS
        $kategori4Questions = [
            'Saya lebih suka komunikasi langsung dan to-the-point.',
            'Saya lebih suka komunikasi yang halus dan diplomatis.',
            'Saya lebih banyak mendengarkan daripada berbicara.',
            'Saya lebih banyak berbicara daripada mendengarkan.',
            'Saya percaya pada pendapat orang lain.',
            'Saya lebih percaya pada penilaian sendiri.',
            'Saya menyadari bahasa tubuh orang lain.',
            'Saya menggunakan bahasa tubuh yang ekspresif.',
            'Saya suka bekerja dalam kelompok.',
            'Saya lebih suka bekerja sendiri.',
            'Saya nyaman menjadi pusat perhatian.',
            'Saya lebih nyaman di belakang layar.',
            'Saya mudah bergaul dengan orang baru.',
            'Saya butuh waktu untuk nyaman dengan orang baru.',
            'Saya menyampaikan pendapat dengan terbuka.',
            'Saya menahan pendapat untuk menghindari konflik.',
            'Saya responsif terhadap kebutuhan orang lain.',
            'Saya lebih fokus pada kebutuhan sendiri.',
            'Saya suka negosiasi dan compromise.',
            'Saya lebih suka keputusan tegas tanpa compromise.',
        ];

        // KATEGORI 5: HIGHER META-PROGRAM
        $kategori5Questions = [
            'Saya merasa puas dengan hidup saya saat ini.',
            'Saya merasa hidup saya memiliki tujuan yang jelas.',
            'Saya hidup sesuai dengan nilai-nilai pribadi saya.',
            'Saya memprioritaskan kesejahteraan pribadi.',
            'Saya memprioritaskan kesejahteraan orang lain.',
            'Saya merasa mampu mencapai tujuan saya.',
            'Saya percaya usaha saya akan membuahkan hasil.',
            'Saya merasa tertekan dengan tenggat waktu.',
            'Saya merasa ada banyak waktu untuk melakukan apa yang saya inginkan.',
            'Saya fokus pada masa sekarang.',
            'Saya sering merenungkan masa lalu.',
            'Saya sering memikirkan masa depan.',
            'Saya percaya keberuntungan memegang peran penting dalam kesuksesan.',
            'Saya percaya kesuksesan hasil dari usaha sendiri.',
            'Saya merasa hidup saya seimbang.',
            'Saya merasa ada satu area yang mendominasi hidup saya.',
            'Saya fleksibel menyesuaikan diri dengan perubahan.',
            'Saya sulit beradaptasi dengan perubahan.',
            'Saya proaktif dalam mencari solusi.',
            'Saya reaktif menunggu masalah selesai sendiri.',
        ];

        // Likert scale options
        $likertOptions = [
            ['text' => 'Sangat Tidak Setuju', 'value' => 1],
            ['text' => 'Tidak Setuju', 'value' => 2],
            ['text' => 'Netral', 'value' => 3],
            ['text' => 'Setuju', 'value' => 4],
            ['text' => 'Sangat Setuju', 'value' => 5],
        ];

        $allQuestions = [
            $kategori1Questions,
            $kategori2Questions,
            $kategori3Questions,
            $kategori4Questions,
            $kategori5Questions,
        ];

        // Insert questions for each category
        foreach ($allQuestions as $index => $questions) {
            $courseId = $courses[$index];

            foreach ($questions as $order => $questionText) {
                Question::create([
                    'course_id' => $courseId,
                    'question_text' => $questionText,
                    'scale_description' => json_encode($likertOptions),
                    'order' => $order + 1,
                    'is_active' => true,
                    'is_reverse' => false,
                ]);
            }
        }

        $this->command->info('Assessment questions for all 5 categories seeded successfully!');
    }
}

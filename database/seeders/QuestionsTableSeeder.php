<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get course IDs
        $courses = [
            'talenta-cara-memperoleh-informasi' => Course::where('slug', 'talenta-cara-memperoleh-informasi')->first()->id,
            'talenta-proses-pengambilan-keputusan' => Course::where('slug', 'talenta-proses-pengambilan-keputusan')->first()->id,
            'talenta-gaya-analisis' => Course::where('slug', 'talenta-gaya-analisis')->first()->id,
            'talenta-gaya-komunikasi' => Course::where('slug', 'talenta-gaya-komunikasi')->first()->id,
            'talenta-presentasi' => Course::where('slug', 'talenta-presentasi')->first()->id,
            'talenta-negosiasi' => Course::where('slug', 'talenta-negosiasi')->first()->id,
            'talenta-peran-dalam-tim' => Course::where('slug', 'talenta-peran-dalam-tim')->first()->id,
            'talenta-kolaborasi' => Course::where('slug', 'talenta-kolaborasi')->first()->id,
            'talenta-konflik-tim' => Course::where('slug', 'talenta-konflik-tim')->first()->id,
            'talenta-kreativitas' => Course::where('slug', 'talenta-kreativitas')->first()->id,
            'talenta-analisis-masalah' => Course::where('slug', 'talenta-analisis-masalah')->first()->id,
            'talenta-solusi-inovatif' => Course::where('slug', 'talenta-solusi-inovatif')->first()->id,
            'talenta-gaya-kepemimpinan' => Course::where('slug', 'talenta-gaya-kepemimpinan')->first()->id,
            'talenta-pengambilan-risiko' => Course::where('slug', 'talenta-pengambilan-risiko')->first()->id,
            'talenta-motivasi' => Course::where('slug', 'talenta-motivasi')->first()->id,
        ];

        // Questions for "Talenta Cara Memperoleh Informasi" - 10 questions with 4 options each
        $infoAcquisitionQuestions = [
            [
                'question_text' => 'Dalam situasi baru, saya cenderung...',
                'options' => [
                    ['option_text' => 'Mengamati secara hati-hati sebelum bertindak', 'talent_type' => 'ANA'],
                    ['option_text' => 'Langsung terlibat dan mencoba hal baru', 'talent_type' => 'EXP'],
                    ['option_text' => 'Mengikuti prosedur yang sudah ditetapkan', 'talent_type' => 'CON'],
                    ['option_text' => 'Mencari solusi praktis yang efisien', 'talent_type' => 'RES'],
                ],
                'order' => 1,
            ],
            [
                'question_text' => 'Saat memecahkan masalah, saya lebih suka...',
                'options' => [
                    ['option_text' => 'Menganalisis data dan fakta secara menyeluruh', 'talent_type' => 'ANA'],
                    ['option_text' => 'Mencoba pendekatan yang berbeda-beda', 'talent_type' => 'EXP'],
                    ['option_text' => 'Menggunakan metode yang teruji dan terbukti', 'talent_type' => 'CON'],
                    ['option_text' => 'Fokus pada solusi yang langsung bisa diterapkan', 'talent_type' => 'RES'],
                ],
                'order' => 2,
            ],
            [
                'question_text' => 'Dalam pengambilan keputusan, saya biasanya...',
                'options' => [
                    ['option_text' => 'Mempertimbangkan berbagai kemungkinan dan konsekuensi', 'talent_type' => 'ANA'],
                    ['option_text' => 'Mencari pendekatan yang inovatif dan kreatif', 'talent_type' => 'EXP'],
                    ['option_text' => 'Mengacu pada aturan dan standar yang berlaku', 'talent_type' => 'CON'],
                    ['option_text' => 'Memilih opsi yang paling praktis dan efisien', 'talent_type' => 'RES'],
                ],
                'order' => 3,
            ],
            [
                'question_text' => 'Ketika belajar hal baru, saya...',
                'options' => [
                    ['option_text' => 'Mempelajari teori dan konsep terlebih dahulu', 'talent_type' => 'ANA'],
                    ['option_text' => 'Langsung mencoba dan belajar dari pengalaman', 'talent_type' => 'EXP'],
                    ['option_text' => 'Mengikuti instruksi dan manual dengan teliti', 'talent_type' => 'CON'],
                    ['option_text' => 'Fokus pada aspek praktis yang langsung berguna', 'talent_type' => 'RES'],
                ],
                'order' => 4,
            ],
            [
                'question_text' => 'Dalam diskusi kelompok, saya cenderung...',
                'options' => [
                    ['option_text' => 'Menganalisis argumen dan mencari kebenaran', 'talent_type' => 'ANA'],
                    ['option_text' => 'Mengemukakan ide-ide baru dan kreatif', 'talent_type' => 'EXP'],
                    ['option_text' => 'Menjaga agar diskusi tetap terstruktur dan tertib', 'talent_type' => 'CON'],
                    ['option_text' => 'Mendorong agar diskusi menghasilkan tindakan nyata', 'talent_type' => 'RES'],
                ],
                'order' => 5,
            ],
            [
                'question_text' => 'Saat menghadapi perubahan, saya...',
                'options' => [
                    ['option_text' => 'Menganalisis dampak dan implikasi dari perubahan tersebut', 'talent_type' => 'ANA'],
                    ['option_text' => 'Menganggapnya sebagai peluang untuk eksplorasi', 'talent_type' => 'EXP'],
                    ['option_text' => 'Menyesuaikan diri dengan aturan dan prosedur baru', 'talent_type' => 'CON'],
                    ['option_text' => 'Segera menyesuaikan diri dan fokus pada efisiensi', 'talent_type' => 'RES'],
                ],
                'order' => 6,
            ],
            [
                'question_text' => 'Dalam mengerjakan proyek, saya lebih suka...',
                'options' => [
                    ['option_text' => 'Memastikan semua aspek dipertimbangkan secara mendalam', 'talent_type' => 'ANA'],
                    ['option_text' => 'Mencoba pendekatan-pendekatan kreatif', 'talent_type' => 'EXP'],
                    ['option_text' => 'Mengikuti rencana dan jadwal yang telah ditentukan', 'talent_type' => 'CON'],
                    ['option_text' => 'Fokus pada hasil dan efisiensi pelaksanaan', 'talent_type' => 'RES'],
                ],
                'order' => 7,
            ],
            [
                'question_text' => 'Dalam mengevaluasi ide atau solusi, saya...',
                'options' => [
                    ['option_text' => 'Menganalisis kelebihan dan kekurangan secara logis', 'talent_type' => 'ANA'],
                    ['option_text' => 'Mencari potensi inovasi dan kreativitasnya', 'talent_type' => 'EXP'],
                    ['option_text' => 'Memastikan kesesuaian dengan standar dan prosedur', 'talent_type' => 'CON'],
                    ['option_text' => 'Menilai berdasarkan efektivitas dan hasil yang diharapkan', 'talent_type' => 'RES'],
                ],
                'order' => 8,
            ],
            [
                'question_text' => 'Dalam lingkungan kerja, saya paling produktif saat...',
                'options' => [
                    ['option_text' => 'Saya memiliki waktu untuk menganalisis dan memahami situasi', 'talent_type' => 'ANA'],
                    ['option_text' => 'Saya bisa bereksperimen dan mencoba hal baru', 'talent_type' => 'EXP'],
                    ['option_text' => 'Saya bekerja dalam struktur dan prosedur yang jelas', 'talent_type' => 'CON'],
                    ['option_text' => 'Saya fokus pada tugas-tugas konkret dan hasil yang jelas', 'talent_type' => 'RES'],
                ],
                'order' => 9,
            ],
            [
                'question_text' => 'Saya merasa paling nyaman saat...',
                'options' => [
                    ['option_text' => 'Saya memahami secara mendalam bagaimana sesuatu bekerja', 'talent_type' => 'ANA'],
                    ['option_text' => 'Saya bisa mengekspresikan ide dan kreativitas saya', 'talent_type' => 'EXP'],
                    ['option_text' => 'Saya bekerja sesuai dengan pedoman dan standar yang jelas', 'talent_type' => 'CON'],
                    ['option_text' => 'Saya fokus pada hal-hal yang praktis dan langsung terukur', 'talent_type' => 'RES'],
                ],
                'order' => 10,
            ],
        ];

        // Create questions and options for "Talenta Cara Memperoleh Informasi"
        foreach ($infoAcquisitionQuestions as $questionData) {
            $question = \App\Models\Question::updateOrCreate(
                [
                    'course_id' => $courses['talenta-cara-memperoleh-informasi'],
                    'question_text' => $questionData['question_text'],
                ],
                [
                    'order' => $questionData['order'],
                    'is_active' => true,
                ]
            );

            foreach ($questionData['options'] as $optionData) {
                \App\Models\QuestionOption::updateOrCreate(
                    [
                        'question_id' => $question->id,
                        'option_text' => $optionData['option_text'],
                    ],
                    [
                        'talent_type' => $optionData['talent_type'],
                        'order' => 0, // Order will be determined by the sequence they're added
                    ]
                );
            }
        }

        // Add some sample questions for other courses
        $this->createSampleQuestions($courses);
    }

    private function createSampleQuestions($courses)
    {
        // Sample questions for "Talenta Proses Pengambilan Keputusan"
        $decisionMakingQuestions = [
            [
                'question_text' => 'Dalam mengambil keputusan penting, saya biasanya...',
                'options' => [
                    ['option_text' => 'Menganalisis semua data dan informasi yang tersedia', 'talent_type' => 'ANA'],
                    ['option_text' => 'Mencari pendekatan yang inovatif dan berbeda', 'talent_type' => 'EXP'],
                    ['option_text' => 'Mengikuti prosedur dan kebijakan yang sudah ada', 'talent_type' => 'CON'],
                    ['option_text' => 'Fokus pada hasil dan efisiensi terbaik', 'talent_type' => 'RES'],
                ],
                'order' => 1,
            ],
            [
                'question_text' => 'Saat menghadapi pilihan yang sulit, saya...',
                'options' => [
                    ['option_text' => 'Mempertimbangkan semua faktor dan konsekuensinya', 'talent_type' => 'ANA'],
                    ['option_text' => 'Mencoba berbagai pendekatan sebelum memilih', 'talent_type' => 'EXP'],
                    ['option_text' => 'Mengacu pada standar dan kriteria yang telah ditentukan', 'talent_type' => 'CON'],
                    ['option_text' => 'Memilih opsi yang paling langsung efektif', 'talent_type' => 'RES'],
                ],
                'order' => 2,
            ],
        ];

        foreach ($decisionMakingQuestions as $questionData) {
            $question = \App\Models\Question::updateOrCreate(
                [
                    'course_id' => $courses['talenta-proses-pengambilan-keputusan'],
                    'question_text' => $questionData['question_text'],
                ],
                [
                    'order' => $questionData['order'],
                    'is_active' => true,
                ]
            );

            foreach ($questionData['options'] as $optionData) {
                \App\Models\QuestionOption::updateOrCreate(
                    [
                        'question_id' => $question->id,
                        'option_text' => $optionData['option_text'],
                    ],
                    [
                        'talent_type' => $optionData['talent_type'],
                        'order' => 0,
                    ]
                );
            }
        }

        // Sample questions for "Talenta Gaya Komunikasi"
        $communicationQuestions = [
            [
                'question_text' => 'Dalam berkomunikasi dengan orang lain, saya cenderung...',
                'options' => [
                    ['option_text' => 'Menganalisis pesan dan maknanya secara mendalam', 'talent_type' => 'ANA'],
                    ['option_text' => 'Menggunakan pendekatan kreatif dan inovatif', 'talent_type' => 'EXP'],
                    ['option_text' => 'Mengikuti norma dan aturan komunikasi yang berlaku', 'talent_type' => 'CON'],
                    ['option_text' => 'Berfokus pada kejelasan dan efisiensi pesan', 'talent_type' => 'RES'],
                ],
                'order' => 1,
            ],
            [
                'question_text' => 'Saat menyampaikan informasi penting, saya...',
                'options' => [
                    ['option_text' => 'Menyajikan data dan fakta secara rinci', 'talent_type' => 'ANA'],
                    ['option_text' => 'Menggunakan metode yang menarik dan kreatif', 'talent_type' => 'EXP'],
                    ['option_text' => 'Mengikuti format dan struktur yang standar', 'talent_type' => 'CON'],
                    ['option_text' => 'Menyampaikan informasi secara langsung dan jelas', 'talent_type' => 'RES'],
                ],
                'order' => 2,
            ],
        ];

        foreach ($communicationQuestions as $questionData) {
            $question = \App\Models\Question::updateOrCreate(
                [
                    'course_id' => $courses['talenta-gaya-komunikasi'],
                    'question_text' => $questionData['question_text'],
                ],
                [
                    'order' => $questionData['order'],
                    'is_active' => true,
                ]
            );

            foreach ($questionData['options'] as $optionData) {
                \App\Models\QuestionOption::updateOrCreate(
                    [
                        'question_id' => $question->id,
                        'option_text' => $optionData['option_text'],
                    ],
                    [
                        'talent_type' => $optionData['talent_type'],
                        'order' => 0,
                    ]
                );
            }
        }

        // Sample questions for "Talenta Kepemimpinan"
        $leadershipQuestions = [
            [
                'question_text' => 'Dalam memimpin tim, saya lebih suka...',
                'options' => [
                    ['option_text' => 'Menganalisis situasi dan membuat keputusan berdasarkan data', 'talent_type' => 'ANA'],
                    ['option_text' => 'Menginspirasi tim dengan ide-ide inovatif', 'talent_type' => 'EXP'],
                    ['option_text' => 'Mengelola tim dengan struktur dan prosedur yang jelas', 'talent_type' => 'CON'],
                    ['option_text' => 'Fokus pada hasil dan efisiensi tim', 'talent_type' => 'RES'],
                ],
                'order' => 1,
            ],
            [
                'question_text' => 'Saat menghadapi tantangan tim, saya...',
                'options' => [
                    ['option_text' => 'Menganalisis akar masalah secara mendalam', 'talent_type' => 'ANA'],
                    ['option_text' => 'Mencari solusi kreatif dan tidak konvensional', 'talent_type' => 'EXP'],
                    ['option_text' => 'Mengikuti protokol dan kebijakan yang ada', 'talent_type' => 'CON'],
                    ['option_text' => 'Segera mengambil tindakan untuk mengatasi masalah', 'talent_type' => 'RES'],
                ],
                'order' => 2,
            ],
        ];

        foreach ($leadershipQuestions as $questionData) {
            $question = \App\Models\Question::updateOrCreate(
                [
                    'course_id' => $courses['talenta-gaya-kepemimpinan'],
                    'question_text' => $questionData['question_text'],
                ],
                [
                    'order' => $questionData['order'],
                    'is_active' => true,
                ]
            );

            foreach ($questionData['options'] as $optionData) {
                \App\Models\QuestionOption::updateOrCreate(
                    [
                        'question_id' => $question->id,
                        'option_text' => $optionData['option_text'],
                    ],
                    [
                        'talent_type' => $optionData['talent_type'],
                        'order' => 0,
                    ]
                );
            }
        }
    }
}

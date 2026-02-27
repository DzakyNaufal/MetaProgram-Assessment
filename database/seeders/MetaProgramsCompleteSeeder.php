<?php

namespace Database\Seeders;

use App\Models\KategoriMetaProgram;
use App\Models\MetaProgram;
use App\Models\SubMetaProgram;
use App\Models\PertanyaanMetaProgram;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetaProgramsCompleteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // Clear existing data
        PertanyaanMetaProgram::query()->delete();
        SubMetaProgram::query()->delete();
        MetaProgram::query()->delete();

        // Enable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Get kategori
        $kategoriMental = KategoriMetaProgram::where('slug', 'mental-meta-programs')->first();
        $kategoriEmotional = KategoriMetaProgram::where('slug', 'emotional-meta-programs')->first();
        $kategoriVolitional = KategoriMetaProgram::where('slug', 'volitional-meta-programs')->first();
        $kategoriCommunication = KategoriMetaProgram::where('slug', 'communication-meta-programs')->first();
        $kategoriHigher = KategoriMetaProgram::where('slug', 'higher-meta-programs')->first();

        // Define all 51 Meta Programs with Sub Meta Programs
        $metaProgramsData = $this->getMetaProgramsData();

        $mpOrder = 1;
        $questionsPerCategory = [];

        foreach ($metaProgramsData as $kategoriSlug => $metaPrograms) {
            $kategori = null;
            switch ($kategoriSlug) {
                case 'mental':
                    $kategori = $kategoriMental;
                    break;
                case 'emotional':
                    $kategori = $kategoriEmotional;
                    break;
                case 'volitional':
                    $kategori = $kategoriVolitional;
                    break;
                case 'communication':
                    $kategori = $kategoriCommunication;
                    break;
                case 'behavioral':
                    $kategori = $kategoriHigher;
                    break;
            }

            if (!$kategori) {
                continue;
            }

            $questionsPerCategory[$kategoriSlug] = [];

            foreach ($metaPrograms as $mpData) {
                // Create Meta Program
                $metaProgram = MetaProgram::create([
                    'kategori_meta_program_id' => $kategori->id,
                    'name' => $mpData['name'],
                    'slug' => $mpData['slug'],
                    'description' => $mpData['description'],
                    'scoring_type' => $mpData['scoring_type'] ?? 'standard',
                    'order' => $mpOrder++,
                    'is_active' => true,
                ]);

                // Create Sub Meta Programs
                $subOrder = 1;
                foreach ($mpData['sub_meta_programs'] as $subData) {
                    $subMetaProgram = SubMetaProgram::create([
                        'meta_program_id' => $metaProgram->id,
                        'name' => $subData['name'],
                        'slug' => $subData['slug'],
                        'description' => $subData['description'],
                        'order' => $subOrder++,
                        'is_active' => true,
                    ]);

                    // Add questions for this sub meta program
                    foreach ($subData['questions'] as $questionText) {
                        $questionsPerCategory[$kategoriSlug][] = [
                            'meta_program_id' => $metaProgram->id,
                            'meta_program_name' => $metaProgram->name,
                            'sub_meta_program_id' => $subMetaProgram->id,
                            'sub_meta_program_name' => $subData['name'],
                            'question' => $questionText,
                        ];
                    }
                }
            }

            // Limit to 20 questions per category as requested
            $questionsPerCategory[$kategoriSlug] = array_slice($questionsPerCategory[$kategoriSlug], 0, 20);
        }

        // Create Pertanyaan Meta Programs (20 per category)
        $questionOrder = 1;
        foreach ($questionsPerCategory as $kategoriSlug => $questions) {
            foreach ($questions as $qData) {
                PertanyaanMetaProgram::create([
                    'meta_program_id' => $qData['meta_program_id'],
                    'sub_meta_program_id' => $qData['sub_meta_program_id'],
                    'pertanyaan' => $qData['question'],
                    'order' => $questionOrder++,
                    'is_active' => true,
                ]);
            }
        }

        $this->command->info('Successfully seeded Meta Programs, Sub Meta Programs, and Pertanyaan.');
        $this->command->info('Total Meta Programs: ' . MetaProgram::count());
        $this->command->info('Total Sub Meta Programs: ' . SubMetaProgram::count());
        $this->command->info('Total Pertanyaan: ' . PertanyaanMetaProgram::count());
    }

    private function getMetaProgramsData(): array
    {
        return [
            'mental' => [
                [
                    'name' => 'MP 1 — Chunk Size',
                    'slug' => 'mp-1-chunk-size',
                    'description' => 'Cara memproses informasi - gambaran besar vs detail',
                    'scoring_type' => 'standard',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Global',
                            'slug' => 'global',
                            'description' => 'Fokus pada gambaran besar',
                            'questions' => [
                                'Saya lebih mudah memahami sesuatu jika dijelaskan secara gambaran besar terlebih dahulu.',
                                'Saya cenderung mencari makna keseluruhan sebelum memperhatikan detail.',
                                'Saya sulit memahami sesuatu sebelum mengetahui detail-detail kecilnya.',
                            ],
                        ],
                        [
                            'name' => 'Specific',
                            'slug' => 'specific',
                            'description' => 'Fokus pada detail spesifik',
                            'questions' => [
                                'Informasi yang spesifik membantu saya memproses suatu masalah dengan lebih baik.',
                                'Detail kecil sangat penting bagi saya untuk memahami suatu hal.',
                                'Gambaran besar saja sudah cukup bagi saya tanpa perlu dijelaskan lebih detail.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 3 — Representational System Processing',
                    'slug' => 'mp-3-representational-system',
                    'description' => 'Sistem representasi sensorik dalam memproses informasi',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Visual',
                            'slug' => 'visual',
                            'description' => 'Belajar melalui visual',
                            'questions' => [
                                'Saya lebih cepat memahami informasi jika disertai gambar atau visual.',
                                'Diagram atau ilustrasi sangat membantu saya belajar.',
                                'Saya tidak membutuhkan tampilan visual untuk memahami sesuatu.',
                            ],
                        ],
                        [
                            'name' => 'Auditory',
                            'slug' => 'auditory',
                            'description' => 'Belajar melalui pendengaran',
                            'questions' => [
                                'Saya mudah memahami materi dengan mendengarkan penjelasan.',
                                'Penjelasan lisan membantu saya mengingat informasi.',
                                'Mendengarkan penjelasan jarang membantu saya memahami sesuatu.',
                            ],
                        ],
                        [
                            'name' => 'Kinesthetic',
                            'slug' => 'kinesthetic',
                            'description' => 'Belajar melalui pengalaman langsung',
                            'questions' => [
                                'Saya memahami sesuatu dengan lebih baik jika mencobanya langsung.',
                                'Pengalaman langsung membuat saya lebih cepat paham.',
                                'Saya tidak perlu praktik langsung untuk memahami sesuatu.',
                            ],
                        ],
                        [
                            'name' => 'Language',
                            'slug' => 'language',
                            'description' => 'Belajar melalui teks/tulisan',
                            'questions' => [
                                'Saya nyaman memahami informasi melalui teks atau tulisan.',
                                'Membaca penjelasan tertulis membantu saya berpikir lebih jelas.',
                                'Saya kesulitan memahami informasi dalam bentuk tulisan.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 4 & 5 — Information Gathering Sort',
                    'slug' => 'mp-4-5-information-gathering',
                    'description' => 'Cara mengumpulkan informasi',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Sensor',
                            'slug' => 'sensor',
                            'description' => 'Mengumpulkan data empiris',
                            'questions' => [
                                'Saya lebih percaya pada informasi yang dapat saya lihat atau dengar secara langsung.',
                                'Fakta nyata membantu saya memahami situasi dengan jelas.',
                                'Saya lebih percaya firasat dibandingkan bukti nyata.',
                            ],
                        ],
                        [
                            'name' => 'Intuitor',
                            'slug' => 'intuitor',
                            'description' => 'Menggunakan intuisi',
                            'questions' => [
                                'Saya sering memahami sesuatu berdasarkan intuisi atau perasaan.',
                                'Dugaan awal sering membantu saya mengambil keputusan.',
                                'Saya jarang menggunakan intuisi dalam memahami sesuatu.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 6 — Perceptual Sort',
                    'slug' => 'mp-6-perceptual-sort',
                    'description' => 'Cara memandang sesuatu - hitam putih vs kontinum',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Black-White',
                            'slug' => 'black-white',
                            'description' => 'Pandangan hitam putih',
                            'questions' => [
                                'Saya cenderung melihat suatu hal sebagai benar atau salah dengan jelas.',
                                'Kejelasan dan kepastian penting bagi saya dalam menilai suatu situasi.',
                                'Menurut saya, suatu masalah tidak selalu punya satu jawaban yang pasti.',
                            ],
                        ],
                        [
                            'name' => 'Continuum',
                            'slug' => 'continuum',
                            'description' => 'Pandangan spektrum',
                            'questions' => [
                                'Saya memahami bahwa suatu hal dapat berubah tergantung konteks.',
                                'Saya mempertimbangkan berbagai tingkat sebelum menilai sesuatu.',
                                'Saya lebih nyaman dengan penilaian yang mutlak.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 9 — Focus Sort',
                    'slug' => 'mp-9-focus-sort',
                    'description' => 'Kemampuan menyaring stimulus eksternal',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Screeners',
                            'slug' => 'screeners',
                            'description' => 'Dapat menyaring distraksi',
                            'questions' => [
                                'Saya dapat tetap fokus meskipun ada gangguan di sekitar.',
                                'Saya mampu menyaring hal-hal yang tidak relevan.',
                                'Saya mudah terdistraksi oleh lingkungan sekitar saat mengerjakan suatu hal.',
                            ],
                        ],
                        [
                            'name' => 'Non-Screeners',
                            'slug' => 'non-screeners',
                            'description' => 'Mudah terpengaruh lingkungan',
                            'questions' => [
                                'Suara atau kondisi sekitar mudah menarik perhatian saya.',
                                'Saya sering memperhatikan banyak hal sekaligus.',
                                'Saya jarang terganggu oleh kondisi sekitar ketika sedang fokus.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 10 — Philosophical Direction',
                    'slug' => 'mp-10-philosophical-direction',
                    'description' => 'Fokus pada asal usul vs solusi',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Why',
                            'slug' => 'why',
                            'description' => 'Fokus pada alasan',
                            'questions' => [
                                'Saya sering ingin mengetahui alasan di balik suatu kejadian.',
                                'Memahami penyebab suatu masalah penting bagi saya.',
                                'Saya jarang tertarik mengetahui alasan terjadinya sesuatu.',
                            ],
                        ],
                        [
                            'name' => 'How',
                            'slug' => 'how',
                            'description' => 'Fokus pada cara',
                            'questions' => [
                                'Saya lebih tertarik pada cara melakukan sesuatu daripada alasannya.',
                                'Saya fokus pada proses ketika mempelajari hal baru.',
                                'Saya tidak peduli bagaimana cara sesuatu dilakukan.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 11 — Reality Structure Sort',
                    'slug' => 'mp-11-reality-structure',
                    'description' => 'Pandangan realitas statis vs proses',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Static',
                            'slug' => 'static',
                            'description' => 'Realitas statis',
                            'questions' => [
                                'Saya lebih nyaman dengan keadaan yang stabil dan tidak banyak perubahan.',
                                'Menurut saya, sifat dasar sesuatu jarang berubah.',
                                'Saya melihat segala sesuatu sebagai proses yang terus berubah.',
                            ],
                        ],
                        [
                            'name' => 'Process',
                            'slug' => 'process',
                            'description' => 'Realitas dinamis',
                            'questions' => [
                                'Saya melihat banyak hal sebagai sesuatu yang terus berkembang.',
                                'Menurut saya, perubahan adalah hal yang wajar dan terus terjadi.',
                                'Saya lebih melihat hasil akhir daripada proses yang berjalan.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 31 — Comparison Sort',
                    'slug' => 'mp-31-comparison-sort',
                    'description' => 'Gaya membandingkan - mencari persamaan vs perbedaan',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Matching',
                            'slug' => 'matching',
                            'description' => 'Mencari persamaan',
                            'questions' => [
                                'Saya mudah menemukan kesamaan antara berbagai hal.',
                                'Saya cenderung fokus pada apa yang sudah sesuai.',
                                'Saya lebih sering memperhatikan perbedaan.',
                            ],
                        ],
                        [
                            'name' => 'Mismatching',
                            'slug' => 'mismatching',
                            'description' => 'Mencari perbedaan',
                            'questions' => [
                                'Saya cepat melihat perbedaan atau kekurangan.',
                                'Saya sering menilai sesuatu dari apa yang belum sesuai.',
                                'Saya jarang memperhatikan perbedaan.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 37 — Perceptual Sort (Internal vs External)',
                    'slug' => 'mp-37-perceptual-sort',
                    'description' => 'Referensi persepsi internal vs eksternal',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Internal',
                            'slug' => 'internal',
                            'description' => 'Referensi internal',
                            'questions' => [
                                'Saya lebih percaya pada penilaian diri sendiri.',
                                'Keputusan saya didasarkan pada keyakinan pribadi.',
                                'Saya sangat bergantung pada pendapat orang lain.',
                            ],
                        ],
                        [
                            'name' => 'External',
                            'slug' => 'external',
                            'description' => 'Referensi eksternal',
                            'questions' => [
                                'Pendapat orang lain dapat memengaruhi keputusan saya.',
                                'Ketika memustukan suatu hal saya merasa lebih yakin jika ada beberapa masukan dari luar.',
                                'Saya jarang mempertimbangkan pendapat orang lain.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 38 — Perceptual Sort (Self vs Other)',
                    'slug' => 'mp-38-self-other-sort',
                    'description' => 'Fokus persepsi pada diri vs orang lain',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Self',
                            'slug' => 'self',
                            'description' => 'Fokus pada diri sendiri',
                            'questions' => [
                                'Saya memprioritaskan kepentingan diri sendiri dalam keputusan.',
                                'Saya lebih memikirkan dampak keputusan bagi diri saya.',
                                'Saya jarang memikirkan diri sendiri dalam mengambil keputusan.',
                            ],
                        ],
                        [
                            'name' => 'Other',
                            'slug' => 'other',
                            'description' => 'Fokus pada orang lain',
                            'questions' => [
                                'Saya mempertimbangkan perasaan orang lain sebelum bertindak.',
                                'Kepentingan orang lain penting bagi saya.',
                                'Saya jarang memikirkan dampak tindakan saya pada orang lain.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 46 — Time Orientation',
                    'slug' => 'mp-46-time-orientation',
                    'description' => 'Orientasi waktu - masa lalu, sekarang, masa depan',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Past',
                            'slug' => 'past',
                            'description' => 'Orientasi masa lalu',
                            'questions' => [
                                'Pengalaman masa lalu sering menjadi acuan saya.',
                                'Saya sering memikirkan kejadian yang telah berlalu.',
                                'Saya jarang memikirkan masa lalu.',
                            ],
                        ],
                        [
                            'name' => 'Present',
                            'slug' => 'present',
                            'description' => 'Orientasi masa kini',
                            'questions' => [
                                'Saya fokus pada apa yang terjadi saat ini.',
                                'Menikmati momen sekarang penting bagi saya.',
                                'Saya jarang memperhatikan apa yang sedang terjadi sekarang.',
                            ],
                        ],
                        [
                            'name' => 'Future',
                            'slug' => 'future',
                            'description' => 'Orientasi masa depan',
                            'questions' => [
                                'Saya sering memikirkan rencana masa depan.',
                                'Tujuan jangka panjang penting bagi saya.',
                                'Saya jarang memikirkan masa depan.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 47 — Time Tense',
                    'slug' => 'mp-47-time-tense',
                    'description' => 'Persepsi waktu - in time vs through time',
                    'sub_meta_programs' => [
                        [
                            'name' => 'In Time',
                            'slug' => 'in-time',
                            'description' => 'Terlarut dalam aktivitas',
                            'questions' => [
                                'Saya mudah larut dalam aktivitas yang saya lakukan.',
                                'Saat fokus, saya sering lupa waktu.',
                                'Saya selalu menyadari waktu saat beraktivitas.',
                            ],
                        ],
                        [
                            'name' => 'Through Time',
                            'slug' => 'through-time',
                            'description' => 'Menyadari alur waktu',
                            'questions' => [
                                'Saya selalu menyadari alur waktu saat melakukan sesuatu.',
                                'Saya terbiasa mengatur jadwal secara rapi.',
                                'Saya sering lupa waktu ketika melakukan sesuatu.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 48 — Time Access Sort',
                    'slug' => 'mp-48-time-access',
                    'description' => 'Akses waktu - sekuensial vs acak',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Sequential',
                            'slug' => 'sequential',
                            'description' => 'Urutan teratur',
                            'questions' => [
                                'Saya lebih nyaman mengerjakan tugas secara berurutan.',
                                'Langkah teratur memudahkan saya bekerja.',
                                'Saya suka mengerjakan banyak hal tanpa urutan.',
                            ],
                        ],
                        [
                            'name' => 'Random',
                            'slug' => 'random',
                            'description' => 'Urutan fleksibel',
                            'questions' => [
                                'Saya dapat berpindah tugas dengan mudah tanpa urutan tetap.',
                                'Saya tidak selalu mengikuti urutan saat bekerja.',
                                'Saya selalu membutuhkan urutan yang jelas.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 51 — Causation Sort',
                    'slug' => 'mp-51-causation-sort',
                    'description' => 'Atribusi sebab-akibat',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Linear',
                            'slug' => 'linear',
                            'description' => 'Satu penyebab utama',
                            'questions' => [
                                'Saya percaya suatu masalah biasanya memiliki satu penyebab utama.',
                                'Sebagian besar masalah berasal dari satu faktor utama.',
                                'Masalah biasanya disebabkan oleh banyak faktor sekaligus.',
                            ],
                        ],
                        [
                            'name' => 'Multi-Cause',
                            'slug' => 'multi-cause',
                            'description' => 'Banyak penyebab',
                            'questions' => [
                                'Menurut saya, suatu kejadian dipengaruhi banyak faktor.',
                                'Masalah jarang memiliki satu penyebab saja.',
                                'Setiap masalah pasti hanya memiliki satu penyebab.',
                            ],
                        ],
                    ],
                ],
            ],
            'emotional' => [
                [
                    'name' => 'MP 7 — Attribution Sort',
                    'slug' => 'mp-7-attribution-sort',
                    'description' => 'Gaya atribusi - optimis vs pesimis',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Optimist',
                            'slug' => 'optimist',
                            'description' => 'Pandangan optimis',
                            'questions' => [
                                'Saya cenderung melihat sisi positif dari suatu kejadian.',
                                'Saya percaya hal buruk bisa diperbaiki di masa depan.',
                                'Saya sering merasa masa depan akan berjalan buruk.',
                            ],
                        ],
                        [
                            'name' => 'Pessimist',
                            'slug' => 'pessimist',
                            'description' => 'Pandangan pesimis',
                            'questions' => [
                                'Saya sering memperkirakan hasil terburuk dari suatu situasi.',
                                'Kegagalan mudah membuat saya kehilangan harapan.',
                                'Saya jarang memikirkan kemungkinan buruk.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 8 — Perceptual Durability Sort',
                    'slug' => 'mp-8-perceptual-durability',
                    'description' => 'Stabilitas persepsi emosional',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Permeable',
                            'slug' => 'permeable',
                            'description' => 'Mudah terpengaruh',
                            'questions' => [
                                'Perkataan orang lain mudah memengaruhi perasaan saya.',
                                'Kritik sering membuat emosi saya berubah.',
                                'Pendapat orang lain tidak pernah memengaruhi perasaan saya.',
                            ],
                        ],
                        [
                            'name' => 'Impermeable',
                            'slug' => 'impermeable',
                            'description' => 'Stabil terhadap pengaruh',
                            'questions' => [
                                'Saya dapat menjaga emosi meskipun mendapat kritik.',
                                'Perasaan saya tidak mudah berubah karena lingkungan.',
                                'Emosi saya sangat mudah terpengaruh situasi luar.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 13 — Stress Coping Sort',
                    'slug' => 'mp-13-stress-coping',
                    'description' => 'Cara menghadapi stres',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Passive',
                            'slug' => 'passive',
                            'description' => 'Respons pasif',
                            'questions' => [
                                'Saat stres, saya cenderung menunggu keadaan membaik sendiri.',
                                'Saya memilih diam ketika menghadapi tekanan.',
                                'Saya langsung mengambil tindakan saat stres.',
                            ],
                        ],
                        [
                            'name' => 'Fight',
                            'slug' => 'fight',
                            'description' => 'Melawan stres',
                            'questions' => [
                                'Saat tertekan, saya melawan atau menghadapi masalah secara langsung.',
                                'Saya menjadi lebih tegas ketika berada di bawah tekanan.',
                                'Saya menghindari konflik saat stres.',
                            ],
                        ],
                        [
                            'name' => 'Flight',
                            'slug' => 'flight',
                            'description' => 'Menghindari stres',
                            'questions' => [
                                'Saya cenderung menghindari sumber stres.',
                                'Menjauh dari situasi sulit membuat saya lebih tenang.',
                                'Saya tetap menghadapi masalah meskipun merasa tertekan.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 15 — Emotional State',
                    'slug' => 'mp-15-emotional-state',
                    'description' => 'Keterlibatan emosional',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Associated',
                            'slug' => 'associated',
                            'description' => 'Terlibat dalam emosi',
                            'questions' => [
                                'Saya mudah larut dalam emosi yang saya rasakan.',
                                'Saya merasakan emosi dengan intens ketika suatu hal terjadi.',
                                'Saya bisa melihat emosi saya secara terpisah.',
                            ],
                        ],
                        [
                            'name' => 'Dissociated',
                            'slug' => 'dissociated',
                            'description' => 'Terpisah dari emosi',
                            'questions' => [
                                'Saya mampu menjaga jarak dari emosi saya.',
                                'Saya dapat menilai situasi tanpa terbawa perasaan.',
                                'Saya mudah tenggelam dalam emosi.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 18 — Emotional Direction Sort',
                    'slug' => 'mp-18-emotional-direction',
                    'description' => 'Sebaran emosi',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Uni-Directional',
                            'slug' => 'uni-directional',
                            'description' => 'Emosi fokus satu hal',
                            'questions' => [
                                'Emosi saya biasanya fokus pada satu hal saja.',
                                'Saya sulit merasakan dua emosi berbeda secara bersamaan.',
                                'Saya sering merasakan banyak emosi sekaligus.',
                            ],
                        ],
                        [
                            'name' => 'Multi-Directional',
                            'slug' => 'multi-directional',
                            'description' => 'Emosi tersebar',
                            'questions' => [
                                'Saya dapat merasakan beberapa emosi dalam waktu bersamaan.',
                                'Perasaan saya bisa bercampur antara senang dan sedih.',
                                'Emosi saya selalu hanya satu jenis.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 19 — Emotional Intensity Sort',
                    'slug' => 'mp-19-emotional-intensity',
                    'description' => 'Intensitas emosi',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Desurgency',
                            'slug' => 'desurgency',
                            'description' => 'Emosi tenang',
                            'questions' => [
                                'Saya cenderung tenang dalam berbagai situasi.',
                                'Emosi saya biasanya stabil.',
                                'Saya mudah terbawa emosi yang kuat.',
                            ],
                        ],
                        [
                            'name' => 'Surgency',
                            'slug' => 'surgency',
                            'description' => 'Emosi intens',
                            'questions' => [
                                'Saya merasakan emosi dengan intensitas tinggi.',
                                'Perasaan saya mudah naik dan turun.',
                                'Emosi saya jarang terasa kuat.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 36 — Association Sort',
                    'slug' => 'mp-36-association-sort',
                    'description' => 'Cara mengingat secara emosional',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Associated',
                            'slug' => 'associated-memory',
                            'description' => 'Ingatan emosional',
                            'questions' => [
                                'Saya kembali merasakan emosi saat mengingat pengalaman masa lalu.',
                                'Ingatan saya terasa hidup secara emosional.',
                                'Saya mengingat kejadian tanpa emosi.',
                            ],
                        ],
                        [
                            'name' => 'Disassociated',
                            'slug' => 'disassociated',
                            'description' => 'Ingatan netral',
                            'questions' => [
                                'Saya bisa mengingat pengalaman tanpa merasakan emosinya.',
                                'Saya melihat pengalaman masa lalu seperti penonton.',
                                'Ingatan saya selalu disertai emosi kuat.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 40 — Emotional Intensity Level',
                    'slug' => 'mp-40-emotional-intensity-level',
                    'description' => 'Level intensitas emosi',
                    'sub_meta_programs' => [
                        [
                            'name' => 'High',
                            'slug' => 'high-intensity',
                            'description' => 'Intensitas tinggi',
                            'questions' => [
                                'Saya bereaksi emosional dengan cepat.',
                                'Emosi saya terasa kuat.',
                                'Emosi saya sangat datar.',
                            ],
                        ],
                        [
                            'name' => 'Medium',
                            'slug' => 'medium-intensity',
                            'description' => 'Intensitas sedang',
                            'questions' => [
                                'Emosi saya berada di tingkat sedang.',
                                'Saya jarang bereaksi berlebihan.',
                                'Emosi saya selalu ekstrem.',
                            ],
                        ],
                        [
                            'name' => 'Low',
                            'slug' => 'low-intensity',
                            'description' => 'Intensitas rendah',
                            'questions' => [
                                'Saya jarang menunjukkan emosi.',
                                'Ekspresi emosi saya cenderung tenang.',
                                'Saya bereaksi emosional dengan kuat.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 45 — Self-Esteem Sort',
                    'slug' => 'mp-45-self-esteem',
                    'description' => 'Tingkat self-esteem',
                    'sub_meta_programs' => [
                        [
                            'name' => 'High Self-Esteem',
                            'slug' => 'high-self-esteem',
                            'description' => 'Self-esteem tinggi',
                            'questions' => [
                                'Saya menghargai diri saya apa adanya.',
                                'Saya percaya pada kemampuan diri sendiri.',
                                'Saya sering meragukan nilai diri saya.',
                            ],
                        ],
                        [
                            'name' => 'Low Self-Esteem',
                            'slug' => 'low-self-esteem',
                            'description' => 'Self-esteem rendah',
                            'questions' => [
                                'Saya sering merasa tidak cukup baik.',
                                'Saya mudah merasa rendah diri.',
                                'Saya merasa yakin pada diri sendiri.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 49 — Ego Strength',
                    'slug' => 'mp-49-ego-strength',
                    'description' => 'Kekuatan ego',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Proactive',
                            'slug' => 'proactive',
                            'description' => 'Respon proaktif',
                            'questions' => [
                                'Saya mampu mengendalikan diri dalam situasi sulit.',
                                'Saya berpikir sebelum bereaksi.',
                                'Tekanan membuat saya langsung bereaksi tanpa kontrol.',
                            ],
                        ],
                        [
                            'name' => 'Reactive',
                            'slug' => 'reactive',
                            'description' => 'Respon reaktif',
                            'questions' => [
                                'Saya mudah bereaksi secara spontan saat tertekan.',
                                'Emosi saya muncul dengan cepat ketika ada tekanan.',
                                'Saya tetap tenang di bawah tekanan.',
                            ],
                        ],
                    ],
                ],
            ],
            'volitional' => [
                [
                    'name' => 'MP 20 — Motivation Direction',
                    'slug' => 'mp-20-motivation-direction',
                    'description' => 'Arah motivasi',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Toward',
                            'slug' => 'toward',
                            'description' => 'Motivasi menuju tujuan',
                            'questions' => [
                                'Saya termotivasi oleh tujuan yang ingin saya capai.',
                                'Saya fokus pada hasil positif yang ingin diraih.',
                                'Saya lebih termotivasi untuk menghindari kegagalan.',
                            ],
                        ],
                        [
                            'name' => 'Away From',
                            'slug' => 'away-from',
                            'description' => 'Motivasi menghindari',
                            'questions' => [
                                'Saya terdorong untuk menghindari masalah atau risiko.',
                                'Menghindari hal buruk menjadi motivasi utama saya.',
                                'Saya jarang memikirkan kemungkinan buruk.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 21 — Adaptation Style',
                    'slug' => 'mp-21-adaptation-style',
                    'description' => 'Gaya adaptasi',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Procedures',
                            'slug' => 'procedures',
                            'description' => 'Suka prosedur',
                            'questions' => [
                                'Saya lebih nyaman mengikuti langkah yang sudah jelas.',
                                'Aturan membantu saya bekerja dengan baik.',
                                'Saya tidak suka mengikuti cara yang sudah ditetapkan.',
                            ],
                        ],
                        [
                            'name' => 'Options',
                            'slug' => 'options',
                            'description' => 'Suka pilihan',
                            'questions' => [
                                'Saya suka memiliki banyak pilihan dalam bekerja.',
                                'Kebebasan memilih cara kerja penting bagi saya.',
                                'Saya lebih nyaman mengikuti satu cara yang sama.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 22 — Adaptation Sort',
                    'slug' => 'mp-22-adaptation-sort',
                    'description' => 'Gaya adaptasi - terstruktur vs fleksibel',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Judger',
                            'slug' => 'judger',
                            'description' => 'Terstruktur',
                            'questions' => [
                                'Saya lebih suka menyelesaikan tugas sebelum batas waktu.',
                                'Kepastian membuat saya merasa tenang.',
                                'Saya nyaman dengan hal-hal yang belum pasti.',
                            ],
                        ],
                        [
                            'name' => 'Perceiver',
                            'slug' => 'perceiver',
                            'description' => 'Fleksibel',
                            'questions' => [
                                'Saya fleksibel terhadap perubahan rencana.',
                                'Saya nyaman bekerja tanpa keputusan final di awal.',
                                'Saya tidak suka perubahan mendadak.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 23 — Modal Operators',
                    'slug' => 'mp-23-modal-operators',
                    'description' => 'Pola bahasa motivasi',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Necessity',
                            'slug' => 'necessity',
                            'description' => 'Kewajiban',
                            'questions' => [
                                'Saya sering merasa "harus" melakukan sesuatu.',
                                'Kewajiban menjadi pendorong utama saya.',
                                'Saya jarang merasa terikat kewajiban.',
                            ],
                        ],
                        [
                            'name' => 'Desire',
                            'slug' => 'desire',
                            'description' => 'Keinginan',
                            'questions' => [
                                'Saya melakukan sesuatu karena ingin, bukan karena harus.',
                                'Keinginan pribadi memotivasi saya.',
                                'Saya jarang termotivasi oleh keinginan sendiri.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 24 — Preference Sort',
                    'slug' => 'mp-24-preference-sort',
                    'description' => 'Preferensi utama',
                    'sub_meta_programs' => [
                        [
                            'name' => 'People',
                            'slug' => 'people',
                            'description' => 'Fokus pada orang',
                            'questions' => [
                                'Saya menikmati bekerja dengan orang lain.',
                                'Interaksi sosial memberi saya energi.',
                                'Saya lebih nyaman bekerja sendiri.',
                            ],
                        ],
                        [
                            'name' => 'Things',
                            'slug' => 'things',
                            'description' => 'Fokus pada benda',
                            'questions' => [
                                'Saya lebih fokus pada alat atau benda daripada orang.',
                                'Mesin atau sistem lebih menarik bagi saya.',
                                'Saya tidak tertarik pada benda atau alat.',
                            ],
                        ],
                        [
                            'name' => 'Activity',
                            'slug' => 'activity',
                            'description' => 'Fokus pada aktivitas',
                            'questions' => [
                                'Saya menikmati aktivitas yang membuat saya terus bergerak.',
                                'Saya suka terlibat langsung dalam kegiatan.',
                                'Saya tidak suka aktivitas yang sibuk.',
                            ],
                        ],
                        [
                            'name' => 'Information',
                            'slug' => 'information',
                            'description' => 'Fokus pada informasi',
                            'questions' => [
                                'Saya senang belajar dan mencari informasi baru.',
                                'Pengetahuan membuat saya termotivasi.',
                                'Saya tidak tertarik mempelajari hal baru.',
                            ],
                        ],
                        [
                            'name' => 'Location',
                            'slug' => 'location',
                            'description' => 'Fokus pada lokasi',
                            'questions' => [
                                'Lingkungan atau tempat sangat memengaruhi kenyamanan saya.',
                                'Saya memilih aktivitas berdasarkan tempatnya.',
                                'Tempat tidak penting bagi saya.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 25 — Goal Striving Sort',
                    'slug' => 'mp-25-goal-striving',
                    'description' => 'Gaya mengejar tujuan',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Perfectionism',
                            'slug' => 'perfectionism',
                            'description' => 'Sempurna',
                            'questions' => [
                                'Saya berusaha mencapai hasil yang sempurna.',
                                'Kesalahan kecil terasa mengganggu bagi saya.',
                                'Hasil "cukup baik" sudah memuaskan saya.',
                            ],
                        ],
                        [
                            'name' => 'Optimization',
                            'slug' => 'optimization',
                            'description' => 'Optimal',
                            'questions' => [
                                'Saya mencari hasil terbaik dengan usaha yang realistis.',
                                'Efisiensi penting dalam mencapai tujuan.',
                                'Saya tidak memikirkan efisiensi hasil.',
                            ],
                        ],
                        [
                            'name' => 'Skepticism',
                            'slug' => 'skepticism',
                            'description' => 'Skeptis',
                            'questions' => [
                                'Saya cenderung mempertanyakan standar yang ada.',
                                'Saya tidak mudah puas dengan klaim hasil.',
                                'Saya langsung menerima hasil tanpa berpikir kritis.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 41 — Decision Sort',
                    'slug' => 'mp-41-decision-sort',
                    'description' => 'Sumber pengambilan keputusan',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Internal',
                            'slug' => 'internal-decision',
                            'description' => 'Keputusan internal',
                            'questions' => [
                                'Saya percaya pada keputusan yang saya buat sendiri.',
                                'Keyakinan pribadi menentukan pilihan saya.',
                                'Saya selalu membutuhkan persetujuan orang lain.',
                            ],
                        ],
                        [
                            'name' => 'External',
                            'slug' => 'external-decision',
                            'description' => 'Keputusan eksternal',
                            'questions' => [
                                'Saya mempertimbangkan masukan orang lain saat mengambil keputusan.',
                                'Pendapat orang lain membantu saya menentukan pilihan.',
                                'Saya tidak peduli dengan masukan orang lain.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 43 — State Sort',
                    'slug' => 'mp-43-state-sort',
                    'description' => 'Orientasi proses vs tujuan',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Process',
                            'slug' => 'process-state',
                            'description' => 'Fokus proses',
                            'questions' => [
                                'Saya menikmati proses menjalani suatu kegiatan.',
                                'Proses lebih penting daripada hasil akhir.',
                                'Saya hanya peduli pada hasil akhir.',
                            ],
                        ],
                        [
                            'name' => 'Goal',
                            'slug' => 'goal-state',
                            'description' => 'Fokus tujuan',
                            'questions' => [
                                'Mencapai tujuan adalah hal terpenting bagi saya.',
                                'Saya fokus pada target yang ingin dicapai.',
                                'Proses tidak begitu penting bagi saya.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 50 — Morality Sort',
                    'slug' => 'mp-50-morality-sort',
                    'description' => 'Tingkat moralitas',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Strong Super-Ego',
                            'slug' => 'strong-super-ego',
                            'description' => 'Moralitas kuat',
                            'questions' => [
                                'Saya berpegang kuat pada prinsip moral.',
                                'Nilai benar-salah sangat jelas bagi saya.',
                                'Saya mudah mengabaikan prinsip demi keuntungan.',
                            ],
                        ],
                        [
                            'name' => 'Weak Super-Ego',
                            'slug' => 'weak-super-ego',
                            'description' => 'Moralitas fleksibel',
                            'questions' => [
                                'Saya fleksibel terhadap aturan moral.',
                                'Situasi menentukan apa yang benar bagi saya.',
                                'Prinsip moral selalu menjadi pedoman utama saya.',
                            ],
                        ],
                    ],
                ],
            ],
            'communication' => [
                [
                    'name' => 'MP 2 — Relationship Sort',
                    'slug' => 'mp-2-relationship-sort',
                    'description' => 'Gaya mencari kesamaan vs perbedaan',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Sameness',
                            'slug' => 'sameness',
                            'description' => 'Mencari kesamaan',
                            'questions' => [
                                'Saya mudah melihat kesamaan antara diri saya dan orang lain.',
                                'Saya nyaman dengan pola atau cara yang sudah ada.',
                                'Saya lebih tertarik pada perbedaan daripada persamaan.',
                            ],
                        ],
                        [
                            'name' => 'Difference',
                            'slug' => 'difference',
                            'description' => 'Mencari perbedaan',
                            'questions' => [
                                'Saya cepat melihat perbedaan dalam suatu situasi.',
                                'Perbedaan membuat saya tertarik untuk mengeksplorasi hal baru.',
                                'Saya jarang memperhatikan perbedaan.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 12 — Communication Channel Preference',
                    'slug' => 'mp-12-communication-channel',
                    'description' => 'Preferensi kanal komunikasi',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Verbal',
                            'slug' => 'verbal',
                            'description' => 'Komunikasi verbal',
                            'questions' => [
                                'Saya lebih nyaman berkomunikasi melalui kata-kata.',
                                'Penjelasan lisan membantu saya memahami pesan dengan baik.',
                                'Saya tidak suka menjelaskan sesuatu dengan kata-kata.',
                            ],
                        ],
                        [
                            'name' => 'Non-Verbal',
                            'slug' => 'non-verbal',
                            'description' => 'Komunikasi non-verbal',
                            'questions' => [
                                'Ekspresi wajah atau bahasa tubuh lebih bermakna bagi saya.',
                                'Saya peka terhadap bahasa tubuh orang lain.',
                                'Saya jarang memperhatikan isyarat non-verbal.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 14 — Referencing Style',
                    'slug' => 'mp-14-referencing-style',
                    'description' => 'Gaya referensi dalam penilaian',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Internal Reference',
                            'slug' => 'internal-reference',
                            'description' => 'Referensi internal',
                            'questions' => [
                                'Saya menilai keberhasilan berdasarkan standar diri sendiri.',
                                'Keyakinan pribadi menjadi dasar penilaian saya.',
                                'Saya selalu membutuhkan penilaian orang lain.',
                            ],
                        ],
                        [
                            'name' => 'External Reference',
                            'slug' => 'external-reference',
                            'description' => 'Referensi eksternal',
                            'questions' => [
                                'Saya merasa yakin jika ada pengakuan dari orang lain.',
                                'Penilaian orang lain memengaruhi cara saya melihat diri sendiri.',
                                'Pendapat orang lain tidak pernah memengaruhi saya.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 28 — People Convincer Sort',
                    'slug' => 'mp-28-people-convincer',
                    'description' => 'Tingkat kepercayaan terhadap orang',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Trusting',
                            'slug' => 'trusting',
                            'description' => 'Mudah percaya',
                            'questions' => [
                                'Saya cenderung mudah mempercayai orang lain.',
                                'Saya percaya niat orang biasanya baik.',
                                'Saya jarang mempercayai orang.',
                            ],
                        ],
                        [
                            'name' => 'Distrusting',
                            'slug' => 'distrusting',
                            'description' => 'Hati-hati percaya',
                            'questions' => [
                                'Saya berhati-hati sebelum mempercayai orang.',
                                'Saya perlu bukti sebelum percaya.',
                                'Saya langsung percaya tanpa pertimbangan.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 32 — Authority Sort',
                    'slug' => 'mp-32-authority-sort',
                    'description' => 'Gaya terhadap otoritas',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Self Authority',
                            'slug' => 'self-authority',
                            'description' => 'Otoritas diri sendiri',
                            'questions' => [
                                'Saya lebih nyaman memimpin diri sendiri.',
                                'Saya tidak suka dikontrol orang lain.',
                                'Saya selalu membutuhkan arahan orang lain.',
                            ],
                        ],
                        [
                            'name' => 'Other Authority',
                            'slug' => 'other-authority',
                            'description' => 'Otoritas orang lain',
                            'questions' => [
                                'Saya merasa nyaman dipimpin oleh orang lain.',
                                'Arahan atasan membantu saya bekerja lebih baik.',
                                'Saya tidak suka menerima arahan dari orang lain.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 33 — Rapport Sort',
                    'slug' => 'mp-33-rapport-sort',
                    'description' => 'Gaya membangun rapport',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Affiliative',
                            'slug' => 'affiliative',
                            'description' => 'Fokus keharmonisan',
                            'questions' => [
                                'Saya berusaha menjaga hubungan tetap harmonis.',
                                'Kerja sama lebih penting bagi saya daripada konflik.',
                                'Saya tidak peduli dengan keharmonisan hubungan.',
                            ],
                        ],
                        [
                            'name' => 'Confrontational',
                            'slug' => 'confrontational',
                            'description' => 'Terbuka pada konflik',
                            'questions' => [
                                'Saya berani menyampaikan perbedaan pendapat secara langsung.',
                                'Saya tidak masalah dengan konflik terbuka.',
                                'Saya selalu menghindari perbedaan pendapat.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 34 — Knowledge/Competency Sort',
                    'slug' => 'mp-34-knowledge-competency',
                    'description' => 'Fokus pada pengetahuan vs kompetensi',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Knowledge-Focused',
                            'slug' => 'knowledge-focused',
                            'description' => 'Fokus pengetahuan',
                            'questions' => [
                                'Saya ingin dianggap berpengetahuan.',
                                'Informasi membuat saya percaya diri.',
                                'Pengetahuan tidak penting bagi saya.',
                            ],
                        ],
                        [
                            'name' => 'Competency-Focused',
                            'slug' => 'competency-focused',
                            'description' => 'Fokus kompetensi',
                            'questions' => [
                                'Saya ingin dianggap mampu secara praktik.',
                                'Kemampuan nyata lebih penting daripada teori.',
                                'Saya tidak peduli pada kemampuan praktik.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 39 — Relationship Context',
                    'slug' => 'mp-39-relationship-context',
                    'description' => 'Konteks relasi kerja',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Self',
                            'slug' => 'self-context',
                            'description' => 'Bekerja sendiri',
                            'questions' => [
                                'Saya lebih nyaman bekerja sendiri.',
                                'Fokus pada diri sendiri membuat saya produktif.',
                                'Saya tidak bisa bekerja sendiri.',
                            ],
                        ],
                        [
                            'name' => 'One Other',
                            'slug' => 'one-other',
                            'description' => 'Bekerja berdua',
                            'questions' => [
                                'Saya bekerja paling baik dengan satu orang lain.',
                                'Diskusi berdua membantu saya fokus.',
                                'Saya tidak nyaman bekerja berdua.',
                            ],
                        ],
                        [
                            'name' => 'Group',
                            'slug' => 'group-context',
                            'description' => 'Bekerja kelompok',
                            'questions' => [
                                'Saya menikmati bekerja dalam kelompok.',
                                'Dinamika tim memberi saya energi.',
                                'Saya menghindari kerja kelompok.',
                            ],
                        ],
                    ],
                ],
            ],
            'behavioral' => [
                [
                    'name' => 'MP 16 — Somatic Response Style',
                    'slug' => 'mp-16-somatic-response',
                    'description' => 'Gaya respon somatik',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Active',
                            'slug' => 'active',
                            'description' => 'Respon aktif',
                            'questions' => [
                                'Saya cenderung langsung bertindak ketika menghadapi situasi baru.',
                                'Bergerak dan bertindak membuat saya merasa lebih nyaman.',
                                'Saya lebih suka menunggu daripada bertindak.',
                            ],
                        ],
                        [
                            'name' => 'Inactive',
                            'slug' => 'inactive',
                            'description' => 'Respon pasif',
                            'questions' => [
                                'Saya lebih memilih berpikir dulu sebelum bertindak.',
                                'Saya nyaman menahan diri untuk tidak langsung bereaksi.',
                                'Saya selalu segera bertindak tanpa berpikir.',
                            ],
                        ],
                        [
                            'name' => 'Reactive',
                            'slug' => 'reactive',
                            'description' => 'Respon reaktif',
                            'questions' => [
                                'Saya bereaksi setelah ada dorongan atau rangsangan dari luar.',
                                'Lingkungan sering menentukan reaksi saya.',
                                'Saya bertindak tanpa dipengaruhi lingkungan sekitar.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 17 — Convincer Sort',
                    'slug' => 'mp-17-convincer-sort',
                    'description' => 'Cara menjadi yakin',
                    'sub_meta_programs' => [
                        [
                            'name' => 'VAK',
                            'slug' => 'vak',
                            'description' => 'Yakin lewat pengalaman sensorik',
                            'questions' => [
                                'Saya yakin setelah melihat, mendengar, atau merasakan langsung.',
                                'Bukti pengalaman langsung membuat saya percaya.',
                                'Saya tidak membutuhkan pengalaman langsung untuk percaya.',
                            ],
                        ],
                        [
                            'name' => 'Language',
                            'slug' => 'language-convincer',
                            'description' => 'Yakin lewat bahasa',
                            'questions' => [
                                'Penjelasan verbal atau tulisan membuat saya yakin.',
                                'Kata-kata yang meyakinkan cukup bagi saya.',
                                'Penjelasan dengan kata-kata tidak memengaruhi keyakinan saya.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 26 — Buying Sort',
                    'slug' => 'mp-26-buying-sort',
                    'description' => 'Kriteria pembelian',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Cost',
                            'slug' => 'cost',
                            'description' => 'Fokus harga',
                            'questions' => [
                                'Harga menjadi pertimbangan utama bagi saya.',
                                'Saya fokus mencari pilihan yang paling murah.',
                                'Harga tidak penting bagi saya.',
                            ],
                        ],
                        [
                            'name' => 'Time',
                            'slug' => 'time',
                            'description' => 'Fokus waktu',
                            'questions' => [
                                'Kecepatan atau waktu sangat penting bagi saya.',
                                'Saya memilih yang paling cepat selesai.',
                                'Saya tidak keberatan menunggu lama.',
                            ],
                        ],
                        [
                            'name' => 'Quality',
                            'slug' => 'quality',
                            'description' => 'Fokus kualitas',
                            'questions' => [
                                'Kualitas lebih penting daripada harga.',
                                'Saya memilih yang paling baik meskipun lebih mahal.',
                                'Kualitas bukan prioritas saya.',
                            ],
                        ],
                        [
                            'name' => 'Convenience',
                            'slug' => 'convenience',
                            'description' => 'Fokus kemudahan',
                            'questions' => [
                                'Kemudahan menjadi pertimbangan utama saya.',
                                'Saya memilih yang paling praktis.',
                                'Saya tidak peduli apakah sesuatu itu praktis atau tidak.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 27 — Responsibility Sort',
                    'slug' => 'mp-27-responsibility-sort',
                    'description' => 'Tingkat tanggung jawab',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Under-Responsibility',
                            'slug' => 'under-responsibility',
                            'description' => 'Kurang tanggung jawab',
                            'questions' => [
                                'Saya sering menyerahkan tanggung jawab kepada orang lain.',
                                'Saya merasa masalah bukan sepenuhnya tanggung jawab saya.',
                                'Saya selalu mengambil alih tanggung jawab.',
                            ],
                        ],
                        [
                            'name' => 'Appropriate Responsibility',
                            'slug' => 'appropriate-responsibility',
                            'description' => 'Tanggung jawab tepat',
                            'questions' => [
                                'Saya mengambil tanggung jawab sesuai peran saya.',
                                'Saya tahu batas tanggung jawab saya.',
                                'Saya sering mengambil tanggung jawab yang bukan milik saya.',
                            ],
                        ],
                        [
                            'name' => 'Over-Responsibility',
                            'slug' => 'over-responsibility',
                            'description' => 'Berlebih tanggung jawab',
                            'questions' => [
                                'Saya merasa bertanggung jawab atas banyak hal.',
                                'Saya sulit melepas tanggung jawab.',
                                'Saya jarang merasa bertanggung jawab.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 29 — Rejuvenation of Battery',
                    'slug' => 'mp-29-rejuvenation',
                    'description' => 'Sumber energi',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Extrovert',
                            'slug' => 'extrovert',
                            'description' => 'Energi dari interaksi',
                            'questions' => [
                                'Berinteraksi dengan orang lain memberi saya energi.',
                                'Saya merasa segar setelah bersosialisasi.',
                                'Bersosialisasi membuat saya kelelahan.',
                            ],
                        ],
                        [
                            'name' => 'Introvert',
                            'slug' => 'introvert',
                            'description' => 'Energi dari sendiri',
                            'questions' => [
                                'Saya merasa segar ketika menghabiskan waktu sendiri.',
                                'Waktu sendiri membantu saya memulihkan energi.',
                                'Waktu sendiri justru membuat saya lelah.',
                            ],
                        ],
                        [
                            'name' => 'Ambivert',
                            'slug' => 'ambivert',
                            'description' => 'Energi dari keduanya',
                            'questions' => [
                                'Saya menikmati waktu sendiri dan bersosialisasi.',
                                'Keduanya sama-sama penting bagi saya.',
                                'Saya hanya nyaman pada salah satu saja.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 30 — Affiliation/Management Sort',
                    'slug' => 'mp-30-affiliation-management',
                    'description' => 'Gaya afiliasi dan manajemen',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Affiliation',
                            'slug' => 'affiliation',
                            'description' => 'Fokus hubungan',
                            'questions' => [
                                'Saya lebih fokus membangun hubungan kerja yang baik.',
                                'Keharmonisan tim penting bagi saya.',
                                'Saya tidak peduli dengan hubungan antar anggota tim.',
                            ],
                        ],
                        [
                            'name' => 'Management',
                            'slug' => 'management',
                            'description' => 'Fokus pengaturan',
                            'questions' => [
                                'Saya fokus pada pengaturan dan pengambilan keputusan.',
                                'Mengontrol proses kerja membuat saya nyaman.',
                                'Saya menghindari peran mengatur orang lain.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 35 — Activity Level Sort',
                    'slug' => 'mp-35-activity-level',
                    'description' => 'Tingkat aktivitas',
                    'sub_meta_programs' => [
                        [
                            'name' => 'High',
                            'slug' => 'high-activity',
                            'description' => 'Aktivitas tinggi',
                            'questions' => [
                                'Saya suka aktivitas yang padat dan cepat.',
                                'Saya merasa hidup saat sibuk.',
                                'Saya tidak suka aktivitas yang ramai.',
                            ],
                        ],
                        [
                            'name' => 'Medium',
                            'slug' => 'medium-activity',
                            'description' => 'Aktivitas sedang',
                            'questions' => [
                                'Saya nyaman dengan tingkat aktivitas sedang.',
                                'Saya bisa menyesuaikan diri antara sibuk dan santai.',
                                'Saya selalu ingin berada di aktivitas ekstrem.',
                            ],
                        ],
                        [
                            'name' => 'Low',
                            'slug' => 'low-activity',
                            'description' => 'Aktivitas rendah',
                            'questions' => [
                                'Saya lebih menyukai aktivitas yang tenang.',
                                'Ritme lambat membuat saya nyaman.',
                                'Saya tidak tahan dengan aktivitas yang pelan.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 42 — Action Sort',
                    'slug' => 'mp-42-action-sort',
                    'description' => 'Gaya aksi',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Reflective',
                            'slug' => 'reflective',
                            'description' => 'Pertimbangan dulu',
                            'questions' => [
                                'Saya mempertimbangkan segala hal sebelum bertindak.',
                                'Berpikir matang membantu saya membuat keputusan yang baik.',
                                'Saya sering bertindak tanpa berpikir.',
                            ],
                        ],
                        [
                            'name' => 'Impulsive',
                            'slug' => 'impulsive',
                            'description' => 'Spontan',
                            'questions' => [
                                'Saya cenderung bertindak spontan.',
                                'Saya mengikuti dorongan sesaat.',
                                'Saya selalu berpikir panjang sebelum bertindak.',
                            ],
                        ],
                    ],
                ],
                [
                    'name' => 'MP 44 — Status Sort',
                    'slug' => 'mp-44-status-sort',
                    'description' => 'Preferensi status',
                    'sub_meta_programs' => [
                        [
                            'name' => 'Superior',
                            'slug' => 'superior',
                            'description' => 'Posisi atas',
                            'questions' => [
                                'Saya nyaman berada pada posisi memimpin.',
                                'Saya senang memiliki kendali.',
                                'Saya tidak suka berada di posisi atas.',
                            ],
                        ],
                        [
                            'name' => 'Peer',
                            'slug' => 'peer',
                            'description' => 'Posisi setara',
                            'questions' => [
                                'Saya lebih nyaman berada pada posisi setara.',
                                'Kesetaraan penting bagi saya.',
                                'Saya tidak suka posisi setara.',
                            ],
                        ],
                        [
                            'name' => 'Subordinate',
                            'slug' => 'subordinate',
                            'description' => 'Posisi bawah',
                            'questions' => [
                                'Saya nyaman mengikuti arahan.',
                                'Saya bekerja lebih baik jika ada pemimpin.',
                                'Saya tidak suka menerima arahan.',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}

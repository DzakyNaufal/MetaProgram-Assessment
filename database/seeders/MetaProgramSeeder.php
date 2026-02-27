<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\Question;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MetaProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create default tier
        $tier = \App\Models\Tier::first();
        if (!$tier) {
            $tier = \App\Models\Tier::create([
                'name' => 'Basic',
                'price' => 0,
                'description' => 'Basic tier for Meta Programs assessment',
                'features' => json_encode(['Akses 51 Meta Programs', 'Laporan hasil assessment']),
                'is_recommended' => false,
                'is_active' => true,
            ]);
        }

        // Define all 51 Meta Programs with their categories
        $metaPrograms = $this->getMetaProgramsData();

        // Create categories and courses
        $order = 1;
        foreach ($metaPrograms as $mpData) {
            // Create or update category
            $category = Category::updateOrCreate(
                ['slug' => $mpData['category_slug']],
                [
                    'name' => $mpData['category_name'],
                    'slug' => $mpData['category_slug'],
                    'description' => $mpData['category_description'],
                    'icon' => $mpData['category_icon'] ?? 'fas fa-brain',
                    'color' => $mpData['category_color'] ?? '#' . dechex(rand(0, 0xFFFFFF)),
                    'order' => $order,
                    'is_active' => true,
                ]
            );

            // Create course for this Meta Program
            $course = Course::updateOrCreate(
                ['slug' => $mpData['course_slug']],
                [
                    'category_id' => $category->id,
                    'tier_id' => $tier->id,
                    'title' => $mpData['course_title'],
                    'slug' => $mpData['course_slug'],
                    'description' => $mpData['course_description'],
                    'thumbnail' => null,
                    'estimated_time' => 10,
                    'is_active' => true,
                ]
            );

            // Create questions
            foreach ($mpData['questions'] as $index => $questionText) {
                Question::updateOrCreate(
                    [
                        'course_id' => $course->id,
                        'order' => $index + 1,
                    ],
                    [
                        'question_text' => $questionText,
                        'is_active' => true,
                    ]
                );
            }

            $order++;
        }

        $this->command->info('Successfully seeded 51 Meta Programs with categories, courses, and questions.');
    }

    /**
     * Get all 51 Meta Programs data from the markdown file
     */
    private function getMetaProgramsData(): array
    {
        return [
            // MP 1: Chunk Size
            [
                'category_name' => 'Chunk Size',
                'category_slug' => 'chunk-size',
                'category_description' => 'How you process information - big picture vs details',
                'category_icon' => 'fas fa-layer-group',
                'category_color' => '#3498db',
                'course_title' => 'MP1: Chunk Size - Global vs Specific',
                'course_slug' => 'mp1-chunk-size',
                'course_description' => 'Meta Program untuk mengukur preferensi informasi global (gambaran besar) atau spesifik (detail)',
                'questions' => [
                    'Saat belajar hal baru, saya lebih suka langsung memahami gambaran besar daripada detail kecil.',
                    'Saya merasa nyaman berpikir induktif, yaitu menyimpulkan dari detail ke prinsip umum.',
                    'Ketika mendengar ide baru, saya ingin tahu makna keseluruhan daripada fakta spesifik.',
                    'Saya cenderung fokus pada gestalt (keseluruhan) daripada bagian-bagian kecil.',
                    'Dalam diskusi, saya lebih sering bertanya "Apa artinya secara keseluruhan?" daripada "Siapa, apa, kapan spesifiknya?"',
                ],
            ],

            // MP 2: Relationship Sort
            [
                'category_name' => 'Relationship Sort',
                'category_slug' => 'relationship-sort',
                'category_description' => 'How you find similarities and differences',
                'category_icon' => 'fas fa-equals',
                'category_color' => '#9b59b6',
                'course_title' => 'MP2: Relationship Sort - Sameness vs Difference',
                'course_slug' => 'mp2-relationship-sort',
                'course_description' => 'Meta Program untuk mengukur kecenderungan mencari kesamaan atau perbedaan',
                'questions' => [
                    'Saat melihat hal baru, saya pertama kali mencari kesamaannya dengan yang saya tahu.',
                    'Saya merasa nyaman dengan rutinitas dan menghindari perubahan besar.',
                    'Dalam membandingkan dua hal, saya fokus pada apa yang sama daripada yang berbeda.',
                    'Saya suka hal-hal yang tetap sama dan tidak berubah.',
                    'Saat memahami konsep baru, saya cocokkan dengan pengalaman lama daripada cari yang unik.',
                ],
            ],

            // MP 3: Representational System
            [
                'category_name' => 'Representational System',
                'category_slug' => 'representational-system',
                'category_description' => 'Your preferred sensory system for processing information',
                'category_icon' => 'fas fa-eye',
                'category_color' => '#e74c3c',
                'course_title' => 'MP3: Representational System - VAKL',
                'course_slug' => 'mp3-representational-system',
                'course_description' => 'Meta Program untuk mengukur sistem representasi sensorik: Visual, Auditory, Kinesthetic, Language',
                'questions' => [
                    'Saat belajar, saya paling nyaman dengan gambar atau visualisasi.',
                    'Saya sering berpikir dengan mendengar suara internal atau dialog diri.',
                    'Saya perlu merasakan atau menyentuh sesuatu untuk benar-benar memahaminya.',
                    'Saya lebih suka memproses informasi melalui kata-kata, logika, atau simbol abstrak.',
                    'Sistem sensorik favorit saya adalah yang membuat saya paling mudah belajar hal baru.',
                ],
            ],

            // MP 4: Information Gathering - Sensor/Uptime
            [
                'category_name' => 'Sensor Uptime',
                'category_slug' => 'sensor-uptime',
                'category_description' => 'Gathering information through external sensory data - Uptime mode',
                'category_icon' => 'fas fa-eye',
                'category_color' => '#00b894',
                'course_title' => 'MP4: Sensor Uptime - External Data Focus',
                'course_slug' => 'mp4-sensor-uptime',
                'course_description' => 'Meta Program untuk mengukur preferensi data empiris dan kesadaran sensorik (uptime)',
                'questions' => [
                    'Saya lebih percaya data empiris dari luar daripada firasat internal.',
                    'Saat mendengar ceramah, saya fokus pada fakta yang bisa dilihat/didengar/dirasakan.',
                    'Bukti dari luar lebih penting bagi saya daripada perasaan atau hunch.',
                    'Saya prefer operasi di uptime (sadar sensorik) daripada downtime (intuisi internal).',
                    'Saya cenderung mencari bukti konkret sebelum membuat keputusan.',
                ],
            ],

            // MP 5: Information Gathering - Intuitor/Downtime
            [
                'category_name' => 'Intuitor Downtime',
                'category_slug' => 'intuitor-downtime',
                'category_description' => 'Gathering information through internal intuition - Downtime mode',
                'category_icon' => 'fas fa-brain',
                'category_color' => '#6c5ce7',
                'course_title' => 'MP5: Intuitor Downtime - Internal Intuition Focus',
                'course_slug' => 'mp5-intuitor-downtime',
                'course_description' => 'Meta Program untuk mengukur preferensi firasat internal dan intuisi (downtime)',
                'questions' => [
                    'Saya sering pergi ke dalam pikiran untuk mencari makna daripada bukti eksternal.',
                    'Perasaan atau hunch saya lebih dapat diandalkan daripada data empiris.',
                    'Saya prefer operasi di downtime (intuisi internal) daripada uptime (sadar sensorik).',
                    'Saya cenderung mencari makna mendalam di balik fakta yang tersedia.',
                    'Sering saya mendapat insight tiba-tiba tanpa bukti konkrit.',
                ],
            ],

            // MP 6: Perceptual Sort
            [
                'category_name' => 'Perceptual Sort',
                'category_slug' => 'perceptual-sort',
                'category_description' => 'Black-white thinking vs continuum perspective',
                'category_icon' => 'fas fa-adjust',
                'category_color' => '#34495e',
                'course_title' => 'MP6: Perceptual Sort - Black-White vs Continuum',
                'course_slug' => 'mp6-perceptual-sort',
                'course_description' => 'Meta Program untuk mengukur cara pandang hitam-putih atau spektrum continuum',
                'questions' => [
                    'Ketika menilai hasil kerja, saya cenderung melihatnya sebagai "sukses total" atau "kegagalan total".',
                    'Saya percaya orang di dunia ini terbagi menjadi orang "baik" dan orang "buruk".',
                    'Dalam diskusi, pendapat yang berbeda dari saya adalah sesuatu yang "salah".',
                    'Ketika tertekan, situasi terasa seperti bencana yang tidak terhindarkan.',
                    'Suatu keterampilan harus dikuasai sempurna agar dianggap kompeten.',
                ],
            ],

            // MP 7: Attribution Sort
            [
                'category_name' => 'Attribution Sort',
                'category_slug' => 'attribution-sort',
                'category_description' => 'Optimistic vs pessimistic thinking patterns',
                'category_icon' => 'fas fa-sun',
                'category_color' => '#f39c12',
                'course_title' => 'MP7: Attribution Sort - Optimists vs Pessimists',
                'course_slug' => 'mp7-attribution-sort',
                'course_description' => 'Meta Program untuk mengukur pola pikir optimis vs pesimis',
                'questions' => [
                    'Saya selalu mencari peluang terbaik dalam situasi sulit.',
                    'Saya cenderung memikirkan risiko dan kegagalan terburuk terlebih dahulu.',
                    'Saya merasa empowered dan bisa mengubah nasib buruk menjadi baik.',
                    'Masalah terasa permanen dan menyeluruh bagi saya.',
                    'Saya fokus pada solusi daripada bahaya potensial.',
                ],
            ],

            // MP 8: Perceptual Durability
            [
                'category_name' => 'Perceptual Durability',
                'category_slug' => 'perceptual-durability',
                'category_description' => 'How stable your ideas and perceptions are',
                'category_icon' => 'fas fa-lock',
                'category_color' => '#7f8c8d',
                'course_title' => 'MP8: Perceptual Durability - Permeable vs Impermeable',
                'course_slug' => 'mp8-perceptual-durability',
                'course_description' => 'Meta Program untuk mengukur stabilitas ide dan persepsi',
                'questions' => [
                    'Ide-ide saya cenderung kuat dan stabil, sulit berubah.',
                    'Saya mudah lupa atau melepaskan konsep yang sudah dipikirkan.',
                    'Keyakinan saya terasa "real" dan permanen di pikiran.',
                    'Saya sulit menjaga ide tetap di depan pikiran tanpa usaha.',
                    'Konstruksi mental saya solid dan tidak mudah rusak.',
                ],
            ],

            // MP 9: Focus Sort
            [
                'category_name' => 'Focus Sort',
                'category_slug' => 'focus-sort',
                'category_description' => 'How you filter external stimuli',
                'category_icon' => 'fas fa-filter',
                'category_color' => '#16a085',
                'course_title' => 'MP9: Focus Sort - Screeners vs Non-Screeners',
                'course_slug' => 'mp9-focus-sort',
                'course_description' => 'Meta Program untuk mengukur kemampuan menyaring input eksternal',
                'questions' => [
                    'Saya mudah terganggu oleh lingkungan sekitar.',
                    'Saya bisa fokus lama tanpa perhatikan distraksi luar.',
                    'Stimulus eksternal sering membuat saya kehilangan konsentrasi.',
                    'Saya cenderung zoned-out karena terlalu fokus internal.',
                    'Saya kurang selektif dalam menyaring input dari luar.',
                ],
            ],

            // MP 10: Philosophical Direction
            [
                'category_name' => 'Philosophical Direction',
                'category_slug' => 'philosophical-direction',
                'category_description' => 'Focus on origins/why vs solutions/how',
                'category_icon' => 'fas fa-compass',
                'category_color' => '#8e44ad',
                'course_title' => 'MP10: Philosophical Direction - Why vs How',
                'course_slug' => 'mp10-philosophical-direction',
                'course_description' => 'Meta Program untuk mengukur fokus pada asal-usul vs solusi praktis',
                'questions' => [
                    'Saya lebih tertarik pada asal-usul atau "mengapa" sesuatu terjadi.',
                    'Saya fokus pada cara praktis atau "bagaimana" menyelesaikan masalah.',
                    'Filosofi sumber lebih penting bagi saya daripada aplikasi langsung.',
                    'Saya prefer solusi cepat daripada analisis masa lalu.',
                    'Saat memahami hal baru, saya tanya "Dari mana asalnya?" daripada "Bagaimana gunanya?"',
                ],
            ],

            // MP 11: Reality Structure
            [
                'category_name' => 'Reality Structure',
                'category_slug' => 'reality-structure',
                'category_description' => 'Static vs process view of reality',
                'category_icon' => 'fas fa-cube',
                'category_color' => '#2c3e50',
                'course_title' => 'MP11: Reality Structure - Aristotelian vs Non-Aristotelian',
                'course_slug' => 'mp11-reality-structure',
                'course_description' => 'Meta Program untuk mengukur pandangan realitas statis vs proses',
                'questions' => [
                    'Ketika mendeskripsikan pekerjaan, saya menggunakan kata benda permanen ("Saya akuntan").',
                    'Hal-hal yang dapat saya sentuh dan beri nama lebih "nyata" daripada perubahan konstan.',
                    'Konflik terasa seperti sesuatu yang statis ("Ini adalah masalah").',
                    'Dalam merencanakan masa depan, saya fokus pada mencapai posisi/status tertentu.',
                    'Saya lebih suka definisi peran yang kaku dan permanen di tempat kerja.',
                ],
            ],

            // MP 12: Communication Channel
            [
                'category_name' => 'Communication Channel',
                'category_slug' => 'communication-channel',
                'category_description' => 'Verbal/digital vs non-verbal/analogue preference',
                'category_icon' => 'fas fa-comments',
                'category_color' => '#27ae60',
                'course_title' => 'MP12: Communication Channel - Verbal vs Non-Verbal',
                'course_slug' => 'mp12-communication-channel',
                'course_description' => 'Meta Program untuk mengukur preferensi komunikasi verbal vs non-verbal',
                'questions' => [
                    'Saat berkomunikasi, saya lebih perhatikan kata-kata dan isi pesan.',
                    'Bahasa tubuh dan nada suara lebih penting bagi saya daripada kata-kata.',
                    'Saya meyakini pesan dari konten bahasa daripada gestur.',
                    'Ekspresi non-verbal seperti postur lebih meyakinkan saya.',
                    'Komunikasi efektif bagi saya bergantung pada kata-kata logis.',
                ],
            ],

            // MP 13: Stress Coping
            [
                'category_name' => 'Stress Coping',
                'category_slug' => 'stress-coping',
                'category_description' => 'How you respond to stress - fight or flight',
                'category_icon' => 'fas fa-shield-alt',
                'category_color' => '#c0392b',
                'course_title' => 'MP13: Stress Coping - Passive vs Aggressive',
                'course_slug' => 'mp13-stress-coping',
                'course_description' => 'Meta Program untuk mengukur respons terhadap stres',
                'questions' => [
                    'Saat stres, saya cenderung mundur atau menghindari ancaman.',
                    'Saya langsung maju dan menghadapi stres secara agresif.',
                    'Respons saya terhadap bahaya adalah lari daripada lawan.',
                    'Saya gunakan pendekatan asertif (bicara dulu) daripada insting fight/flight.',
                    'Stres membuat saya ingin "go at it" daripada "get away".',
                ],
            ],

            // MP 14: Referencing Style
            [
                'category_name' => 'Referencing Style',
                'category_slug' => 'referencing-style',
                'category_description' => 'External vs internal locus of reference',
                'category_icon' => 'fas fa-balance-scale',
                'category_color' => '#d35400',
                'course_title' => 'MP14: Referencing Style - External vs Internal',
                'course_slug' => 'mp14-referencing-style',
                'course_description' => 'Meta Program untuk mengukur lokus kontrol - eksternal vs internal',
                'questions' => [
                    'Saya sering mencari pendapat orang lain sebelum memutuskan.',
                    'Pilihan saya lebih bergantung pada nilai diri sendiri daripada otoritas luar.',
                    'Lokus kontrol saya ada di luar, seperti opini teman atau atasan.',
                    'Saya andalkan diri sendiri sebagai otoritas utama.',
                    'Saat ragu, saya tanya orang lain daripada introspeksi internal.',
                ],
            ],

            // MP 15: Emotional State
            [
                'category_name' => 'Emotional State',
                'category_slug' => 'emotional-state',
                'category_description' => 'Associated vs dissociated from emotions',
                'category_icon' => 'fas fa-heart',
                'category_color' => '#e84393',
                'course_title' => 'MP15: Emotional State - Associated vs Dissociated',
                'course_slug' => 'mp15-emotional-state',
                'course_description' => 'Meta Program untuk mengukur keterlibatan emosional',
                'questions' => [
                    'Saat mengingat pengalaman, saya merasakannya lagi secara penuh emosional.',
                    'Saya lihat kenangan dari luar, seperti menonton film tanpa emosi kuat.',
                    'Emosi saya sering intens karena saya "masuk" ke dalam situasi.',
                    'Saya tetap netral secara emosional, melihat dari posisi kedua/ketiga.',
                    'Dalam kerja, saya rasakan emosi langsung daripada amati dari jauh.',
                ],
            ],

            // MP 16: Somatic Response
            [
                'category_name' => 'Somatic Response',
                'category_slug' => 'somatic-response',
                'category_description' => 'Active, inactive, or reactive response pattern',
                'category_icon' => 'fas fa-running',
                'category_color' => '#00b894',
                'course_title' => 'MP16: Somatic Response - Active/Inactive/Reactive',
                'course_slug' => 'mp16-somatic-response',
                'course_description' => 'Meta Program untuk mengukur pola respon somatik',
                'questions' => [
                    'Ketika menghadapi situasi baru, saya biasanya bertindak cepat setelah menilainya.',
                    'Dalam situasi sosial, saya biasanya bertindak cepat setelah menilainya.',
                    'Saya cenderung melakukan studi mendetail sebelum bertindak.',
                    'Saat menyadari telah menunda-nunda, saya segera bertindak.',
                    'Dalam krisis, saya orang yang pertama bergerak.',
                ],
            ],

            // MP 17: Convincer Sort
            [
                'category_name' => 'Convincer Sort',
                'category_slug' => 'convincer-sort',
                'category_description' => 'VAK & Language convincer patterns',
                'category_icon' => 'fas fa-check-circle',
                'category_color' => '#fdcb6e',
                'course_title' => 'MP17: Convincer Sort - VAK & Language',
                'course_slug' => 'mp17-convincer-sort',
                'course_description' => 'Meta Program untuk mengukur bagaimana seseorang yakin',
                'questions' => [
                    'Saya memutuskan pilihan mobil berdasarkan tampilan visualnya.',
                    'Saat memilih liburan, saya membayangkan suara atau perasaan di sana.',
                    'Saat memikirkan liburan, saya melihat atau mendengar tentangnya.',
                    'Produk terasa tepat bagi saya melalui firasat atau perasaan.',
                    'Saya perlu mendengar beberapa kali sebelum benar-benar yakin.',
                ],
            ],

            // MP 18: Emotional Direction
            [
                'category_name' => 'Emotional Direction',
                'category_slug' => 'emotional-direction',
                'category_description' => 'Uni-directional vs multi-directional emotions',
                'category_icon' => 'fas fa-arrows-alt',
                'category_color' => '#6c5ce7',
                'course_title' => 'MP18: Emotional Direction - Uni vs Multi Directional',
                'course_slug' => 'mp18-emotional-direction',
                'course_description' => 'Meta Program untuk mengukur sebaran emosi',
                'questions' => [
                    'Kegembiraan di satu bidang memengaruhi perasaan saya tentang bidang lain.',
                    'Jika hari buruk di kerja, saya membawanya pulang.',
                    'Kemarahan terbatas pada situasi penyebabnya, tidak menyebar.',
                    'Saya mudah memisahkan perasaan tentang orang A dari orang B.',
                    'Masalah di rumah bisa saya kesampingkan saat bekerja.',
                ],
            ],

            // MP 19: Emotional Intensity
            [
                'category_name' => 'Emotional Intensity',
                'category_slug' => 'emotional-intensity',
                'category_description' => 'Desurgency vs surgency; timidity vs boldness',
                'category_icon' => 'fas fa-bolt',
                'category_color' => '#e17055',
                'course_title' => 'MP19: Emotional Intensity - Desurgency vs Surgency',
                'course_slug' => 'mp19-emotional-intensity',
                'course_description' => 'Meta Program untuk mengukur intensitas ekspresi emosi',
                'questions' => [
                    'Saat sangat bahagia, orang lain bisa jelas melihatnya dari ekspresi saya.',
                    'Saya lebih suka mempertahankan ketenangan emosional.',
                    'Saya senang mengekspresikan perasaan dengan kuat.',
                    'Dalam situasi tidak pasti, saya cenderung berhati-hati.',
                    'Sering emosi mengambil alih vs saya menahan emosi tetap terkendali.',
                ],
            ],

            // MP 20: Motivation Direction
            [
                'category_name' => 'Motivation Direction',
                'category_slug' => 'motivation-direction',
                'category_description' => 'Away from vs toward motivation',
                'category_icon' => 'fas fa-sign-out-alt',
                'category_color' => '#00cec9',
                'course_title' => 'MP20: Motivation Direction - Away From vs Toward',
                'course_slug' => 'mp20-motivation-direction',
                'course_description' => 'Meta Program untuk mengukur arah motivasi',
                'questions' => [
                    'Dalam hubungan, saya fokus pada menghindari masalah.',
                    'Saya ingin mendapatkan kebahagiaan dari hubungan.',
                    'Yang penting dari pekerjaan adalah menghindari stres.',
                    'Saya fokus pada potensi promosi dan belajar.',
                    'Fokus utama saya adalah memastikan tidak ada hal buruk terjadi.',
                ],
            ],

            // MP 21: Adaptation Style
            [
                'category_name' => 'Adaptation Style',
                'category_slug' => 'adaptation-style',
                'category_description' => 'Procedures vs options preference',
                'category_icon' => 'fas fa-cogs',
                'category_color' => '#74b9ff',
                'course_title' => 'MP21: Adaptation Style - Procedures vs Options',
                'course_slug' => 'mp21-adaptation-style',
                'course_description' => 'Meta Program untuk mengukur preferensi prosedur vs opsi',
                'questions' => [
                    'Saya memilih mobil karena fitur dan spesifikasinya.',
                    'Saat memasak hidangan baru, saya ikuti resep dengan tepat.',
                    'Diberikan tugas, saya cari instruksi langkah demi langkah.',
                    'Yang penting adalah melakukan sesuatu dengan benar.',
                    'Saya cari solusi yang telah terbukti.',
                ],
            ],

            // MP 22: Adaptation Sort
            [
                'category_name' => 'Adaptation Sort',
                'category_slug' => 'adaptation-sort',
                'category_description' => 'Judger/adaptor vs perceiver/floater',
                'category_icon' => 'fas fa-tasks',
                'category_color' => '#a29bfe',
                'course_title' => 'MP22: Adaptation Sort - Judger vs Perceiver',
                'course_slug' => 'mp22-adaptation-sort',
                'course_description' => 'Meta Program untuk mengukur gaya adaptasi - terstruktur vs fleksibel',
                'questions' => [
                    'Saya suka menjalani hidup dengan rencana.',
                    'Saya merasa mudah mengambil keputusan.',
                    'Saya suka membuat garis besar dan merencanakan secara teratur.',
                    'Saya memiliki dan menggunakan daytimer/kalender.',
                    'Saat bertemu kelompok baru, saya cenderung berusaha memimpin.',
                ],
            ],

            // MP 23: Modal Operators
            [
                'category_name' => 'Modal Operators',
                'category_slug' => 'modal-operators',
                'category_description' => 'Necessity vs desire; impossibility vs possibility',
                'category_icon' => 'fas fa-key',
                'category_color' => '#fd79a8',
                'course_title' => 'MP23: Modal Operators - Necessity vs Desire',
                'course_slug' => 'mp23-modal-operators',
                'course_description' => 'Meta Program untuk mengukur pola bahasa motivasi',
                'questions' => [
                    'Saya memotivasi diri dengan "saya harus pergi bekerja".',
                    'Saya mengatakan "saya ingin mulai bergerak".',
                    'Saya menggunakan "saya harus mencapai ini".',
                    'Sering saya gunakan "must" dan "should" dalam percakapan.',
                    'Hadapi tantangan dengan "tidak mungkin" atau "bisa dicoba".',
                ],
            ],

            // MP 24: Preference Sort
            [
                'category_name' => 'Preference Sort',
                'category_slug' => 'preference-sort',
                'category_description' => 'People, things, activity, information, location',
                'category_icon' => 'fas fa-star',
                'category_color' => '#fab1a0',
                'course_title' => 'MP24: Preference Sort - People/Things/Activity/Info/Location',
                'course_slug' => 'mp24-preference-sort',
                'course_description' => 'Meta Program untuk mengukur prioritas preferensi',
                'questions' => [
                    'Hal terpenting dalam liburan adalah orang-orangnya.',
                    'Saya butuh aktivitas menarik agar liburan hebat.',
                    'Restoran favorit karena makanannya dan lokasinya.',
                    'Dalam proyek, saya tertarik pada orang-orangnya.',
                    'Dalam pekerjaan ideal, lokasinya yang paling penting.',
                ],
            ],

            // MP 25: Goal Striving
            [
                'category_name' => 'Goal Striving',
                'category_slug' => 'goal-striving',
                'category_description' => 'Perfectionism vs optimization vs skepticism',
                'category_icon' => 'fas fa-bullseye',
                'category_color' => '#006266',
                'course_title' => 'MP25: Goal Striving - Perfectionism vs Optimization',
                'course_slug' => 'mp25-goal-striving',
                'course_description' => 'Meta Program untuk mengukur gaya mengejar tujuan',
                'questions' => [
                    'Proyek harus "sempurna" sebelum saya anggap selesai.',
                    'Saya lebih fokus pada hasil akhir yang sempurna.',
                    'Jika tidak mencapai tujuan, saya anggap tidak realistis.',
                    'Saya menyeimbangkan kualitas tinggi dengan kecepatan.',
                    'Saya cenderung menghindari situasi kompetisi.',
                ],
            ],

            // MP 26: Buying Sort
            [
                'category_name' => 'Buying Sort',
                'category_slug' => 'buying-sort',
                'category_description' => 'Cost, convenience, quality, time preference',
                'category_icon' => 'fas fa-shopping-cart',
                'category_color' => '#e84393',
                'course_title' => 'MP26: Buying Sort - Cost/Convenience/Quality/Time',
                'course_slug' => 'mp26-buying-sort',
                'course_description' => 'Meta Program untuk mengukur kriteria pembelian',
                'questions' => [
                    'Saat membeli, harga adalah pertimbangan utama saya.',
                    'Kenyamanan adalah prioritas dalam pembelian.',
                    'Kualitas adalah yang paling penting saat membeli.',
                    'Waktu pengiriman lebih penting daripada harga terendah.',
                    'Saya korbankan satu faktor demi faktor lain.',
                ],
            ],

            // MP 27: Responsibility
            [
                'category_name' => 'Responsibility Sort',
                'category_slug' => 'responsibility-sort',
                'category_description' => 'Under-responsible, responsible, over-responsible',
                'category_icon' => 'fas fa-user-check',
                'category_color' => '#636e72',
                'course_title' => 'MP27: Responsibility Sort - Under/Over/Responsible',
                'course_slug' => 'mp27-responsibility-sort',
                'course_description' => 'Meta Program untuk mengukur tingkat tanggung jawab',
                'questions' => [
                    'Saat ada yang salah, saya cari faktor eksternal untuk disalahkan.',
                    'Saya melihat peran saya dalam masalah yang terjadi.',
                    'Saya mudah mendelegasikan tugas tanpa campur tangan.',
                    'Saya merasa harus melakukan pekerjaan orang lain agar selesai.',
                    'Dalam konflik, saya merasa berkewajiban menyelesaikan meski bukan tanggung jawab.',
                ],
            ],

            // MP 28: People Convincer
            [
                'category_name' => 'People Convincer',
                'category_slug' => 'people-convincer',
                'category_description' => 'Distrusting-trusting; paranoid-naive spectrum',
                'category_icon' => 'fas fa-users',
                'category_color' => '#2d3436',
                'course_title' => 'MP28: People Convincer - Trusting vs Distrusting',
                'course_slug' => 'mp28-people-convincer',
                'course_description' => 'Meta Program untuk mengukur tingkat kepercayaan terhadap orang lain',
                'questions' => [
                    'Saat bertemu orang baru, saya mulai dari posisi percaya.',
                    'Saya mulai dari posisi tidak percaya sampai terbukti.',
                    'Saya cepat berbagi informasi pribadi dengan rekan baru.',
                    'Butuh banyak bukti untuk memberikan kepercayaan.',
                    'Dalam negosiasi, saya asumsi pihak lain ingin keuntungan.',
                ],
            ],

            // MP 29: Rejuvenation
            [
                'category_name' => 'Rejuvenation Sort',
                'category_slug' => 'rejuvenation-sort',
                'category_description' => 'Extrovert, ambivert, introvert energy source',
                'category_icon' => 'fas fa-battery-full',
                'category_color' => '#0984e3',
                'course_title' => 'MP29: Rejuvenation - Extrovert vs Introvert',
                'course_slug' => 'mp29-rejuvenation-sort',
                'course_description' => 'Meta Program untuk mengukur sumber energi - ekstroversi vs introversi',
                'questions' => [
                    'Saat stres, saya cari waktu sendiri untuk merenung.',
                    'Saat stres, saya cari orang lain untuk dukungan.',
                    'Setelah weekend sibuk, saya merasa berenergi di Senin.',
                    'Jika ada masalah, saya simpan sendiri.',
                    'Setelah pertemuan besar, saya merasa lebih berenergi.',
                ],
            ],

            // MP 30: Affiliation
            [
                'category_name' => 'Affiliation Sort',
                'category_slug' => 'affiliation-sort',
                'category_description' => 'No-team, team and self, or team preference',
                'category_icon' => 'fas fa-project-diagram',
                'category_color' => '#6c5ce7',
                'course_title' => 'MP30: Affiliation - No Team vs Team',
                'course_slug' => 'mp30-affiliation-sort',
                'course_description' => 'Meta Program untuk mengukur preferensi kerja tim',
                'questions' => [
                    'Pengalaman kerja favorit saya adalah mengerjakan proyek sendiri.',
                    'Saya suka bertanggung jawab penuh atas satu bagian.',
                    'Lebih memuaskan menyelesaikan tugas kompleks sendirian.',
                    'Saya melihat diri sebagai partisipan setara dalam tim.',
                    'Saya biasanya menunggu diberi tugas dan fokus pada bagian saya.',
                ],
            ],

            // MP 31: Comparison Sort
            [
                'category_name' => 'Comparison Sort',
                'category_slug' => 'comparison-sort',
                'category_description' => 'Matching vs mismatching comparison style',
                'category_icon' => 'fas fa-balance-scale-right',
                'category_color' => '#00b894',
                'course_title' => 'MP31: Comparison Sort - Matching vs Mismatching',
                'course_slug' => 'mp31-comparison-sort',
                'course_description' => 'Meta Program untuk mengukur gaya membandingkan',
                'questions' => [
                    'Saat melihat dua hal mirip, saya sadari persamaannya dulu.',
                    'Saat melihat dua hal mirip, saya sadari perbedaannya dulu.',
                    'Ketika bertemu teman lama, yang menarik adalah perubahannya.',
                    'Yang membuat ingin berubah adalah kebutuhan sesuatu baru.',
                    'Saat menyusun laporan baru, saya meniru format lama.',
                ],
            ],

            // MP 32: Authority Sort
            [
                'category_name' => 'Authority Sort',
                'category_slug' => 'authority-sort',
                'category_description' => 'Self-reference vs other-reference',
                'category_icon' => 'fas fa-gavel',
                'category_color' => '#b71540',
                'course_title' => 'MP32: Authority Sort - Self vs Other Reference',
                'course_slug' => 'mp32-authority-sort',
                'course_description' => 'Meta Program untuk mengukur sumber otoritas',
                'questions' => [
                    'Saya tahu pekerjaan saya baik dari penilaian sendiri.',
                    'Saya tahu pekerjaan saya baik dari pujian orang lain.',
                    'Saat membeli pakaian, yang penting saya menyukainya.',
                    'Jika pakar bilang saya salah tapi saya yakin benar, saya dengarkan diri.',
                    'Kritik orang lain membuat saya mempertanyakan diri.',
                ],
            ],

            // MP 33: Rapport Sort
            [
                'category_name' => 'Rapport Sort',
                'category_slug' => 'rapport-sort',
                'category_description' => 'Affiliative, confrontational, or responsive',
                'category_icon' => 'fas fa-handshake',
                'category_color' => '#4a69bd',
                'course_title' => 'MP33: Rapport Sort - Affiliative vs Confrontational',
                'course_slug' => 'mp33-rapport-sort',
                'course_description' => 'Meta Program untuk mengukur gaya membangun rapport',
                'questions' => [
                    'Diskusi memanas: saya cari titik temu.',
                    'Diskusi memanas: saya bersemangat mempertahankan argumen.',
                    'Temu mengajukan ide salah: saya sampaikan dengan halus.',
                    'Temu mengajukan ide salah: saya tantang langsung.',
                    'Lingkungan kerja ideal adalah penuh konsensus.',
                ],
            ],

            // MP 34: Knowledge/Competency
            [
                'category_name' => 'Knowledge Competency',
                'category_slug' => 'knowledge-competency',
                'category_description' => 'Demonstrated, undemonstrated, or conceptual',
                'category_icon' => 'fas fa-graduation-cap',
                'category_color' => '#1e3799',
                'course_title' => 'MP34: Knowledge Competency - Demonstrated vs Conceptual',
                'course_slug' => 'mp34-knowledge-competency',
                'course_description' => 'Meta Program untuk mengukur bagaimana kompetensi dinilai',
                'questions' => [
                    'Merekrut: saya cari pengalaman kerja terbukti.',
                    'Merekrut: saya cari potensi dan pemahaman teoritis.',
                    'Saya tahu kuasai skill setelah membaca semua buku.',
                    'Saya tahu kuasai skill setelah mengimplementasikan.',
                    'Saya lebih mengagumi orang dengan gelar akademik.',
                ],
            ],

            // MP 35: Activity Level
            [
                'category_name' => 'Activity Level',
                'category_slug' => 'activity-level',
                'category_description' => 'High, medium, or low activity preference',
                'category_icon' => 'fas fa-tachometer-alt',
                'category_color' => '#0c2461',
                'course_title' => 'MP35: Activity Level - High vs Low',
                'course_slug' => 'mp35-activity-level',
                'course_description' => 'Meta Program untuk mengukur tingkat aktivitas',
                'questions' => [
                    'Saat merencanakan hari, saya isi dengan banyak tugas.',
                    'Saat merencanakan hari, saya pastikan banyak waktu luang.',
                    'Saya berjalan cepat dari satu tempat ke tempat lain.',
                    'Saya belajar dengan cepat dan padat.',
                    'Tempat ramai membuat saya bersemangat.',
                ],
            ],

            // MP 36: Association Sort
            [
                'category_name' => 'Association Sort',
                'category_slug' => 'association-sort',
                'category_description' => 'Associated vs dissociated processing',
                'category_icon' => 'fas fa-link',
                'category_color' => '#3c6382',
                'course_title' => 'MP36: Association Sort - Associated vs Dissociated',
                'course_slug' => 'mp36-association-sort',
                'course_description' => 'Meta Program untuk mengukur gaya asosiasi',
                'questions' => [
                    'Mengingat liburan: saya merasa seperti berada di sana lagi.',
                    'Mengingat liburan: saya melihat diri dalam ingatan.',
                    'Presentasi sulit: saya rasakan semua kegugupan.',
                    'Presentasi sulit: saya lihat diri tampil dari kejauhan.',
                    'Krisis: saya tenggelam dalam emosi.',
                ],
            ],

            // MP 37: Perceptual Sort Internal
            [
                'category_name' => 'Perceptual Focus',
                'category_slug' => 'perceptual-focus',
                'category_description' => 'Internal vs external perceptual focus',
                'category_icon' => 'fas fa-eye-slash',
                'category_color' => '#60a3bc',
                'course_title' => 'MP37: Perceptual Focus - Internal vs External',
                'course_slug' => 'mp37-perceptual-focus',
                'course_description' => 'Meta Program untuk mengukur fokus persepsi',
                'questions' => [
                    'Masuk ruangan: saya perhatikan perasaan tubuh.',
                    'Masuk ruangan: saya lihat sekeliling.',
                    'Berbicara: fokus pada perasaan internal.',
                    'Berbicara: fokus pada bahasa tubuh orang.',
                    'Stres: saya tahu dari sensasi fisik.',
                ],
            ],

            // MP 38: Self vs Other
            [
                'category_name' => 'Self Other Focus',
                'category_slug' => 'self-other-focus',
                'category_description' => 'Self-focused vs other-focused attention',
                'category_icon' => 'fas fa-user-friends',
                'category_color' => '#82ccdd',
                'course_title' => 'MP38: Self vs Other Focus',
                'course_slug' => 'mp38-self-other-focus',
                'course_description' => 'Meta Program untuk mengukur fokus perhatian',
                'questions' => [
                    'Percakapan: saya pikirkan apa yang akan saya katakan.',
                    'Percakapan: saya pikirkan apa yang baru dikatakan.',
                    'Keputusan: saya pikirkan dampaknya pada diri saya.',
                    'Keputusan: saya pikirkan dampaknya pada orang lain.',
                    'Konflik: saya khawatir perasaan mereka.',
                ],
            ],

            // MP 39: Relationship Sort
            [
                'category_name' => 'Relationship Scope',
                'category_slug' => 'relationship-scope',
                'category_description' => 'Self, one other, or group relationship',
                'category_icon' => 'fas fa-user-circle',
                'category_color' => '#3c6382',
                'course_title' => 'MP39: Relationship Scope - Self/One/Group',
                'course_slug' => 'mp39-relationship-scope',
                'course_description' => 'Meta Program untuk mengukur lingkup relasi',
                'questions' => [
                    'Proyek penting: saya lebih suka mengerjakan sendiri.',
                    'Proyek penting: lebih suka dengan satu rekan.',
                    'Proyek penting: lebih suka sebagai bagian tim.',
                    'Pesta besar vs makan santai dengan satu teman.',
                    'Belajar: membaca sendiri/tutor privat/seminar.',
                ],
            ],

            // MP 40: Emotional Sort
            [
                'category_name' => 'Emotional Intensity Sort',
                'category_slug' => 'emotional-intensity-sort',
                'category_description' => 'Intense, moderate, or low emotion',
                'category_icon' => 'fas fa-theater-masks',
                'category_color' => '#b2bec3',
                'course_title' => 'MP40: Emotional Intensity - Intense vs Low',
                'course_slug' => 'mp40-emotional-intensity-sort',
                'course_description' => 'Meta Program untuk mengukur intensitas emosi',
                'questions' => [
                    'Saat bersemangat, orang lain jelas melihat dari ekspresi.',
                    'Saya lebih menghargai orang yang tetap tenang.',
                    'Reaksi saya: orang yang menunjukkan emosi kuat.',
                    'Emosi kuat membantu pengambilan keputusan.',
                    'Kegagalan besar: reaksi dramatis.',
                ],
            ],

            // MP 41: Decision Sort
            [
                'category_name' => 'Decision Source',
                'category_slug' => 'decision-source',
                'category_description' => 'External vs internal decision making',
                'category_icon' => 'fas fa-gavel',
                'category_color' => '#636e72',
                'course_title' => 'MP41: Decision Source - External vs Internal',
                'course_slug' => 'mp41-decision-source',
                'course_description' => 'Meta Program untuk mengukur sumber keputusan',
                'questions' => [
                    'Pilih karir baru: saya buat sendiri setelah berpikir.',
                    'Pilih karir baru: saya perlu konsultasi banyak orang.',
                    'Fakta dan data eksternal lebih penting.',
                    'Waktu merenung internal lebih penting.',
                    'Situasi tidak pasti: saya cari pendapat ahli.',
                ],
            ],

            // MP 42: Action Sort
            [
                'category_name' => 'Action Style',
                'category_slug' => 'action-style',
                'category_description' => 'Reflectivity vs impulsivity',
                'category_icon' => 'fas fa-bolt',
                'category_color' => '#e17055',
                'course_title' => 'MP42: Action Style - Reflective vs Impulsive',
                'course_slug' => 'mp42-action-style',
                'course_description' => 'Meta Program untuk mengukur gaya aksi',
                'questions' => [
                    'Dapat ide hebat: saya segera mulai bertindak.',
                    'Dapat ide hebat: saya habiskan waktu merencanakan.',
                    'Situasi darurat: saya secara naluriah bertindak.',
                    'Situasi darurat: saya mundur sejenak menilai.',
                    'Sering menyesali tindakan terlalu cepat.',
                ],
            ],

            // MP 43: State Sort
            [
                'category_name' => 'State Orientation',
                'category_slug' => 'state-orientation',
                'category_description' => 'Process vs goal orientation',
                'category_icon' => 'fas fa-road',
                'category_color' => '#006266',
                'course_title' => 'MP43: State Sort - Process vs Goal',
                'course_slug' => 'mp43-state-sort',
                'course_description' => 'Meta Program untuk mengukur orientasi proses vs tujuan',
                'questions' => [
                    'Perjalanan jauh: saya nikmati pemandangan sepanjang jalan.',
                    'Perjalanan jauh: saya ingin segera sampai tujuan.',
                    'Selesai proyek: menikmati setiap langkah.',
                    'Selesai proyek: mencapai tujuan yang memuaskan.',
                    'Motivasi tengah proyek: memikirkan kemajuan.',
                ],
            ],

            // MP 44: Status Sort
            [
                'category_name' => 'Status Preference',
                'category_slug' => 'status-preference',
                'category_description' => 'Superior, peer, or subordinate preference',
                'category_icon' => 'fas fa-crown',
                'category_color' => '#f9ca24',
                'course_title' => 'MP44: Status Sort - Superior/Peer/Subordinate',
                'course_slug' => 'mp44-status-sort',
                'course_description' => 'Meta Program untuk mengukur preferensi status',
                'questions' => [
                    'Dalam tim: saya mengambil peran kepemimpinan.',
                    'Dalam tim: saya ikuti arahan yang diberikan.',
                    'Saya lebih nyaman berbicara dengan atasan.',
                    'Saya lebih nyaman berbicara dengan kolega.',
                    'Pertemanan: penting memiliki kedudukan sama.',
                ],
            ],

            // MP 45: Self-Esteem Sort
            [
                'category_name' => 'Self Esteem',
                'category_slug' => 'self-esteem',
                'category_description' => 'High, medium, or low self-esteem',
                'category_icon' => 'fas fa-heart',
                'category_color' => '#badc58',
                'course_title' => 'MP45: Self-Esteem - High vs Low',
                'course_slug' => 'mp45-self-esteem',
                'course_description' => 'Meta Program untuk mengukur tingkat self-esteem',
                'questions' => [
                    'Pujian tulus: saya menerimanya dengan percaya diri.',
                    'Gagal dalam tugas: saya mempertanyakan kemampuan saya.',
                    'Penting mendapatkan pengakuan orang lain.',
                    'Saat merasa tidak aman, saya katakan sesuatu positif.',
                    'Wawancara kerja: mudah menyoroti kekuatan.',
                ],
            ],

            // MP 46: Time Orientation
            [
                'category_name' => 'Time Orientation',
                'category_slug' => 'time-orientation',
                'category_description' => 'Past, present, or future orientation',
                'category_icon' => 'fas fa-clock',
                'category_color' => '#dff9fb',
                'course_title' => 'MP46: Time Orientation - Past/Present/Future',
                'course_slug' => 'mp46-time-orientation',
                'course_description' => 'Meta Program untuk mengukur orientasi waktu',
                'questions' => [
                    'Keputusan besar: saya pikirkan pelajaran masa lalu.',
                    'Keputusan besar: saya pikirkan kebutuhan saat ini.',
                    'Keputusan besar: saya pikirkan tujuan masa depan.',
                    'Lebih penting: menghormati tradisi.',
                    'Lebih penting: merencanakan inovasi.',
                ],
            ],

            // MP 47: Time Tense
            [
                'category_name' => 'Time Tense',
                'category_slug' => 'time-tense',
                'category_description' => 'In time vs through time',
                'category_icon' => 'fas fa-hourglass',
                'category_color' => '#c7ecee',
                'course_title' => 'MP47: Time Tense - In Time vs Through Time',
                'course_slug' => 'mp47-time-tense',
                'course_description' => 'Meta Program untuk mengukur persepsi waktu',
                'questions' => [
                    'Saya cenderung mudah lupa waktu saat sibuk.',
                    'Saya menggunakan kalender terstruktur.',
                    'Saya mengandalkan perasaan dan ingatan.',
                    'Seseorang terlambat: reaksi saya fleksibel.',
                    'Masa depan: sesuatu yang saya masuki.',
                ],
            ],

            // MP 48: Time Access
            [
                'category_name' => 'Time Access',
                'category_slug' => 'time-access',
                'category_description' => 'Sequential vs random access',
                'category_icon' => 'fas fa-sort-numeric-down',
                'category_color' => '#95afc0',
                'course_title' => 'MP48: Time Access - Sequential vs Random',
                'course_slug' => 'mp48-time-access',
                'course_description' => 'Meta Program untuk mengukur pola akses waktu',
                'questions' => [
                    'Bercerita: saya mulai dari awal sampai akhir.',
                    'Bercerita: saya sering melompat ke belakang/depan.',
                    'Belajar topik: harus paham A sebelum B.',
                    'Belajar topik: nyaman memproses banyak info sekaligus.',
                    'Berikan petunjuk: setiap belokan berurutan.',
                ],
            ],

            // MP 49: Ego Strength
            [
                'category_name' => 'Ego Strength',
                'category_slug' => 'ego-strength',
                'category_description' => 'Unstable vs stable; reactive vs proactive',
                'category_icon' => 'fas fa-fist-raised',
                'category_color' => '#535c68',
                'course_title' => 'MP49: Ego Strength - Stable vs Reactive',
                'course_slug' => 'mp49-ego-strength',
                'course_description' => 'Meta Program untuk mengukur kekuatan ego',
                'questions' => [
                    'Kegagalan besar: saya cepat bangkit cari solusi.',
                    'Kritik menyakitkan: saya tetap tenang.',
                    'Masalah: saya respon muncul atau cegah.',
                    'Konflik: saya mudah terintimidasi.',
                    'Pendapat orang menentukan suasana hati.',
                ],
            ],

            // MP 50: Morality Sort
            [
                'category_name' => 'Morality Sort',
                'category_slug' => 'morality-sort',
                'category_description' => 'Weak vs strong super-ego',
                'category_icon' => 'fas fa-balance-scale',
                'category_color' => '#222f3e',
                'course_title' => 'MP50: Morality Sort - Weak vs Strong Super-Ego',
                'course_slug' => 'mp50-morality-sort',
                'course_description' => 'Meta Program untuk mengukur moralitas',
                'questions' => [
                    'Kesempatan untung dengan langgar aturan kecil: saya ambil.',
                    'Hasil sukses lebih penting daripada cara etis.',
                    'Mudah memaafkan diri saat salah moral.',
                    'Sering merasa bersalah saat tidak lakukan yang "seharusnya".',
                    'Melihat orang bertindak tidak etis: saya reaksikan.',
                ],
            ],

            // MP 51: Causation Sort
            [
                'category_name' => 'Causation Sort',
                'category_slug' => 'causation-sort',
                'category_description' => 'Personal, linear, multi-cause, or causeless attribution',
                'category_icon' => 'fas fa-project-diagram',
                'category_color' => '#576574',
                'course_title' => 'MP51: Causation Sort - Attribution Style',
                'course_slug' => 'mp51-causation-sort',
                'course_description' => 'Meta Program untuk mengukur gaya atribusi sebab-akibat',
                'questions' => [
                    'Hal buruk terjadi: saya cari siapa bertanggung jawab.',
                    'Hal buruk terjadi: saya cari satu penyebab utama.',
                    'Hal buruk terjadi: saya lihat banyak faktor berkontribusi.',
                    'Kehidupan dikendalikan nasib vs pilihan sendiri.',
                    'Dua hal terjadi bersamaan: satu menyebabkan yang lain.',
                ],
            ],
        ];
    }
}

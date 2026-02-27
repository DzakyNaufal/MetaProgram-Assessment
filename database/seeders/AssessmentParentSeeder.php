<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AssessmentParentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing assessment courses first
        $existingSlugs = [
            'full-assessment-basic',
            'assessment-kategori-1-kepribadian',
            'assessment-kategori-2-gaya-kerja',
            'assessment-kategori-3-komunikasi',
            'assessment-kategori-4-leadership',
            'assessment-kategori-5-pertumbuhan',
            'assessment-premium-konsultasi',
            'assessment-elite-konsultasi-coaching',
        ];

        // Delete questions and options first (cascade)
        Course::whereIn('slug', $existingSlugs)->delete();

        // ==================== ASSESSMENT - BASIC ====================

        // Create Parent Course: Meta Programs Assessment - Basic
        $parentBasic = Course::create([
            'title' => 'Meta Programs Assessment - Basic',
            'slug' => 'meta-programs-assessment-basic',
            'description' => 'Pilih jenis assessment yang sesuai dengan kebutuhan Anda. Tersedia Full Assessment lengkap atau Assessment per kategori spesifik.',
            'thumbnail' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800',
            'estimated_time' => 15,
            'price' => 0, // Free - parent is just a menu
            'is_active' => true,
            'has_whatsapp_consultation' => false,
            'has_offline_coaching' => false,
            'order' => 10,
        ]);

        // Create Categories as Options (these will be displayed as course options)
        $catFull = Category::create([
            'course_id' => $parentBasic->id,
            'name' => 'Full Assessment - Basic',
            'slug' => 'full-assessment-basic',
            'description' => 'Assessment lengkap 5 kategori: Kepribadian, Gaya Kerja, Komunikasi, Leadership, dan Pertumbuhan. Hemat Rp. 251.000!',
            'icon' => 'star',
            'color' => '#3B82F6',
            'order' => 1,
            'is_active' => true,
            'price' => 999000, // Custom price for this category
        ]);

        $cat1 = Category::create([
            'course_id' => $parentBasic->id,
            'name' => 'Kategori 1 - Kepribadian',
            'slug' => 'kategori-1-kepribadian',
            'description' => 'Kenali tipe kepribadian dasar Anda dan bagaimana hal itu mempengaruhi cara Anda berinteraksi.',
            'icon' => 'user',
            'color' => '#3B82F6',
            'order' => 2,
            'is_active' => true,
            'price' => 250000,
        ]);

        $cat2 = Category::create([
            'course_id' => $parentBasic->id,
            'name' => 'Kategori 2 - Gaya Kerja',
            'slug' => 'kategori-2-gaya-kerja',
            'description' => 'Temukan gaya kerja yang paling sesuai dengan karakter Anda untuk produktivitas maksimal.',
            'icon' => 'briefcase',
            'color' => '#10B981',
            'order' => 3,
            'is_active' => true,
            'price' => 250000,
        ]);

        $cat3 = Category::create([
            'course_id' => $parentBasic->id,
            'name' => 'Kategori 3 - Komunikasi',
            'slug' => 'kategori-3-komunikasi',
            'description' => 'Pahami gaya komunikasi Anda dan bagaimana berkomunikasi lebih efektif dengan orang lain.',
            'icon' => 'message-circle',
            'color' => '#8B5CF6',
            'order' => 4,
            'is_active' => true,
            'price' => 250000,
        ]);

        $cat4 = Category::create([
            'course_id' => $parentBasic->id,
            'name' => 'Kategori 4 - Leadership',
            'slug' => 'kategori-4-leadership',
            'description' => 'Kenali potensi kepemimpinan Anda dan kembangkan gaya memimpin yang efektif.',
            'icon' => 'users',
            'color' => '#F59E0B',
            'order' => 5,
            'is_active' => true,
            'price' => 250000,
        ]);

        $cat5 = Category::create([
            'course_id' => $parentBasic->id,
            'name' => 'Kategori 5 - Pertumbuhan',
            'slug' => 'kategori-5-pertumbuhan',
            'description' => 'Kenali potensi pengembangan diri Anda dan rencanakan pertumbuhan karier yang tepat.',
            'icon' => 'trending-up',
            'color' => '#EC4899',
            'order' => 6,
            'is_active' => true,
            'price' => 250000,
        ]);

        // Questions for each category
        // Full Assessment Questions
        $this->createQuestion($parentBasic, $catFull, 1, 'Saat menghadapi masalah, Anda lebih cenderung:', [
            ['option_text' => 'Mencari solusi praktis yang bisa langsung diterapkan', 'talent_type' => 'RES'],
            ['option_text' => 'Menganalisis penyebab masalah secara mendalam', 'talent_type' => 'ANA'],
            ['option_text' => 'Mencari cara kreatif dan unik untuk mengatasinya', 'talent_type' => 'EXP'],
            ['option_text' => 'Mengikuti prosedur yang sudah terbukti berhasil', 'talent_type' => 'CON'],
        ]);

        $this->createQuestion($parentBasic, $catFull, 2, 'Lingkungan kerja ideal Anda adalah:', [
            ['option_text' => 'Lapangan atau workshop dengan alat-alat', 'talent_type' => 'RES'],
            ['option_text' => 'Kantor yang rapi dan terorganisir', 'talent_type' => 'CON'],
            ['option_text' => 'Studio ruang kreatif yang bebas', 'talent_type' => 'EXP'],
            ['option_text' => 'Perpustakaan atau laboratorium tenang', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($parentBasic, $catFull, 3, 'Dalam presentasi, Anda lebih suka:', [
            ['option_text' => 'Demonstrasi langsung produk', 'talent_type' => 'RES'],
            ['option_text' => 'Slide yang terstruktur rapi', 'talent_type' => 'CON'],
            ['option_text' => 'Storytelling yang menarik', 'talent_type' => 'EXP'],
            ['option_text' => 'Data dan analisis yang mendalam', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($parentBasic, $catFull, 4, 'Gaya memimpin Anda:', [
            ['option_text' => 'Lead by example', 'talent_type' => 'RES'],
            ['option_text' => 'Delegasi dengan jelas', 'talent_type' => 'CON'],
            ['option_text' => 'Inspirasi dan vision', 'talent_type' => 'EXP'],
            ['option_text' => 'Data-driven decision', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($parentBasic, $catFull, 5, 'Cara Anda beradaptasi dengan perubahan:', [
            ['option_text' => 'Coba dan adaptasi langsung', 'talent_type' => 'RES'],
            ['option_text' => 'Pelajari aturan baru dulu', 'talent_type' => 'CON'],
            ['option_text' => 'Anggap sebagai kesempatan baru', 'talent_type' => 'EXP'],
            ['option_text' => 'Analisis dampak perubahan', 'talent_type' => 'ANA'],
        ]);

        // Kategori 1 Questions
        $this->createQuestion($parentBasic, $cat1, 6, 'Aktivitas yang paling Anda nikmati:', [
            ['option_text' => 'Membuat sesuatu dengan tangan (kerajinan, memasak)', 'talent_type' => 'RES'],
            ['option_text' => 'Mengorganisir acara atau jadwal', 'talent_type' => 'CON'],
            ['option_text' => 'Menulis, melukis, atau berkarya seni', 'talent_type' => 'EXP'],
            ['option_text' => 'Membaca buku atau memecahkan puzzle', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($parentBasic, $cat1, 7, 'Dalam situasi sosial, Anda:', [
            ['option_text' => 'Langsung terlibat dalam aktivitas', 'talent_type' => 'RES'],
            ['option_text' => 'Mengamati dan menganalisis interaksi', 'talent_type' => 'ANA'],
            ['option_text' => 'Mencari topik pembicaraan unik', 'talent_type' => 'EXP'],
            ['option_text' => 'Mengikuti aturan sosial yang ada', 'talent_type' => 'CON'],
        ]);

        // Kategori 2 Questions
        $this->createQuestion($parentBasic, $cat2, 8, 'Dalam kerja tim, Anda biasanya:', [
            ['option_text' => 'Langsung terjun bekerja tanpa banyak diskusi', 'talent_type' => 'RES'],
            ['option_text' => 'Membagi tugas secara jelas dan teratur', 'talent_type' => 'CON'],
            ['option_text' => 'Mencari ide baru yang belum pernah dicoba', 'talent_type' => 'EXP'],
            ['option_text' => 'Menganalisis kontribusi setiap anggota tim', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($parentBasic, $cat2, 9, 'Cara Anda mengatur waktu:', [
            ['option_text' => 'Fleksibel sesuai mood', 'talent_type' => 'EXP'],
            ['option_text' => 'Terjadwal dan disiplin', 'talent_type' => 'CON'],
            ['option_text' => 'Bekerja saat ada momentum', 'talent_type' => 'RES'],
            ['option_text' => 'Berdasarkan prioritas yang dianalisis', 'talent_type' => 'ANA'],
        ]);

        // Kategori 3 Questions
        $this->createQuestion($parentBasic, $cat3, 10, 'Dalam meeting, Anda biasanya:', [
            ['option_text' => 'Singkat dan to the point', 'talent_type' => 'RES'],
            ['option_text' => 'Well prepared dan terstruktur', 'talent_type' => 'CON'],
            ['option_text' => 'Membawa ide out of the box', 'talent_type' => 'EXP'],
            ['option_text' => 'Mempresentasikan data lengkap', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($parentBasic, $cat3, 11, 'Saat berdebat, Anda:', [
            ['option_text' => 'Gunakan contoh nyata', 'talent_type' => 'RES'],
            ['option_text' => 'Susun argumen secara logis', 'talent_type' => 'CON'],
            ['option_text' => 'Cari perspektif berbeda', 'talent_type' => 'EXP'],
            ['option_text' => 'Analisis argumen lawan', 'talent_type' => 'ANA'],
        ]);

        // Kategori 4 Questions
        $this->createQuestion($parentBasic, $cat4, 12, 'Tipe bos yang Anda sukai:', [
            ['option_text' => 'Yang terjun langsung bersama tim', 'talent_type' => 'RES'],
            ['option_text' => 'Yang jelas aturan dan ekspektasi', 'talent_type' => 'CON'],
            ['option_text' => 'Yang terbuka pada ide baru', 'talent_type' => 'EXP'],
            ['option_text' => 'Yang berdasar pada merit', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($parentBasic, $cat4, 13, 'Saat memimpin tim, Anda fokus pada:', [
            ['option_text' => 'Hasil yang bisa dicapai', 'talent_type' => 'RES'],
            ['option_text' => 'Proses yang teratur', 'talent_type' => 'CON'],
            ['option_text' => 'Inovasi tim', 'talent_type' => 'EXP'],
            ['option_text' => 'Pengembangan tim', 'talent_type' => 'ANA'],
        ]);

        // Kategori 5 Questions
        $this->createQuestion($parentBasic, $cat5, 14, 'Sifat yang ingin Anda kembangkan:', [
            ['option_text' => 'Lebih percaya diri', 'talent_type' => 'RES'],
            ['option_text' => 'Lebih konsisten', 'talent_type' => 'CON'],
            ['option_text' => 'Lebih ekspresif', 'talent_type' => 'EXP'],
            ['option_text' => 'Lebih kritis', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($parentBasic, $cat5, 15, 'Cara Anda menghadapi kegagalan:', [
            ['option_text' => 'Coba lagi dengan cara berbeda', 'talent_type' => 'RES'],
            ['option_text' => 'Evaluasi apa yang salah', 'talent_type' => 'CON'],
            ['option_text' => 'Cari peluang di balik kegagalan', 'talent_type' => 'EXP'],
            ['option_text' => 'Analisis penyebabnya', 'talent_type' => 'ANA'],
        ]);

        // ==================== ASSESSMENT - PREMIUM ====================

        $premium = Course::create([
            'title' => 'Assessment Premium - dengan Konsultasi',
            'slug' => 'assessment-premium-konsultasi',
            'description' => 'Assessment lengkap PLUS sesi konsultasi personal via WhatsApp untuk membahas hasil dan mendapatkan rekomendasi karier.',
            'thumbnail' => 'https://images.unsplash.com/photo-1600880292203-757bb62b4baf?w=800',
            'estimated_time' => 60,
            'price' => 2500000,
            'is_active' => true,
            'has_whatsapp_consultation' => true,
            'has_offline_coaching' => false,
            'order' => 20,
        ]);

        $catPrem1 = Category::create([
            'course_id' => $premium->id,
            'name' => 'Kepribadian Mendalam',
            'slug' => 'kepribadian-mendalam',
            'description' => 'Analisis kepribadian yang lebih mendalam',
            'icon' => 'user',
            'color' => '#3B82F6',
            'order' => 1,
            'is_active' => true,
        ]);

        $catPrem2 = Category::create([
            'course_id' => $premium->id,
            'name' => 'Gaya Kerja Optimal',
            'slug' => 'gaya-kerja-optimal',
            'description' => 'Temukan gaya kerja paling optimal',
            'icon' => 'briefcase',
            'color' => '#10B981',
            'order' => 2,
            'is_active' => true,
        ]);

        $catPrem3 = Category::create([
            'course_id' => $premium->id,
            'name' => 'Komunikasi Efektif',
            'slug' => 'komunikasi-efektif',
            'description' => 'Tingkatkan efektivitas komunikasi',
            'icon' => 'message-circle',
            'color' => '#8B5CF6',
            'order' => 3,
            'is_active' => true,
        ]);

        $catPrem4 = Category::create([
            'course_id' => $premium->id,
            'name' => 'Leadership Style',
            'slug' => 'leadership-style',
            'description' => 'Gaya kepemimpinan Anda',
            'icon' => 'users',
            'color' => '#F59E0B',
            'order' => 4,
            'is_active' => true,
        ]);

        $catPrem5 = Category::create([
            'course_id' => $premium->id,
            'name' => 'Potensi Karier',
            'slug' => 'potensi-karier',
            'description' => 'Analisis potensi karier',
            'icon' => 'trending-up',
            'color' => '#EC4899',
            'order' => 5,
            'is_active' => true,
        ]);

        $this->createQuestion($premium, $catPrem1, 1, 'Dalam situasi krisis, Anda:', [
            ['option_text' => 'Langsung bertindak', 'talent_type' => 'RES'],
            ['option_text' => 'Ikuti protokol', 'talent_type' => 'CON'],
            ['option_text' => 'Cari solusi kreatif', 'talent_type' => 'EXP'],
            ['option_text' => 'Analisis situasi', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($premium, $catPrem2, 2, 'Cara Anda mengambil keputusan besar:', [
            ['option_text' => 'Berdasarkan insting', 'talent_type' => 'RES'],
            ['option_text' => 'Sesuai prosedur', 'talent_type' => 'CON'],
            ['option_text' => 'Dengan pendekatan baru', 'talent_type' => 'EXP'],
            ['option_text' => 'Berdasarkan data', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($premium, $catPrem3, 3, 'Negosiasi terbaik Anda adalah:', [
            ['option_text' => 'Langsung to the point', 'talent_type' => 'RES'],
            ['option_text' => 'Terstruktur dan sistematis', 'talent_type' => 'CON'],
            ['option_text' => 'Kreatif dan fleksibel', 'talent_type' => 'EXP'],
            ['option_text' => 'Berdasarkan fakta', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($premium, $catPrem4, 4, 'Sebagai leader, Anda:', [
            ['option_text' => 'Turun langsung', 'talent_type' => 'RES'],
            ['option_text' => 'Atur delegasi', 'talent_type' => 'CON'],
            ['option_text' => 'Berikan visi', 'talent_type' => 'EXP'],
            ['option_text' => 'Buat strategi', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($premium, $catPrem5, 5, 'Tujuan karier 5 tahun ke depan:', [
            ['option_text' => 'Praktisi ahli', 'talent_type' => 'RES'],
            ['option_text' => 'Manajer stabil', 'talent_type' => 'CON'],
            ['option_text' => 'Inovator', 'talent_type' => 'EXP'],
            ['option_text' => 'Strategis', 'talent_type' => 'ANA'],
        ]);

        // ==================== ASSESSMENT - ELITE ====================

        $elite = Course::create([
            'title' => 'Assessment Elite - dengan Konsultasi & Coaching',
            'slug' => 'assessment-elite-konsultasi-coaching',
            'description' => 'Assessment komprehensif PLUS sesi konsultasi personal dan coaching offline untuk transformasi karier maksimal.',
            'thumbnail' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=800',
            'estimated_time' => 90,
            'price' => 7500000,
            'is_active' => true,
            'has_whatsapp_consultation' => true,
            'has_offline_coaching' => true,
            'order' => 30,
        ]);

        $catElite1 = Category::create([
            'course_id' => $elite->id,
            'name' => 'Core Identity',
            'slug' => 'core-identity',
            'description' => 'Identitas diri yang sejati',
            'icon' => 'user',
            'color' => '#3B82F6',
            'order' => 1,
            'is_active' => true,
        ]);

        $catElite2 = Category::create([
            'course_id' => $elite->id,
            'name' => 'Strength Mastery',
            'slug' => 'strength-mastery',
            'description' => 'Kuasai kekuatan utama Anda',
            'icon' => 'briefcase',
            'color' => '#10B981',
            'order' => 2,
            'is_active' => true,
        ]);

        $catElite3 = Category::create([
            'course_id' => $elite->id,
            'name' => 'Impact Communication',
            'slug' => 'impact-communication',
            'description' => 'Komunikasi berdampak',
            'icon' => 'message-circle',
            'color' => '#8B5CF6',
            'order' => 3,
            'is_active' => true,
        ]);

        $catElite4 = Category::create([
            'course_id' => $elite->id,
            'name' => 'Visionary Leadership',
            'slug' => 'visionary-leadership',
            'description' => 'Kepemimpinan visioner',
            'icon' => 'users',
            'color' => '#F59E0B',
            'order' => 4,
            'is_active' => true,
        ]);

        $catElite5 = Category::create([
            'course_id' => $elite->id,
            'name' => 'Life Purpose',
            'slug' => 'life-purpose',
            'description' => 'Tujuan hidup dan karier',
            'icon' => 'trending-up',
            'color' => '#EC4899',
            'order' => 5,
            'is_active' => true,
        ]);

        $this->createQuestion($elite, $catElite1, 1, 'Apa definisi sukses bagi Anda?', [
            ['option_text' => 'Mencapai target nyata', 'talent_type' => 'RES'],
            ['option_text' => 'Punya posisi stabil', 'talent_type' => 'CON'],
            ['option_text' => 'Bisa berkarya', 'talent_type' => 'EXP'],
            ['option_text' => 'Terus berkembang', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($elite, $catElite2, 2, 'Keunikan terbesar Anda:', [
            ['option_text' => 'Praktis dan eksekusi', 'talent_type' => 'RES'],
            ['option_text' => 'Organisasi dan sistem', 'talent_type' => 'CON'],
            ['option_text' => 'Kreativitas tinggi', 'talent_type' => 'EXP'],
            ['option_text' => 'Analisis mendalam', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($elite, $catElite3, 3, 'Cara Anda mempengaruhi orang:', [
            ['option_text' => 'Dengan contoh nyata', 'talent_type' => 'RES'],
            ['option_text' => 'Dengan logika', 'talent_type' => 'CON'],
            ['option_text' => 'Dengan inspirasi', 'talent_type' => 'EXP'],
            ['option_text' => 'Dengan data', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($elite, $catElite4, 4, 'Visi hidup Anda:', [
            ['option_text' => 'Menciptakan karya', 'talent_type' => 'RES'],
            ['option_text' => 'Membangun sistem', 'talent_type' => 'CON'],
            ['option_text' => 'Mengubah dunia', 'talent_type' => 'EXP'],
            ['option_text' => 'Memecahkan masalah', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($elite, $catElite5, 5, 'Warisan yang ingin tinggalkan:', [
            ['option_text' => 'Karya nyata', 'talent_type' => 'RES'],
            ['option_text' => 'Institusi', 'talent_type' => 'CON'],
            ['option_text' => 'Ide baru', 'talent_type' => 'EXP'],
            ['option_text' => 'Pengetahuan', 'talent_type' => 'ANA'],
        ]);

        $this->command->info('Assessment Parent Courses seeded successfully!');
        $this->command->info(' - Meta Programs Assessment - Basic (with 6 category options)');
        $this->command->info(' - Assessment Premium (1 course)');
        $this->command->info(' - Assessment Elite (1 course)');
    }

    private function createQuestion($course, $category, $order, $text, $options)
    {
        $question = Question::create([
            'course_id' => $course->id,
            'category_id' => $category->id,
            'question_text' => $text,
            'order' => $order,
            'is_active' => true,
        ]);

        foreach ($options as $index => $option) {
            QuestionOption::create([
                'question_id' => $question->id,
                'option_text' => $option['option_text'],
                'talent_type' => $option['talent_type'],
                'order' => $index + 1,
            ]);
        }
    }
}

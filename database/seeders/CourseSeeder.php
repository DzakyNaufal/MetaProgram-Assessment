<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Category;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Course 1: Free - Discover Your Talent
        $course1 = Course::create([
            'title' => 'Discover Your Talent',
            'slug' => 'discover-your-talent',
            'description' => 'Kenali potensi tersembunyi Anda melalui assessment bakat dasar ini.',
            'thumbnail' => 'https://images.unsplash.com/photo-1517486808906-6ca8b3f04846?w=800',
            'estimated_time' => 15,
            'price' => 0, // Free
            'is_active' => true,
            'order' => 1,
        ]);

        // Categories for Course 1
        $cat1_1 = Category::create([
            'course_id' => $course1->id,
            'name' => 'Personality',
            'slug' => 'personality',
            'description' => 'Kenali kepribadian dasar Anda',
            'icon' => 'user',
            'color' => '#3B82F6',
            'order' => 1,
            'is_active' => true,
        ]);

        $cat1_2 = Category::create([
            'course_id' => $course1->id,
            'name' => 'Work Style',
            'slug' => 'work-style',
            'description' => 'Gaya kerja yang paling sesuai untuk Anda',
            'icon' => 'briefcase',
            'color' => '#10B981',
            'order' => 2,
            'is_active' => true,
        ]);

        // Questions for Course 1
        $this->createQuestion($course1, $cat1_1, 1, 'Saat menghadapi masalah, Anda lebih cenderung:', [
            ['option_text' => 'Mencari solusi praktis yang bisa langsung diterapkan', 'talent_type' => 'RES'],
            ['option_text' => 'Menganalisis penyebab masalah secara mendalam', 'talent_type' => 'ANA'],
            ['option_text' => 'Mencari cara kreatif dan unik untuk mengatasinya', 'talent_type' => 'EXP'],
            ['option_text' => 'Mengikuti prosedur yang sudah terbukti berhasil', 'talent_type' => 'CON'],
        ]);

        $this->createQuestion($course1, $cat1_1, 2, 'Aktivitas yang paling Anda nikmati:', [
            ['option_text' => 'Membuat sesuatu dengan tangan (kerajinan, memasak)', 'talent_type' => 'RES'],
            ['option_text' => 'Mengorganisir acara atau jadwal', 'talent_type' => 'CON'],
            ['option_text' => 'Menulis, melukis, atau berkarya seni', 'talent_type' => 'EXP'],
            ['option_text' => 'Membaca buku atau memecahkan puzzle', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($course1, $cat1_2, 3, 'Dalam kerja tim, Anda biasanya:', [
            ['option_text' => 'Langsung terjun bekerja tanpa banyak diskusi', 'talent_type' => 'RES'],
            ['option_text' => 'Membagi tugas secara jelas dan teratur', 'talent_type' => 'CON'],
            ['option_text' => 'Mencari ide baru yang belum pernah dicoba', 'talent_type' => 'EXP'],
            ['option_text' => 'Menganalisis kontribusi setiap anggota tim', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($course1, $cat1_2, 4, 'Saat belajar hal baru, Anda lebih suka:', [
            ['option_text' => 'Langsung mempraktikkan', 'talent_type' => 'RES'],
            ['option_text' => 'Mencatat dan mengorganisir materi', 'talent_type' => 'CON'],
            ['option_text' => 'Mencari cara sendiri yang lebih menarik', 'talent_type' => 'EXP'],
            ['option_text' => 'Memahami konsep dasar terlebih dahulu', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($course1, $cat1_2, 5, 'Lingkungan kerja ideal Anda adalah:', [
            ['option_text' => 'Lapangan atau workshop dengan alat-alat', 'talent_type' => 'RES'],
            ['option_text' => 'Kantor yang rapi dan terorganisir', 'talent_type' => 'CON'],
            ['option_text' => 'Studio ruang kreatif yang bebas', 'talent_type' => 'EXP'],
            ['option_text' => 'Perpustakaan atau laboratorium tenang', 'talent_type' => 'ANA'],
        ]);

        // Course 2: Paid - Career Path Assessment
        $course2 = Course::create([
            'title' => 'Career Path Assessment',
            'slug' => 'career-path-assessment',
            'description' => 'Temukan jalur karier yang paling sesuai dengan kepribadian dan bakat Anda.',
            'thumbnail' => 'https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=800',
            'estimated_time' => 20,
            'price' => 99000,
            'is_active' => true,
            'order' => 2,
        ]);

        // Categories for Course 2
        $cat2_1 = Category::create([
            'course_id' => $course2->id,
            'name' => 'Motivasi',
            'slug' => 'motivasi',
            'description' => 'Apa yang memotivasi Anda',
            'icon' => 'heart',
            'color' => '#EF4444',
            'order' => 1,
            'is_active' => true,
        ]);

        $cat2_2 = Category::create([
            'course_id' => $course2->id,
            'name' => 'Decision Making',
            'slug' => 'decision-making',
            'description' => 'Cara Anda mengambil keputusan',
            'icon' => 'settings',
            'color' => '#8B5CF6',
            'order' => 2,
            'is_active' => true,
        ]);

        $cat2_3 = Category::create([
            'course_id' => $course2->id,
            'name' => 'Work Environment',
            'slug' => 'work-environment',
            'description' => 'Lingkungan kerja ideal Anda',
            'icon' => 'office',
            'color' => '#F59E0B',
            'order' => 3,
            'is_active' => true,
        ]);

        // Questions for Course 2
        $this->createQuestion($course2, $cat2_1, 1, 'Apa yang memotivasi Anda dalam bekerja?', [
            ['option_text' => 'Hasil nyata yang bisa dilihat langsung', 'talent_type' => 'RES'],
            ['option_text' => 'Stabilitas dan kepastian', 'talent_type' => 'CON'],
            ['option_text' => 'Kebebasan berkreasi', 'talent_type' => 'EXP'],
            ['option_text' => 'Peluang untuk terus belajar', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($course2, $cat2_1, 2, 'Apa arti sukses bagi Anda?', [
            ['option_text' => 'Mencapai target yang ditetapkan', 'talent_type' => 'RES'],
            ['option_text' => 'Punya posisi dan karier yang stabil', 'talent_type' => 'CON'],
            ['option_text' => 'Bisa berkarya sesuai passion', 'talent_type' => 'EXP'],
            ['option_text' => 'Terus tumbuh dan berkembang', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($course2, $cat2_2, 3, 'Bagaimana Anda mengambil keputusan penting?', [
            ['option_text' => 'Mengikuti firasat dan pengalaman', 'talent_type' => 'RES'],
            ['option_text' => 'Mempertimbangkan pro dan kontra secara sistematis', 'talent_type' => 'CON'],
            ['option_text' => 'Mencari opsi alternatif yang unik', 'talent_type' => 'EXP'],
            ['option_text' => 'Menganalisis data dan fakta yang tersedia', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($course2, $cat2_2, 4, 'Dalam situasi tekanan, Anda:', [
            ['option_text' => 'Bertindak cepat untuk menyelesaikan masalah', 'talent_type' => 'RES'],
            ['option_text' => 'Mengikuti SOP yang sudah ada', 'talent_type' => 'CON'],
            ['option_text' => 'Mencari solusi dari sudut pandang berbeda', 'talent_type' => 'EXP'],
            ['option_text' => 'Menganalisis situasi sebelum bertindak', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($course2, $cat2_3, 5, 'Tipe pekerjaan yang Anda hindari:', [
            ['option_text' => 'Pekerjaan administrasi yang terlalu banyak kertas', 'talent_type' => 'RES'],
            ['option_text' => 'Pekerjaan yang tidak punya prosedur jelas', 'talent_type' => 'CON'],
            ['option_text' => 'Pekerjaan yang monoton dan repetitif', 'talent_type' => 'EXP'],
            ['option_text' => 'Pekerjaan yang tidak menantang secara intelektual', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($course2, $cat2_3, 6, 'Apa yang Anda cari dari relasi kerja?', [
            ['option_text' => 'Rekan yang bisa diajak kerja bareng', 'talent_type' => 'RES'],
            ['option_text' => 'Aturan dan batasan yang jelas', 'talent_type' => 'CON'],
            ['option_text' => 'Suasana yang menyenangkan', 'talent_type' => 'EXP'],
            ['option_text' => 'Tukar pikiran yang intelektual', 'talent_type' => 'ANA'],
        ]);

        // Course 3: Paid - Complete Talent Analysis
        $course3 = Course::create([
            'title' => 'Complete Talent Analysis',
            'slug' => 'complete-talent-analysis',
            'description' => 'Analisis lengkap bakat dan potensi Anda untuk meraih kesuksesan karier.',
            'thumbnail' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800',
            'estimated_time' => 30,
            'price' => 199000,
            'is_active' => true,
            'order' => 3,
        ]);

        // Categories for Course 3
        $cat3_1 = Category::create([
            'course_id' => $course3->id,
            'name' => 'Strengths',
            'slug' => 'strengths',
            'description' => 'Kelebihan utama Anda',
            'icon' => 'star',
            'color' => '#EAB308',
            'order' => 1,
            'is_active' => true,
        ]);

        $cat3_2 = Category::create([
            'course_id' => $course3->id,
            'name' => 'Communication',
            'slug' => 'communication',
            'description' => 'Gaya komunikasi Anda',
            'icon' => 'message-circle',
            'color' => '#06B6D4',
            'order' => 2,
            'is_active' => true,
        ]);

        $cat3_3 = Category::create([
            'course_id' => $course3->id,
            'name' => 'Leadership',
            'slug' => 'leadership',
            'description' => 'Potensi kepemimpinan Anda',
            'icon' => 'users',
            'color' => '#EC4899',
            'order' => 3,
            'is_active' => true,
        ]);

        $cat3_4 = Category::create([
            'course_id' => $course3->id,
            'name' => 'Growth',
            'slug' => 'growth',
            'description' => 'Potensi pertumbuhan Anda',
            'icon' => 'trending-up',
            'color' => '#14B8A6',
            'order' => 4,
            'is_active' => true,
        ]);

        // Questions for Course 3
        $this->createQuestion($course3, $cat3_1, 1, 'Kelebihan utama Anda:', [
            ['option_text' => 'Praktis dan hands-on', 'talent_type' => 'RES'],
            ['option_text' => 'Terorganisir dan disiplin', 'talent_type' => 'CON'],
            ['option_text' => 'Kreatif dan inovatif', 'talent_type' => 'EXP'],
            ['option_text' => 'Analitis dan logis', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($course3, $cat3_1, 2, 'Apa yang membuat Anda bangga?', [
            ['option_text' => 'Bisa menciptakan sesuatu', 'talent_type' => 'RES'],
            ['option_text' => 'Menyelesaikan dengan benar', 'talent_type' => 'CON'],
            ['option_text' => 'Karya yang orisinal', 'talent_type' => 'EXP'],
            ['option_text' => 'Memecahkan masalah kompleks', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($course3, $cat3_2, 3, 'Dalam presentasi, Anda lebih suka:', [
            ['option_text' => 'Demonstrasi langsung produk', 'talent_type' => 'RES'],
            ['option_text' => 'Slide yang terstruktur rapi', 'talent_type' => 'CON'],
            ['option_text' => 'Storytelling yang menarik', 'talent_type' => 'EXP'],
            ['option_text' => 'Data dan analisis yang mendalam', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($course3, $cat3_2, 4, 'Dalam meeting, Anda biasanya:', [
            ['option_text' => 'Singkat dan to the point', 'talent_type' => 'RES'],
            ['option_text' => 'Well prepared dan terstruktur', 'talent_type' => 'CON'],
            ['option_text' => 'Membawa ide out of the box', 'talent_type' => 'EXP'],
            ['option_text' => 'Mempresentasikan data lengkap', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($course3, $cat3_3, 5, 'Gaya memimpin Anda:', [
            ['option_text' => 'Lead by example', 'talent_type' => 'RES'],
            ['option_text' => 'Delegasi dengan jelas', 'talent_type' => 'CON'],
            ['option_text' => 'Inspirasi dan vision', 'talent_type' => 'EXP'],
            ['option_text' => 'Data-driven decision', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($course3, $cat3_3, 6, 'Tipe bos yang Anda sukai:', [
            ['option_text' => 'Yang terjun langsung bersama tim', 'talent_type' => 'RES'],
            ['option_text' => 'Yang jelas aturan dan ekspektasi', 'talent_type' => 'CON'],
            ['option_text' => 'Yang terbuka pada ide baru', 'talent_type' => 'EXP'],
            ['option_text' => 'Yang berdasar pada merit', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($course3, $cat3_4, 7, 'Sifat yang ingin Anda kembangkan:', [
            ['option_text' => 'Lebih percaya diri', 'talent_type' => 'RES'],
            ['option_text' => 'Lebih konsisten', 'talent_type' => 'CON'],
            ['option_text' => 'Lebih ekspresif', 'talent_type' => 'EXP'],
            ['option_text' => 'Lebih kritis', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($course3, $cat3_4, 8, 'Cara Anda beradaptasi dengan perubahan:', [
            ['option_text' => 'Coba dan adaptasi langsung', 'talent_type' => 'RES'],
            ['option_text' => 'Pelajari aturan baru dulu', 'talent_type' => 'CON'],
            ['option_text' => 'Anggap sebagai kesempatan baru', 'talent_type' => 'EXP'],
            ['option_text' => 'Analisis dampak perubahan', 'talent_type' => 'ANA'],
        ]);

        $this->createQuestion($course3, $cat3_4, 9, 'Cara Anda menghadapi kegagalan:', [
            ['option_text' => 'Coba lagi dengan cara berbeda', 'talent_type' => 'RES'],
            ['option_text' => 'Evaluasi apa yang salah', 'talent_type' => 'CON'],
            ['option_text' => 'Cari peluang di balik kegagalan', 'talent_type' => 'EXP'],
            ['option_text' => 'Analisis penyebabnya', 'talent_type' => 'ANA'],
        ]);
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

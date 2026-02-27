<?php

namespace Database\Seeders;

use App\Models\PertanyaanMetaProgram;
use App\Models\MetaProgram;
use App\Models\SubMetaProgram;
use Illuminate\Database\Seeder;

class PertanyaanMetaProgramsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // KATEGORI 1: THE MENTAL META-PROGRAMS

        // MP 1 - Chunk Size
        $this->createPertanyaan(1, 'Saya lebih suka melihat gambaran besar (big picture) daripada detail kecil.');
        $this->createPertanyaan(1, 'Saya cenderung fokus pada detail spesifik ketika menganalisis masalah.');

        // MP 10 - Philosophical Direction
        $this->createPertanyaan(2, 'Saya lebih tertarik pada masa depan dan kemungkinan-kemungkinan baru.');
        $this->createPertanyaan(2, 'Saya lebih suka berkaca pada pengalaman masa lalu untuk belajar.');

        // MP 11 - Reality Structure Sort
        $this->createPertanyaan(3, 'Saya cenderung mencari pola dan keterkaitan antar hal.');
        $this->createPertanyaan(3, 'Saya suka mengorganisir informasi dalam kategori yang jelas.');

        // MP 17 - Convincer Sort
        $this->createPertanyaan(4, 'Saya bisa diyakinkan dengan data dan fakta yang logis.');
        $this->createPertanyaan(4, 'Saya lebih mudah diyakinkan dengan contoh nyata yang bisa dilihat.');

        // MP 21 - Adaptation Style
        $this->createPertanyaan(5, 'Saya cepat beradaptasi dengan situasi dan lingkungan baru.');
        $this->createPertanyaan(5, 'Saya butuh waktu lebih lama untuk menyesuaikan diri dengan perubahan.');

        // MP 22 - Adaptation Sort
        $this->createPertanyaan(6, 'Saya suka mencoba hal baru dan mengambil inisiatif.');
        $this->createPertanyaan(6, 'Saya lebih nyaman dengan rutinitas yang sudah terbiasa.');

        // MP 2 - Relationship Sort
        $this->createPertanyaan(7, 'Saya membutuhkan kebebasan untuk membuat keputusan sendiri.');
        $this->createPertanyaan(7, 'Saya penting untuk mendapat persetujuan dari orang lain sebelum bertindak.');

        // MP 3 - Representational System Processing
        $this->createPertanyaan(8, 'Saya lebih mudah memahami sesuatu melalui gambar/diagram.');
        $this->createPertanyaan(8, 'Saya lebih mudah memahami sesuatu melalui suara/musik.');
        $this->createPertanyaan(8, 'Saya lebih mudah memahami sesuatu melalui perasaan/emosi.');
        $this->createPertanyaan(8, 'Saya lebih mudah memahami sesuatu melalui gerakan fisik.');

        // MP 35 – Comparison Sort
        $this->createPertanyaan(9, 'Saya cenderung membandingkan diri saya dengan orang lain.');
        $this->createPertanyaan(9, 'Saya fokus pada kemajuan diri saya sendiri tanpa membandingkan.');

        // MP 36 – Knowledge Source
        $this->createPertanyaan(10, 'Saya percaya pada pengetahuan yang telah terbukti kebenarannya.');
        $this->createPertanyaan(10, 'Saya mengandalkan intuisi dan perasaan dalam mengambil keputusan.');

        // MP 37 – Closure Sort
        $this->createPertanyaan(11, 'Saya merasa perlu menyelesaikan tugas sebelum memulai yang baru.');
        $this->createPertanyaan(11, 'Saya nyaman memiliki beberapa tugas yang belum selesai.');

        // MP 4 & 5 — Information Gathering Sort
        $this->createPertanyaan(12, 'Saya membutuhkan informasi detail lengkap sebelum membuat keputusan.');
        $this->createPertanyaan(12, 'Saya bisa membuat keputusan dengan informasi yang terbatas.');

        // MP 6 — Perceptual Sort
        $this->createPertanyaan(13, 'Saya percaya kemampuan orang dapat dikembangkan dengan latihan.');
        $this->createPertanyaan(13, 'Saya percaya kemampuan orang bersifat bawaan sejak lahir.');

        // MP 9 — Focus Sort
        $this->createPertanyaan(14, 'Saya bisa fokus pada satu hal untuk waktu yang lama.');
        $this->createPertanyaan(14, 'Saya cenderung melakukan banyak hal sekaligus (multitasking).');

        // KATEGORI 2: THE EMOTIONAL META-PROGRAMS

        // MP 13 — Stress Coping Sort
        $this->createPertanyaan(15, 'Dalam situasi stres, saya tetap tenang dan fokus pada solusi.');
        $this->createPertanyaan(15, 'Saya cenderung merasa tertekan saat menghadapi masalah.');
        $this->createPertanyaan(15, 'Saya mencari dukungan orang lain saat menghadapi stres.');

        // MP 15 — Emotional State
        $this->createPertanyaan(16, 'Saya bisa mengontrol emosi saya dengan baik.');
        $this->createPertanyaan(16, 'Emosi saya sering berubah-ubah sepanjang hari.');

        // MP 18 — Emotional Direction Sort
        $this->createPertanyaan(17, 'Saya cenderung melihat sisi positif dari setiap situasi.');
        $this->createPertanyaan(17, 'Saya cenderung melihat sisi negatif dari setiap situasi.');

        // MP 19 — Emotional Intensity Sort
        $this->createPertanyaan(18, 'Saya mengekspresikan emosi saya dengan intens yang tinggi.');
        $this->createPertanyaan(18, 'Saya mengekspresikan emosi saya dengan tenang dan terkendali.');

        // MP 42 – Self-Esteem
        $this->createPertanyaan(19, 'Saya merasa percaya diri dalam kemampuan saya sendiri.');
        $this->createPertanyaan(19, 'Saya sering merasa ragu dengan kemampuan saya sendiri.');

        // MP 43 — State Sort
        $this->createPertanyaan(20, 'Saya bisa menyesuaikan emosi saya dengan situasi.');
        $this->createPertanyaan(20, 'Emosi saya cenderung konsisten sepanjang hari.');

        // MP 49 — Ego Strength
        $this->createPertanyaan(21, 'Saya tetap teguh memegang pendapat saya meskipun ada tekanan.');
        $this->createPertanyaan(21, 'Saya mudah berubah pendapat jika ada argumen yang kuat.');

        // MP 7 — Attribution Sort
        $this->createPertanyaan(22, 'Saya mengambil tanggung jawab penuh atas hasil yang saya dapatkan.');
        $this->createPertanyaan(22, 'Saya cenderung menyalahkan keadaan di luar kendali saya.');

        // MP 8 — Perceptual Durability Sort
        $this->createPertanyaan(23, 'Saya percaya kesulitan bersifat sementara dan akan berlalu.');
        $this->createPertanyaan(23, 'Saya percaya kesulitan akan terus berlanjut.');

        // KATEGORI 3: THE VOLITIONAL META-PROGRAMS

        // MP 20 — Motivation Direction
        $this->createPertanyaan(24, 'Saya termotivasi untuk mencapai tujuan dan target saya.');
        $this->createPertanyaan(24, 'Saya termotivasi untuk menghindari masalah dan kegagalan.');

        // MP 23 — Modal Operators
        $this->createPertanyaan(25, 'Saya merasa bahwa saya MAMPU mencapai tujuan saya.');
        $this->createPertanyaan(25, 'Saya merasa bahwa saya TIDAK mampu mencapai tujuan saya.');

        // MP 24 — Preference Sort
        $this->createPertanyaan(26, 'Saya menyukai tantangan baru yang memacu saya.');
        $this->createPertanyaan(26, 'Saya lebih nyaman dengan situasi yang sudah familiar.');
        $this->createPertanyaan(26, 'Saya suka rutinitas yang dapat diprediksi.');
        $this->createPertanyaan(26, 'Saya menghindari situasi yang menimbulkan konflik.');
        $this->createPertanyaan(26, 'Saya menyukai variasi dan perubahan dalam aktivitas saya.');

        // MP 25 — Goal Striving Sort
        $this->createPertanyaan(27, 'Saya menikmati proses mencapai tujuan.');
        $this->createPertanyaan(27, 'Saya hanya fokus pada hasil akhir yang ingin dicapai.');
        $this->createPertanyaan(27, 'Saya lebih suka tujuan yang sudah ditentukan orang lain.');

        // MP 26 — Buying Sort
        $this->createPertanyaan(28, 'Saya suka membeli barang yang berkualitas tinggi.');
        $this->createPertanyaan(28, 'Saya lebih memilih barang yang murah dan terjangkau.');
        $this->createPertanyaan(28, 'Saya suka membeli barang dengan cepat dan praktis.');
        $this->createPertanyaan(28, 'Saya sering menunda keputusan pembelian.');

        // MP 27 — Responsibility Sort
        $this->createPertanyaan(29, 'Saya memegang teguh komitmen yang sudah saya buat.');
        $this->createPertanyaan(29, 'Saya fleksibel menyesuaikan komitmen saya sesuai situasi.');
        $this->createPertanyaan(29, 'Saya cenderung menghindari membuat komitmen.');

        // MP 29 — Rejuvenation of Battery
        $this->createPertanyaan(30, 'Saya membutuhkan waktu sendiri untuk mengisi ulang energi saya.');
        $this->createPertanyaan(30, 'Saya mendapatkan energi dari berinteraksi dengan orang banyak.');
        $this->createPertanyaan(30, 'Saya pulih dengan cepat setelah kelelahan.');

        // MP 34 – Work Preference
        $this->createPertanyaan(31, 'Saya suka bekerja dalam tim dengan orang lain.');
        $this->createPertanyaan(31, 'Saya lebih suka bekerja secara mandiri.');
        $this->createPertanyaan(31, 'Saya suka bekerja dengan alat dan mesin.');
        $this->createPertanyaan(31, 'Saya suka bekerja dengan orang sebagai fokus utama.');

        // MP 39 – Hierarchical Dominance
        $this->createPertanyaan(32, 'Saya nyaman berada dalam posisi kepemimpinan.');
        $this->createPertanyaan(32, 'Saya lebih nyaman mengikuti arahan orang lain.');
        $this->createPertanyaan(32, 'Saya menghargai struktur hierarki dalam organisasi.');

        // MP 40 – Value Sort
        $this->createPertanyaan(33, 'Saya memprioritaskan keadilan dan kejujuran dalam setiap situasi.');
        $this->createPertanyaan(33, 'Saya memprioritaskan kenyamanan dan keamanan.');

        // MP 41 – Temper to Instruction
        $this->createPertanyaan(34, 'Saya mengikuti instruksi secara detail seperti yang diberikan.');
        $this->createPertanyaan(34, 'Saya cenderung memodifikasi instruksi sesuai gaya saya sendiri.');

        // MP 50 — Morality Sort
        $this->createPertanyaan(35, 'Saya mengikuti aturan moral yang telah ditetapkan.');
        $this->createPertanyaan(35, 'Saya menentukan sendiri aturan moral berdasarkan situasi.');

        // KATEGORI 4: COMMUNICATION META-PROGRAMS

        // MP 12 — Communication Channel Preference
        $this->createPertanyaan(36, 'Saya lebih suka komunikasi langsung dan to-the-point.');
        $this->createPertanyaan(36, 'Saya lebih suka komunikasi yang halus dan diplomatis.');

        // MP 14 — Referencing Style
        $this->createPertanyaan(37, 'Saya sering menggunakan kata-kata dari orang lain.');
        $this->createPertanyaan(37, 'Saya menggunakan kata-kata dan gaya bahasa saya sendiri.');

        // MP 16 — Somatic Response Style
        $this->createPertanyaan(38, 'Saya memberikan respons dengan gerakan tubuh yang jelas.');
        $this->createPertanyaan(38, 'Saya menjaga ekspresi wajah saya tetap netral.');
        $this->createPertanyaan(38, 'Saya suka berdiri dekat saat berkomunikasi.');

        // MP 28 — People Convincer Sort
        $this->createPertanyaan(39, 'Saya mudah diyakinkan melalui logika dan alasan.');
        $this->createPertanyaan(39, 'Saya mudah diyakinkan melalui perasaan dan emosi.');

        // MP 30 – Affiliation & Management
        $this->createPertanyaan(40, 'Saya suka bekerja dalam tim yang solid.');
        $this->createPertanyaan(40, 'Saya lebih suka menjadi pemimpin dalam tim.');
        $this->createPertanyaan(40, 'Saya senang bekerja mandiri tanpa ketergantungan orang lain.');

        // MP 31 – Communication Stance
        $this->createPertanyaan(41, 'Saya aktif mengambil alih pembicaraan dalam diskusi.');
        $this->createPertanyaan(41, 'Saya lebih banyak mendengarkan daripada berbicara.');
        $this->createPertanyaan(41, 'Saya reaktif dan menunggu giliran bicara.');
        $this->createPertanyaan(41, 'Saya menghindari situasi komunikasi konfrontatif.');
        $this->createPertanyaan(41, 'Saya suka mengamati dari luar sebelum berpartisipasi.');

        // MP 33 – Somatic Response
        $this->createPertanyaan(42, 'Saya menggunakan gestur tangan saat berbicara.');
        $this->createPertanyaan(42, 'Saya mengubah posisi tubuh saat berpikir.');
        $this->createPertanyaan(42, 'Saya nada bicara saya berubah sesuai emosi.');
        $this->createPertanyaan(42, 'Saya bernapas dengan pola tertentu saat fokus.');

        // MP 38 – Social Presentation
        $this->createPertanyaan(43, 'Saya tampil menonjol dalam situasi sosial.');
        $this->createPertanyaan(43, 'Saya lebih suka berada di belakang dalam situasi sosial.');

        // KATEGORI 5: HIGHER META-PROGRAM

        // MP 32 – General Response
        $this->createPertanyaan(44, 'Saya merasa puas dengan hidup saya saat ini.');
        $this->createPertanyaan(44, 'Saya merasa hidup saya memiliki tujuan yang jelas.');
        $this->createPertanyaan(44, 'Saya hidup sesuai dengan nilai-nilai pribadi saya.');
        $this->createPertanyaan(44, 'Saya memprioritaskan kesejahteraan diri sendiri.');
        $this->createPertanyaan(44, 'Saya memprioritaskan kesejahteraan orang lain.');
        $this->createPertanyaan(44, 'Saya merasa mampu mencapai tujuan hidup saya.');

        // MP 44 — Status Sort
        $this->createPertanyaan(45, 'Status sosial sangat penting bagi saya.');
        $this->createPertanyaan(45, 'Saya ingin diakui kontribusi saya oleh orang lain.');
        $this->createPertanyaan(45, 'Saya memilih kehidupan sederhana tanpa mengejar status.');
        $this->createPertanyaan(45, 'Saya merasa nyaman dengan posisi saya dalam masyarakat.');
        $this->createPertanyaan(45, 'Saya menghargai pengakuan dari orang terdekat.');
        $this->createPertanyaan(45, 'Saya tetap rendah hati meskipun sukses.');

        // MP 45 — Self-Integrity
        $this->createPertanyaan(46, 'Saya bertindak sesuai dengan prinsip moral saya.');
        $this->createPertanyaan(46, 'Saya fleksibel menyesuaikan prinsip saya dengan situasi.');

        // MP 46 — Time Processing
        $this->createPertanyaan(47, 'Saya merasa selalu terburu-buru oleh waktu.');
        $this->createPertanyaan(47, 'Saya merasa ada banyak waktu untuk apa yang ingin saya lakukan.');
        $this->createPertanyaan(47, 'Saya bisa menyeimbangi waktu antara berbagai aktivitas.');

        // MP 47 — Time Experience
        $this->createPertanyaan(48, 'Saya fokus pada masa sekarang (here and now).');
        $this->createPertanyaan(48, 'Saya sering merenungkan masa lalu.');
        $this->createPertanyaan(48, 'Saya sering memikirkan dan merencanakan masa depan.');

        // MP 48 — Time Access Sort
        $this->createPertanyaan(49, 'Saya mengingat-ingat kejadian masa lalu dengan detail.');
        $this->createPertanyaan(49, 'Saya sulit mengingat detail kejadian masa lalu.');

        // MP 51 — Causation Sort
        $this->createPertanyaan(50, 'Saya percaya keberuntungan memegang peran penting dalam kesuksesan.');
        $this->createPertanyaan(50, 'Saya percaya kesuksesan hasil dari usaha sendiri.');
        $this->createPertanyaan(50, 'Saya percaya takdir berperan dalam hidup saya.');
        $this->createPertanyaan(50, 'Saya percaya keputusan saya sendiri yang menentukan hidup saya.');
        $this->createPertanyaan(50, 'Saya percaya kekuatan di luar kendali saya mempengaruhi hasil.');
        $this->createPertanyaan(50, 'Saya percaya kombinasi usaha dan keberuntungan.');
        $this->createPertanyaan(50, 'Saya percaya pola alam semesta mempengaruhi segala hal.');

        $this->command->info('Pertanyaan Meta Programs seeded successfully!');
    }

    /**
     * Create a single pertanyaan meta program
     */
    private function createPertanyaan($metaProgramId, $pertanyaanText, $subMetaProgramId = null)
    {
        PertanyaanMetaProgram::create([
            'meta_program_id' => $metaProgramId,
            'sub_meta_program_id' => $subMetaProgramId,
            'pertanyaan' => $pertanyaanText,
            'skala_sangat_setuju' => 6,
            'skala_setuju' => 5,
            'skala_agak_setuju' => 4,
            'skala_agak_tidak_setuju' => 3,
            'skala_tidak_setuju' => 2,
            'skala_sangat_tidak_setuju' => 1,
            'keterangan' => null,
            'is_negatif' => false,
            'order' => 0, // Will be updated after creation
            'is_active' => true,
        ]);
    }
}

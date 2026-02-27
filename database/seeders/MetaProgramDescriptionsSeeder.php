<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MetaProgram;
use App\Models\SubMetaProgram;
use Illuminate\Support\Facades\DB;

class MetaProgramDescriptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // MP 1: Chunk Size
        $this->updateMPDescriptions(
            'mp-1-chunk-size',
            'Meta Program Chunk Size menggambarkan bagaimana seseorang secara alami memproses dan memahami informasi, apakah ia lebih cenderung melihat gambaran besar secara menyeluruh atau justru fokus pada detail-detail spesifik. Pola ini memengaruhi cara berpikir, gaya belajar, kebiasaan kerja, pola komunikasi, serta cara seseorang mengambil keputusan dalam kehidupan sehari-hari.',
            [
                'global' => 'Individu dengan pola pikir Global cenderung memahami informasi melalui gambaran besar dan konteks menyeluruh. Mereka lebih cepat menangkap inti, makna, dan tujuan utama dari suatu situasi tanpa harus mengetahui seluruh detail teknisnya. Dalam berpikir dan berkomunikasi, individu Global nyaman dengan konsep, visi, dan arah umum, serta sering kali mampu melihat keterkaitan antara berbagai hal secara strategis. Mereka biasanya tertarik pada hasil akhir dan tujuan jangka panjang, sehingga mampu memahami ide baru dengan cepat dan berpikir dalam kerangka besar. Kekuatan utama pola Global terletak pada kemampuan merumuskan visi, membuat perencanaan strategis, serta memahami makna suatu situasi secara menyeluruh. Namun, pola ini juga memiliki tantangan, terutama dalam hal ketelitian terhadap detail. Individu Global dapat melewatkan informasi penting yang bersifat teknis atau rinci dan sering membutuhkan dukungan dari orang lain untuk memastikan aspek-aspek detail tetap tertangani. Pola Global sangat mendukung peran yang menuntut pandangan luas, kepemimpinan, serta pengambilan keputusan strategis.',
                'specific' => 'Individu dengan pola pikir Specific memproses informasi secara rinci, terstruktur, dan berurutan. Mereka memahami suatu hal melalui detail konkret, fakta, data, serta langkah-langkah yang jelas. Dalam aktivitas sehari-hari, individu Specific cenderung teliti, sistematis, dan berhati-hati, serta merasa lebih nyaman ketika menerima instruksi yang jelas dan detail. Mereka memiliki kecenderungan untuk memastikan setiap bagian berjalan dengan benar sebelum melangkah ke tahap berikutnya. Kekuatan utama dari pola Specific terletak pada ketepatan, konsistensi, serta kemampuan mengelola aspek teknis dan operasional dengan baik. Namun, individu dengan pola ini terkadang mengalami kesulitan dalam melihat gambaran besar atau memahami konteks yang bersifat abstrak. Perubahan mendadak atau penjelasan yang terlalu umum dapat menimbulkan ketidaknyamanan karena kurangnya kejelasan detail. Pola Specific sangat sesuai untuk peran yang membutuhkan ketelitian tinggi, analisis mendalam, dan eksekusi teknis yang akurat.'
            ],
            'Meta Program Chunk Size menunjukkan kecenderungan dasar seseorang dalam memahami dunia dan memproses pengalaman. Pola Global berorientasi pada keseluruhan, makna, dan arah besar, sedangkan pola Specific berorientasi pada detail, kejelasan, dan struktur. Kedua pola ini sama-sama bernilai dan saling melengkapi, serta akan memberikan hasil terbaik ketika diterapkan pada konteks dan peran yang sesuai dengan karakteristik individunya.'
        );

        // MP 2: Relationship Sort
        $this->updateMPDescriptions(
            'mp-2-relationship-sort',
            'Meta Program Relationship Sort menggambarkan cara seseorang secara alami membandingkan dan menghubungkan suatu hal dengan hal lainnya. Pola ini menentukan apakah seseorang lebih fokus pada kesamaan yang ada atau justru pada perbedaan yang muncul ketika menghadapi situasi, orang, atau pengalaman baru. Relationship Sort sangat memengaruhi cara individu berpikir, belajar, menilai perubahan, serta merespons lingkungan sosial dan pekerjaan.',
            [
                'sameness' => 'Individu dengan pola Sameness cenderung memperhatikan persamaan antara situasi yang sedang dihadapi dengan pengalaman sebelumnya. Mereka secara alami mencari hal-hal yang terasa familiar, konsisten, dan stabil. Dalam berpikir dan mengambil keputusan, individu Sameness merasa nyaman ketika menemukan pola yang serupa dan berulang, sehingga perubahan yang besar atau mendadak sering kali kurang disukai. Mereka memiliki kecenderungan untuk mempertahankan cara yang sudah terbukti berhasil dan menghargai kesinambungan. Kekuatan utama dari pola Sameness terletak pada stabilitas, loyalitas, dan konsistensi dalam menjalankan tugas maupun hubungan. Namun, tantangan yang mungkin muncul adalah resistensi terhadap perubahan dan kesulitan beradaptasi dengan pendekatan baru yang sangat berbeda dari kebiasaan sebelumnya. Pola Sameness sangat mendukung peran yang membutuhkan ketekunan, pemeliharaan sistem, dan kesinambungan proses dalam jangka panjang.',
                'difference' => 'Individu dengan pola Difference secara alami lebih peka terhadap perbedaan, perubahan, dan hal-hal yang baru. Mereka cenderung memperhatikan apa yang tidak sama dan apa yang telah berubah dibandingkan dengan situasi sebelumnya. Dalam berpikir dan berkomunikasi, individu Difference merasa tertantang oleh variasi dan inovasi, serta cepat mengenali ketidaksesuaian atau peluang perbaikan. Kekuatan utama dari pola Difference adalah kemampuan beradaptasi, berpikir kritis, dan menciptakan pembaruan. Individu dengan pola ini cenderung terbuka terhadap ide-ide baru dan tidak ragu meninggalkan cara lama yang dianggap kurang efektif. Namun, tantangan yang dapat muncul adalah kesulitan mempertahankan konsistensi dan rasa cepat bosan terhadap rutinitas. Pola Difference sangat sesuai untuk peran yang membutuhkan inovasi, perubahan, pemecahan masalah, dan pengembangan ide baru.'
            ],
            'Meta Program Relationship Sort menunjukkan bagaimana seseorang secara alami memahami hubungan antara pengalaman, situasi, dan informasi. Pola Sameness berfokus pada konsistensi dan kesamaan, sementara pola Difference berfokus pada perubahan dan perbedaan. Keduanya memiliki nilai dan fungsi masing-masing, dan akan bekerja secara optimal ketika selaras dengan konteks, lingkungan, serta tuntutan peran individu tersebut.'
        );

        // MP 3: Representational System
        $this->updateMPDescriptions(
            'mp-3-representational-system',
            'Meta Program Representational System menggambarkan bagaimana seseorang terutama merepresentasikan, memproses, dan mengkomunikasikan informasi melalui saluran indera yang dominan. Pola ini memengaruhi cara seseorang belajar, mengingat, memahami, dan mengekspresikan diri, serta menentukan preferensi komunikasi dan gaya berbahasa yang digunakan sehari-hari.',
            [
                'visual' => 'Individu dengan sistem representasi Visual cenderung memproses informasi melalui gambar, bentuk, warna, dan visualisasi mental. Mereka lebih mudah memahami sesuatu ketika dapat "melihat" gambaran atau contoh secara visual, baik dalam bentuk ilustrasi, diagram, maupun imajinasi di dalam pikiran. Dalam komunikasi, individu Visual sering menggunakan bahasa yang berkaitan dengan penglihatan dan lebih peka terhadap tampilan, tata letak, serta ekspresi visual. Kekuatan utama dari sistem Visual adalah kemampuan membayangkan, mengonsep, dan memahami informasi secara cepat melalui gambaran menyeluruh. Namun, individu dengan kecenderungan ini dapat mengalami kesulitan ketika harus memproses informasi yang hanya disampaikan secara lisan tanpa dukungan visual. Sistem Visual sangat mendukung aktivitas yang menuntut kreativitas visual, perencanaan, desain, dan pemikiran konseptual.',
                'auditory' => 'Individu dengan sistem representasi Auditory cenderung memproses informasi melalui suara, irama, dan kata-kata yang didengar. Mereka lebih mudah memahami sesuatu melalui percakapan, penjelasan lisan, atau diskusi dibandingkan membaca atau melihat gambar. Dalam keseharian, individu Auditory peka terhadap nada bicara, intonasi, dan kejelasan ucapan. Kekuatan utama dari sistem Auditory terletak pada kemampuan mendengarkan, mengingat informasi verbal, serta berkomunikasi secara lisan dengan efektif. Tantangan yang mungkin muncul adalah kesulitan memahami informasi visual yang kompleks atau suasana yang terlalu bising sehingga mengganggu konsentrasi. Sistem Auditory sangat cocok untuk peran yang membutuhkan komunikasi verbal, presentasi, diskusi, dan kerja berbasis dialog.',
                'kinesthetic' => 'Individu dengan sistem representasi Kinesthetic memproses informasi melalui perasaan, sensasi tubuh, dan pengalaman langsung. Mereka belajar dan memahami sesuatu dengan cara melakukan, merasakan, atau mengalami secara nyata. Dalam aktivitas sehari-hari, individu Kinesthetic cenderung peka terhadap kenyamanan fisik dan respons tubuh, serta lebih mudah mengingat pengalaman yang melibatkan emosi atau tindakan. Kekuatan utama dari sistem Kinesthetic adalah keterlibatan penuh dalam pengalaman, kemampuan merasakan situasi secara mendalam, dan kecenderungan untuk belajar melalui praktik. Namun, individu dengan pola ini mungkin kurang nyaman dengan pembelajaran yang terlalu teoritis atau abstrak tanpa keterlibatan langsung. Sistem Kinesthetic sangat mendukung peran yang membutuhkan praktik, interaksi langsung, dan pengalaman nyata.'
            ],
            'Meta Program Representational System menunjukkan cara dominan seseorang membangun dan mengelola pengalaman internalnya. Visual, Auditory, Kinesthetic, dan Language masing-masing merepresentasikan jalur pemrosesan yang berbeda dan saling melengkapi. Tidak ada sistem yang lebih baik dari yang lain; setiap sistem memiliki kekuatan tersendiri dan akan bekerja paling efektif ketika diselaraskan dengan cara belajar, berkomunikasi, dan beraktivitas yang sesuai bagi individu tersebut.'
        );

        // MP 4-5: Information Gathering (Sensor/Intuitor)
        $this->updateMPDescriptions(
            'mp-4-5-information-gathering',
            'Meta Program Information Gathering menggambarkan bagaimana seseorang secara alami mengumpulkan dan memproses informasi dari lingkungannya, apakah lebih berfokus pada apa yang dapat diamati secara nyata di saat ini atau pada pemrosesan internal berdasarkan intuisi dan makna di balik pengalaman. Pola ini memengaruhi cara seseorang belajar, mengambil keputusan, serta merespons situasi baru.',
            [
                'sensor' => 'Individu dengan pola Sensor atau Uptime cenderung mengarahkan perhatiannya ke dunia luar dan informasi yang dapat ditangkap secara langsung melalui pancaindra. Mereka fokus pada fakta, detail konkret, dan apa yang benar-benar terjadi pada saat ini. Dalam berpikir dan berperilaku, individu Sensor memperhatikan kondisi lingkungan, data nyata, serta bukti yang dapat diverifikasi. Kekuatan utama dari pola ini terletak pada kemampuan mengamati realitas dengan akurat, memahami kondisi aktual, serta bereaksi secara responsif terhadap situasi yang sedang berlangsung. Namun, individu Sensor terkadang kurang memberi ruang pada makna simbolik atau kemungkinan tersembunyi di balik suatu pengalaman, sehingga dapat melewatkan pemahaman yang bersifat intuitif atau konseptual. Pola Sensor sangat sesuai dalam konteks yang membutuhkan ketelitian, kesadaran situasional, serta respons yang cepat dan konkret.',
                'intuitor' => 'Individu dengan pola Intuitor atau Downtime cenderung memproses informasi melalui dunia internal mereka, dengan mengandalkan intuisi, refleksi, dan pemaknaan pengalaman. Perhatian individu Intuitor sering mengarah ke kemungkinan, pola tersembunyi, dan makna di balik kejadian, bukan hanya apa yang tampak di permukaan. Dalam berpikir, mereka mengintegrasikan pengalaman masa lalu, imajinasi, dan perasaan untuk membentuk pemahaman yang lebih mendalam. Kekuatan utama dari pola Intuitor adalah kemampuan melihat peluang, merumuskan ide kreatif, serta memahami situasi secara konseptual dan visioner. Namun, tantangan yang dapat muncul adalah kecenderungan untuk kurang peka terhadap detail faktual atau kondisi nyata yang sedang berlangsung. Pola Intuitor sangat mendukung peran yang membutuhkan kreativitas, pemikiran abstrak, dan perencanaan jangka panjang.'
            ],
            'Meta Program Information Gathering menunjukkan dua arah utama dalam mengumpulkan dan mengolah informasi. Sensor berfokus pada realitas eksternal dan fakta yang dapat diamati secara langsung, sedangkan Intuitor berfokus pada proses internal, intuisi, dan makna yang lebih dalam. Kedua pola ini saling melengkapi dan akan bekerja paling efektif ketika diseimbangkan sesuai dengan tuntutan situasi dan kebutuhan individu.'
        );

        // Tambahkan MP lainnya sesuai kebutuhan...
        // Anda bisa menambahkan semua 41 Meta Programs dari report.md dengan pola yang sama

        $this->command->info('Meta Program descriptions updated!');
    }

    private function updateMPDescriptions($mpSlug, $mpDescription, $sideDescriptions, $conclusion = '')
    {
        // Find Meta Program
        $mp = MetaProgram::where('slug', $mpSlug)->first();

        if (!$mp) {
            $this->command->warn("MP not found: {$mpSlug}");
            return;
        }

        // Update Meta Program description
        $mp->update(['description' => $mpDescription]);

        // Update Sub Meta Programs descriptions
        foreach ($sideDescriptions as $sideSlug => $description) {
            $subMp = SubMetaProgram::where('meta_program_id', $mp->id)
                ->where('slug', $sideSlug)
                ->first();

            if ($subMp) {
                $subMp->update(['description' => $description]);
            }
        }
    }
}

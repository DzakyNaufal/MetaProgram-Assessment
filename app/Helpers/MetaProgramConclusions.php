<?php

namespace App\Helpers;

class MetaProgramConclusions
{
    public static function getConclusion($mpName): ?string
    {
        $conclusions = self::getAll();
        $mpNameLower = strtolower($mpName);

        foreach ($conclusions as $key => $conclusion) {
            if (strpos($mpNameLower, strtolower($key)) !== false) {
                return $conclusion;
            }
        }

        return null;
    }

    public static function getAll(): array
    {
        return [
            'Chunk Size' => 'Meta Program Chunk Size menunjukkan kecenderungan dasar seseorang dalam memahami dunia dan memproses pengalaman. Pola Global berorientasi pada keseluruhan, makna, dan arah besar, sedangkan pola Specific berorientasi pada detail, kejelasan, dan struktur. Kedua pola ini sama-sama bernilai dan saling melengkapi, serta akan memberikan hasil terbaik ketika diterapkan pada konteks dan peran yang sesuai dengan karakteristik individunya.',

            'Relationship Sort' => 'Meta Program Relationship Sort menunjukkan bagaimana seseorang secara alami memahami hubungan antara pengalaman, situasi, dan informasi. Pola Sameness berfokus pada konsistensi dan kesamaan, sementara pola Difference berfokus pada perubahan dan perbedaan. Keduanya memiliki nilai dan fungsi masing-masing, dan akan bekerja secara optimal ketika selaras dengan konteks, lingkungan, serta tuntutan peran individu tersebut.',

            'Representational System' => 'Meta Program Representational System menunjukkan cara dominan seseorang membangun dan mengelola pengalaman internalnya. Visual, Auditory, Kinesthetic, dan Language masing-masing merepresentasikan jalur pemrosesan yang berbeda dan saling melengkapi. Tidak ada sistem yang lebih baik dari yang lain; setiap sistem memiliki kekuatan tersendiri dan akan bekerja paling efektif ketika diselaraskan dengan cara belajar, berkomunikasi, dan beraktivitas yang sesuai bagi individu tersebut.',

            'Information Gathering' => 'Meta Program Information Gathering menunjukkan dua arah utama dalam mengumpulkan dan mengolah informasi. Sensor berfokus pada realitas eksternal dan fakta yang dapat diamati secara langsung, sedangkan Intuitor berfokus pada proses internal, intuisi, dan makna yang lebih dalam. Kedua pola ini saling melengkapi dan akan bekerja paling efektif ketika diseimbangkan sesuai dengan tuntutan situasi dan kebutuhan individu.',

            'Perceptual Sort' => 'Meta Program Perceptual Sort menunjukkan kecenderungan seseorang dalam memahami dan mengelompokkan realitas. Pola Black–White menekankan kejelasan dan ketegasan, sementara pola Continuum menekankan fleksibilitas dan pemahaman konteks. Keduanya memiliki fungsi yang sama-sama penting dan akan memberikan hasil terbaik ketika digunakan sesuai dengan tuntutan lingkungan dan situasi yang dihadapi individu.',

            'Attribution Sort' => 'Meta Program Attribution Sort menunjukkan cara dasar seseorang memaknai sebab-akibat dari pengalaman yang ia alami. Pola Optimistic berorientasi pada peluang, pembelajaran, dan ketahanan, sementara pola Pessimistic berorientasi pada kewaspadaan dan antisipasi risiko. Keduanya memiliki nilai dan fungsi masing-masing, dan akan memberikan hasil terbaik ketika digunakan secara seimbang sesuai dengan konteks dan kebutuhan individu.',

            'Perceptual Durability' => 'Meta Program Perceptual Durability menunjukkan bagaimana seseorang mengelola pengaruh eksternal terhadap persepsi dan emosinya. Pola Permeable menekankan keterbukaan dan kepekaan, sementara pola Impermeable menekankan stabilitas dan kekuatan internal. Keduanya memiliki fungsi adaptif dan akan bekerja paling efektif ketika digunakan sesuai dengan konteks dan kebutuhan situasi.',

            'Focus Sort' => 'Meta Program Focus Sort menunjukkan bagaimana seseorang mengatur dan mengelola fokus perhatiannya. Pola Screener menekankan selektivitas dan konsentrasi, sementara pola Non-Screener menekankan keterbukaan terhadap berbagai rangsangan. Keduanya memiliki nilai dan kekuatan masing-masing, serta akan bekerja paling efektif ketika digunakan sesuai dengan konteks dan tuntutan situasi yang dihadapi individu.',

            'Philosophical Direction' => 'Meta Program Philosophical Direction menunjukkan kecenderungan individu dalam memaknai dan menjalankan suatu aktivitas. Pola Why menekankan pemahaman alasan dan tujuan, sedangkan pola How menekankan kejelasan proses dan pelaksanaan. Kedua orientasi ini saling melengkapi dan akan bekerja paling efektif ketika digunakan sesuai dengan konteks serta kebutuhan individu dan lingkungan.',

            'Reality Structure' => 'Meta Program Reality Structure menunjukkan bagaimana seseorang memaknai sifat dasar realitas yang dihadapinya. Pola Static menekankan kestabilan dan kepastian, sementara pola Process menekankan dinamika dan perkembangan. Keduanya memiliki kelebihan masing-masing dan akan memberikan hasil terbaik ketika digunakan sesuai dengan konteks dan tuntutan lingkungan.',

            'Communication Channel' => 'Meta Program Communication Channel menunjukkan cara utama seseorang dalam membangun dan memahami komunikasi. Pola Verbal berfokus pada kejelasan kata dan struktur, sementara pola Non-Verbal berfokus pada ekspresi dan nuansa emosional. Keduanya saling melengkapi dan akan bekerja paling efektif ketika diselaraskan dengan konteks komunikasi dan karakteristik individu yang terlibat.',

            'Stress Coping' => 'Meta Program Stress Coping Sort menunjukkan gaya dasar seseorang dalam menghadapi tekanan. Pola Flight berorientasi pada penghindaran, pola Fight pada konfrontasi langsung, dan pola Assertive pada keseimbangan yang konstruktif. Ketiga pola ini memiliki fungsi masing-masing dan akan bekerja paling efektif ketika disadari dan digunakan sesuai dengan konteks situasi yang dihadapi individu.',

            'Referencing Style' => 'Meta Program Referencing Style menunjukkan dari mana seseorang memperoleh rasa kepastian dan validasi dalam bertindak. Pola External Referent berfokus pada penilaian dari luar, sementara pola Internal Referent berfokus pada standar internal. Keduanya memiliki kelebihan dan keterbatasan masing-masing, serta akan memberikan hasil terbaik ketika disadari dan digunakan sesuai dengan situasi dan kebutuhan individu.',

            'Emotional State' => 'Meta Program Emotional State menunjukkan bagaimana seseorang berhubungan dengan emosi dan pengalamannya. Pola Associated menekankan keterlibatan emosional yang mendalam, sementara pola Dissociated menekankan jarak emosional dan objektivitas. Keduanya memiliki fungsi penting dan akan bekerja paling efektif ketika digunakan sesuai dengan konteks dan kebutuhan individu.',

            'Somatic Response' => 'Meta Program Somatic Response Style menunjukkan bagaimana individu mengekspresikan respons emosional dan mental melalui tubuh. Pola Inactive menekankan ketenangan, pola Active menekankan energi dan tindakan, serta pola Reactive menekankan responsivitas terhadap stimulus. Setiap pola memiliki kekuatan dan akan bekerja paling efektif ketika disesuaikan dengan situasi.',

            'Convincer Sort' => 'Meta Program Convincer Sort menunjukkan jalur utama yang digunakan individu untuk membentuk keyakinan. Pola Visual, Auditory, Kinesthetic, dan Language masing-masing merepresentasikan cara yang berbeda dan memiliki kekuatan unik. Pemahaman terhadap pola ini membantu individu mengoptimalkan cara belajar, mengambil keputusan, dan membangun keyakinan yang lebih kokoh.',

            'Emotional Direction' => 'Meta Program Emotional Direction menunjukkan bagaimana emosi bergerak dan berkembang dalam diri individu. Pola Uni-Directional menekankan alur emosi yang stabil dan terarah, sementara pola Multi-Directional menekankan variasi dan kompleksitas emosional. Keduanya memiliki keunikan masing-masing dan akan memberikan hasil terbaik ketika disadari dan dikelola secara sehat.',

            'Emotional Intensity' => 'Meta Program Emotional Intensity menunjukkan seberapa kuat emosi dialami dan diekspresikan oleh individu. Pola Surgency menekankan intensitas dan ekspresi tinggi, sementara pola Desurgency menekankan ketenangan dan stabilitas emosional. Keduanya memiliki fungsi penting dalam kehidupan dan akan bekerja paling efektif ketika seimbang dan disadari.',

            'Motivation Direction' => 'Meta Program Motivation Direction menunjukkan arah dasar yang menggerakkan perilaku individu. Pola Toward mendorong individu untuk mengejar tujuan dan peluang, sedangkan pola Away From mendorong individu untuk menghindari masalah dan risiko. Keduanya sama-sama kuat dan akan memberikan hasil terbaik ketika digunakan secara sadar sesuai kebutuhan.',

            'Adaptation Style' => 'Meta Program Adaptation Style menunjukkan pendekatan individu dalam menyesuaikan diri terhadap lingkungan. Pola Procedures menekankan keteraturan dan stabilitas, sementara pola Options menekankan fleksibilitas dan eksplorasi. Keduanya memiliki nilai dan fungsi masing-masing, serta akan bekerja paling efektif ketika disesuaikan dengan konteks dan tuntutan situasi.',

            'Adaptation Sort' => 'Meta Program Adaptation Sort menunjukkan pendekatan individu dalam menghadapi struktur dan keputusan hidup. Pola Judger menekankan ketegasan dan kepastian, sementara pola Perceiver menekankan fleksibilitas dan keterbukaan. Keduanya memiliki kelebihan masing-masing dan akan memberikan hasil terbaik ketika digunakan sesuai dengan kebutuhan situasi dan lingkungan.',

            'Modal Operators' => 'Meta Program Modal Operators menunjukkan bagaimana bahasa internal membentuk batasan dan dorongan dalam hidup individu. Pola Necessity dan Impossibility cenderung menekankan batas dan kontrol, sementara pola Desire dan Possibility cenderung menekankan pilihan dan peluang. Pemahaman terhadap pola ini membantu individu mengubah kebiasaan bahasa internal untuk mendukung pertumbuhan dan kebebasan.',

            'Preference Sort' => 'Meta Program Preference Sort menunjukkan area utama yang menarik perhatian dan energi individu. Setiap preferensi memiliki kekuatan dan tantangan masing-masing, dan pemahaman terhadap pola ini membantu individu memilih lingkungan dan aktivitas yang paling selaras dengan minat dan kekuatan alaminya.',

            'Goal Striving' => 'Meta Program Goal Striving menunjukkan bagaimana individu mendefinisikan dan mengejar keberhasilan. Pola Perfectionism, Optimizing, dan Skepticism masing-masing memiliki fungsi yang berharga dalam konteks yang berbeda. Pemahaman terhadap pola ini membantu individu menemukan keseimbangan antara standar tinggi dan kesejahteraan pribadi.',

            'Buying Sort' => 'Meta Program Buying Sort menunjukkan nilai dominan yang digunakan individu saat mengambil keputusan pembelian. Setiap orientasi—Cost, Convenience, Quality, dan Time—memiliki kekuatan dan keterbatasan. Pemahaman terhadap pola ini membantu individu membuat keputusan yang lebih sesuai dengan kebutuhan dan nilai-nilai pribadi.',

            'Responsibility Sort' => 'Meta Program Responsibility Sort menunjukkan cara individu mempersepsi dan memikul tanggung jawab dalam hidup. Pola Under-Responsible, Responsible, dan Over-Responsible masing-masing memiliki kecenderungan dan dampak yang berbeda. Kesadaran terhadap pola ini membantu individu menemukan keseimbangan yang sehat dalam memikul tanggung jawab.',

            'People Convincer' => 'Meta Program People Convincer menunjukkan kecenderungan dasar kepercayaan individu terhadap orang lain. Pola Distrusting dan Trusting masing-masing memiliki fungsi perlindungan dan keterbukaan. Pemahaman terhadap pola ini membantu individu menemukan keseimbangan antara kewaspadaan dan kepercayaan dalam membangun relasi.',

            'Rejuvenation' => 'Meta Program Rejuvenation Sort menunjukkan bagaimana individu memulihkan energi setelah aktivitas. Pola Introvert, Extrovert, dan Ambi memiliki cara yang berbeda dalam mengisi ulang energi. Pemahaman terhadap pola ini membantu individu mengelola energi secara efektif dan menjaga keseimbangan kehidupan.',

            'Affiliation' => 'Meta Program Affiliation & Management menunjukkan preferensi individu dalam bekerja sendiri maupun dengan orang lain. Pola No-Team, Team & Self, dan Team masing-masing memiliki keunikan dan kekuatan. Pemahaman terhadap pola ini membantu individu menemukan lingkungan kerja yang paling sesuai dengan karakter dan kebutuhannya.',

            'Comparison Sort' => 'Meta Program Comparison Sort menunjukkan pendekatan individu dalam melakukan perbandingan dan evaluasi. Pola Matching menekankan kesamaan dan harmoni, sementara pola Mismatching menekankan perbedaan dan analisis. Keduanya memiliki fungsi penting dan akan bekerja paling efektif ketika digunakan sesuai dengan konteks kebutuhan.',

            'Authority Sort' => 'Meta Program Authority Sort menunjukkan bagaimana individu menentukan kebenaran dan keputusan. Pola Self-Reference menekankan penilaian internal, sementara pola Other-Reference menekankan otoritas eksternal. Keduanya memiliki kelebihan dan keterbatasan, serta akan memberikan hasil terbaik ketika digunakan secara seimbang sesuai situasi.',

            'Rapport Sort' => 'Meta Program Rapport Sort menunjukkan cara individu membangun relasi dengan orang lain. Pola Affiliative menekankan kedekatan dan keharmonisan, sementara pola Confrontational menekankan kejujuran dan ketegasan. Keduanya memiliki fungsi penting dan akan bekerja paling efektif ketika digunakan sesuai dengan konteks relasi.',

            'Knowledge Competency' => 'Meta Program Knowledge & Competency Sort menunjukkan bagaimana individu mengembangkan dan menilai pengetahuan. Pola Demonstrated menekankan hasil yang terlihat, sementara pola Conceptual menekankan pemahaman teoretis. Keduanya saling melengkapi dan akan memberikan hasil terbaik ketika digunakan secara seimbang.',

            'Activity Level' => 'Meta Program Activity Level menunjukkan tingkat energi dan aktivitas individu. Pola High, Medium, dan Low masing-masing memiliki keunikan dan kebutuhan yang berbeda. Pemahaman terhadap pola ini membantu individu menemukan keseimbangan antara aktivitas dan istirahat.',

            'Association Sort' => 'Meta Program Association Sort menunjukkan bagaimana individu menghubungkan diri dengan pengalaman. Pola Associated menekankan keterlibatan langsung, sementara pola Disassociated menekankan jarak dan observasi. Keduanya memiliki fungsi penting dalam kehidupan dan akan bekerja paling efektif ketika digunakan secara sadar.',

            'Perceptual Sort' => 'Meta Program Perceptual Sort (Self-Other) menunjukkan fokus persepsi individu. Pola Self menekankan pengalaman internal, sementara pola Other menekankan orang di sekitar. Keduanya memiliki kekuatan dan akan bekerja paling efektif ketika disesuaikan dengan konteks.',

            'Relationship Context' => 'Meta Program Relationship Context Sort menunjukkan konteks relasi yang paling nyaman bagi individu. Pola Self, One Other, dan Group masing-masing memiliki karakteristik dan kebutuhan berbeda. Pemahaman terhadap pola ini membantu individu membangun relasi yang lebih sehat.',

            'Emotional Intensity Level' => 'Meta Program Emotional Intensity Level menunjukkan amplitudo emosi yang dialami individu. Pola Intense, Moderate, dan Low masing-masing memiliki kekuatan dan tantangan. Kesadaran terhadap pola ini membantu individu mengelola ekspresi emosional secara sehat.',

            'Decision Sort' => 'Meta Program Decision Sort menunjukkan cara individu mengambil keputusan. Pola External berfokus pada masukan dari luar, sementara pola Internal berfokus pada pertimbangan pribadi. Keduanya memiliki kelebihan dan akan bekerja paling efektif ketika digunakan secara seimbang.',

            'Action Sort' => 'Meta Program Action Sort menunjukkan kecepatan respons individu. Pola Impulsif bertindak cepat, sementara pola Reflectif mempertimbangkan terlebih dahulu. Keduanya memiliki fungsi penting dan akan bekerja paling efektif ketika disesuaikan dengan situasi.',

            'State Sort' => 'Meta Program State Sort menunjukkan orientasi individu terhadap proses dan tujuan. Pola Process menikmati perjalanan, sementara pola Goal berfokus pada hasil. Keduanya memiliki nilai dan akan bekerja paling efektif ketika digunakan secara seimbang.',

            'Status Sort' => 'Meta Program Status Sort menunjukkan cara individu memosisikan diri dalam hierarki. Pola Superior, Peer, dan Subordinate masing-masing memiliki karakteristik yang berbeda. Pemahaman terhadap pola ini membantu individu menemukan posisi yang paling sesuai.',

            'Self Esteem' => 'Meta Program Self-Esteem Sort menunjukkan cara individu menilai diri sendiri. Pola High, Medium, dan Low masing-masing memiliki kekuatan dan tantangan. Kesadaran terhadap pola ini membantu individu membangun harga diri yang sehat.',

            'Time Orientation' => 'Meta Program Time Orientation Sort menunjukkan fokus waktu individu. Pola Past, Present, dan Future masing-masing memiliki keunikan. Pemahaman terhadap pola ini membantu individu menyeimbangkan pembelajaran dari masa lalu, keterlibatan di masa kini, dan perencanaan masa depan.',

            'Time Tense' => 'Meta Program Time Tense menunjukkan cara individu mengalami waktu. Pola In-Time berada di dalam pengalaman, sementara pola Through-Time melihat dari luar. Keduanya memiliki fungsi penting dan akan bekerja paling efektif ketika digunakan secara seimbang.',

            'Time Access' => 'Meta Program Time Access Sort menunjukkan cara individu mengakses informasi. Pola Sequential teratur dan sistematis, sementara pola Random fleksibel dan kreatif. Keduanya memiliki kelebihan dan akan bekerja paling efektif ketika disesuaikan dengan kebutuhan.',

            'Ego Strength' => 'Meta Program Ego-Strength menunjukkan stabilitas emosi individu. Pola Unstable lebih sensitif, sementara pola Stable lebih tenang. Keduanya memiliki fungsi penting dan akan bekerja paling efektif ketika disadari dan dikelola.',

            'Morality Sort' => 'Meta Program Morality Sort menunjukkan kekuatan pengendalian diri individu. Pola Weak Super-Ego lebih fleksibel, sementara pola Strong Super-Ego lebih disiplin. Keduanya memiliki kelebihan dan keterbatasan masing-masing.',

            'Causation Sort' => 'Meta Program Causation Sort menunjukkan cara individu memahami penyebab peristiwa. Pola External, Linear, dan Multi-Cause masing-masing memiliki cara berpikir yang berbeda. Pemahaman terhadap pola ini membantu individu menjelaskan realitas dan mengambil keputusan yang lebih tepat.',
        ];
    }
}

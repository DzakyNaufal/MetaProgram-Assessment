<?php

namespace App\Helpers;

class MetaProgramDescriptions
{
    /**
     * Get complete description for a Meta Program by slug
     */
    public static function getDescription(string $slug): ?array
    {
        $descriptions = self::getAll();

        return $descriptions[$slug] ?? null;
    }

    /**
     * Get all Meta Program descriptions
     */
    public static function getAll(): array
    {
        return [
            'chunk-size' => [
                'title' => 'Chunk Size: GLOBAL VS SPECIFIC',
                'intro' => 'Meta Program Chunk Size menggambarkan bagaimana seseorang secara alami memproses dan memahami informasi, apakah ia lebih cenderung melihat gambaran besar secara menyeluruh atau justru fokus pada detail-detail spesifik. Pola ini memengaruhi cara berpikir, gaya belajar, kebiasaan kerja, pola komunikasi, serta cara seseorang mengambil keputusan dalam kehidupan sehari-hari.',
                'sides' => [
                    'global' => [
                        'title' => 'Global',
                        'content' => 'Individu dengan pola pikir Global cenderung memahami informasi melalui gambaran besar dan konteks menyeluruh. Mereka lebih cepat menangkap inti, makna, dan tujuan utama dari suatu situasi tanpa harus mengetahui seluruh detail teknisnya. Dalam berpikir dan berkomunikasi, individu Global nyaman dengan konsep, visi, dan arah umum, serta sering kali mampu melihat keterkaitan antara berbagai hal secara strategis. Mereka biasanya tertarik pada hasil akhir dan tujuan jangka panjang, sehingga mampu memahami ide baru dengan cepat dan berpikir dalam kerangka besar. Kekuatan utama pola Global terletak pada kemampuan merumuskan visi, membuat perencanaan strategis, serta memahami makna suatu situasi secara menyeluruh. Namun, pola ini juga memiliki tantangan, terutama dalam hal ketelitian terhadap detail. Individu Global dapat melewatkan informasi penting yang bersifat teknis atau rinci dan sering membutuhkan dukungan dari orang lain untuk memastikan aspek-aspek detail tetap tertangani. Pola Global sangat mendukung peran yang menuntut pandangan luas, kepemimpinan, serta pengambilan keputusan strategis.'
                    ],
                    'specific' => [
                        'title' => 'Specific',
                        'content' => 'Individu dengan pola pikir Specific memproses informasi secara rinci, terstruktur, dan berurutan. Mereka memahami suatu hal melalui detail konkret, fakta, data, serta langkah-langkah yang jelas. Dalam aktivitas sehari-hari, individu Specific cenderung teliti, sistematis, dan berhati-hati, serta merasa lebih nyaman ketika menerima instruksi yang jelas dan detail. Mereka memiliki kecenderungan untuk memastikan setiap bagian berjalan dengan benar sebelum melangkah ke tahap berikutnya. Kekuatan utama dari pola Specific terletak pada ketepatan, konsistensi, serta kemampuan mengelola aspek teknis dan operasional dengan baik. Namun, individu dengan pola ini terkadang mengalami kesulitan dalam melihat gambaran besar atau memahami konteks yang bersifat abstrak. Perubahan mendadak atau penjelasan yang terlalu umum dapat menimbulkan ketidaknyamanan karena kurangnya kejelasan detail. Pola Specific sangat sesuai untuk peran yang membutuhkan ketelitian tinggi, analisis mendalam, dan eksekusi teknis yang akurat.'
                    ]
                ],
                'conclusion' => 'Meta Program Chunk Size menunjukkan kecenderungan dasar seseorang dalam memahami dunia dan memproses pengalaman. Pola Global berorientasi pada keseluruhan, makna, dan arah besar, sedangkan pola Specific berorientasi pada detail, kejelasan, dan struktur. Kedua pola ini sama-sama bernilai dan saling melengkapi, serta akan memberikan hasil terbaik ketika diterapkan pada konteks dan peran yang sesuai dengan karakteristik individunya.'
            ],

            'relationship-sort' => [
                'title' => 'Relationship Sort: SAMENESS VS DIFFERENCE',
                'intro' => 'Meta Program Relationship Sort menggambarkan cara seseorang secara alami membandingkan dan menghubungkan suatu hal dengan hal lainnya. Pola ini menentukan apakah seseorang lebih fokus pada kesamaan yang ada atau justru pada perbedaan yang muncul ketika menghadapi situasi, orang, atau pengalaman baru. Relationship Sort sangat memengaruhi cara individu berpikir, belajar, menilai perubahan, serta merespons lingkungan sosial dan pekerjaan.',
                'sides' => [
                    'sameness' => [
                        'title' => 'Sameness',
                        'content' => 'Individu dengan pola Sameness cenderung memperhatikan persamaan antara situasi yang sedang dihadapi dengan pengalaman sebelumnya. Mereka secara alami mencari hal-hal yang terasa familiar, konsisten, dan stabil. Dalam berpikir dan mengambil keputusan, individu Sameness merasa nyaman ketika menemukan pola yang serupa dan berulang, sehingga perubahan yang besar atau mendadak sering kali kurang disukai. Mereka memiliki kecenderungan untuk mempertahankan cara yang sudah terbukti berhasil dan menghargai kesinambungan. Kekuatan utama dari pola Sameness terletak pada stabilitas, loyalitas, dan konsistensi dalam menjalankan tugas maupun hubungan. Namun, tantangan yang mungkin muncul adalah resistensi terhadap perubahan, kecenderungan untuk bertahan dalam zona nyaman, dan potensi kehilangan peluang baru karena enggan mencoba hal-hal yang berbeda. Pola Sameness sangat mendukung peran yang menuntut kestabilan, ketelitian dalam prosedur, dan kemampuan membangun kepercayaan melalui konsistensi.'
                    ],
                    'difference' => [
                        'title' => 'Difference',
                        'content' => 'Individu dengan pola Difference secara alami tertarik pada hal-hal baru, berbeda, dan unik. Mereka cenderung dengan cepat memperhatikan perubahan, inovasi, dan penyimpangan dari pola yang biasa. Dalam menghadapi situasi atau orang baru, individu Difference aktif mencari aspek yang membedakan dari pengalaman sebelumnya. Mereka biasanya menyukai variasi, eksplorasi, dan tantangan baru. Kekuatan utama dari pola Difference terletak pada kemampuan adaptasi yang cepat, kreativitas dalam menemukan solusi baru, serta antusiasme terhadap inovasi dan perubahan. Namun, tantangan yang mungkin muncul adalah kesulitan dalam mempertahankan konsistensi, kecenderungan untuk mudah bosan dengan rutinitas, dan potensi kelelahan akibat terlalu sering mencari hal-hal baru. Pola Difference sangat mendukung peran yang menuntut kreativitas, inovasi, kemampuan adaptasi, dan penguasaan perubahan.'
                    ]
                ],
                'conclusion' => 'Meta Program Relationship Sort menunjukkan cara seseorang membandingkan dan menghubungkan pengalaman. Pola Sameness berorientasi pada kesamaan, stabilitas, dan kontinuitas, sedangkan pola Difference berorientasi pada perbedaan, variasi, dan perubahan. Kedua pola ini sama-sama bernilai dan saling melengkapi dalam membentuk cara individu merespons lingkungan dan mengambil keputusan.'
            ],

            'representational-system' => [
                'title' => 'Representational System: VISUAL - AUDITORY - KINESTHETIC',
                'intro' => 'Meta Program Representational System menggambarkan bagaimana seseorang terutama merepresentasikan, memproses, dan mengkomunikasikan informasi melalui saluran indera yang dominan. Pola ini memengaruhi cara seseorang belajar, mengingat, memahami, dan mengekspresikan diri, serta menentukan preferensi komunikasi dan gaya berbahasa yang digunakan sehari-hari.',
                'sides' => [
                    'visual' => [
                        'title' => 'Visual',
                        'content' => 'Individu dengan Representational System Visual cenderung memproses informasi terutama melalui gambar, visualisasi mental, dan stimulasi visual. Mereka lebih mudah memahami sesuatu ketika dapat melihatnya secara langsung, melalui diagram, grafik, atau ilustrasi. Dalam belajar, individu Visual lebih cepat menyerap informasi yang disajikan dalam bentuk visual, seperti peta, bagan, atau demonstrasi langsung. Dalam berkomunikasi, mereka sering menggunakan kata-kata yang berkaitan dengan penglihatan, seperti "lihat", "tampak", "jelas", "terang", atau "bayangkan". Kekuatan utama pola Visual terletak pada kemampuan visualisasi, pemahaman spasial, dan kemampuan untuk melihat pola atau hubungan visual. Namun, mereka mungkin kesulitan dengan informasi yang terlalu abstrak tanpa dukungan visual atau dengan instruksi yang hanya disampaikan secara lisan tanpa contoh konkret. Pola Visual sangat mendukung peran yang menuntut kemampuan visual, desain, presentasi, dan pemrosesan informasi visual.'
                    ],
                    'auditory' => [
                        'title' => 'Auditory',
                        'content' => 'Individu dengan Representational System Auditory cenderung memproses informasi terutama melalui suara, musik, dan stimulus pendengaran. Mereka lebih mudah memahami sesuatu ketika mendengarkan penjelasan, diskusi, atau materi audio. Dalam belajar, individu Auditory lebih cepat menyerap informasi yang disampaikan melalui ceramah, diskusi kelompok, atau materi audio. Dalam berkomunikasi, mereka sering menggunakan kata-kata yang berkaitan dengan pendengaran, seperti "dengar", "suara", "berbunyi", "katakan", atau "terdengar". Kekuatan utama pola Auditory terletak pada kemampuan mendengarkan, memahami nuansa komunikasi lisan, dan sensitivitas terhadap nada atau irama. Namun, mereka mungkin kesulitan dengan informasi yang terlalu visual atau dengan instruksi yang hanya disampaikan secara tertulis tanpa penjelasan lisan. Pola Auditory sangat mendukung peran yang menuntut kemampuan komunikasi lisan, pendengaran aktif, dan pemrosesan informasi audio.'
                    ],
                    'kinesthetic' => [
                        'title' => 'Kinesthetic',
                        'content' => 'Individu dengan Representational System Kinesthetic cenderung memproses informasi terutama melalui sensasi fisik, gerakan, dan pengalaman taktil. Mereka lebih mudah memahami sesuatu ketika dapat mencoba langsung, menyentuh, atau merasakannya. Dalam belajar, individu Kinesthetic lebih cepat menyerap informasi melalui praktik langsung, eksperimen, atau aktivitas fisik. Dalam berkomunikasi, mereka sering menggunakan kata-kata yang berkaitan dengan perasaan atau sensasi fisik, seperti "rasa", "sentuh", "pegang", "gerak", atau "hangat". Kekuatan utama pola Kinesthetic terletak pada kemampuan belajar melalui pengalaman langsung, koordinasi fisik, dan koneksi antara tubuh dan pikiran. Namun, mereka mungkin kesulitan dengan informasi yang terlalu abstrak atau teoretis tanpa kesempatan untuk praktik langsung. Pola Kinesthetic sangat mendukung peran yang menuntut kemampuan fisik, praktik, dan pengalaman langsung.'
                    ]
                ],
                'conclusion' => 'Meta Program Representational System menunjukkan saluran indera yang dominan dalam memproses informasi. Pola Visual berorientasi pada gambar dan visualisasi, Auditory berorientasi pada suara dan pendengaran, sedangkan Kinesthetic berorientasi pada sensasi fisik dan pengalaman langsung. Pemahaman terhadap pola ini membantu dalam merancang metode pembelajaran dan komunikasi yang lebih efektif.'
            ],

            // Tambahkan Meta Program lainnya di sini...
            // Karena keterbatasan panjang, saya akan buat beberapa yang utama dulu
        ];
    }
}

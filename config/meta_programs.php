<?php

return [
    // MP 1: Chunk Size
    'chunk-size' => [
        'name' => 'MP 1: Chunk Size',
        'title' => 'Global vs Specific',
        'sides' => [
            'global' => [
                'name' => 'Global',
                'description' => 'Fokus pada gambaran besar, pola, dan makna keseluruhan',
            ],
            'specific' => [
                'name' => 'Specific',
                'description' => 'Fokus pada detail, fakta spesifik, dan informasi konkret',
            ],
        ],
        // Questions 1-5: score 1-2 = specific, 4-5 = global, 3 = neutral
        'scoring' => 'inverse', // Lower score = first side (specific), Higher = second side (global)
    ],

    // MP 2: Relationship Sort
    'relationship-sort' => [
        'name' => 'MP 2: Relationship Sort',
        'title' => 'Sameness vs Difference',
        'sides' => [
            'sameness' => [
                'name' => 'Sameness',
                'description' => 'Mencari kesamaan dan stabilitas',
            ],
            'difference' => [
                'name' => 'Difference',
                'description' => 'Mencari perbedaan dan variasi',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 3: Representational System
    'representational-system' => [
        'name' => 'MP 3: Representational System',
        'title' => 'Visual, Auditory, Kinesthetic, Language',
        'sides' => [
            'visual' => [
                'name' => 'Visual',
                'description' => 'Belajar melalui gambar dan visualisasi',
            ],
            'auditory' => [
                'name' => 'Auditory',
                'description' => 'Belajar melalui suara dan audio',
            ],
            'kinesthetic' => [
                'name' => 'Kinesthetic',
                'description' => 'Belajar melalui gerakan dan sentuhan',
            ],
            'language' => [
                'name' => 'Language',
                'description' => 'Belajar melalui kata-kata dan logika',
            ],
        ],
        'scoring' => 'multi', // Special scoring for 4 options
    ],

    // MP 4: Sensor Uptime
    'sensor-uptime' => [
        'name' => 'MP 4: Sensor Uptime',
        'title' => 'External Data vs Intuition',
        'sides' => [
            'external' => [
                'name' => 'External Data',
                'description' => 'Percaya data empiris dan bukti konkret',
            ],
            'intuition' => [
                'name' => 'Intuition',
                'description' => 'Percaya firasat dan intuisi internal',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 5: Intuitor Downtime
    'intuitor-downtime' => [
        'name' => 'MP 5: Intuitor Downtime',
        'title' => 'Internal vs External',
        'sides' => [
            'internal' => [
                'name' => 'Internal',
                'description' => 'Fokus pada pemrosesan internal dan intuisi',
            ],
            'external' => [
                'name' => 'External',
                'description' => 'Fokus pada data eksternal dan fakta',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 6: Perceptual Sort
    'perceptual-sort' => [
        'name' => 'MP 6: Perceptual Sort',
        'title' => 'Black-White vs Continuum',
        'sides' => [
            'blackwhite' => [
                'name' => 'Black-White',
                'description' => 'Melihat hal secara biner: benar/salah, sukses/gagal',
            ],
            'continuum' => [
                'name' => 'Continuum',
                'description' => 'Melihat hal sebagai spektrum gradasi',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 7: Attribution Sort
    'attribution-sort' => [
        'name' => 'MP 7: Attribution Sort',
        'title' => 'Optimist vs Pessimist',
        'sides' => [
            'optimist' => [
                'name' => 'Optimist',
                'description' => 'Fokus pada peluang dan solusi',
            ],
            'pessimist' => [
                'name' => 'Pessimist',
                'description' => 'Fokus pada risiko dan kegagalan',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 8: Perceptual Durability
    'perceptual-durability' => [
        'name' => 'MP 8: Perceptual Durability',
        'title' => 'Permeable vs Impermeable',
        'sides' => [
            'impermeable' => [
                'name' => 'Impermeable',
                'description' => 'Ide-ide kuat dan stabil',
            ],
            'permeable' => [
                'name' => 'Permeable',
                'description' => 'Ide-ide fleksibel dan mudah berubah',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 9: Focus Sort
    'focus-sort' => [
        'name' => 'MP 9: Focus Sort',
        'title' => 'Screener vs Non-Screener',
        'sides' => [
            'screener' => [
                'name' => 'Screener',
                'description' => 'Dapat menyaring distraksi dan fokus',
            ],
            'non-screener' => [
                'name' => 'Non-Screener',
                'description' => 'Mudah terganggu oleh lingkungan',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 10: Philosophical Direction
    'philosophical-direction' => [
        'name' => 'MP 10: Philosophical Direction',
        'title' => 'Why vs How',
        'sides' => [
            'why' => [
                'name' => 'Why (Asal-Usul)',
                'description' => 'Fokus pada sejarah dan alasan',
            ],
            'how' => [
                'name' => 'How (Solusi)',
                'description' => 'Fokus pada solusi dan aplikasi praktis',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 11: Reality Structure
    'reality-structure' => [
        'name' => 'MP 11: Reality Structure',
        'title' => 'Static vs Process',
        'sides' => [
            'static' => [
                'name' => 'Static (Aristotelian)',
                'description' => 'Melihat realitas sebagai hal-hal statis',
            ],
            'process' => [
                'name' => 'Process (Non-Aristotelian)',
                'description' => 'Melihat realitas sebagai proses berkelanjutan',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 12: Communication Channel
    'communication-channel' => [
        'name' => 'MP 12: Communication Channel',
        'title' => 'Verbal vs Non-Verbal',
        'sides' => [
            'verbal' => [
                'name' => 'Verbal',
                'description' => 'Fokus pada kata-kata dan isi pesan',
            ],
            'non-verbal' => [
                'name' => 'Non-Verbal',
                'description' => 'Fokus pada bahasa tubuh dan nada suara',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 13: Stress Coping
    'stress-coping' => [
        'name' => 'MP 13: Stress Coping',
        'title' => 'Passive vs Aggressive',
        'sides' => [
            'passive' => [
                'name' => 'Passive (Flight)',
                'description' => 'Menghindar atau mundur saat stres',
            ],
            'aggressive' => [
                'name' => 'Aggressive (Fight)',
                'description' => 'Menghadapi secara langsung saat stres',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 14: Referencing Style
    'referencing-style' => [
        'name' => 'MP 14: Referencing Style',
        'title' => 'External vs Internal',
        'sides' => [
            'external' => [
                'name' => 'External',
                'description' => 'Bergantung pada pendapat orang lain',
            ],
            'internal' => [
                'name' => 'Internal',
                'description' => 'Bergantung pada nilai diri sendiri',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 15: Emotional State
    'emotional-state' => [
        'name' => 'MP 15: Emotional State',
        'title' => 'Associated vs Dissociated',
        'sides' => [
            'associated' => [
                'name' => 'Associated',
                'description' => 'Masuk ke dalam emosi secara penuh',
            ],
            'dissociated' => [
                'name' => 'Dissociated',
                'description' => 'Melihat emosi dari jauh/netral',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 16: Somatic Response
    'somatic-response' => [
        'name' => 'MP 16: Somatic Response',
        'title' => 'Active vs Reactive',
        'sides' => [
            'active' => [
                'name' => 'Active',
                'description' => 'Bertindak cepat setelah menilai',
            ],
            'reactive' => [
                'name' => 'Reactive',
                'description' => 'Butuh waktu studi mendetail',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 17: Convincer Sort
    'convincer-sort' => [
        'name' => 'MP 17: Convincer Sort',
        'title' => 'VAK & Language',
        'sides' => [
            'visual' => [
                'name' => 'Visual',
                'description' => 'Yakin melalui visual',
            ],
            'auditory' => [
                'name' => 'Auditory',
                'description' => 'Yakin melalui pendengaran',
            ],
            'kinesthetic' => [
                'name' => 'Kinesthetic',
                'description' => 'Yakin melalui perasaan',
            ],
            'language' => [
                'name' => 'Language',
                'description' => 'Yakin melalui logika',
            ],
        ],
        'scoring' => 'multi',
    ],

    // MP 18: Emotional Direction
    'emotional-direction' => [
        'name' => 'MP 18: Emotional Direction',
        'title' => 'Uni vs Multi Directional',
        'sides' => [
            'uni' => [
                'name' => 'Uni-Directional',
                'description' => 'Emosi menyebar ke semua bidang',
            ],
            'multi' => [
                'name' => 'Multi-Directional',
                'description' => 'Emosi terbatas pada situasi',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 19: Emotional Intensity
    'emotional-intensity' => [
        'name' => 'MP 19: Emotional Intensity',
        'title' => 'Surgency vs Desurgency',
        'sides' => [
            'surgency' => [
                'name' => 'Surgency',
                'description' => 'Ekspresi emosi yang kuat dan terlihat',
            ],
            'desurgency' => [
                'name' => 'Desurgency',
                'description' => 'Ekspresi emosi yang tenang',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 20: Motivation Direction
    'motivation-direction' => [
        'name' => 'MP 20: Motivation Direction',
        'title' => 'Away From vs Toward',
        'sides' => [
            'away' => [
                'name' => 'Away From',
                'description' => 'Motivasi untuk menghindari hal buruk',
            ],
            'toward' => [
                'name' => 'Toward',
                'description' => 'Motivasi untuk mendapatkan hal baik',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 21: Adaptation Style
    'adaptation-style' => [
        'name' => 'MP 21: Adaptation Style',
        'title' => 'Procedures vs Options',
        'sides' => [
            'procedures' => [
                'name' => 'Procedures',
                'description' => 'Suka instruksi langkah demi langkah',
            ],
            'options' => [
                'name' => 'Options',
                'description' => 'Suka variasi dan alternatif',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 22: Adaptation Sort
    'adaptation-sort' => [
        'name' => 'MP 22: Adaptation Sort',
        'title' => 'Judger vs Perceiver',
        'sides' => [
            'judger' => [
                'name' => 'Judger',
                'description' => 'Terstruktur dan terencana',
            ],
            'perceiver' => [
                'name' => 'Perceiver',
                'description' => 'Fleksibel dan spontan',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 23: Modal Operators
    'modal-operators' => [
        'name' => 'MP 23: Modal Operators',
        'title' => 'Necessity vs Desire',
        'sides' => [
            'necessity' => [
                'name' => 'Necessity',
                'description' => 'Termotivasi oleh "harus"',
            ],
            'desire' => [
                'name' => 'Desire',
                'description' => 'Termotivasi oleh "ingin"',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 24: Preference Sort
    'preference-sort' => [
        'name' => 'MP 24: Preference Sort',
        'title' => 'People/Things/Activity/Info/Location',
        'sides' => [
            'people' => [
                'name' => 'People',
                'description' => 'Prioritas pada orang',
            ],
            'things' => [
                'name' => 'Things',
                'description' => 'Prioritas pada benda',
            ],
            'activity' => [
                'name' => 'Activity',
                'description' => 'Prioritas pada aktivitas',
            ],
            'info' => [
                'name' => 'Information',
                'description' => 'Prioritas pada informasi',
            ],
            'location' => [
                'name' => 'Location',
                'description' => 'Prioritas pada lokasi',
            ],
        ],
        'scoring' => 'multi',
    ],

    // MP 25: Goal Striving
    'goal-striving' => [
        'name' => 'MP 25: Goal Striving',
        'title' => 'Perfectionism vs Optimization',
        'sides' => [
            'perfectionism' => [
                'name' => 'Perfectionism',
                'description' => 'Harus sempurna sebelum selesai',
            ],
            'optimization' => [
                'name' => 'Optimization',
                'description' => 'Seimbang antara kualitas dan kecepatan',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 26: Buying Sort
    'buying-sort' => [
        'name' => 'MP 26: Buying Sort',
        'title' => 'Cost/Convenience/Quality/Time',
        'sides' => [
            'cost' => [
                'name' => 'Cost',
                'description' => 'Prioritas pada harga',
            ],
            'convenience' => [
                'name' => 'Convenience',
                'description' => 'Prioritas pada kenyamanan',
            ],
            'quality' => [
                'name' => 'Quality',
                'description' => 'Prioritas pada kualitas',
            ],
            'time' => [
                'name' => 'Time',
                'description' => 'Prioritas pada waktu',
            ],
        ],
        'scoring' => 'multi',
    ],

    // MP 27: Responsibility
    'responsibility-sort' => [
        'name' => 'MP 27: Responsibility Sort',
        'title' => 'Under/Responsible/Over',
        'sides' => [
            'under' => [
                'name' => 'Under-Responsible',
                'description' => 'Cari alasan eksternal saat salah',
            ],
            'responsible' => [
                'name' => 'Responsible',
                'description' => 'Sadar peran dalam masalah',
            ],
            'over' => [
                'name' => 'Over-Responsible',
                'description' => 'Merasa harus menyelesaikan semua',
            ],
        ],
        'scoring' => 'multi',
    ],

    // MP 28: People Convincer
    'people-convincer' => [
        'name' => 'MP 28: People Convincer',
        'title' => 'Trusting vs Distrusting',
        'sides' => [
            'trusting' => [
                'name' => 'Trusting',
                'description' => 'Mulai dengan percaya',
            ],
            'distrusting' => [
                'name' => 'Distrusting',
                'description' => 'Mulai dengan curiga',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 29: Rejuvenation
    'rejuvenation-sort' => [
        'name' => 'MP 29: Rejuvenation',
        'title' => 'Extrovert vs Introvert',
        'sides' => [
            'extrovert' => [
                'name' => 'Extrovert',
                'description' => 'Energi dari interaksi sosial',
            ],
            'introvert' => [
                'name' => 'Introvert',
                'description' => 'Energi dari waktu sendiri',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 30: Affiliation
    'affiliation-sort' => [
        'name' => 'MP 30: Affiliation',
        'title' => 'No Team vs Team',
        'sides' => [
            'solo' => [
                'name' => 'Solo Worker',
                'description' => 'Lebih suka bekerja sendiri',
            ],
            'team' => [
                'name' => 'Team Player',
                'description' => 'Lebih suka bekerja dalam tim',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 31: Comparison Sort
    'comparison-sort' => [
        'name' => 'MP 31: Comparison Sort',
        'title' => 'Matching vs Mismatching',
        'sides' => [
            'matching' => [
                'name' => 'Matching',
                'description' => 'Melihat persamaan dulu',
            ],
            'mismatching' => [
                'name' => 'Mismatching',
                'description' => 'Melihat perbedaan dulu',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 32: Authority Sort
    'authority-sort' => [
        'name' => 'MP 32: Authority Sort',
        'title' => 'Self vs Other Reference',
        'sides' => [
            'self' => [
                'name' => 'Self-Reference',
                'description' => 'Otoritas dari diri sendiri',
            ],
            'other' => [
                'name' => 'Other-Reference',
                'description' => 'Otoritas dari orang lain',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 33: Rapport Sort
    'rapport-sort' => [
        'name' => 'MP 33: Rapport Sort',
        'title' => 'Affiliative vs Confrontational',
        'sides' => [
            'affiliative' => [
                'name' => 'Affiliative',
                'description' => 'Cari titik temu',
            ],
            'confrontational' => [
                'name' => 'Confrontational',
                'description' => 'Bersemangat berdebat',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 34: Knowledge/Competency
    'knowledge-competency' => [
        'name' => 'MP 34: Knowledge Competency',
        'title' => 'Demonstrated vs Conceptual',
        'sides' => [
            'demonstrated' => [
                'name' => 'Demonstrated',
                'description' => 'Kompetensi dari pengalaman',
            ],
            'conceptual' => [
                'name' => 'Conceptual',
                'description' => 'Kompetensi dari teori',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 35: Activity Level
    'activity-level' => [
        'name' => 'MP 35: Activity Level',
        'title' => 'High vs Low',
        'sides' => [
            'high' => [
                'name' => 'High Activity',
                'description' => 'Banyak aktivitas dan tugas',
            ],
            'low' => [
                'name' => 'Low Activity',
                'description' => 'Lebih santai dan waktu luang',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 36: Association Sort
    'association-sort' => [
        'name' => 'MP 36: Association Sort',
        'title' => 'Associated vs Dissociated',
        'sides' => [
            'associated' => [
                'name' => 'Associated',
                'description' => 'Merasakan pengalaman langsung',
            ],
            'dissociated' => [
                'name' => 'Dissociated',
                'description' => 'Melihat pengalaman dari luar',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 37: Perceptual Focus
    'perceptual-focus' => [
        'name' => 'MP 37: Perceptual Focus',
        'title' => 'Internal vs External',
        'sides' => [
            'internal' => [
                'name' => 'Internal',
                'description' => 'Fokus pada sensasi internal',
            ],
            'external' => [
                'name' => 'External',
                'description' => 'Fokus pada lingkungan luar',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 38: Self vs Other
    'self-other-focus' => [
        'name' => 'MP 38: Self vs Other Focus',
        'title' => 'Self vs Other',
        'sides' => [
            'self' => [
                'name' => 'Self-Focused',
                'description' => 'Fokus pada diri sendiri',
            ],
            'other' => [
                'name' => 'Other-Focused',
                'description' => 'Fokus pada orang lain',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 39: Relationship Scope
    'relationship-scope' => [
        'name' => 'MP 39: Relationship Scope',
        'title' => 'Self/One/Group',
        'sides' => [
            'self' => [
                'name' => 'Self',
                'description' => 'Lebih suka bekerja sendiri',
            ],
            'one' => [
                'name' => 'One Other',
                'description' => 'Lebih suka dengan satu orang',
            ],
            'group' => [
                'name' => 'Group',
                'description' => 'Lebih suka dalam tim',
            ],
        ],
        'scoring' => 'multi',
    ],

    // MP 40: Emotional Intensity Sort
    'emotional-intensity-sort' => [
        'name' => 'MP 40: Emotional Intensity Sort',
        'title' => 'Intense vs Low',
        'sides' => [
            'intense' => [
                'name' => 'Intense',
                'description' => 'Ekspresi emosi yang kuat',
            ],
            'low' => [
                'name' => 'Low',
                'description' => 'Ekspresi emosi yang tenang',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 41: Decision Source
    'decision-source' => [
        'name' => 'MP 41: Decision Source',
        'title' => 'External vs Internal',
        'sides' => [
            'external' => [
                'name' => 'External',
                'description' => 'Keputusan dari konsultasi',
            ],
            'internal' => [
                'name' => 'Internal',
                'description' => 'Keputusan dari diri sendiri',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 42: Action Style
    'action-style' => [
        'name' => 'MP 42: Action Style',
        'title' => 'Reflective vs Impulsive',
        'sides' => [
            'reflective' => [
                'name' => 'Reflective',
                'description' => 'Rencana dulu baru bertindak',
            ],
            'impulsive' => [
                'name' => 'Impulsive',
                'description' => 'Langsung bertindak',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 43: State Sort
    'state-sort' => [
        'name' => 'MP 43: State Sort',
        'title' => 'Process vs Goal',
        'sides' => [
            'process' => [
                'name' => 'Process',
                'description' => 'Nikmati perjalanan',
            ],
            'goal' => [
                'name' => 'Goal',
                'description' => 'Fokus pada tujuan',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 44: Status Sort
    'status-sort' => [
        'name' => 'MP 44: Status Sort',
        'title' => 'Superior/Peer/Subordinate',
        'sides' => [
            'superior' => [
                'name' => 'Superior',
                'description' => 'Nyaman dengan atasan',
            ],
            'peer' => [
                'name' => 'Peer',
                'description' => 'Nyaman dengan selevel',
            ],
            'subordinate' => [
                'name' => 'Subordinate',
                'description' => 'Nyaman memimpin',
            ],
        ],
        'scoring' => 'multi',
    ],

    // MP 45: Self-Esteem
    'self-esteem' => [
        'name' => 'MP 45: Self-Esteem',
        'title' => 'High vs Low',
        'sides' => [
            'high' => [
                'name' => 'High',
                'description' => 'Percaya diri tinggi',
            ],
            'low' => [
                'name' => 'Low',
                'description' => 'Mudah merasa tidak aman',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 46: Time Orientation
    'time-orientation' => [
        'name' => 'MP 46: Time Orientation',
        'title' => 'Past/Present/Future',
        'sides' => [
            'past' => [
                'name' => 'Past',
                'description' => 'Fokus pada masa lalu',
            ],
            'present' => [
                'name' => 'Present',
                'description' => 'Fokus pada saat ini',
            ],
            'future' => [
                'name' => 'Future',
                'description' => 'Fokus pada masa depan',
            ],
        ],
        'scoring' => 'multi',
    ],

    // MP 47: Time Tense
    'time-tense' => [
        'name' => 'MP 47: Time Tense',
        'title' => 'In Time vs Through Time',
        'sides' => [
            'intime' => [
                'name' => 'In Time',
                'description' => 'Lupa waktu saat sibuk',
            ],
            'through' => [
                'name' => 'Through Time',
                'description' => 'Terstruktur dengan kalender',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 48: Time Access
    'time-access' => [
        'name' => 'MP 48: Time Access',
        'title' => 'Sequential vs Random',
        'sides' => [
            'sequential' => [
                'name' => 'Sequential',
                'description' => 'Urutan dari awal ke akhir',
            ],
            'random' => [
                'name' => 'Random',
                'description' => 'Melompat-lompat',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 49: Ego Strength
    'ego-strength' => [
        'name' => 'MP 49: Ego Strength',
        'title' => 'Stable vs Reactive',
        'sides' => [
            'stable' => [
                'name' => 'Stable',
                'description' => 'Tenang dalam krisis',
            ],
            'reactive' => [
                'name' => 'Reactive',
                'description' => 'Mudah terintimidasi',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 50: Morality Sort
    'morality-sort' => [
        'name' => 'MP 50: Morality Sort',
        'title' => 'Weak vs Strong Super-Ego',
        'sides' => [
            'weak' => [
                'name' => 'Weak',
                'description' => 'Fleksibel dengan moral',
            ],
            'strong' => [
                'name' => 'Strong',
                'description' => 'Sangat taat moral',
            ],
        ],
        'scoring' => 'inverse',
    ],

    // MP 51: Causation Sort
    'causation-sort' => [
        'name' => 'MP 51: Causation Sort',
        'title' => 'Attribution Style',
        'sides' => [
            'personal' => [
                'name' => 'Personal',
                'description' => 'Cari yang bertanggung jawab',
            ],
            'linear' => [
                'name' => 'Linear',
                'description' => 'Satu penyebab utama',
            ],
            'multi' => [
                'name' => 'Multi-Cause',
                'description' => 'Banyak faktor berkontribusi',
            ],
            'causeless' => [
                'name' => 'Causeless',
                'description' => 'Kejadiann nasib',
            ],
        ],
        'scoring' => 'multi',
    ],
];

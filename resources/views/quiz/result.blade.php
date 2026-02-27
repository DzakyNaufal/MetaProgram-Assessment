@extends('layouts.app')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        <div class="max-w-4xl mx-auto">
            <div class="mb-8 text-center">
                <h1 class="mb-2 text-3xl font-bold text-gray-800">Hasil Kuis Talent Mapping</h1>
                <p class="text-gray-600">Berikut adalah analisis tipe bakat terbaikmu dalam memperoleh informasi baru</p>
            </div>

            <div class="p-6 mb-8 bg-white rounded-lg shadow-md">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    <div>
                        <h2 class="mb-4 text-xl font-bold text-gray-800">Diagram Bakat</h2>
                        <canvas id="talentChart" width="400" height="400"></canvas>
                    </div>

                    <div>
                        <h2 class="mb-4 text-xl font-bold text-gray-800">Perincian Skor</h2>

                        <div class="space-y-4">
                            <div class="p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium">Researcher (RES)</span>
                                    <span class="font-bold">{{ $percentages['RES'] }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percentages['RES'] }}%">
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-gray-600">Skor: {{ $scores['RES'] }}</p>
                            </div>

                            <div class="p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium">Connector (CON)</span>
                                    <span class="font-bold">{{ $percentages['CON'] }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-green-600 h-2.5 rounded-full" style="width: {{ $percentages['CON'] }}%">
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-gray-600">Skor: {{ $scores['CON'] }}</p>
                            </div>

                            <div class="p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium">Explorer (EXP)</span>
                                    <span class="font-bold">{{ $percentages['EXP'] }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-yellow-600 h-2.5 rounded-full" style="width: {{ $percentages['EXP'] }}%">
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-gray-600">Skor: {{ $scores['EXP'] }}</p>
                            </div>

                            <div class="p-4 border border-gray-200 rounded-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="font-medium">Analyzer (ANA)</span>
                                    <span class="font-bold">{{ $percentages['ANA'] }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-red-600 h-2.5 rounded-full" style="width: {{ $percentages['ANA'] }}%">
                                    </div>
                                </div>
                                <p class="mt-1 text-sm text-gray-600">Skor: {{ $scores['ANA'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 bg-white rounded-lg shadow-md">
                <h2 class="mb-6 text-2xl font-bold text-center">
                    <span class="text-blue-600">Kamu adalah
                        {{ $dominantType === 'RES' ? 'Researcher' : ($dominantType === 'CON' ? 'Connector' : ($dominantType === 'EXP' ? 'Explorer' : 'Analyzer')) }}!</span>
                </h2>

                <div class="mb-6 text-center">
                    <p class="mb-4 text-lg text-gray-700">
                        @if ($dominantType === 'RES')
                            Kamu memiliki kemampuan luar biasa dalam mengumpulkan dan menganalisis informasi dari berbagai
                            sumber terpercaya. Pendekatanmu yang sistematis dan berbasis data membuatmu unggul dalam
                            memahami konsep kompleks.
                        @elseif($dominantType === 'CON')
                            Keterampilanmu dalam membangun hubungan dan berkomunikasi dengan orang lain adalah kekuatan
                            utamamu. Kamu pandai menggali informasi dari berbagai perspektif melalui interaksi dan diskusi
                            yang bermakna.
                        @elseif($dominantType === 'EXP')
                            Eksperimen dan praktik langsung adalah cara terbaik bagimu untuk belajar. Kamu tidak takut
                            mencoba hal baru dan belajar dari pengalaman langsung, menjadikanmu inovator yang tangguh.
                        @else
                            Kamu memiliki kemampuan luar biasa dalam menyusun informasi secara logis dan sistematis.
                            Kecerdasan analitismu membantumu memahami struktur dan pola yang tersembunyi dari informasi
                            kompleks.
                        @endif
                    </p>

                    <p class="text-gray-600">
                        @if ($dominantType === 'RES')
                            Profesi yang cocok untukmu: Peneliti, Analis Data, Jurnalis, Ilmuwan, Pustakawan, Konsultan
                            Riset
                        @elseif($dominantType === 'CON')
                            Profesi yang cocok untukmu: Konsultan, HR Specialist, Sales Manager, Network Administrator,
                            Psikolog, Mediator
                        @elseif($dominantType === 'EXP')
                            Profesi yang cocok untukmu: Desainer Produk, Wirausahawan, Developer, Peneliti Lapangan,
                            Pelatih, Inovator
                        @else
                            Profesi yang cocok untukmu: Analis Sistem, Arsitek Perangkat Lunak, Akuntan, Pengacara,
                            Strategis, Arsitek Informasi
                        @endif
                    </p>
                </div>

                <div class="mt-8 text-center">
                    <a href="{{ route('quiz.index') }}"
                        class="inline-block px-6 py-3 font-bold text-white transition-colors bg-blue-600 rounded-lg hover:bg-blue-700">
                        Coba Kuis Lagi
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Data untuk chart
        const data = {
            labels: ['Researcher (RES)', 'Connector (CON)', 'Explorer (EXP)', 'Analyzer (ANA)'],
            datasets: [{
                data: [{{ $percentages['RES'] }}, {{ $percentages['CON'] }}, {{ $percentages['EXP'] }},
                    {{ $percentages['ANA'] }}
                ],
                backgroundColor: [
                    'rgba(59, 130, 246, 0.8)', // Blue for RES
                    'rgba(16, 185, 129, 0.8)', // Green for CON
                    'rgba(245, 158, 11, 0.8)', // Yellow for EXP
                    'rgba(239, 68, 0.8)' // Red for ANA
                ],
                borderColor: [
                    'rgba(59, 130, 246, 1)',
                    'rgba(16, 185, 129, 1)',
                    'rgba(245, 158, 11, 1)',
                    'rgba(239, 68, 68, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Konfigurasi chart
        const config = {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                return `${label}: ${value}%`;
                            }
                        }
                    }
                }
            }
        };

        // Render chart
        window.onload = function() {
            const ctx = document.getElementById('talentChart').getContext('2d');
            const myChart = new Chart(ctx, config);
        };
    </script>
@endsection

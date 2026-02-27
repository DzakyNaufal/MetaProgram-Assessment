@extends('layouts.user')

@section('content')
    <div class="min-h-screen px-4 py-8 bg-gradient-to-br from-slate-50 to-blue-50 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="mb-6">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-blue-700 transition-all duration-300 bg-white shadow-md rounded-xl hover:shadow-lg hover:bg-blue-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>

            <!-- Success Header -->
            <div class="p-8 mb-8 text-center shadow-xl bg-gradient-to-r from-green-400 to-green-600 rounded-2xl">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 mb-4 rounded-full bg-white/20 backdrop-blur-sm">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="mb-2 text-3xl font-bold text-white">Selamat!</h1>
                <p class="text-white/90">Anda telah menyelesaikan assessment: {{ $latestAttempt->course->title }}</p>
                @if ($latestAttempt->category)
                    <p class="mt-2 text-sm text-white/80">{{ $latestAttempt->category->name }}</p>
                @endif
                <p class="mt-1 text-sm text-white/80">Selesai: {{ $latestAttempt->created_at->format('d M Y H:i') }}</p>
            </div>

            <!-- Bar Chart -->
            @if (isset($kategoriBreakdown) && count($kategoriBreakdown) > 0)
                @foreach ($kategoriBreakdown as $kategori)
                    @if (isset($kategori['meta_program_pairs']) && count($kategori['meta_program_pairs']) > 0)
                        <!-- Radar Chart -->
                        <div class="mb-8 overflow-hidden bg-white shadow-xl rounded-2xl">
                            <div class="p-6">
                                <p class="text-sm text-gray-500 mb-2">DEBUG: Canvas ID should be mpRadarChart_{{ $loop->index }}</p>
                                <h3 class="flex items-center gap-2 mb-4 text-xl font-bold text-gray-800">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                                    </svg>
                                    Grafik Meta Programs (Jaring Laba-Laba) - {{ $kategori['name'] }}
                                </h3>
                                <div class="flex justify-center" style="height: 500px;">
                                    <canvas id="mpRadarChart_{{ $loop->index }}"></canvas>
                                </div>
                            </div>
                        </div>

                        <!-- Bar Chart -->
                        <div class="mb-8 overflow-hidden bg-white shadow-xl rounded-2xl">
                            <div class="p-6">
                                <h3 class="flex items-center gap-2 mb-4 text-xl font-bold text-gray-800">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                    Grafik Meta Programs - {{ $kategori['name'] }}
                                </h3>
                                <div style="height: {{ max(400, count($kategori['meta_program_pairs']) * 80) }}px;">
                                    <canvas id="subMpStackedBarChart_{{ $kategori['slug'] }}"></canvas>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif

            <!-- Navigation -->
            <div class="flex flex-col justify-center gap-4 sm:flex-row">
                <a href="{{ route('results.download', $latestAttempt->id) }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 font-semibold text-white transition-all shadow-md bg-gradient-to-r from-red-500 to-red-600 rounded-xl hover:from-red-600 hover:to-red-700 hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Download PDF Report
                </a>
                <a href="{{ route('courses.index') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 font-semibold text-blue-600 transition-colors bg-white border-2 border-blue-600 rounded-xl hover:bg-blue-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    Course Lainnya
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kategoriBreakdown = @js($kategoriBreakdown ?? []);
            console.log('kategoriBreakdown data:', kategoriBreakdown);
            console.log('Number of kategoris:', kategoriBreakdown.length);

            // Register the datalabels plugin
            Chart.register(ChartDataLabels);

            // ============ RADAR CHARTS PER KATEGORI ============
            kategoriBreakdown.forEach(function(kategori, kategoriIndex) {
                if (!kategori.meta_program_pairs || kategori.meta_program_pairs.length === 0) return;

                // Use loop index (0-based) for canvas ID
                const canvasId = 'mpRadarChart_' + kategoriIndex;
                console.log('Creating radar chart for:', kategori.name, 'Canvas ID:', canvasId);

                // Collect dominant Sub-MP for each Meta Program
                const radarLabels = [];
                const radarNames = [];
                const radarScores = [];
                const radarPercentages = [];

                kategori.meta_program_pairs.forEach(function(mp) {
                    // Parse MP name to extract numbers
                    const mpName = mp.meta_program_name;
                    let label = '';

                    const match = mpName.match(/^MP\s+(\d+(?:\s*&\s*\d+)*)(?:\s*—|\s*-|$)/i);
                    if (match) {
                        let numbers = match[1];
                        numbers = numbers.replace(/\s*&\s*/g, '&');
                        label = numbers;
                    } else {
                        const numMatch = mpName.match(/\d+/);
                        label = numMatch ? numMatch[0] : '?';
                    }

                    // Find dominant Sub-MP (highest score)
                    let dominantSubMp = null;
                    let highestScore = -1;

                    mp.pairs.forEach(function(pair) {
                        if (pair.side1 && pair.side1.total_score > highestScore) {
                            highestScore = pair.side1.total_score;
                            dominantSubMp = pair.side1;
                        }
                        if (pair.side2 && pair.side2.total_score > highestScore) {
                            highestScore = pair.side2.total_score;
                            dominantSubMp = pair.side2;
                        }
                    });

                    if (dominantSubMp) {
                        radarLabels.push(label);
                        radarNames.push(dominantSubMp.name);
                        radarScores.push(dominantSubMp.total_score);
                        radarPercentages.push(dominantSubMp.score_percentage || 0);
                    }
                });

                // Sort by label number
                const combinedData = radarLabels.map(function(label, index) {
                    return {
                        label: label,
                        name: radarNames[index],
                        score: radarScores[index],
                        percentage: radarPercentages[index],
                        sortKey: parseInt(label.split('&')[0])
                    };
                });

                combinedData.sort(function(a, b) { return a.sortKey - b.sortKey; });

                const sortedLabels = [];
                const sortedNames = [];
                const sortedScores = [];
                const sortedPercentages = [];

                combinedData.forEach(function(item) {
                    sortedLabels.push(item.label);
                    sortedNames.push(item.name);
                    sortedScores.push(item.score);
                    sortedPercentages.push(item.percentage);
                });

                // Find highest score for highlighting
                const maxScore = Math.max(...sortedScores);
                const pointColors = sortedScores.map(score => score >= maxScore ? 'rgba(239, 68, 68, 1)' : 'rgba(59, 130, 246, 1)');
                const pointSizes = sortedScores.map(score => score >= maxScore ? 6 : 3);
                const pointHoverSizes = sortedScores.map(score => score >= maxScore ? 8 : 5);

                const ctx = document.getElementById(canvasId);
                if (!ctx) {
                    console.error('Canvas element not found:', canvasId);
                    return;
                }
                console.log('Canvas found, creating chart with', sortedLabels.length, 'data points');

                new Chart(ctx.getContext('2d'), {
                    type: 'radar',
                    data: {
                        labels: sortedLabels,
                        datasets: [{
                            label: 'Skor Meta Programs',
                            data: sortedScores,
                            backgroundColor: 'rgba(59, 130, 246, 0.25)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: pointColors,
                            pointBorderColor: '#fff',
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(59, 130, 246, 1)',
                            pointRadius: pointSizes,
                            pointHoverRadius: pointHoverSizes
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        scales: {
                            r: {
                                min: 0,
                                max: 18,
                                ticks: {
                                    stepSize: 3,
                                    font: { size: 9 },
                                    backdropColor: 'transparent'
                                },
                                pointLabels: {
                                    font: function(context) {
                                        const mpCount = sortedLabels.length;
                                        if (mpCount > 20) {
                                            return { size: 7, weight: '500' };
                                        } else if (mpCount > 10) {
                                            return { size: 8, weight: '500' };
                                        } else {
                                            return { size: 9, weight: '600' };
                                        }
                                    },
                                    color: '#374151'
                                },
                                grid: { color: 'rgba(0, 0, 0, 0.1)' },
                                angleLines: { color: 'rgba(0, 0, 0, 0.1)' }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: { font: { size: 13 } }
                            },
                            tooltip: {
                                callbacks: {
                                    title: function(context) {
                                        const index = context[0].dataIndex;
                                        const mpLabel = sortedLabels[index] || '';
                                        const subMpName = sortedNames[index] || '';
                                        return mpLabel + ' - ' + subMpName;
                                    },
                                    label: function(context) {
                                        const index = context.dataIndex;
                                        const totalScore = sortedScores[index] || 0;
                                        const percentage = sortedPercentages[index] || 0;
                                        return 'Skor: ' + totalScore.toFixed(1) + ' (' + percentage.toFixed(0) + '%)';
                                    }
                                }
                            },
                            datalabels: {
                                color: '#1e40af',
                                font: { size: 9, weight: 'bold' },
                                formatter: function(value, context) {
                                    const index = context.dataIndex;
                                    const totalScore = sortedScores[index] || 0;
                                    const percentage = sortedPercentages[index] || 0;
                                    return totalScore.toFixed(1) + ' (' + percentage.toFixed(0) + '%)';
                                },
                                anchor: 'end',
                                align: 'end',
                                offset: 8,
                                display: true
                            }
                        }
                    }
                });
            });

            // ============ STACKED BAR CHARTS PER KATEGORI ============
            // Color per category (same color for all bars in same category, darker for dominant)
            const categoryColors = [
                { base: [59, 130, 246] },      // Blue - Kategori 1
                { base: [16, 185, 129] },      // Green - Kategori 2
                { base: [245, 158, 11] },      // Amber - Kategori 3
                { base: [139, 92, 246] },      // Purple - Kategori 4
                { base: [236, 72, 153] },      // Pink - Kategori 5
                { base: [20, 184, 166] },      // Teal - Kategori 6
                { base: [249, 115, 22] },      // Orange - Kategori 7
            ];

            // Function to get color based on dominance
            function getColorForSide(rgb, isDominant) {
                const alpha = isDominant ? 0.9 : 0.4;
                return `rgba(${rgb[0]}, ${rgb[1]}, ${rgb[2]}, ${alpha})`;
            }

            function getBorderColor(rgb) {
                return `rgb(${rgb[0]}, ${rgb[1]}, ${rgb[2]})`;
            }

            kategoriBreakdown.forEach(function(kategori, kategoriIndex) {
                if (!kategori.meta_program_pairs || kategori.meta_program_pairs.length === 0) return;

                const metaProgramPairs = kategori.meta_program_pairs;
                const canvasId = 'subMpStackedBarChart_' + kategori.slug;

                // Get color for this category
                const categoryColor = categoryColors[kategoriIndex % categoryColors.length].base;

                // Prepare chart data for stacked bar chart (using percentage with total_score display)
                const labels = [];
                const side1Data = [];
                const side2Data = [];
                const side1Labels = [];
                const side2Labels = [];
                const side1Pct = [];
                const side2Pct = [];
                const allPairs = []; // Store all pairs for easy access

                metaProgramPairs.forEach(function(mp, idx) {
                    // Collect all Sub-MPs from all pairs
                    const allSubMps = [];
                    mp.pairs.forEach(function(pair) {
                        if (pair.side1) {
                            allSubMps.push({
                                side: pair.side1,
                                score: pair.side1.score_percentage || 0
                            });
                        }
                        if (pair.side2) {
                            allSubMps.push({
                                side: pair.side2,
                                score: pair.side2.score_percentage || 0
                            });
                        }
                    });

                    // Sort by score (descending) and get top 2
                    allSubMps.sort(function(a, b) { return b.score - a.score; });

                    if (allSubMps.length >= 2) {
                        labels.push(mp.meta_program_name);

                        // Highest - Dominan
                        const pct1 = allSubMps[0].score;
                        side1Data.push(pct1);
                        side1Labels.push(allSubMps[0].side.name);
                        side1Pct.push(pct1);

                        // Second highest - Lainnya
                        const pct2 = allSubMps[1].score;
                        side2Data.push(pct2);
                        side2Labels.push(allSubMps[1].side.name);
                        side2Pct.push(pct2);

                        allPairs.push({
                            side1: allSubMps[0].side,
                            side2: allSubMps[1].side
                        });
                    } else if (allSubMps.length === 1) {
                        // Only one Sub-MP
                        labels.push(mp.meta_program_name);
                        const pct = allSubMps[0].score;
                        side1Data.push(pct);
                        side2Data.push(0);
                        side1Labels.push(allSubMps[0].side.name);
                        side2Labels.push('Other');
                        side1Pct.push(pct);
                        side2Pct.push(0);

                        allPairs.push({
                            side1: allSubMps[0].side,
                            side2: null
                        });
                    }
                });

                const ctx = document.getElementById(canvasId);
                if (!ctx) return;

                // Dataset 0 = dominant (darker), Dataset 1 = other (lighter)
                const side1Colors = side1Data.map(() => getColorForSide(categoryColor, true));
                const side2Colors = side2Data.map((score) => {
                    if (score === 0) return 'rgba(200, 200, 200, 0.5)';
                    return getColorForSide(categoryColor, false);
                });
                const side1Borders = side1Data.map(() => getBorderColor(categoryColor));
                const side2Borders = side2Data.map((score) => {
                    if (score === 0) return 'rgb(180, 180, 180)';
                    return getBorderColor(categoryColor);
                });

                // Replace 0 with minimum value for display (so bars are visible)
                const displayData1 = side1Data.map(val => val > 0 ? val : 0.5);
                const displayData2 = side2Data.map(val => val > 0 ? val : 0.5);

                new Chart(ctx.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Dominan',
                                data: displayData1,
                                backgroundColor: side1Colors,
                                borderColor: side1Borders,
                                borderWidth: 1
                            },
                            {
                                label: 'Lainnya',
                                data: displayData2,
                                backgroundColor: side2Colors,
                                borderColor: side2Borders,
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        indexAxis: 'y',
                        scales: {
                            x: {
                                stacked: false,
                                min: 0,
                                max: 100,
                                display: false
                            },
                            y: {
                                stacked: false,
                                ticks: {
                                    font: { size: 10 },
                                    autoSkip: false,
                                    maxRotation: 0,
                                    minRotation: 0
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top',
                                labels: { font: { size: 11 } }
                            },
                            tooltip: {
                                callbacks: {
                                    title: function(context) {
                                        const idx = context[0].dataIndex;
                                        const pair = allPairs[idx];
                                        if (!pair) return '';
                                        // Show Sub-MP names as title
                                        if (pair.side2) {
                                            return (pair.side1?.name || '') + ' vs ' + (pair.side2?.name || '');
                                        } else {
                                            return pair.side1?.name || 'Sub-MP';
                                        }
                                    },
                                    label: function(context) {
                                        const idx = context.dataIndex;
                                        const pair = allPairs[idx];
                                        if (!pair) return '';
                                        // Use original data arrays for tooltip
                                        if (context.datasetIndex === 0) {
                                            const totalScore = pair.side1?.total_score || 0;
                                            const pct = side1Pct[idx] || 0;
                                            return side1Labels[idx] + ': ' + totalScore.toFixed(1) + ' (' + pct.toFixed(0) + '%)';
                                        } else {
                                            const totalScore = pair.side2?.total_score || 0;
                                            const pct = side2Pct[idx] || 0;
                                            // Show 0% for Other bar
                                            if (pct === 0) {
                                                return side2Labels[idx] + ': 0.0 (0%)';
                                            }
                                            return side2Labels[idx] + ': ' + totalScore.toFixed(1) + ' (' + pct.toFixed(0) + '%)';
                                        }
                                    }
                                }
                            },
                            datalabels: {
                                color: '#fff',
                                font: { size: 10, weight: 'bold' },
                                formatter: function(value, context) {
                                    const idx = context.dataIndex;
                                    const pair = allPairs[idx];
                                    if (!pair) return '';
                                    if (context.datasetIndex === 0) {
                                        const pct = side1Pct[idx] || 0;
                                        if (pct < 15) return '';
                                        const totalScore = pair.side1?.total_score || 0;
                                        return side1Labels[idx] + '\n' + totalScore.toFixed(1) + ' (' + pct.toFixed(0) + '%)';
                                    } else {
                                        const pct = side2Pct[idx] || 0;
                                        // Show 0% for Other bar
                                        if (pct === 0) return side2Labels[idx] + '\n0.0 (0%)';
                                        if (pct < 15) return '';
                                        const totalScore = pair.side2?.total_score || 0;
                                        return side2Labels[idx] + '\n' + totalScore.toFixed(1) + ' (' + pct.toFixed(0) + '%)';
                                    }
                                }
                            }
                        }
                    }
                });
            });
        });
    </script>
@endsection

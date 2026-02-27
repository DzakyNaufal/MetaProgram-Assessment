@extends('layouts.user')

@section('content')
    <div class="min-h-screen px-4 py-8 bg-gradient-to-br from-slate-50 to-blue-50 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="mb-6">
                <a href="{{ route('user.history') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-blue-700 transition-all duration-300 bg-white shadow-md rounded-xl hover:shadow-lg hover:bg-blue-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke History
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
                <p class="text-white/90">Anda telah menyelesaikan Full Assessment Meta Programs</p>
                <p class="mt-2 text-sm text-white/80">Selesai: {{ $latestAttempt->created_at->format('d M Y H:i') }}</p>
            </div>

            <!-- Radar Chart Section -->
            <div class="mb-8 overflow-hidden bg-white shadow-xl rounded-2xl">
                <div class="p-6">
                    <h3 class="flex items-center gap-2 mb-4 text-xl font-bold text-gray-800">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                        </svg>
                        Grafik Meta Programs (Jaring Laba-Laba)
                    </h3>
                    <div class="flex justify-center" style="height: 700px;">
                        <canvas id="mpRadarChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Grafik Meta Programs per Kategori -->
            @foreach ($kategoriBreakdown as $kategori)
                @if (isset($kategori['meta_program_pairs']) && count($kategori['meta_program_pairs']) > 0)
                    <div class="mb-8 overflow-hidden bg-white shadow-xl rounded-2xl">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="flex items-center gap-2 text-xl font-bold text-gray-800">
                                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                    Grafik Meta Programs - {{ $kategori['name'] }}
                                </h3>
                                @if (isset($kategori['highest_sub_mps']) && !empty($kategori['highest_sub_mps']))
                                    <div
                                        class="px-4 py-2 shadow-md bg-gradient-to-r from-amber-400 to-orange-500 rounded-xl">
                                        <span class="text-sm font-semibold text-white">
                                            Tertinggi:
                                            {{ implode(', ', $kategori['highest_sub_mps']) }}{{ count($kategori['highest_sub_mps']) > 1 ? '.' : '' }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div style="height: {{ max(400, count($kategori['meta_program_pairs']) * 80) }}px;">
                                <canvas id="subMpStackedBarChart_{{ $kategori['slug'] }}"></canvas>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

            <!-- WhatsApp Consultation -->
            @if ($latestAttempt->course && $latestAttempt->course->has_whatsapp_consultation)
                <div class="p-6 mb-8 border-2 border-green-200 bg-green-50 rounded-2xl">
                    <h3 class="flex items-center gap-2 mb-4 text-lg font-semibold text-green-800">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                        </svg>
                        Konsultasi WhatsApp Tersedia!
                    </h3>
                    <p class="mb-4 text-green-700">Diskusikan hasil Meta Program Anda dengan konsultan kami.</p>
                    <a href="{{ route('results.whatsapp', $latestAttempt->id) }}"
                        class="inline-flex items-center gap-2 px-6 py-3 font-bold text-white transition-colors bg-green-500 shadow-md rounded-xl hover:bg-green-600 hover:shadow-lg"
                        target="_blank">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                        </svg>
                        Konsultasi WhatsApp
                    </a>
                </div>
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
                <a href="{{ route('user.history') }}"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 font-bold text-white transition-all shadow-md bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 hover:shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Lihat History
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js">
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mpRadarData = @js($mpRadarData);
            const kategoriBreakdown = @js($kategoriBreakdown);

            // Register the datalabels plugin
            Chart.register(ChartDataLabels);

            // ============ RADAR CHART (Jaring Laba-Laba) - Dominant Sub-MPs Only ============
            // Use mpRadarData prepared by controller (already has dominant Sub-MP only)
            const radarData = [];

            mpRadarData.forEach(function(item) {
                // Parse MP name to extract numbers
                // item.label is like "MP 4 & 5 — Information Gathering Sort" or "MP 36 — Something"
                const mpName = item.label;

                // Extract MP numbers from the name
                let label = '';

                // Match pattern like "MP 4 & 5", "MP 36", "MP 4 & 5 — ..."
                const match = mpName.match(/^MP\s+(\d+(?:\s*&\s*\d+)*)(?:\s*—|\s*-|$)/i);
                if (match) {
                    // Get the numbers part and clean it up
                    let numbers = match[1];
                    // Replace " & " or " &" or "& " with just "&"
                    numbers = numbers.replace(/\s*&\s*/g, '&');
                    label = numbers;
                } else {
                    // Fallback: extract first number found
                    const numMatch = mpName.match(/\d+/);
                    label = numMatch ? numMatch[0] : '?';
                }

                radarData.push({
                    label: label,  // e.g., "4", "4&5", "36"
                    mpNumber: item.mp_number,  // For sorting
                    subMpName: item.sub_mp_name,
                    score: item.total_score,
                    percentage: item.percentage
                });
            });

            // Sort by the first number in label to ensure proper order (1, 2, 3, 4&5, 6, ...)
            radarData.sort(function(a, b) {
                const getFirstNumber = function(label) {
                    const match = label.match(/^(\d+)/);
                    return match ? parseInt(match[1]) : 0;
                };
                return getFirstNumber(a.label) - getFirstNumber(b.label);
            });

            // Build arrays from sorted data
            const sortedLabels = [];
            const sortedNames = [];
            const sortedScores = [];
            const sortedPercentages = [];

            radarData.forEach(function(item) {
                sortedLabels.push(item.label);
                sortedNames.push(item.subMpName);
                sortedScores.push(item.score);
                sortedPercentages.push(item.percentage);
            });

            // Find highest score(s) for highlighting (scale is fixed 0-18)
            const maxScore = Math.max(...sortedScores);
            const pointColors = sortedScores.map(score => score >= maxScore ? 'rgba(239, 68, 68, 1)' :
                'rgba(59, 130, 246, 1)');
            const pointSizes = sortedScores.map(score => score >= maxScore ? 6 : 3);
            const pointHoverSizes = sortedScores.map(score => score >= maxScore ? 8 : 5);

            const ctxRadar = document.getElementById('mpRadarChart').getContext('2d');
            new Chart(ctxRadar, {
                type: 'radar',
                data: {
                    labels: sortedLabels, // 1, 2, 3, 4&5, 6, 7, ... up to 51
                    datasets: [{
                        label: 'Skor Meta Programs',
                        data: sortedScores, // Use total scores
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
                                font: {
                                    size: 9
                                },
                                backdropColor: 'transparent'
                            },
                            pointLabels: {
                                // Adjust font size based on number of Sub-MPs
                                font: function(context) {
                                    const mpCount = sortedLabels.length;
                                    if (mpCount > 100) {
                                        return {
                                            size: 6,
                                            weight: '400'
                                        };
                                    } else if (mpCount > 60) {
                                        return {
                                            size: 7,
                                            weight: '500'
                                        };
                                    } else if (mpCount > 30) {
                                        return {
                                            size: 8,
                                            weight: '500'
                                        };
                                    } else {
                                        return {
                                            size: 9,
                                            weight: '600'
                                        };
                                    }
                                },
                                color: '#374151'
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            },
                            angleLines: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                font: {
                                    size: 13
                                }
                            }
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
                            font: {
                                size: 9,
                                weight: 'bold'
                            },
                            formatter: function(value, context) {
                                const index = context.dataIndex;
                                const totalScore = sortedScores[index] || 0;
                                const percentage = sortedPercentages[index] || 0;
                                return totalScore.toFixed(1) + ' (' + percentage.toFixed(0) + '%)';
                            },
                            anchor: 'end',
                            align: 'end',
                            offset: 8,
                            // Always display labels
                            display: true
                        }
                    }
                }
            });

            // ============ STACKED BAR CHARTS PER KATEGORI ============
            // Color per category (same color for all bars in same category, darker for dominant)
            const categoryColors = [{
                    base: [59, 130, 246]
                }, // Blue - Kategori 1
                {
                    base: [16, 185, 129]
                }, // Green - Kategori 2
                {
                    base: [245, 158, 11]
                }, // Amber - Kategori 3
                {
                    base: [139, 92, 246]
                }, // Purple - Kategori 4
                {
                    base: [236, 72, 153]
                }, // Pink - Kategori 5
                {
                    base: [20, 184, 166]
                }, // Teal - Kategori 6
                {
                    base: [249, 115, 22]
                }, // Orange - Kategori 7
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
                        datasets: [{
                                label: 'Dominan',
                                data: displayData1,
                                backgroundColor: side1Colors,
                                borderColor: side1Borders,
                                borderWidth: 1
                            },
                            {
                                label: 'Other',
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
                                    font: {
                                        size: 10
                                    },
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
                                labels: {
                                    font: {
                                        size: 11
                                    }
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    title: function(context) {
                                        const idx = context[0].dataIndex;
                                        const pair = allPairs[idx];
                                        if (!pair) return '';
                                        // Show Sub-MP names as title
                                        if (pair.side2) {
                                            return (pair.side1?.name || '') + ' vs ' + (pair
                                                .side2?.name || '');
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
                                            return side1Labels[idx] + ': ' + totalScore.toFixed(
                                                1) + ' (' + pct.toFixed(0) + '%)';
                                        } else {
                                            const totalScore = pair.side2?.total_score || 0;
                                            const pct = side2Pct[idx] || 0;
                                            // Show 0% for Other bar
                                            if (pct === 0) {
                                                return side2Labels[idx] + ': 0.0 (0%)';
                                            }
                                            return side2Labels[idx] + ': ' + totalScore.toFixed(
                                                1) + ' (' + pct.toFixed(0) + '%)';
                                        }
                                    }
                                }
                            },
                            datalabels: {
                                color: '#fff',
                                font: {
                                    size: 10,
                                    weight: 'bold'
                                },
                                formatter: function(value, context) {
                                    const idx = context.dataIndex;
                                    const pair = allPairs[idx];
                                    if (!pair) return '';
                                    if (context.datasetIndex === 0) {
                                        const pct = side1Pct[idx] || 0;
                                        if (pct < 15) return '';
                                        const totalScore = pair.side1?.total_score || 0;
                                        return side1Labels[idx] + '\n' + totalScore.toFixed(1) +
                                            ' (' + pct.toFixed(0) + '%)';
                                    } else {
                                        const pct = side2Pct[idx] || 0;
                                        // Show 0% for Other bar
                                        if (pct === 0) return side2Labels[idx] + '\n0.0 (0%)';
                                        if (pct < 15) return '';
                                        const totalScore = pair.side2?.total_score || 0;
                                        return side2Labels[idx] + '\n' + totalScore.toFixed(1) +
                                            ' (' + pct.toFixed(0) + '%)';
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

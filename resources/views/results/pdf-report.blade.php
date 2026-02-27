<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>REPORT META-PROGRAM</title>
    <style>
        @page {
            margin: 0.8in 1in 0.8in 1in;
            size: A4;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            color: #000;
            margin: 0;
            padding: 0;
        }

        /* Prevent kategori section from breaking */
        .kategori-section {
            page-break-inside: avoid;
        }

        .kategori-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #f5f5f5;
            border: 2px solid #000;
            padding: 12px;
            margin: 30px 0 0 0;
        }

        .highest-badge {
            text-align: center;
            background-color: #f97316;
            color: #fff;
            font-size: 10pt;
            font-weight: bold;
            padding: 8px;
            margin-bottom: 15px;
            border-radius: 4px;
        }

        .chart-container {
            margin: 0 0 20px 0;
            page-break-inside: avoid;
        }

        .mp-group {
            margin: 20px 0;
            page-break-inside: avoid;
        }

        .mp-name {
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        .bar-row {
            margin: 4px 0;
            page-break-inside: avoid;
        }

        .bar-label {
            font-size: 8pt;
            margin-bottom: 0px;
            display: flex;
            justify-content: space-between;
        }

        .bar-name {
            font-weight: bold;
        }

        .bar-score {
            color: #666;
        }

        .bar-container {
            position: relative;
            height: 30px;
            background-color: #f0f0f0;
            border: 1px solid #000;
            border-radius: 3px;
            overflow: hidden;
            margin-top: 2px;
        }

        .bar-fill {
            height: 100%;
            display: flex;
            align-items: center;
            color: #fff;
            font-weight: bold;
            font-size: 7pt;
            position: relative;
        }

        .bar-text {
            position: absolute;
            left: 5px;
            top: 50%;
            transform: translateY(-50%);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: calc(100% - 35px);
            font-size: 6pt;
        }

        .bar-percent {
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 7pt;
            white-space: nowrap;
        }

        /* Category colors - dominant (darker) */
        .cat-1-dominant {
            background-color: #3b82f6;
        }

        .cat-1-non-dominant {
            background-color: rgba(59, 130, 246, 0.4);
        }

        .cat-2-dominant {
            background-color: #10b981;
        }

        .cat-2-non-dominant {
            background-color: rgba(16, 185, 129, 0.4);
        }

        .cat-3-dominant {
            background-color: #f59e0b;
        }

        .cat-3-non-dominant {
            background-color: rgba(245, 158, 11, 0.4);
        }

        .cat-4-dominant {
            background-color: #8b5cf6;
        }

        .cat-4-non-dominant {
            background-color: rgba(139, 92, 246, 0.4);
        }

        .cat-5-dominant {
            background-color: #ec4899;
        }

        .cat-5-non-dominant {
            background-color: rgba(236, 72, 153, 0.4);
        }

        .cat-6-dominant {
            background-color: #14b8a6;
        }

        .cat-6-non-dominant {
            background-color: rgba(20, 184, 166, 0.4);
        }

        .cat-7-dominant {
            background-color: #f97316;
        }

        .cat-7-non-dominant {
            background-color: rgba(249, 115, 22, 0.4);
        }

        .empty-bar {
            background-color: #c8c8c8;
        }

        .summary-section {
            margin-top: 40px;
            page-break-before: always;
        }

        .summary-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #f97316;
            color: #fff;
            border: 2px solid #000;
            padding: 12px;
            margin-bottom: 20px;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .summary-table th {
            background-color: #333;
            color: #fff;
            font-weight: bold;
            padding: 10px;
            text-align: left;
            border: 1px solid #000;
            font-size: 10pt;
        }

        .summary-table td {
            padding: 8px 10px;
            border: 1px solid #000;
            font-size: 10pt;
        }

        .summary-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .summary-table tr:nth-child(odd) {
            background-color: #fff;
        }
    </style>
</head>

<body>
    @foreach ($kategoriBreakdown as $kategoriIndex => $kategori)
        @if (isset($kategori['meta_program_pairs']) && count($kategori['meta_program_pairs']) > 0)
            <div class="kategori-section">
                <div class="kategori-title">{{ $kategori['name'] }}</div>

                <div class="chart-container">
                    @foreach ($kategori['meta_program_pairs'] as $mpItem)
                        @php
                            // Collect ALL Sub-MPs from all pairs
                            $allSubMps = [];
                            foreach ($mpItem['pairs'] as $pair) {
                                if (isset($pair['side1'])) {
                                    $s1 = $pair['side1'];
                                    $score1 = isset($s1['score_percentage']) ? (float)$s1['score_percentage'] : 0.0;
                                    $allSubMps[] = [
                                        'side' => $s1,
                                        'score' => $score1,
                                        'name' => $s1['name'] ?? '',
                                        'total_score' => isset($s1['total_score']) ? (float)$s1['total_score'] : 0.0
                                    ];
                                }
                                if (isset($pair['side2'])) {
                                    $s2 = $pair['side2'];
                                    $score2 = isset($s2['score_percentage']) ? (float)$s2['score_percentage'] : 0.0;
                                    $allSubMps[] = [
                                        'side' => $s2,
                                        'score' => $score2,
                                        'name' => $s2['name'] ?? '',
                                        'total_score' => isset($s2['total_score']) ? (float)$s2['total_score'] : 0.0
                                    ];
                                }
                            }

                            // Sort by score (descending) - explicit subtraction like JavaScript
                            usort($allSubMps, function($a, $b) {
                                return $b['score'] - $a['score'];
                            });

                            // Get top 2
                            $topSubMps = array_slice($allSubMps, 0, 2);
                            $catNum = $kategoriIndex + 1;
                        @endphp

                        @if (count($topSubMps) > 0)
                            <div class="mp-group">
                                <div class="mp-name">{{ $mpItem['meta_program_name'] }}</div>

                                {{-- Dominan (Highest) --}}
                                @php
                                    $dominanSide = $topSubMps[0]['side'];
                                    $dominanScore = $topSubMps[0]['score'];
                                    $dominanTotalScore = $dominanSide['total_score'] ?? 0;
                                    $dominanName = $dominanSide['name'] ?? '';
                                    $dominanPct = $dominanSide['score_percentage'] ?? 0;
                                @endphp
                                <div class="bar-row">
                                    <div class="bar-label">
                                        <span class="bar-name">{{ $dominanName }} (Dominan)</span>
                                        <span class="bar-score">{{ number_format($dominanTotalScore, 1) }} ({{ number_format($dominanPct, 0) }}%)</span>
                                    </div>
                                    <div class="bar-container">
                                        <div class="bar-fill cat-{{ $catNum }}-dominant" style="width: {{ $dominanPct }}%;">
                                            @if ($dominanPct > 20)
                                                <span class="bar-text">{{ $dominanName }}</span>
                                            @endif
                                            <span class="bar-percent">{{ number_format($dominanPct, 0) }}%</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Other (Second Highest) --}}
                                @if (isset($topSubMps[1]))
                                    @php
                                        $otherSide = $topSubMps[1]['side'];
                                        $otherScore = $topSubMps[1]['score'];
                                        $otherTotalScore = $otherSide['total_score'] ?? 0;
                                        $otherName = $otherSide['name'] ?? '';
                                        $otherPct = $otherSide['score_percentage'] ?? 0;
                                    @endphp
                                    <div class="bar-row">
                                        <div class="bar-label">
                                            <span class="bar-name">{{ $otherName }} (Other)</span>
                                            <span class="bar-score">{{ number_format($otherTotalScore, 1) }} ({{ number_format($otherPct, 0) }}%)</span>
                                        </div>
                                        <div class="bar-container">
                                            <div class="bar-fill cat-{{ $catNum }}-non-dominant" style="width: {{ $otherPct }}%;">
                                                @if ($otherPct > 20)
                                                    <span class="bar-text">{{ $otherName }}</span>
                                                @endif
                                                <span class="bar-percent">{{ number_format($otherPct, 0) }}%</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach

    {{-- Summary Table - Highest Sub-MP per Category --}}
    <div class="summary-section">
        <div class="summary-title">RINGKASAN SUB-META PROGRAM TERTINGGI</div>

        <table class="summary-table">
            <thead>
                <tr>
                    <th width="15%">No</th>
                    <th width="85%">Sub-Meta Program Tertinggi</th>
                </tr>
            </thead>
            <tbody>
                @php $no = 1; @endphp
                @if (isset($sortedHighestSubMps) && is_array($sortedHighestSubMps) && count($sortedHighestSubMps) > 0)
                    @foreach ($sortedHighestSubMps as $highestSubMp)
                        @if ($no <= 10)
                            <tr>
                                <td align="center">{{ $no++ }}</td>
                                <td>{{ $highestSubMp }}</td>
                            </tr>
                        @endif
                    @endforeach
                @else
                    @foreach ($kategoriBreakdown as $kategori)
                        @if (isset($kategori['highest_sub_mps']) &&
                                is_array($kategori['highest_sub_mps']) &&
                                count($kategori['highest_sub_mps']) > 0)
                            @foreach ($kategori['highest_sub_mps'] as $highestSubMp)
                                @if ($no <= 10)
                                    <tr>
                                        <td align="center">{{ $no++ }}</td>
                                        <td>{{ $highestSubMp }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</body>

</html>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Assessment Result Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .user-info {
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 30px;
        }

        .chart-container {
            margin: 20px 0;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .interpretation {
            margin-top: 20px;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Assessment Result Report</h1>
        <h2>{{ $attempt->user->name }}</h2>
        <p>{{ $attempt->user->email }}</p>
        <p>Assessment Date: {{ $attempt->created_at->format('d M Y') }}</p>
        @if ($purchase)
            <p>Package: {{ $purchase->course->title }}</p>
            <p>Status: {{ ucfirst($purchase->status) }}</p>
        @endif
    </div>

    <div class="section">
        <h3>Meta Programs Average Scores</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Meta Program</th>
                    <th>Average Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mpAverages as $mpNumber => $average)
                    <tr>
                        <td>{{ $mpNumber }}</td>
                        <td>{{ $mpNames[$mpNumber - 1] ?? 'Meta Program ' . $mpNumber }}</td>
                        <td>{{ number_format($average, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Detailed Raw Scores</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Meta Program</th>
                    <th>Total Score</th>
                    <th>Question Count</th>
                    <th>Average</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mpScores as $mpIndex => $mpData)
                    <tr>
                        <td>{{ $mpData['mp_number'] }}</td>
                        <td>{{ $mpNames[$mpIndex] ?? 'Meta Program ' . ($mpIndex + 1) }}</td>
                        <td>{{ $mpData['total_score'] }}</td>
                        <td>{{ $mpData['count'] }}</td>
                        <td>{{ number_format($mpData['count'] > 0 ? $mpData['total_score'] / $mpData['count'] : 0, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($purchase && $purchase->course->price > 0)
        <div class="section interpretation">
            <h3>Detailed Interpretation</h3>
            <p>
                Based on your assessment results, here is a detailed interpretation of your personality profile.
                Your responses indicate specific patterns in how you process information, make decisions, and
                interact with the world.
            </p>
            <p>
                The Meta Programs identified in your profile suggest that you have particular ways of filtering
                information, organizing your experience, and responding to different situations. Understanding these
                patterns
                can help you leverage your strengths and work on potential blind spots.
            </p>
            <p>
                For example, if you scored high on "Global" in the Chunk Size category, it suggests you prefer
                to see the big picture before focusing on details. Conversely, a high "Specific" score would indicate
                you prefer to understand details before seeing the overall picture.
            </p>
            <p>
                Each Meta Program dimension provides insights into different aspects of your thinking and
                behavioral patterns. These insights can be valuable for personal development, career planning,
                communication, and
                relationship building.
            </p>
        </div>
    @endif
</body>

</html>

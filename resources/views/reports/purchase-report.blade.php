<!DOCTYPE html>
<html>

<head>
    <title>Talent Assessment Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #33;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .content {
            margin: 20px 0;
        }

        .section {
            margin: 15px 0;
        }

        .section h2 {
            color: #333;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Talent Assessment Report</h1>
        <p><strong>Generated for:</strong> {{ $user->name }} ({{ $user->email }})</p>
        <p><strong>Product:</strong> {{ $product->name }}</p>
        <p><strong>Assessment Date:</strong> {{ $purchase->purchase_date->format('d F Y') }}</p>
    </div>

    <div class="content">
        <div class="section">
            <h2>Assessment Overview</h2>
            <p>This report presents the results of your talent assessment. The assessment evaluates various competencies
                and personality traits to provide insights into your professional strengths and potential.</p>
        </div>

        <div class="section">
            <h2>Key Findings</h2>
            <ul>
                <li><strong>Primary Talent:</strong> Strategic Thinker</li>
                <li><strong>Leadership Style:</strong> Collaborative</li>
                <li><strong>Communication Strength:</strong> Persuasive</li>
                <li><strong>Problem-Solving:</strong> Analytical</li>
            </ul>
        </div>

        <div class="section">
            <h2>Recommendations</h2>
            <p>Based on your assessment results, you would excel in roles that require strategic planning and team
                leadership. Consider positions in project management, business analysis, or team leadership.</p>
        </div>

        <div class="section">
            <h2>Development Areas</h2>
            <p>Focus on enhancing your technical skills in data analysis and digital tools to complement your strategic
                thinking abilities.</p>
        </div>
    </div>

    <div class="footer">
        <p>Talents Mapping &copy; {{ date('Y') }} - Professional Talent Assessment Services</p>
        <p>This report is confidential and intended solely for the named individual.</p>
    </div>
</body>

</html>

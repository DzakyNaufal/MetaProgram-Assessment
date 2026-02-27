<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Personal - {{ $attempt->user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .prose-content {
            line-height: 1.8;
        }

        .prose-content h1 {
            font-size: 1.875rem;
            font-weight: 700;
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: #1f2937;
        }

        .prose-content h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-top: 1.75rem;
            margin-bottom: 0.75rem;
            color: #374151;
        }

        .prose-content h3 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
            color: #4b5563;
        }

        .prose-content p {
            margin-bottom: 1rem;
            color: #4b5563;
        }

        .prose-content ul, .prose-content ol {
            margin-bottom: 1rem;
            padding-left: 1.5rem;
        }

        .prose-content li {
            margin-bottom: 0.5rem;
            color: #4b5563;
        }

        .prose-content strong {
            font-weight: 600;
            color: #1f2937;
        }

        .loading-spinner {
            border: 4px solid #f3f4f6;
            border-top: 4px solid #3b82f6;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">
                        Ur-BrainDevPro
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">
                        Dashboard
                    </a>
                    <a href="{{ route('user.history') }}" class="text-gray-600 hover:text-gray-900">
                        History
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('results.show', $attempt->id) }}"
               class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Hasil
            </a>
        </div>

        <!-- Report Header -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <div class="text-center">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Laporan Personal Meta-Programs</h1>
                <p class="text-gray-600">
                    <strong>{{ $attempt->user->name }}</strong>
                </p>
                <p class="text-sm text-gray-500 mt-1">
                    Tanggal Assessment: {{ $attempt->completed_at ? $attempt->completed_at->format('d F Y') : $attempt->created_at->format('d F Y') }}
                </p>
            </div>
        </div>

        <!-- Generated Report Content -->
        @if($personalReport)
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                <div class="prose-content">
                    {!! $personalReport !!}
                </div>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-lg p-8 text-center">
                <div class="loading-spinner mx-auto mb-4"></div>
                <p class="text-gray-600">Memuat laporan personal...</p>
            </div>
        @endif

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-4 justify-center">
            <a href="{{ route('results.download', $attempt->id) }}"
               class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-red-700 transition-all duration-300 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Download PDF Lengkap
            </a>

            <button onclick="window.print()"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white font-semibold rounded-xl hover:from-indigo-600 hover:to-indigo-700 transition-all duration-300 shadow-md hover:shadow-lg">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak Laporan Ini
            </button>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-gray-600 text-sm">
                    Laporan ini digenerate secara otomatis oleh sistem Ur-BrainDevPro dengan bantuan AI
                </p>
                <p class="text-gray-500 text-xs mt-2">
                    &copy; {{ date('Y') }} Ur-BrainDevPro. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Print Styles -->
    <style media="print">
        body {
            background: white;
        }

        nav, footer, .mb-6 {
            display: none !important;
        }

        main {
            max-width: 100%;
            padding: 0;
        }

        .bg-white {
            box-shadow: none !important;
            border: none !important;
        }
    </style>
</body>
</html>

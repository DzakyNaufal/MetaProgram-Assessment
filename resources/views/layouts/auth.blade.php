<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gradient-to-br from-blue-50 via-white to-blue-100">
    <div class="flex flex-col min-h-screen md:flex-row">
        <!-- Left side with background and branding -->
        <div
            class="relative flex flex-col justify-center w-full p-8 overflow-hidden text-white md:w-1/2 bg-gradient-to-br from-primary-600 to-primary-800">
            <!-- Animated background elements -->
            <div class="absolute inset-0 opacity-20">
                <div
                    class="absolute top-0 left-0 w-full h-full bg-gradient-to-br from-blue-400/30 via-transparent to-blue-600/30 animate-pulse">
                </div>
                <div
                    class="absolute inset-0 bg-[radial-gradient(circle_at_20%_80%,rgba(59,130,246,0.3),transparent_50%)]">
                </div>
                <div
                    class="absolute inset-0 bg-[radial-gradient(circle_at_80%_20%,rgba(96,165,250,0.3),transparent_50%)]">
                </div>
            </div>

            <div class="relative z-10 text-center">
                <div class="mb-8">
                    <h1 class="mb-4 text-4xl font-bold md:text-5xl">Talent Mapping & Assessment</h1>
                    <p class="max-w-md mx-auto text-xl text-blue-100">Temukan potensi tersembunyi Anda dan tingkatkan
                        karier Anda</p>
                </div>

                <div class="mt-12">
                    <div class="max-w-sm p-6 mx-auto bg-white/10 backdrop-blur-sm rounded-2xl">
                        <div
                            class="flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-gradient-to-r from-blue-400 to-blue-600">
                            <i class="text-2xl text-white fas fa-user"></i>
                        </div>
                        <h3 class="mb-2 text-xl font-semibold">Assessment Akurat</h3>
                        <p class="text-blue-100">Metodologi ilmiah dan validasi statistik untuk hasil yang dapat
                            diandalkan</p>
                    </div>
                </div>
            </div>
        </div> <!-- Close the left div here -->

        <!-- Right side with form -->
        <div class="flex items-center justify-center w-full p-6 md:w-1/2">
            <div class="w-full max-w-md">
                <div class="mb-8 text-center">
                    <a href="/" class="inline-block">
                        <div
                            class="flex items-center justify-center w-16 h-16 mx-auto rounded-full bg-gradient-to-r from-blue-500 to-blue-700">
                            <i class="text-2xl text-white fas fa-chart-line"></i>
                        </div>
                        <h2 class="mt-4 text-2xl font-bold text-gray-800">Talent Mapping & Assessment</h2>
                    </a>
                </div>

                <div class="p-8 bg-white border border-gray-100 shadow-xl rounded-2xl">
                    @yield('content')
                </div>

                <div class="mt-6 text-sm text-center text-gray-600">
                    &copy; {{ date('Y') }} Talent Mapping & Assessment. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</body>

</html>

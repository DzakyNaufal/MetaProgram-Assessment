<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Talent Mapping') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js"></script>
    @stack('styles') {{-- Tambah ini untuk @push('styles') di child --}}
</head>

<body class="overflow-x-hidden font-sans antialiased bg-gray-100"> {{-- Tambah overflow-x-hidden --}}
    <div x-data="{ mobileMenuOpen: false }" class="flex h-screen overflow-hidden bg-gray-100">
        <!-- Mobile menu overlay -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-black bg-opacity-50 lg:hidden"
            @click="mobileMenuOpen = false">
        </div>

        <!-- Sidebar Kiri -->
        <div class="fixed inset-y-0 left-0 z-50 flex flex-col w-64 overflow-x-hidden transition-transform duration-300 ease-in-out transform -translate-x-full bg-white shadow-lg lg:relative lg:translate-x-0 lg:inset-y-0"
            :class="{ '-translate-x-0': mobileMenuOpen }">
            <div
                class="flex items-center justify-center h-16 px-4 text-white shadow-lg bg-gradient-to-r from-blue-600 to-indigo-600">
                <h1 class="text-xl font-bold truncate">{{ config('app.name', 'Dashboard') }}</h1>
            </div>
            <nav class="flex-1 px-2 py-4 space-y-2 overflow-x-hidden overflow-y-auto">
                @include('layouts.navigation')
            </nav>
        </div>

        <!-- Konten Utama Kanan -->
        <div class="flex flex-col flex-1 overflow-x-hidden lg:pl-64">
            <!-- Mobile Top Bar with Menu Button -->
            <div class="flex items-center justify-between p-4 bg-white border-b border-gray-200 shadow-sm lg:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="p-2 text-gray-500 rounded-md hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" class="hidden" />
                    </svg>
                </button>
                <h1 class="text-lg font-semibold text-gray-800 truncate">{{ config('app.name', 'Dashboard') }}</h1>
                <div></div> <!-- Spacer for alignment -->
            </div>

            <!-- Page Heading (Desktop & Mobile) -->
            @hasSection('header')
                {{-- Ganti @isset($header) jadi @hasSection --}}
                <header class="bg-white border-b border-gray-200 shadow-sm">
                    <div class="px-4 py-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                        @yield('header') {{-- Ganti {{ $header }} jadi @yield('header') --}}
                    </div>
                </header>
            @endif

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
                <div class="p-4 sm:p-6 lg:p-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts') {{-- Tambah ini untuk @push('scripts') di child --}}
</body>

</html>

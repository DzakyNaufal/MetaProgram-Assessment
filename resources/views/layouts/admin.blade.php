<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ur-BrainDevPro') }} - @yield('title', 'Dashboard')</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js"></script>
    @stack('styles')
</head>

<body class="font-sans antialiased bg-gray-50">
    <div x-data="{ mobileMenuOpen: false }" class="flex h-screen overflow-hidden">

        <!-- SIDEBAR -->
        <aside :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 transition-transform duration-300 ease-in-out bg-white shadow-2xl lg:relative lg:translate-x-0 lg:z-auto">

            <!-- Sidebar Header -->
            <div class="flex items-center justify-between h-20 px-6 border-b border-blue-500 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800">
                <div class="flex items-center gap-3">
                    <div class="flex items-center justify-center w-10 h-10 bg-white/20 rounded-xl backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold leading-tight text-white">Ur-BrainDevPro</h1>
                        <p class="text-xs text-blue-200">Admin Panel</p>
                    </div>
                </div>
                <button @click="mobileMenuOpen = false" class="p-1 text-white rounded-lg lg:hidden hover:bg-white/10">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <!-- Main Menu -->
                <div class="mb-2">
                    <p class="px-3 mb-2 text-xs font-bold tracking-wider text-gray-400 uppercase">Main Menu</p>

                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">
                        <svg class="flex-shrink-0 w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>

                    <a href="{{ route('admin.courses.index') }}"
                        class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.courses.*') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">
                        <svg class="flex-shrink-0 w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Assessment
                    </a>

                    <a href="{{ route('admin.coupons.index') }}"
                        class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.coupons.*') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">
                        <svg class="flex-shrink-0 w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4zm0 0h5M7 17h.01M17 17h.01" />
                        </svg>
                        Coupons
                    </a>

                    <a href="{{ route('admin.meta-programs.index') }}"
                        class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.meta-programs.index') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">
                        <svg class="flex-shrink-0 w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                        Meta Programs Overview
                    </a>

                    <!-- Meta Programs Submenu -->
                    <div class="pl-2">
                        <a href="{{ route('admin.meta-programs.kategori.index') }}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.meta-programs.kategori.*') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
                            <svg class="flex-shrink-0 w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Kategori
                        </a>

                        <a href="{{ route('admin.meta-programs.meta.index') }}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.meta-programs.meta.*') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
                            <svg class="flex-shrink-0 w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                            51 Meta Programs
                        </a>

                        <a href="{{ route('admin.meta-programs.sub.index') }}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.meta-programs.sub.*') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
                            <svg class="flex-shrink-0 w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                            Sub Meta Programs
                        </a>

                        <a href="{{ route('admin.meta-programs.pertanyaan.index') }}"
                            class="flex items-center px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.meta-programs.pertanyaan.index') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'text-gray-600 hover:bg-blue-50 hover:text-blue-700' }}">
                            <svg class="flex-shrink-0 w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.72-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Pertanyaan
                        </a>
                    </div>

                    <a href="{{ route('admin.users.index') }}"
                        class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">
                        <svg class="flex-shrink-0 w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                        Users
                    </a>

                    <a href="{{ route('admin.contacts.index') }}"
                        class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.contacts.*') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">
                        <svg class="flex-shrink-0 w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Contacts
                    </a>
                </div>

                <!-- Payment Section -->
                <div class="pt-4 mt-4 border-t border-gray-100">
                    <p class="px-3 mb-2 text-xs font-bold tracking-wider text-gray-400 uppercase">Payments</p>

                    <a href="{{ route('admin.purchases.index') }}"
                        class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.purchases.*') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">
                        <svg class="flex-shrink-0 w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Purchases
                    </a>

                    <a href="{{ route('admin.bank-accounts.index') }}"
                        class="flex items-center px-3 py-2.5 text-sm font-medium rounded-xl transition-all duration-200 {{ request()->routeIs('admin.bank-accounts.*') ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-md' : 'text-gray-700 hover:bg-blue-50 hover:text-blue-700' }}">
                        <svg class="flex-shrink-0 w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                        Bank Accounts
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Overlay mobile -->
        <div x-show="mobileMenuOpen" x-transition.opacity @click="mobileMenuOpen = false"
            class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm lg:hidden"></div>

        <!-- MAIN CONTENT -->
        <div class="flex flex-col flex-1 min-w-0">
            <!-- Topbar -->
            <header class="flex items-center justify-between h-20 px-6 bg-white border-b border-gray-200 shadow-sm">
                <div class="flex items-center space-x-4">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 text-gray-600 lg:hidden hover:bg-gray-100 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="flex items-center gap-2">
                        <div class="hidden w-2 h-8 rounded-full sm:block bg-gradient-to-b from-blue-600 to-blue-700"></div>
                        <h1 class="text-xl font-bold text-gray-800">
                            @hasSection('header')
                                @yield('header')
                            @else
                                Dashboard
                            @endif
                        </h1>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        <!-- Profile Dropdown -->
                        <div x-data="{ open: false }" class="relative">
                            <!-- Desktop Profile -->
                            <button @click="open = !open" @click.outside="open = false"
                                class="items-center hidden p-2 space-x-3 transition-all md:flex hover:bg-gray-50 rounded-xl">
                                <div class="text-right">
                                    <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                </div>
                                <div class="flex items-center justify-center w-12 h-12 text-lg font-bold text-white shadow-lg bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl ring-2 ring-blue-100">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            </button>

                            <!-- Mobile Profile -->
                            <button @click="open = !open" @click.outside="open = false"
                                class="flex items-center justify-center font-bold text-white transition-all shadow-lg w-11 h-11 bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl md:hidden hover:from-blue-700 hover:to-blue-800">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 z-50 w-48 mt-2 overflow-hidden bg-white border border-gray-100 shadow-2xl rounded-2xl"
                                style="display: none;">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center w-full px-4 py-3 text-sm font-medium text-red-600 transition-all hover:bg-red-50">
                                        <svg class="flex-shrink-0 w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto bg-gradient-to-br from-gray-50 to-blue-50">
                <div class="px-6 py-8 mx-auto max-w-7xl lg:ml-0">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')
</body>

</html>

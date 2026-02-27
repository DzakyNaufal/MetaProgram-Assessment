<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ur-BrainDevPro') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col min-h-screen font-sans antialiased text-gray-800 bg-gray-50">

    <!-- NAVBAR – BIRU SOLID PEKAT (BLUE ACCENT 100% KELIHATAN) -->
    <nav class="sticky top-0 z-50 bg-blue-600 shadow-2xl">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('logo2.svg') }}" alt="Ur-BrainDevPro" class="h-8 w-auto">
                </a>

                <!-- Desktop Menu -->
                <div class="hidden lg:flex lg:items-center lg:space-x-10">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')"
                        class="px-6 py-2.5 text-white font-semibold rounded-full hover:bg-blue-700 transition">
                        Home
                    </x-nav-link>
                    <x-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.*')"
                        class="px-6 py-2.5 text-white font-semibold rounded-full hover:bg-blue-700 transition">
                        Assessment
                    </x-nav-link>
                    @auth
                        <x-nav-link :href="route('user.history')" :active="request()->routeIs('user.history')"
                            class="px-6 py-2.5 text-white font-semibold rounded-full hover:bg-blue-700 transition">
                            History
                        </x-nav-link>
                        <x-nav-link :href="route('purchases.index')" :active="request()->routeIs('purchases.*')"
                            class="px-6 py-2.5 text-white font-semibold rounded-full hover:bg-blue-700 transition">
                            Pembelian
                        </x-nav-link>
                    @endauth
                    <x-nav-link :href="route('contact')" :active="request()->routeIs('contact')"
                        class="px-6 py-2.5 text-white font-semibold rounded-full hover:bg-blue-700 transition">
                        Contact
                    </x-nav-link>
                </div>

                <!-- Auth Buttons -->
                <div class="hidden lg:flex lg:items-center lg:space-x-4">
                    @guest
                        <a href="{{ route('login') }}"
                            class="px-6 py-2.5 text-white/90 font-medium hover:bg-blue-70 rounded-full transition">
                            Log in
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="px-8 py-3 font-bold text-blue-600 transition-all duration-200 transform bg-white rounded-full shadow-lg hover:bg-gray-100 hover:shadow-xl hover:scale-105">
                                Get Started
                            </a>
                        @endif
                    @else
                        <div x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open" x-ref="profileButton"
                                class="flex items-center gap-3 px-5 py-2.5 text-white rounded-full hover:bg-blue-700 transition">
                                <i class="text-lg fas fa-user-circle"></i>
                                <span>{{ Auth::user()->name }}</span>
                            </button>

                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 :style="`position: fixed; top: ${$refs.profileButton.getBoundingClientRect().bottom + 8}px; right: ${window.innerWidth - $refs.profileButton.getBoundingClientRect().right}px;`"
                                 style="z-index: 99999; display: none;"
                                 @click="open = false"
                                 class="w-48 py-1 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Log Out</a>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden">
                    <button @click="open = !open" class="p-3 text-white transition rounded-lg hover:bg-blue-70">
                        <i :class="open ? 'fas fa-times' : 'fas fa-bars'" class="text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu – JUGA BIRU PEKAT -->
        <div :class="{ 'block': open, 'hidden': !open }" class="bg-blue-600 border-t border-blue-500 lg:hidden">
            <div class="px-4 py-6 space-y-3">
                <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')"
                    class="block px-6 py-3 font-semibold text-center text-white rounded-full hover:bg-blue-700">
                    Home
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.*')"
                    class="block px-6 py-3 font-semibold text-center text-white rounded-full hover:bg-blue-700">
                    Assessment
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('contact')" :active="request()->routeIs('contact')"
                    class="block px-6 py-3 font-semibold text-center text-white rounded-full hover:bg-blue-70">
                    Contact
                </x-responsive-nav-link>
                @auth
                    <x-responsive-nav-link :href="route('user.history')" :active="request()->routeIs('user.history')"
                        class="block px-6 py-3 font-semibold text-center text-white rounded-full hover:bg-blue-700">
                        History
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('purchases.index')" :active="request()->routeIs('purchases.*')"
                        class="block px-6 py-3 font-semibold text-center text-white rounded-full hover:bg-blue-700">
                        Pembelian
                    </x-responsive-nav-link>
                @endauth
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="py-12 text-center bg-white border-t">
        <div class="px-4 mx-auto max-w-7xl">
            <div class="mb-3 text-3xl font-bold text-blue-600">Ur-BrainDevPro</div>
            <p class="mb-4 text-sm text-gray-600">
                Unlock human potential with precision and intelligence.
            </p>
            <p class="text-xs text-gray-400">
                © {{ date('Y') }} Ur-BrainDevPro. Made with <i class="mx-1 text-red-500 fas fa-heart"></i> for better
                talent discovery.
            </p>
        </div>
    </footer>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')
</body>

</html>

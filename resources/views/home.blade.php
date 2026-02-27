@extends('layouts.user')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50">
        <!-- Hero Section -->
        <section class="relative overflow-hidden">
            <!-- Background decorations -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-blue-400/20 to-blue-600/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-br from-indigo-400/20 to-indigo-600/20 rounded-full blur-3xl"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 sm:py-32">
                <div class="text-center">
                    <!-- Badge -->
                    <div class="inline-flex items-center px-4 py-2 mb-8 bg-white/80 backdrop-blur-sm rounded-full shadow-lg border border-blue-200">
                        <span class="flex h-2 w-2 mr-2 bg-blue-600 rounded-full animate-pulse"></span>
                        <span class="text-sm font-semibold text-blue-700">Platform Assessment #1 di Indonesia</span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-5xl sm:text-6xl lg:text-7xl font-extrabold text-gray-900 mb-6">
                        <span class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 bg-clip-text text-transparent">
                            Temukan Potensi
                        </span>
                        <br>
                        <span class="text-gray-800">Karier Terbaikmu</span>
                    </h1>

                    <!-- Description -->
                    <p class="max-w-3xl mx-auto text-xl text-gray-600 mb-10 leading-relaxed">
                        Platform Talent Mapping & Assessment terpercaya untuk mengukur potensi,
                        kemampuan, dan mengembangkan karir Anda dengan metode ilmiah teruji.
                    </p>

                    <!-- CTA Buttons -->
                    @guest
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl shadow-xl hover:from-blue-700 hover:to-blue-800 hover:shadow-2xl hover:scale-105 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                            Mulai Sekarang - Gratis
                        </a>
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-gray-700 bg-white border-2 border-gray-200 rounded-2xl hover:bg-gray-50 hover:border-blue-300 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14" />
                            </svg>
                            Masuk
                        </a>
                    </div>
                    @endguest

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-8 max-w-2xl mx-auto mt-16 pt-16 border-t border-gray-200/60">
                        <div>
                            <div class="text-4xl font-extrabold text-blue-600">10K+</div>
                            <div class="text-sm text-gray-500 mt-1">Pengguna Aktif</div>
                        </div>
                        <div>
                            <div class="text-4xl font-extrabold text-blue-600">50+</div>
                            <div class="text-sm text-gray-500 mt-1">Course Premium</div>
                        </div>
                        <div>
                            <div class="text-4xl font-extrabold text-blue-600">98%</div>
                            <div class="text-sm text-gray-500 mt-1">Kepuasan User</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="inline-block px-4 py-2 mb-4 text-sm font-bold text-blue-700 bg-blue-100 rounded-full">
                        FITUR UNGGULAN
                    </span>
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-4">
                        Kenapa Memilih Kami?
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Platform lengkap dengan berbagai fitur untuk mendukung perkembangan karir Anda
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="group p-8 bg-gradient-to-br from-gray-50 to-blue-50 rounded-3xl border-2 border-gray-100 hover:border-blue-300 hover:shadow-xl transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl flex items-center justify-center shadow-lg mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Assessment Akurat</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Metodologi ilmiah dengan validasi statistik untuk hasil yang akurat dan dapat diandalkan.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="group p-8 bg-gradient-to-br from-gray-50 to-indigo-50 rounded-3xl border-2 border-gray-100 hover:border-indigo-300 hover:shadow-xl transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Laporan Detail</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Analisis komprehensif tentang potensi, kekuatan, dan area pengembangan Anda.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="group p-8 bg-gradient-to-br from-gray-50 to-purple-50 rounded-3xl border-2 border-gray-100 hover:border-purple-300 hover:shadow-xl transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl flex items-center justify-center shadow-lg mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6h8M3 21h18" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Panduan Karier</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Rekomendasi personal pengembangan karir berdasarkan hasil assessment Anda.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        @if(isset($testimonials) && count($testimonials) > 0)
        <section class="py-20 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="inline-block px-4 py-2 mb-4 text-sm font-bold text-blue-700 bg-white rounded-full shadow-sm">
                        TESTIMONI
                    </span>
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-4">
                        Apa Kata Mereka?
                    </h2>
                    <p class="text-xl text-gray-600">
                        Cerita sukses dari pengguna Ur-BrainDevPro
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach ($testimonials as $testimonial)
                    <div class="bg-white p-8 rounded-3xl shadow-xl hover:shadow-2xl transition-all duration-300">
                        <div class="flex items-center mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                {{ strtoupper(substr($testimonial['author'], 0, 1)) }}
                            </div>
                            <div class="ml-4">
                                <h4 class="font-bold text-gray-900">{{ $testimonial['author'] }}</h4>
                                <div class="flex text-yellow-400 mt-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539 1.118l1.07 3.292a1 1 0 00.364 1.118L2.98 8.72c-.783.57-.38 1.81.588 1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <p class="text-gray-600 italic leading-relaxed">
                            "{{ $testimonial['quote'] }}"
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- FAQ Section -->
        @if(isset($faqs) && count($faqs) > 0)
        <section class="py-20 bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="inline-block px-4 py-2 mb-4 text-sm font-bold text-blue-700 bg-blue-100 rounded-full">
                        FAQ
                    </span>
                    <h2 class="text-4xl font-extrabold text-gray-900 mb-4">
                        Pertanyaan Umum
                    </h2>
                    <p class="text-xl text-gray-600">
                        Jawaban untuk pertanyaan yang sering diajukan
                    </p>
                </div>

                <div class="space-y-4">
                    @foreach ($faqs as $index => $faq)
                    <div class="faq-card bg-gray-50 rounded-2xl overflow-hidden border-2 border-gray-100 hover:border-blue-200 transition-all duration-300">
                        <button onclick="toggleFaq({{ $index }})"
                            class="w-full px-6 py-5 flex items-center justify-between text-left hover:bg-white transition-all">
                            <span class="text-lg font-bold text-gray-800 pr-4">
                                {{ $faq['question'] }}
                            </span>
                            <svg class="chevron-icon w-6 h-6 text-blue-600 flex-shrink-0 transition-transform duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="faq-content hidden px-6 pb-5">
                            <p class="text-gray-600 leading-relaxed">
                                {{ $faq['answer'] }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- CTA Section -->
        <section class="py-20 bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 relative overflow-hidden">
            <!-- Background decorations -->
            <div class="absolute inset-0">
                <div class="absolute top-0 left-1/4 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            </div>

            <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-4xl sm:text-5xl font-extrabold text-white mb-6">
                    Siap Mengembangkan Kariermu?
                </h2>
                <p class="text-xl text-blue-100 mb-10 max-w-2xl mx-auto">
                    Bergabung dengan ribuan profesional yang telah menemukan potensi karier terbaik mereka bersama Ur-BrainDevPro.
                </p>

                @guest
                <a href="{{ route('register') }}"
                    class="inline-flex items-center justify-center px-10 py-5 text-lg font-bold text-blue-700 bg-white rounded-2xl shadow-2xl hover:bg-blue-50 hover:shadow-3xl hover:scale-105 transition-all duration-200">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Daftar Gratis Sekarang
                </a>
                @endguest
            </div>
        </section>
    </div>

    <script>
        function toggleFaq(index) {
            const card = document.querySelectorAll('.faq-card')[index];
            const content = card.querySelector('.faq-content');
            const icon = card.querySelector('.chevron-icon');

            content.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }
    </script>
@endsection

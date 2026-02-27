@extends('layouts.user')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 via-blue-50 to-indigo-50">
        <!-- Hero Section -->
        <section class="relative overflow-hidden py-16 sm:py-24">
            <!-- Background decorations -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-blue-400/20 to-blue-600/20 rounded-full blur-3xl"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-br from-indigo-400/20 to-indigo-600/20 rounded-full blur-3xl"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="inline-block px-4 py-2 mb-4 text-sm font-bold text-blue-700 bg-white rounded-full shadow-sm">
                        HUBUNGI KAMI
                    </span>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-gray-900 mb-6">
                        <span class="bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 bg-clip-text text-transparent">
                            Ada Pertanyaan?
                        </span>
                    </h1>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Kami siap membantu Anda. Hubungi kami dan kami akan segera merespons.
                    </p>
                </div>

                <!-- Main Content -->
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                    <!-- Contact Form -->
                    <div class="lg:col-span-3">
                        <div class="bg-white rounded-3xl shadow-2xl p-8 sm:p-10">
                            <!-- Success Message -->
                            @if (session('success'))
                                <div class="p-4 mb-6 text-white shadow-lg rounded-xl bg-gradient-to-r from-green-500 to-emerald-600">
                                    <div class="flex items-center">
                                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ session('success') }}
                                    </div>
                                </div>
                            @endif

                            <!-- Contact Form -->
                            <form method="POST" action="{{ route('contact') }}" class="space-y-6">
                                @csrf

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                    <!-- Name -->
                                    <div>
                                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">
                                            <span class="text-blue-600 mr-1">👤</span>
                                            Nama Lengkap <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" id="name" name="name" required
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                            placeholder="John Doe">
                                        @error('name')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">
                                            <span class="text-blue-600 mr-1">📧</span>
                                            Email <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" id="email" name="email" required
                                            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                            placeholder="email@contoh.com">
                                        @error('email')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Subject -->
                                <div>
                                    <label for="subject" class="block text-sm font-bold text-gray-700 mb-2">
                                        <span class="text-blue-600 mr-1">📝</span>
                                        Subjek
                                    </label>
                                    <input type="text" id="subject" name="subject"
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                        placeholder="Judul pesan Anda">
                                    @error('subject')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Message -->
                                <div>
                                    <label for="message" class="block text-sm font-bold text-gray-700 mb-2">
                                        <span class="text-blue-600 mr-1">💬</span>
                                        Pesan <span class="text-red-500">*</span>
                                    </label>
                                    <textarea id="message" name="message" rows="6" required
                                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all resize-none"
                                        placeholder="Tulis pesan Anda di sini..."></textarea>
                                    @error('message')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="pt-4">
                                    <button type="submit"
                                        class="flex items-center justify-center w-full px-8 py-4 text-base font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl shadow-lg hover:from-blue-700 hover:to-blue-800 hover:shadow-xl hover:scale-105 transition-all">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                        Kirim Pesan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Contact Info Sidebar -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Info Card 1: Phone -->
                        <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 border-2 border-transparent hover:border-blue-200">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="ml-5 flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Telepon</h3>
                                    <p class="text-gray-600">+62 812 3456 7890</p>
                                    <p class="text-sm text-gray-400 mt-1">Senin - Jumat, 9:00 - 17:00</p>
                                </div>
                            </div>
                        </div>

                        <!-- Info Card 2: Email -->
                        <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 border-2 border-transparent hover:border-blue-200">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-indigo-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 02.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="ml-5 flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Email</h3>
                                    <p class="text-gray-600">info@talentsmapping.id</p>
                                    <p class="text-sm text-gray-400 mt-1">Respon dalam 24 jam</p>
                                </div>
                            </div>
                        </div>

                        <!-- Info Card 3: Office -->
                        <div class="bg-white rounded-3xl shadow-xl p-8 hover:shadow-2xl transition-all duration-300 border-2 border-transparent hover:border-blue-200">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-purple-600 to-purple-700 rounded-2xl flex items-center justify-center shadow-lg">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 1-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-5 flex-1">
                                    <h3 class="text-lg font-bold text-gray-900 mb-1">Kantor</h3>
                                    <p class="text-gray-600">Jakarta, Indonesia</p>
                                    <p class="text-sm text-gray-400 mt-1">Kunjungi kantor kami</p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media Card -->
                        <div class="bg-gradient-to-br from-blue-600 to-blue-700 rounded-3xl shadow-xl p-8 text-white">
                            <h3 class="text-lg font-bold mb-4">Ikuti Kami</h3>
                            <p class="text-blue-100 text-sm mb-6">Dapatkan update terbaru melalui sosial media</p>
                            <div class="flex space-x-4">
                                <!-- Facebook -->
                                <a href="#" class="w-12 h-12 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center hover:bg-white/30 transition-all">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5.43c0-2.287-1.528-3.77-3.555-3.77v-3h3v-4h-3c-4.194 0-7 3.125-7 8v4h-3v12h5v-12z"/>
                                    </svg>
                                </a>
                                <!-- Instagram -->
                                <a href="#" class="w-12 h-12 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center hover:bg-white/30 transition-all">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 3.37 3.37z"/>
                                        <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
                                    </svg>
                                </a>
                                <!-- WhatsApp -->
                                <a href="#" class="w-12 h-12 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center hover:bg-white/30 transition-all">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.877 11.893-11.877 6.555 0 11.893 5.324 11.877 11.893zm6.557-8.157c-2.852 0-5.166-2.32-5.166-5.174 0-.898.239-1.432.619-1.432 1.244 0 .729.518 1.325 1.156 1.432.518-.058 2.351-1.413 2.351-1.413.657 0 1.156.518 1.156 1.413 0 2.351-1.413 2.351-1.413.619 0 1.156-.518 1.156-1.432 0-.725-.619-1.325-1.432-1.644-1.696-1.696-2.872-2.314-1.156-2.314-.631 0-1.156.518-1.156 1.413 0 2.852 2.32 5.166 2.32 2.853 0 5.166-2.32 5.166-5.174 0-.898-.239-1.432-.619-1.432-1.244 0-.729-.518-1.325-1.156-1.432-.518.058-2.351 1.413-2.351 1.413-.657 0-1.156-.518-1.156-1.413 0-2.351 1.413-2.351 1.413-.619 0-1.156-.518-1.156-1.432 0-.725.619-1.325 1.432-1.644 1.696-1.696 2.872-2.314 1.156-2.314.631 0 1.156.518 1.156 1.413 0 2.351-1.413 2.351-1.413.619 0 1.156-.518 1.156-1.432 0-.729.518-1.325 1.156-1.432z"/>
                                    </svg>
                                </a>
                                <!-- LinkedIn -->
                                <a href="#" class="w-12 h-12 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center hover:bg-white/30 transition-all">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.754 0 1.75.79 1.75 1.764-.784 1.764-1.75 1.764zm14.5 12.268h-3v-5.604c0-3.368-4-3.113-4-3.113v-2.23h3v-2.61c0-.532.357-.688-2.541-3-2.541-2.486 0-3 2.313-3 4.321v2.472h-2.5v11h3v-5.604z"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

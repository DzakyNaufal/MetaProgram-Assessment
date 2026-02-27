@extends('layouts.admin')

@section('header', 'Dashboard')

@section('content')
    <div class="p-6">
        <div class="overflow-hidden bg-white shadow-xl sm:rounded-3xl">
            <div class="p-8 text-gray-900">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="mb-2 text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-blue-800">
                        Dashboard Admin
                    </h1>
                    <p class="text-gray-600">Selamat datang di panel admin Ur-BrainDevPro</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-7">
                    <!-- Courses Card -->
                    <div class="p-6 transition-all duration-300 border border-blue-200 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl hover:shadow-lg hover:scale-105">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center shadow-lg w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl">
                                <svg class="text-white w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="mb-1 text-sm font-semibold text-blue-700">Total Assessment</h3>
                        <p class="text-3xl font-bold text-blue-900">{{ \App\Models\Course::count() }}</p>
                        <a href="{{ route('admin.courses.index') }}" class="inline-flex items-center mt-3 text-sm font-medium text-blue-600 hover:text-blue-800">
                            Kelola
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Questions Card -->
                    <div class="p-6 transition-all duration-300 border border-purple-200 bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl hover:shadow-lg hover:scale-105">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center shadow-lg w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl">
                                <svg class="text-white w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.72-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="mb-1 text-sm font-semibold text-purple-700">Total Pertanyaan</h3>
                        <p class="text-3xl font-bold text-purple-900">{{ \App\Models\PertanyaanMetaProgram::count() }}</p>
                        <a href="{{ route('admin.meta-programs.pertanyaan.index') }}" class="inline-flex items-center mt-3 text-sm font-medium text-purple-600 hover:text-purple-800">
                            Kelola
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Users Card -->
                    <div class="p-6 transition-all duration-300 border border-green-200 bg-gradient-to-br from-green-50 to-green-100 rounded-2xl hover:shadow-lg hover:scale-105">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center shadow-lg w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl">
                                <svg class="text-white w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="mb-1 text-sm font-semibold text-green-700">Total Users</h3>
                        <p class="text-3xl font-bold text-green-900">{{ \App\Models\User::count() }}</p>
                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center mt-3 text-sm font-medium text-green-600 hover:text-green-800">
                            Kelola
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Purchases Card -->
                    <div class="p-6 transition-all duration-300 border bg-gradient-to-br from-amber-50 to-amber-100 rounded-2xl border-amber-200 hover:shadow-lg hover:scale-105">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center shadow-lg w-14 h-14 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl">
                                <svg class="text-white w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="mb-1 text-sm font-semibold text-amber-700">Total Purchases</h3>
                        <p class="text-3xl font-bold text-amber-900">{{ \App\Models\Purchase::count() }}</p>
                        <a href="{{ route('admin.purchases.index') }}" class="inline-flex items-center mt-3 text-sm font-medium text-amber-600 hover:text-amber-800">
                            Kelola
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Coupons Card -->
                    <div class="p-6 transition-all duration-300 border border-indigo-200 bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-2xl hover:shadow-lg hover:scale-105">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center shadow-lg w-14 h-14 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl">
                                <svg class="text-white w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="mb-1 text-sm font-semibold text-indigo-700">Total Coupons</h3>
                        <p class="text-3xl font-bold text-indigo-900">{{ \App\Models\Coupon::count() }}</p>
                        <a href="{{ route('admin.coupons.index') }}" class="inline-flex items-center mt-3 text-sm font-medium text-indigo-600 hover:text-indigo-800">
                            Kelola
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Bank Accounts Card -->
                    <div class="p-6 transition-all duration-300 border bg-gradient-to-br from-rose-50 to-rose-100 rounded-2xl border-rose-200 hover:shadow-lg hover:scale-105">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center shadow-lg w-14 h-14 bg-gradient-to-br from-rose-500 to-rose-600 rounded-xl">
                                <svg class="text-white w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="mb-1 text-sm font-semibold text-rose-700">Total Rekening</h3>
                        <p class="text-3xl font-bold text-rose-900">{{ \App\Models\BankAccount::count() }}</p>
                        <a href="{{ route('admin.bank-accounts.index') }}" class="inline-flex items-center mt-3 text-sm font-medium text-rose-600 hover:text-rose-800">
                            Kelola
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>

                    <!-- Contacts/Messages Card -->
                    <div class="p-6 transition-all duration-300 border bg-gradient-to-br from-cyan-50 to-cyan-100 rounded-2xl border-cyan-200 hover:shadow-lg hover:scale-105">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center shadow-lg w-14 h-14 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl">
                                <svg class="text-white w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="mb-1 text-sm font-semibold text-cyan-700">Total Pesan</h3>
                        <p class="text-3xl font-bold text-cyan-900">{{ \App\Models\ContactMessage::count() }}</p>
                        <a href="{{ route('admin.contacts.index') }}" class="inline-flex items-center mt-3 text-sm font-medium text-cyan-600 hover:text-cyan-800">
                            Kelola
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="p-6 shadow-xl bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl">
                    <h2 class="mb-4 text-xl font-bold text-white">Aksi Cepat</h2>
                    <div class="grid grid-cols-2 gap-4 md:grid-cols-4 lg:grid-cols-6">
                        <a href="{{ route('admin.courses.create') }}" class="flex flex-col items-center p-4 transition-all bg-white/10 backdrop-blur rounded-xl hover:bg-white/20">
                            <svg class="w-8 h-8 mb-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="text-sm font-medium text-center text-white">Tambah Assessment</span>
                        </a>
                        <a href="{{ route('admin.courses.index') }}" class="flex flex-col items-center p-4 transition-all bg-white/10 backdrop-blur rounded-xl hover:bg-white/20">
                            <svg class="w-8 h-8 mb-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm font-medium text-center text-white">Kelola Assessment</span>
                        </a>
                        <a href="{{ route('admin.users.create') }}" class="flex flex-col items-center p-4 transition-all bg-white/10 backdrop-blur rounded-xl hover:bg-white/20">
                            <svg class="w-8 h-8 mb-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                            <span class="text-sm font-medium text-center text-white">Tambah User</span>
                        </a>
                        <a href="{{ route('admin.purchases.index') }}" class="flex flex-col items-center p-4 transition-all bg-white/10 backdrop-blur rounded-xl hover:bg-white/20">
                            <svg class="w-8 h-8 mb-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <span class="text-sm font-medium text-center text-white">Purchases</span>
                        </a>
                        <a href="{{ route('admin.bank-accounts.index') }}" class="flex flex-col items-center p-4 transition-all bg-white/10 backdrop-blur rounded-xl hover:bg-white/20">
                            <svg class="w-8 h-8 mb-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            <span class="text-sm font-medium text-center text-white">Rekening</span>
                        </a>
                        <a href="{{ route('admin.coupons.index') }}" class="flex flex-col items-center p-4 transition-all bg-white/10 backdrop-blur rounded-xl hover:bg-white/20">
                            <svg class="w-8 h-8 mb-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <span class="text-sm font-medium text-center text-white">Kelola Coupons</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

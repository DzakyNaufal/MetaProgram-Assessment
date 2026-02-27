@extends('layouts.admin')

@section('header', 'Meta Programs')

@section('content')
    <div class="p-6">
        <div class="overflow-hidden bg-white shadow-xl sm:rounded-3xl">
            <div class="p-8 text-gray-900">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-blue-800 mb-2">
                        Manajemen Meta Programs
                    </h1>
                    <p class="text-gray-600">Kelola Kategori, Meta Program, Sub Meta Program, dan Pertanyaan</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 gap-6 mb-8 md:grid-cols-2 lg:grid-cols-4">
                    <div class="p-6 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl border border-blue-200 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-blue-700 mb-1">Kategori</h3>
                        <p class="text-3xl font-bold text-blue-900">{{ $stats['total_kategori'] }}</p>
                    </div>

                    <div class="p-6 bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl border border-purple-200 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-purple-700 mb-1">Meta Programs</h3>
                        <p class="text-3xl font-bold text-purple-900">{{ $stats['total_meta_programs'] }}</p>
                    </div>

                    <div class="p-6 bg-gradient-to-br from-green-50 to-green-100 rounded-2xl border border-green-200 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-green-700 mb-1">Sub Meta Programs</h3>
                        <p class="text-3xl font-bold text-green-900">{{ $stats['total_sub_meta_programs'] }}</p>
                    </div>

                    <div class="p-6 bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl border border-orange-200 hover:shadow-lg transition-all duration-300">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.72-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-orange-700 mb-1">Pertanyaan</h3>
                        <p class="text-3xl font-bold text-orange-900">{{ $stats['total_pertanyaan'] }}</p>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="p-6 bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl shadow-xl mb-8">
                    <h2 class="mb-4 text-xl font-bold text-white">Aksi Cepat</h2>
                    <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                        <a href="{{ route('admin.meta-programs.create-kategori') }}" class="flex flex-col items-center p-4 bg-white/10 backdrop-blur rounded-xl hover:bg-white/20 transition-all">
                            <svg class="w-8 h-8 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="text-sm font-medium text-white text-center">Tambah Kategori</span>
                        </a>
                        <a href="{{ route('admin.meta-programs.create-meta') }}" class="flex flex-col items-center p-4 bg-white/10 backdrop-blur rounded-xl hover:bg-white/20 transition-all">
                            <svg class="w-8 h-8 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <span class="text-sm font-medium text-white text-center">Tambah MP</span>
                        </a>
                        <a href="{{ route('admin.meta-programs.create-sub') }}" class="flex flex-col items-center p-4 bg-white/10 backdrop-blur rounded-xl hover:bg-white/20 transition-all">
                            <svg class="w-8 h-8 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                            <span class="text-sm font-medium text-white text-center">Tambah Sub MP</span>
                        </a>
                        <a href="{{ route('admin.meta-programs.create-pertanyaan') }}" class="flex flex-col items-center p-4 bg-white/10 backdrop-blur rounded-xl hover:bg-white/20 transition-all">
                            <svg class="w-8 h-8 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.72-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm font-medium text-white text-center">Tambah Pertanyaan</span>
                        </a>
                    </div>
                </div>

                <!-- Meta Programs List by Category -->
                <div class="space-y-6">
                    @foreach($kategoriMetaPrograms as $kategori)
                        <div class="p-6 bg-gray-50 rounded-2xl border border-gray-200">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                                </svg>
                                {{ $kategori->name }}
                            </h3>

                            <div class="space-y-3">
                                @foreach($kategori->metaPrograms as $metaProgram)
                                    <div class="p-4 bg-white rounded-xl border border-gray-200 hover:shadow-md transition-shadow">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <h4 class="font-semibold text-gray-900">{{ $metaProgram->name }}</h4>
                                                <div class="flex items-center gap-4 mt-1 text-sm text-gray-600">
                                                    <span>{{ $metaProgram->subMetaPrograms->count() }} Sub MP</span>
                                                    <span>{{ $metaProgram->pertanyaan->count() }} Pertanyaan</span>
                                                    @if($metaProgram->scoring_type === 'inverse')
                                                        <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-xs">Inverse</span>
                                                    @else
                                                        <span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs">Multi</span>
                                                    @endif
                                                </div>
                                                @if($metaProgram->subMetaPrograms->isNotEmpty())
                                                    <div class="mt-2 flex flex-wrap gap-1">
                                                        @foreach($metaProgram->subMetaPrograms->take(5) as $sub)
                                                            <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs">{{ $sub->name }}</span>
                                                        @endforeach
                                                        @if($metaProgram->subMetaPrograms->count() > 5)
                                                            <span class="px-2 py-1 text-gray-500 text-xs">+{{ $metaProgram->subMetaPrograms->count() - 5 }} lagi</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-2 ml-4">
                                                <a href="{{ route('admin.meta-programs.pertanyaan', $metaProgram) }}" class="p-2 text-orange-600 hover:bg-orange-50 rounded-lg transition-colors" title="Kelola Pertanyaan">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.72-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('admin.meta-programs.edit', $metaProgram) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </a>
                                                <form action="{{ route('admin.meta-programs.destroy', $metaProgram) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus Meta Program ini? Semua Sub MP dan Pertanyaan terkait akan dihapus.')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

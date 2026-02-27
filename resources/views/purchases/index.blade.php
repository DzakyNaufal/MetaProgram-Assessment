@extends('layouts.user')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-6xl">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-4 py-2 text-blue-700 bg-white rounded-xl shadow-md hover:shadow-lg hover:bg-blue-50 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Home
                </a>
            </div>

            <!-- Header -->
            <div class="mb-8 text-center">
                <h1 class="text-3xl sm:text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-blue-800 mb-2">
                    Riwayat Pembelian
                </h1>
                <p class="text-gray-600">Pantau status pembelian course Anda</p>
            </div>

            <!-- Success Message -->
            @if(session('success'))
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

            <!-- Error Message -->
            @if(session('error'))
                <div class="p-4 mb-6 text-white shadow-lg rounded-xl bg-gradient-to-r from-red-500 to-rose-600">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if($purchases->count() > 0)
                <!-- Purchases Table -->
                <div class="overflow-hidden bg-white rounded-2xl shadow-lg">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-blue-50 to-blue-100">
                                <tr>
                                    <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-blue-800 uppercase">
                                        Course
                                    </th>
                                    <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-blue-800 uppercase">
                                        Jumlah
                                    </th>
                                    <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-blue-800 uppercase">
                                        Status
                                    </th>
                                    <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-blue-800 uppercase">
                                        Tanggal
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($purchases as $purchase)
                                    <tr class="transition-colors duration-200 hover:bg-blue-50/30">
                                        <td class="px-6 py-4">
                                            @if($purchase->course)
                                                <div class="flex items-center">
                                                    @if($purchase->course->thumbnail_url)
                                                        <img src="{{ $purchase->course->thumbnail_url }}" alt=""
                                                            class="w-16 h-12 rounded-lg object-cover mr-4 border border-blue-100">
                                                    @else
                                                        <div class="w-16 h-12 rounded-lg bg-blue-50 flex items-center justify-center mr-4">
                                                            <svg class="w-8 h-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <div class="text-sm font-semibold text-gray-900">{{ $purchase->course->title }}</div>
                                                        <div class="text-xs text-gray-500">#{{ $purchase->id }}</div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="text-red-600 italic">Course telah dihapus</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm font-bold text-blue-700">
                                                Rp {{ number_format($purchase->amount, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($purchase->status == 'confirmed')
                                                <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-green-100 text-green-800">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Dikonfirmasi
                                                </span>
                                            @elseif($purchase->status == 'pending')
                                                @if($purchase->expired_at && $purchase->expired_at->isPast())
                                                    <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-gray-100 text-gray-600">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                        </svg>
                                                        Kadaluarsa
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800">
                                                        <svg class="w-4 h-4 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                        </svg>
                                                        Menunggu
                                                    </span>
                                                @endif
                                            @elseif($purchase->status == 'rejected')
                                                <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-red-100 text-red-800">
                                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Ditolak
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $purchase->created_at->format('d M Y') }}
                                            <div class="text-xs">{{ $purchase->created_at->format('H:i') }} WIB</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Back to Courses -->
                <div class="mt-8 text-center">
                    <a href="{{ route('courses.index') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Beli Course Lain
                    </a>
                </div>
            @else
                <!-- Empty State -->
                <div class="p-12 text-center bg-white rounded-3xl shadow-xl">
                    <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-2xl font-bold text-gray-900">Belum Ada Pembelian</h3>
                    <p class="mb-8 text-gray-500">Anda belum membeli course apapun. Mulai dengan memilih course yang sesuai kebutuhan Anda.</p>
                    <a href="{{ route('courses.index') }}"
                       class="inline-flex items-center px-8 py-4 font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow-lg hover:shadow-xl hover:scale-105 transition-all">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                        </svg>
                        Lihat Semua Course
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

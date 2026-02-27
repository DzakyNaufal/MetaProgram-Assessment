@extends('layouts.user')

@section('content')
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-8 text-3xl font-bold">Dashboard Asesmen Bakat</h1>

                    <!-- Active Purchases -->
                    @php
                        $activePurchases = auth()->user()->activePurchases()->with('course')->get();
                    @endphp
                    @if ($activePurchases->count() > 0)
                        <div class="mb-8 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <h2 class="text-lg font-semibold text-green-800 mb-2">Course Aktif</h2>
                            @foreach ($activePurchases as $purchase)
                                @if ($purchase->course)
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="font-medium text-green-700">{{ $purchase->course->title }}</span>
                                        @if ($purchase->expired_at)
                                            <span class="text-sm text-green-600 ml-2">
                                                (Berlaku sampai {{ $purchase->expired_at->format('d M Y') }})
                                            </span>
                                        @else
                                            <span class="text-sm text-green-600 ml-2">(Lifetime)</span>
                                        @endif
                                    </div>
                                    @if ($purchase->course->has_whatsapp_consultation)
                                        <a href="https://wa.me/6281234567890?text=Halo,%20saya%20sudah%20membeli%20{{ urlencode($purchase->course->title) }}.%20Boleh%20konsultasi?"
                                            target="_blank"
                                            class="px-3 py-1 text-sm font-semibold text-white bg-green-500 rounded-lg hover:bg-green-600">
                                            <svg class="inline-block w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                            </svg>
                                            Konsultasi WhatsApp
                                        </a>
                                    @endif
                                </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <h2 class="text-lg font-semibold text-blue-800 mb-2">Course Premium</h2>
                            <p class="text-blue-700 mb-2">Anda belum memiliki course premium. Upgrade untuk akses course lengkap dan konsultasi!</p>
                            <a href="{{ route('pricing') }}" class="inline-block px-4 py-2 font-semibold text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                                Lihat Course
                            </a>
                        </div>
                    @endif

                    <div class="mb-8">
                        <h2 class="mb-4 text-xl font-semibold">Riwayat Asesmen</h2>

                        @if ($quizAttempts->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                Course</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                Kategori</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                Tipe Dominan</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                Tanggal</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                                Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($quizAttempts as $attempt)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $attempt->course?->title ?? '-' }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="text-sm text-gray-500">
                                                        {{ $attempt->course?->category?->name ?? '-' }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @switch($attempt->dominant_type)
                                                    @case('RES')
                                                        bg-blue-10 text-blue-800
                                                        @break
                                                    @case('CON')
                                                        bg-red-100 text-red-800
                                                        @break
                                                    @case('EXP')
                                                        bg-green-100 text-green-800
                                                        @break
                                                    @case('ANA')
                                                        bg-yellow-100 text-yellow-800
                                                        @break
                                                @endswitch">
                                                        {{ $attempt->dominant_type }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                    {{ $attempt->completed_at->format('d M Y H:i') }}
                                                </td>
                                                <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                                    <a href="{{ route('courses.result', $attempt->id) }}"
                                                        class="text-indigo-60 hover:text-indigo-900">Lihat Hasil</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-gray-600">Anda belum menyelesaikan asesmen apapun.</p>
                        @endif
                    </div>

                    <div>
                        <h2 class="mb-4 text-xl font-semibold">Mulai Asesmen Baru</h2>
                        <a href="{{ route('courses.index') }}"
                            class="px-6 py-3 font-bold text-white transition-colors duration-300 bg-blue-600 rounded-lg hover:bg-blue-700">
                            Lihat Course
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

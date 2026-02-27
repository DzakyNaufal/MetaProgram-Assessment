@extends('layouts.user')

@section('content')
    <div class="min-h-screen px-4 py-8 bg-gradient-to-br from-slate-50 via-blue-50 to-blue-100 sm:px-6 lg:px-8">
        <div class="container mx-auto max-w-7xl">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('home') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-blue-700 transition-all duration-300 bg-white shadow-md rounded-xl hover:shadow-lg hover:bg-blue-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Home
                </a>
            </div>

            <!-- Enhanced Header -->
            <div class="mb-12 text-center">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 mb-4 shadow-xl rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
                <h1
                    class="mb-3 text-4xl font-extrabold text-transparent sm:text-5xl bg-clip-text bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800">
                    Pilih Course Premium
                </h1>
                <p class="max-w-2xl mx-auto text-lg text-gray-600">
                    Investasikan karier Anda dengan course berkualitas tinggi. Dapatkan akses lengkap dan sertifikat resmi.
                </p>
            </div>

            @if ($courses->count() > 0)
                <!-- Stats Banner -->
                <div class="p-6 mb-10 shadow-2xl bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 rounded-3xl">
                    <div class="grid grid-cols-1 gap-6 text-center text-white sm:grid-cols-3">
                        <div class="transition-transform transform hover:scale-105">
                            <div class="mb-1 text-3xl font-bold sm:text-4xl">{{ $courses->count() }}+</div>
                            <div class="text-sm text-blue-100">Course Tersedia</div>
                        </div>
                        <div class="transition-transform transform hover:scale-105">
                            <div class="mb-1 text-3xl font-bold sm:text-4xl">24/7</div>
                            <div class="text-sm text-blue-100">Akses Seumur Hidup</div>
                        </div>
                        <div class="transition-transform transform hover:scale-105">
                            <div class="mb-1 text-3xl font-bold sm:text-4xl">∞</div>
                            <div class="text-sm text-blue-100">Sertifikat Resmi</div>
                        </div>
                    </div>
                </div>

                <!-- Course Cards Grid -->
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    @foreach ($courses as $course)
                        @if (!$course->isFree())
                            <div
                                class="overflow-hidden transition-all duration-500 bg-white border border-blue-100 shadow-xl group rounded-3xl hover:border-blue-400 hover:shadow-2xl hover:-translate-y-2">
                                <!-- Course Image/Thumbnail -->
                                <div class="relative h-56 overflow-hidden">
                                    @if ($course->thumbnail)
                                        <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}"
                                            class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-110">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent">
                                        </div>
                                    @else
                                        <div
                                            class="flex items-center justify-center w-full h-full bg-gradient-to-br from-blue-400 via-blue-500 to-blue-700">
                                            <svg class="w-20 h-20 text-white/80" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif

                                    <!-- Premium Badge -->
                                    <div class="absolute top-4 right-4">
                                        <span
                                            class="flex items-center gap-1 px-4 py-2 text-xs font-bold text-white rounded-full shadow-lg bg-gradient-to-r from-yellow-400 to-orange-500">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                                </path>
                                            </svg>
                                            PREMIUM
                                        </span>
                                    </div>

                                    <!-- Duration Badge -->
                                </div>

                                <!-- Course Content -->
                                <div class="p-6">
                                    <!-- Categories -->
                                    @if ($course->categories && $course->categories->count() > 0)
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            @foreach ($course->categories->take(2) as $category)
                                                <span
                                                    class="px-2.5 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-lg">
                                                    {{ $category->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif

                                    <!-- Title -->
                                    <h2
                                        class="mb-3 text-xl font-bold text-gray-900 transition-colors line-clamp-2 group-hover:text-blue-700">
                                        {{ $course->title }}
                                    </h2>

                                    <!-- Description -->
                                    @if ($course->description)
                                        <p class="mb-4 text-sm text-gray-600 line-clamp-2">
                                            {{ $course->description }}
                                        </p>
                                    @endif

                                    <!-- Features -->
                                    <div class="mb-5 space-y-2">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="flex-shrink-0 w-4 h-4 mr-2 text-green-500" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>Akses seumur hidup</span>
                                        </div>
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="flex-shrink-0 w-4 h-4 mr-2 text-green-500" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>Sertifikat resmi</span>
                                        </div>
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="flex-shrink-0 w-4 h-4 mr-2 text-green-500" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            <span>Materi lengkap & terupdate</span>
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <div class="flex items-baseline gap-2 mb-5">
                                        <span
                                            class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-blue-800">
                                            Rp {{ number_format($course->price, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <!-- Ringkasan Pembayaran & Promo -->
                                    <div class="p-4 mb-4 bg-gradient-to-br from-slate-50 to-blue-50 border-2 border-blue-200 rounded-xl">
                                        <div class="flex items-center gap-2 mb-3 pb-2 border-b border-blue-200">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                            <span class="font-bold text-blue-800">Ringkasan Pembayaran</span>
                                        </div>

                                        <!-- Price Row -->
                                        <div class="flex items-center justify-between mb-3 pb-3 border-b border-dashed border-gray-300">
                                            <span class="text-sm text-gray-600">Harga Course</span>
                                            <span class="text-lg font-bold text-gray-900">Rp {{ number_format($course->price, 0, ',', '.') }}</span>
                                        </div>

                                        <!-- Available Coupons -->
                                        @if (isset($activeCoupons) && $activeCoupons->count() > 0)
                                            @php
                                                $applicableCoupons = $activeCoupons->filter(function($coupon) use ($course) {
                                                    // Check min order amount
                                                    if ($coupon->min_order_amount && $course->price < $coupon->min_order_amount) {
                                                        return false;
                                                    }
                                                    // Check course type
                                                    if (!$coupon->isApplicableForCourseType($course->type)) {
                                                        return false;
                                                    }
                                                    return true;
                                                });
                                            @endphp
                                            @if ($applicableCoupons->count() > 0)
                                                <div class="mb-3">
                                                    <div class="text-xs font-semibold text-gray-700 mb-2">Kode Promo Tersedia:</div>
                                                    <div class="space-y-2">
                                                        @foreach ($applicableCoupons as $coupon)
                                                            <div class="flex items-center justify-between p-2 bg-white border-2 border-orange-300 rounded-lg">
                                                                <div class="flex items-center gap-2">
                                                                    <div class="p-1.5 bg-orange-100 rounded">
                                                                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                                        </svg>
                                                                    </div>
                                                                    <div>
                                                                        <div class="text-sm font-bold text-orange-700">
                                                                            @if ($coupon->type === 'percentage')
                                                                                {{ number_format($coupon->value, 0) }}% OFF
                                                                            @else
                                                                                Rp {{ number_format($coupon->value, 0, ',', '.') }} OFF
                                                                            @endif
                                                                        </div>
                                                                        <div class="text-xs text-gray-500 font-mono">{{ $coupon->code }}</div>
                                                                    </div>
                                                                </div>
                                                                <button type="button" onclick="claimCoupon('{{ $coupon->code }}', {{ $course->id }}, {{ $course->price }}, this)" class="claim-btn px-3 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg hover:from-orange-600 hover:to-orange-700 transition-all">
                                                                    Claim
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        @endif

                                        <!-- Manual Coupon Input -->
                                        <div class="mb-3">
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Atau masukkan kode lain:</label>
                                            <div class="flex gap-2">
                                                <input type="text" id="coupon_input_{{ $course->id }}" placeholder="Masukkan kode promo" class="flex-1 px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                <button type="button" onclick="validateCouponById({{ $course->id }}, {{ $course->price }})" class="px-3 py-2 text-sm text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                                                    Terapkan
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Applied Coupon Display -->
                                        <div id="applied_coupon_{{ $course->id }}" class="hidden mb-3 p-2 bg-green-50 border border-green-300 rounded-lg">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center gap-2">
                                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                    <span class="text-sm font-medium text-green-800">Kode diterapkan!</span>
                                                </div>
                                                <span id="applied_discount_{{ $course->id }}" class="text-sm font-bold text-green-700"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Purchase Button -->
                                    <form method="POST" action="{{ route('purchases.store') }}">
                                        @csrf
                                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                                        <input type="hidden" name="coupon_code" id="final_coupon_code_{{ $course->id }}" value="">
                                        <button type="submit"
                                            class="relative w-full px-6 py-4 overflow-hidden font-bold text-white transition-all duration-300 group bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 rounded-xl hover:from-blue-700 hover:via-blue-800 hover:to-blue-900 hover:shadow-xl">
                                            <span
                                                class="absolute inset-0 w-full h-full -translate-x-full bg-gradient-to-r from-transparent via-white/20 to-transparent group-hover:animate-shimmer"></span>
                                            <span class="relative flex items-center justify-center gap-2">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                                    </path>
                                                </svg>
                                                Beli Sekarang
                                            </span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            @else
                <!-- Enhanced Empty State -->
                <div class="py-20 text-center bg-white border-2 border-blue-100 shadow-2xl rounded-3xl">
                    <div
                        class="inline-flex items-center justify-center mb-6 rounded-full shadow-lg w-28 h-28 bg-gradient-to-br from-blue-100 to-blue-200">
                        <svg class="text-blue-600 w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="mb-2 text-2xl font-bold text-gray-900">Tidak Ada Course Berbayar</h3>
                    <p class="max-w-md mx-auto mb-8 text-gray-500">Semua course saat ini tersedia secara gratis. Cek course
                        lainnya untuk menemukan yang sesuai dengan kebutuhan Anda.</p>
                    <a href="{{ route('courses.index') }}"
                        class="inline-flex items-center gap-2 px-8 py-4 font-bold text-white transition-all duration-300 shadow-lg bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 hover:shadow-xl hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        Lihat Semua Course
                    </a>
                </div>
            @endif

            <!-- CTA Section -->
            <div class="p-8 mt-16 text-center bg-white border border-blue-100 shadow-xl rounded-3xl">
                <h3 class="mb-3 text-2xl font-bold text-gray-900">Butuh Bantuan Memilih?</h3>
                <p class="mb-6 text-gray-600">Hubungi tim kami untuk rekomendasi course yang sesuai dengan kebutuhan karier
                    Anda.</p>
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center gap-2 px-8 py-4 font-bold text-blue-600 transition-all duration-300 bg-white border-2 border-blue-600 shadow-lg rounded-xl hover:bg-blue-60 hover:text-white hover:shadow-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                        </path>
                    </svg>
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>

    <script>
        // Claim coupon directly from the list
        async function claimCoupon(code, courseId, originalPrice, button) {
            const originalText = button.textContent;
            button.textContent = 'Memproses...';
            button.disabled = true;

            try {
                const response = await fetch(`/api/coupons/validate/${encodeURIComponent(code)}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({
                        course_id: courseId,
                        original_amount: originalPrice
                    })
                });

                const data = await response.json();

                if (data.valid) {
                    // Set the hidden coupon input
                    const finalCouponInput = document.getElementById('final_coupon_code_' + courseId);
                    if (finalCouponInput) {
                        finalCouponInput.value = code;
                    }

                    // Show applied coupon display
                    const appliedDiv = document.getElementById('applied_coupon_' + courseId);
                    const discountSpan = document.getElementById('applied_discount_' + courseId);
                    if (appliedDiv && discountSpan) {
                        appliedDiv.classList.remove('hidden');
                        discountSpan.textContent = `- Rp ${data.discount_amount.toLocaleString('id-ID')}`;
                    }

                    // Clear the manual input
                    const manualInput = document.getElementById('coupon_input_' + courseId);
                    if (manualInput) {
                        manualInput.value = '';
                    }

                    // Update button to show it's applied
                    button.textContent = 'Diterapkan';
                    button.classList.remove('from-orange-500', 'to-orange-600', 'hover:from-orange-600', 'hover:to-orange-700');
                    button.classList.add('bg-green-500', 'hover:bg-green-600');

                    // Reset other claim buttons
                    const allClaimButtons = document.querySelectorAll('.claim-btn');
                    allClaimButtons.forEach(function(btn) {
                        if (btn !== button) {
                            btn.textContent = 'Claim';
                            btn.disabled = false;
                            btn.classList.remove('bg-green-500', 'hover:bg-green-600');
                            btn.classList.add('from-orange-500', 'to-orange-600', 'hover:from-orange-600', 'hover:to-orange-700');
                        }
                    });
                } else {
                    alert(data.message || 'Kode promo tidak valid');
                    button.textContent = originalText;
                    button.disabled = false;
                }
            } catch (error) {
                console.error('Error claiming coupon:', error);
                alert('Terjadi kesalahan saat mengklaim kode promo');
                button.textContent = originalText;
                button.disabled = false;
            }
        }

        // Validate coupon from manual input
        async function validateCouponById(courseId, originalPrice) {
            const couponInput = document.getElementById('coupon_input_' + courseId);
            const couponCode = couponInput.value.trim();

            if (!couponCode) {
                alert('Silakan masukkan kode promo');
                return;
            }

            try {
                const response = await fetch(`/api/coupons/validate/${encodeURIComponent(couponCode)}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({
                        course_id: courseId,
                        original_amount: originalPrice
                    })
                });

                const data = await response.json();

                if (data.valid) {
                    // Set the hidden coupon input
                    const finalCouponInput = document.getElementById('final_coupon_code_' + courseId);
                    if (finalCouponInput) {
                        finalCouponInput.value = couponCode;
                    }

                    // Show applied coupon display
                    const appliedDiv = document.getElementById('applied_coupon_' + courseId);
                    const discountSpan = document.getElementById('applied_discount_' + courseId);
                    if (appliedDiv && discountSpan) {
                        appliedDiv.classList.remove('hidden');
                        discountSpan.textContent = `- Rp ${data.discount_amount.toLocaleString('id-ID')}`;
                    }

                    // Update input style
                    couponInput.style.borderColor = '#10B981';
                    couponInput.value = couponCode;

                    // Reset claim buttons
                    const allClaimButtons = document.querySelectorAll('.claim-btn');
                    allClaimButtons.forEach(function(btn) {
                        btn.textContent = 'Claim';
                        btn.disabled = false;
                        btn.classList.remove('bg-green-500', 'hover:bg-green-600');
                        btn.classList.add('from-orange-500', 'to-orange-600', 'hover:from-orange-600', 'hover:to-orange-700');
                    });
                } else {
                    couponInput.style.borderColor = '#EF4444';
                    alert(data.message || 'Kode promo tidak valid');
                    // Clear hidden input
                    const finalCouponInput = document.getElementById('final_coupon_code_' + courseId);
                    if (finalCouponInput) {
                        finalCouponInput.value = '';
                    }
                }
            } catch (error) {
                console.error('Error validating coupon:', error);
                alert('Terjadi kesalahan saat memvalidasi kode promo');
            }
        }
    </script>

    <style>
        @keyframes shimmer {
            100% {
                transform: translateX(100%);
            }
        }

        .animate-shimmer {
            animation: shimmer 2s infinite;
        }

        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection

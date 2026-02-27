@extends('layouts.user')

@section('content')
    <div class="min-h-screen px-4 py-8 bg-gradient-to-br from-slate-50 via-blue-50 to-blue-100 sm:px-6 lg:px-8">
        <div class="max-w-6xl mx-auto">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('courses.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-blue-700 transition-all duration-300 bg-white shadow-md rounded-xl hover:shadow-lg hover:bg-blue-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Assessment
                </a>
            </div>

            <!-- Header -->
            <div class="mb-8 text-center">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 mb-4 shadow-lg rounded-2xl bg-gradient-to-br from-blue-500 to-blue-700">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
                <h1
                    class="mb-2 text-3xl font-extrabold text-transparent sm:text-4xl bg-clip-text bg-gradient-to-r from-blue-600 to-blue-800">
                    Konfirmasi Pembelian
                </h1>
                <p class="text-gray-600">Lengkapi formulir di bawah ini untuk menyelesaikan pembelian</p>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3" x-data="purchaseForm()">
                <!-- Left Column - Course Info & Payment Details -->
                <div class="space-y-6 lg:col-span-2">
                    <!-- Course Info Card -->
                    <div class="overflow-hidden bg-white border border-blue-100 shadow-xl rounded-3xl">
                        <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700">
                            <h2 class="flex items-center gap-2 text-xl font-bold text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                                Detail Course
                            </h2>
                        </div>
                        <div class="p-6">
                            <h3 class="mb-3 text-2xl font-bold text-gray-900">{{ $course->title }}</h3>
                            @if ($course->description)
                                <p class="mb-4 text-gray-600">{{ $course->description }}</p>
                            @endif

                            <div class="p-4 bg-purple-50 rounded-xl">
                                <div class="flex items-center gap-2 mb-1 text-purple-700">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                        </path>
                                    </svg>
                                    <span class="text-sm font-medium">Pertanyaan</span>
                                </div>
                                <p class="text-xl font-bold text-purple-900">{{ $course->questions_count }}</p>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                @if ($course->has_whatsapp_consultation)
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-100 text-green-800 text-sm font-semibold rounded-lg">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path
                                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                        </svg>
                                        Konsultasi WhatsApp
                                    </span>
                                @endif
                                @if ($course->has_offline_coaching)
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-purple-100 text-purple-800 text-sm font-semibold rounded-lg">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                            </path>
                                        </svg>
                                        Coaching Offline
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Bank Accounts Card -->
                    <div class="overflow-hidden bg-white border border-blue-100 shadow-xl rounded-3xl">
                        <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700">
                            <h2 class="flex items-center gap-2 text-xl font-bold text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                    </path>
                                </svg>
                                Metode Pembayaran
                            </h2>
                        </div>
                        <div class="p-6">
                            <p class="mb-6 text-gray-600">Silakan transfer ke salah satu rekening berikut:</p>

                            <div class="space-y-4">
                                @foreach ($bankAccounts as $bank)
                                    <div
                                        class="p-5 transition-all duration-300 border-2 border-blue-100 rounded-2xl bg-gradient-to-r from-blue-50 to-white hover:from-blue-100 hover:to-blue-50 hover:shadow-lg hover:border-blue-300">
                                        <div class="flex items-center justify-between">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-3 mb-2">
                                                    <div
                                                        class="flex items-center justify-center w-12 h-12 bg-white shadow-md rounded-xl">
                                                        <svg class="w-6 h-6 text-blue-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <p class="text-lg font-bold text-blue-900">{{ $bank->bank_name }}
                                                        </p>
                                                        <p class="text-sm text-gray-500">Bank Transfer</p>
                                                    </div>
                                                </div>
                                                <div class="ml-14">
                                                    <p class="text-2xl font-bold tracking-wider text-gray-900">
                                                        {{ $bank->account_number }}</p>
                                                    <p class="text-gray-600">a.n. {{ $bank->account_holder }}</p>
                                                </div>
                                            </div>
                                            @if ($bank->logo)
                                                <img src="{{ asset('storage/' . $bank->logo) }}"
                                                    alt="{{ $bank->bank_name }}" class="h-16 ml-4 rounded-lg shadow-md">
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Purchase Form Card -->
                    <div class="overflow-hidden bg-white border border-blue-100 shadow-xl rounded-3xl">
                        <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700">
                            <h2 class="flex items-center gap-2 text-xl font-bold text-white">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Konfirmasi Pembayaran
                            </h2>
                        </div>

                        <form method="POST" action="{{ route('purchases.store') }}" enctype="multipart/form-data"
                            class="p-6">
                            @csrf
                            <input type="hidden" name="course_id" value="{{ $course->id }}">
                            <input type="hidden" name="coupon_code" x-model="appliedCoupon">

                            <!-- Coupon Code Section -->
                            <div
                                class="p-5 mb-6 border-2 bg-gradient-to-r from-amber-50 to-orange-50 rounded-2xl border-amber-200">
                                <label class="flex items-center block gap-2 mb-3 text-sm font-bold text-gray-700">
                                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4zm0 0h5M7 17h.01M17 17h.01">
                                        </path>
                                    </svg>
                                    Kode Promo / Kupon
                                </label>
                                <div class="flex gap-3">
                                    <input type="text" x-model="couponCode" @keyup.enter="validateCoupon()"
                                        placeholder="Masukkan kode promo" :disabled="appliedCoupon !== ''"
                                        class="flex-1 px-4 py-3 transition-all border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 disabled:bg-gray-100 disabled:cursor-not-allowed">
                                    <button type="button" @click="validateCoupon()"
                                        :disabled="appliedCoupon !== '' || validatingCoupon"
                                        class="px-6 py-3 font-bold text-white transition-all bg-gradient-to-r from-amber-500 to-orange-500 rounded-xl hover:from-amber-600 hover:to-orange-600 disabled:from-gray-400 disabled:to-gray-500">
                                        <span x-show="!validatingCoupon">Terapkan</span>
                                        <span x-show="validatingCoupon">Cek...</span>
                                    </button>
                                    <button type="button" @click="removeCoupon()" x-show="appliedCoupon !== ''"
                                        class="px-4 py-3 font-bold text-red-600 transition-all bg-red-100 rounded-xl hover:bg-red-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Coupon Status Messages -->
                                <div x-show="couponMessage" x-transition class="mt-3 text-sm"
                                    :class="couponValid ? 'text-green-700' : 'text-red-700'">
                                    <span x-text="couponMessage"></span>
                                </div>

                                <!-- Applied Coupon Info -->
                                <div x-show="appliedCoupon !== '' && couponValid"
                                    class="p-3 mt-3 bg-green-100 rounded-xl">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="font-bold text-green-800">Kupon Berhasil Diterapkan!</p>
                                            <p class="text-sm text-green-700" x-show="discountType === 'percentage'">
                                                Diskon <span x-text="discountValue"></span>%
                                            </p>
                                            <p class="text-sm text-green-700" x-show="discountType === 'fixed'">
                                                Diskon Rp <span x-text="formatNumber(discountAmount)"></span>
                                            </p>
                                        </div>
                                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                                        <span class="text-red-500">*</span> Nama Pengirim
                                    </label>
                                    <input type="text" name="sender_name" required
                                        class="w-full px-4 py-3 transition-all border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Masukkan nama pengirim">
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                                        <span class="text-red-500">*</span> Bank Asal
                                    </label>
                                    <input type="text" name="sender_bank" required
                                        placeholder="Contoh: BCA, Mandiri, BRI"
                                        class="w-full px-4 py-3 transition-all border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                                        <span class="text-red-500">*</span> Tanggal Transfer
                                    </label>
                                    <input type="date" name="transfer_date" required
                                        class="w-full px-4 py-3 transition-all border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label class="block mb-2 text-sm font-semibold text-gray-700">Nomor WhatsApp</label>
                                    <input type="text" name="whatsapp_number" placeholder="Contoh: 08123456789"
                                        class="w-full px-4 py-3 transition-all border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <p class="mt-1 text-xs text-gray-500">Untuk notifikasi status pembelian</p>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block mb-2 text-sm font-semibold text-gray-700">
                                        <span class="text-red-500">*</span> Upload Bukti Transfer
                                    </label>
                                    <div class="relative">
                                        <input type="file" name="proof_image" required accept="image/*,.pdf"
                                            class="w-full px-4 py-3 transition-all border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:font-semibold hover:file:bg-blue-100">
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">Format: JPG, PNG, PDF (Maks. 5MB)</p>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block mb-2 text-sm font-semibold text-gray-700">Catatan
                                        (Opsional)</label>
                                    <textarea name="notes" rows="3"
                                        class="w-full px-4 py-3 transition-all border-2 border-gray-200 resize-none rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full mt-6 px-6 py-4 font-bold text-white transition-all duration-300 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 rounded-xl hover:from-blue-700 hover:via-blue-800 hover:to-blue-900 hover:shadow-xl transform hover:scale-[1.02]">
                                <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Kirim Bukti Pembayaran
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right Column - Price Summary -->
                <div class="lg:col-span-1">
                    <div class="sticky space-y-6 top-4">
                        <!-- Price Card -->
                        <div
                            class="overflow-hidden shadow-2xl bg-gradient-to-br from-blue-600 via-blue-700 to-blue-800 rounded-3xl">
                            <div class="p-6 text-white">
                                <h3 class="mb-4 text-lg font-semibold text-blue-100">Ringkasan Pembayaran</h3>

                                <!-- Original Price -->
                                <div class="pb-4 mb-4 border-b border-blue-400/30">
                                    <p class="mb-1 text-sm text-blue-200">Harga Course</p>
                                    <p class="text-2xl font-bold" x-text="'Rp ' + formatNumber({{ $course->price }})">Rp
                                        {{ number_format($course->price, 0, ',', '.') }}</p>
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
                                        <div class="mb-4">
                                            <p class="mb-2 text-sm font-semibold text-orange-200">Kode Promo Tersedia:</p>
                                            <div class="space-y-2">
                                                @foreach ($applicableCoupons as $coupon)
                                                    <div class="flex items-center justify-between p-2 bg-white/10 backdrop-blur-sm border border-orange-300/30 rounded-lg">
                                                        <div class="flex-1">
                                                            <p class="text-sm font-bold text-orange-300">
                                                                @if ($coupon->type === 'percentage')
                                                                    {{ number_format($coupon->value, 0) }}% OFF
                                                                @else
                                                                    Rp {{ number_format($coupon->value, 0, ',', '.') }} OFF
                                                                @endif
                                                            </p>
                                                            <p class="text-xs font-mono text-orange-200">{{ $coupon->code }}</p>
                                                        </div>
                                                        <button type="button" @click="couponCode = '{{ $coupon->code }}'; validateCoupon();"
                                                            class="px-3 py-1.5 text-xs font-bold text-white bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg hover:from-orange-600 hover:to-orange-700 transition-all">
                                                            Claim
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                <!-- Discount Section (Hidden by default) -->
                                <div x-show="discountAmount > 0" class="pb-4 mb-4 border-b border-blue-400/30">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="mb-1 text-sm text-blue-200">Diskon</p>
                                            <p class="text-sm" x-show="discountType === 'percentage'">
                                                <span x-text="discountValue"></span>%
                                            </p>
                                        </div>
                                        <p class="text-xl font-bold text-green-300">- Rp <span
                                                x-text="formatNumber(discountAmount)"></span></p>
                                    </div>
                                </div>

                                <!-- Final Price -->
                                <div class="pb-6 mb-6 border-b border-blue-400/30">
                                    <p class="mb-1 text-sm text-blue-200">Total Pembayaran</p>
                                    <p class="text-4xl font-bold">Rp <span
                                            x-text="formatNumber(finalAmount)">{{ number_format($course->price, 0, ',', '.') }}</span>
                                    </p>
                                </div>

                                <!-- You Save -->
                                <div x-show="discountAmount > 0" class="p-3 mb-6 bg-green-500/20 rounded-xl">
                                    <p class="text-sm font-semibold text-green-300">
                                        Anda hemat Rp <span x-text="formatNumber(discountAmount)"></span>!
                                    </p>
                                </div>

                                <div class="mb-6 space-y-3">
                                    <div class="flex items-center gap-3 text-sm">
                                        <svg class="flex-shrink-0 w-5 h-5 text-green-300" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Akses seumur hidup</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-sm">
                                        <svg class="flex-shrink-0 w-5 h-5 text-green-300" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Sertifikat resmi</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-sm">
                                        <svg class="flex-shrink-0 w-5 h-5 text-green-300" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Update materi gratis</span>
                                    </div>
                                    <div class="flex items-center gap-3 text-sm">
                                        <svg class="flex-shrink-0 w-5 h-5 text-green-300" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Support prioritas</span>
                                    </div>
                                </div>

                                <div class="p-4 bg-white/10 rounded-2xl">
                                    <div class="flex items-start gap-3">
                                        <svg class="w-6 h-6 text-yellow-300 flex-shrink-0 mt-0.5" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div>
                                            <p class="mb-1 text-sm font-semibold">Proses Verifikasi</p>
                                            <p class="text-xs text-blue-100">Pembayaran akan diverifikasi dalam 1x24 jam
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Support Card -->
                        <div class="p-6 bg-white border border-blue-100 shadow-xl rounded-3xl">
                            <h3 class="flex items-center gap-2 mb-3 font-bold text-gray-900">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                    </path>
                                </svg>
                                Butuh Bantuan?
                            </h3>
                            <p class="mb-4 text-sm text-gray-600">Hubungi tim kami jika mengalami kendala dalam pembayaran
                            </p>
                            <a href="{{ route('contact') }}"
                                class="block w-full px-4 py-3 font-semibold text-center text-blue-600 transition-all duration-300 bg-blue-50 rounded-xl hover:bg-blue-600 hover:text-white">
                                Hubungi Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function purchaseForm() {
            return {
                couponCode: '',
                appliedCoupon: '',
                couponValid: false,
                couponMessage: '',
                validatingCoupon: false,
                discountType: '',
                discountValue: 0,
                discountAmount: 0,
                originalAmount: {{ $course->price }},
                finalAmount: {{ $course->price }},

                validateCoupon() {
                    if (!this.couponCode.trim()) {
                        this.couponMessage = 'Masukkan kode promo';
                        this.couponValid = false;
                        return;
                    }

                    this.validatingCoupon = true;
                    this.couponMessage = '';

                    fetch(`{{ route('coupons.validate', 'CODE') }}`.replace('CODE', this.couponCode.toUpperCase()), {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({
                                course_id: {{ $course->id }},
                                original_amount: this.originalAmount
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            this.validatingCoupon = false;

                            if (data.valid) {
                                this.appliedCoupon = this.couponCode.toUpperCase();
                                this.couponValid = true;
                                this.discountType = data.discount_type;
                                this.discountValue = data.discount_value;
                                this.discountAmount = data.discount_amount;
                                this.finalAmount = data.final_amount;
                                this.couponMessage = 'Kupon berhasil diterapkan!';
                            } else {
                                this.couponValid = false;
                                this.couponMessage = data.message;
                            }
                        })
                        .catch(error => {
                            this.validatingCoupon = false;
                            this.couponValid = false;
                            this.couponMessage = 'Terjadi kesalahan. Silakan coba lagi.';
                            console.error('Error:', error);
                        });
                },

                removeCoupon() {
                    this.couponCode = '';
                    this.appliedCoupon = '';
                    this.couponValid = false;
                    this.couponMessage = '';
                    this.discountType = '';
                    this.discountValue = 0;
                    this.discountAmount = 0;
                    this.finalAmount = this.originalAmount;
                },

                formatNumber(num) {
                    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                }
            }
        }
    </script>
@endsection

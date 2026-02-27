@extends('layouts.user')

@section('content')
    <div class="min-h-screen px-4 py-8 bg-gradient-to-br from-slate-50 to-blue-50 sm:px-6 lg:px-8">
        <div class="container max-w-4xl mx-auto">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('purchases.index') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 text-blue-700 transition-all duration-300 bg-white shadow-md rounded-xl hover:shadow-lg hover:bg-blue-50">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Pembelian
                </a>
            </div>

            <!-- Header -->
            <div class="mb-8 text-center">
                <h1
                    class="mb-2 text-3xl font-extrabold text-transparent sm:text-4xl bg-clip-text bg-gradient-to-r from-blue-600 to-blue-800">
                    Payment Instructions
                </h1>
                <p class="text-gray-600">Selesaikan pembayaran untuk mengaktifkan course Anda</p>
            </div>

            <!-- Selected Course Section -->
            <div class="p-6 mb-8 bg-white border border-blue-100 shadow-lg rounded-2xl">
                <h2 class="mb-4 text-xl font-bold text-blue-800">Selected Course</h2>
                <div class="flex items-center justify-between pb-4 border-b border-blue-100">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $purchase->course->title }}</h3>
                        <p class="text-gray-600">{{ Str::limit($purchase->course->description ?? '', 100) }}</p>
                    </div>
                    <div class="text-2xl font-bold text-blue-600">Rp {{ number_format($purchase->amount, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <!-- Coupon Section -->
            <div class="p-6 mb-8 bg-white border border-blue-100 shadow-lg rounded-2xl">
                <h2 class="mb-4 text-xl font-bold text-blue-800">Apply Coupon</h2>
                <div class="mb-4">
                    <label class="block mb-2 font-medium text-gray-700" for="coupon_code">Coupon Code</label>
                    <div class="flex gap-2">
                        <input type="text" id="coupon_code" name="coupon_code"
                            class="flex-1 px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Enter coupon code">
                        <button type="button" onclick="validateCoupon()"
                            class="px-4 py-2 font-medium text-white transition-colors bg-blue-600 rounded-xl hover:bg-blue-700">
                            Apply
                        </button>
                    </div>
                    <p class="mt-1 text-sm text-gray-500">If you have a coupon code, enter it above to get discount</p>
                </div>

                <!-- Coupon Info Display -->
                <div id="coupon-info" class="hidden p-3 mt-3 border border-green-200 bg-green-50 rounded-xl">
                    <div class="flex items-center justify-between">
                        <span id="coupon-applied-text" class="font-medium text-green-800"></span>
                        <button type="button" onclick="removeCoupon()" class="text-red-600 hover:text-red-800">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div id="coupon-discount-info" class="mt-1 text-sm text-green-700"></div>
                </div>
            </div>

            <!-- Payment Instructions Section -->
            <div class="p-6 mb-8 bg-white border border-blue-100 shadow-lg rounded-2xl">
                <h2 class="mb-4 text-xl font-bold text-blue-800">Payment Instructions</h2>
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <h3 class="mb-2 font-semibold text-gray-800">Transfer to:</h3>
                        @foreach ($bankAccounts as $bankAccount)
                            <div class="p-4 mb-3 border-2 border-blue-100 rounded-xl bg-blue-50/50">
                                <p class="font-medium text-blue-800">{{ $bankAccount->bank_name }}</p>
                                <p class="text-lg font-bold text-blue-900">{{ $bankAccount->account_number }}</p>
                                <p class="text-gray-600">a/n {{ $bankAccount->account_holder }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div>
                        <h3 class="mb-2 font-semibold text-gray-800">Amount to Transfer:</h3>
                        <div class="p-4 text-center rounded-xl bg-gradient-to-r from-blue-500 to-blue-700">
                            <p class="text-2xl font-bold text-white">Rp
                                {{ number_format($purchase->amount, 0, ',', '.') }}</p>
                        </div>

                        @if ($purchase->expired_at && $purchase->expired_at->isFuture())
                            <div class="p-3 mt-4 border border-yellow-200 bg-yellow-50 rounded-xl">
                                <p class="text-sm text-yellow-800">
                                    <i class="mr-1 fas fa-clock"></i>
                                    Payment expires: {{ $purchase->expired_at->format('d M Y, H:i') }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Upload Payment Proof Section -->
            <div class="p-6 bg-white border border-blue-100 shadow-lg rounded-2xl">
                <h2 class="mb-4 text-xl font-bold text-blue-800">Upload Payment Proof</h2>
                <form method="POST" action="{{ route('purchases.upload-proof', $purchase->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="coupon_code" id="hidden_coupon_code" value="">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <label class="block mb-2 font-medium text-gray-700" for="sender_name">Sender Name</label>
                            <input type="text" id="sender_name" name="sender_name" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block mb-2 font-medium text-gray-700" for="sender_bank">Sender Bank</label>
                            <input type="text" id="sender_bank" name="sender_bank" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block mb-2 font-medium text-gray-700" for="transfer_date">Transfer Date</label>
                            <input type="date" id="transfer_date" name="transfer_date" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>

                        <div>
                            <label class="block mb-2 font-medium text-gray-700" for="whatsapp_number">WhatsApp
                                Number</label>
                            <input type="text" id="whatsapp_number" name="whatsapp_number"
                                class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="e.g., 08123456789">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block mb-2 font-medium text-gray-700" for="proof_image">Proof of Payment
                                (Image/PDF)</label>
                            <input type="file" id="proof_image" name="proof_image" accept="image/*,application/pdf"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <p class="mt-1 text-sm text-gray-500">Max file size: 5MB</p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block mb-2 font-medium text-gray-700" for="notes">Additional Notes
                                (Optional)</label>
                            <textarea id="notes" name="notes" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="w-full px-4 py-3 font-bold text-white transition duration-300 bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 hover:shadow-lg">
                            Upload Proof & Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            let appliedCoupon = '';

            async function validateCoupon() {
                const couponCodeInput = document.getElementById('coupon_code');
                const couponCode = couponCodeInput.value.trim();

                if (!couponCode) {
                    alert('Please enter a coupon code');
                    return;
                }

                try {
                    const response = await fetch(`/api/coupons/validate/${encodeURIComponent(couponCode)}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute(
                                'content') || ''
                        },
                        body: JSON.stringify({
                            course_id: {{ $purchase->course->id }},
                            original_amount: {{ $purchase->course->price }}
                        })
                    });

                    const data = await response.json();

                    if (data.valid) {
                        appliedCoupon = couponCode;
                        document.getElementById('hidden_coupon_code').value = couponCode;

                        // Show coupon info
                        document.getElementById('coupon-applied-text').textContent = `Coupon "${couponCode}" applied`;
                        document.getElementById('coupon-discount-info').innerHTML = `
                        Discount: ${data.discount_type === 'percentage' ?
                            data.discount_value + '%' :
                            'Rp ' + new Intl.NumberFormat('id-ID').format(data.discount_value)}
                        <br>New amount: Rp ${new Intl.NumberFormat('id-ID').format(data.final_amount)}`
                    );
                    document.getElementById('coupon-info').classList.remove('hidden');

                    // Update displayed amount
                    document.querySelector('.bg-gradient-to-r.from-blue-500.to-blue-700 .text-2xl.font-bold.text-white')
                        .innerHTML =
                        `Rp ${new Intl.NumberFormat('id-ID').format(data.final_amount)}`;

                    // Clear input
                    couponCodeInput.value = '';
                } else {
                    alert(data.message || 'Invalid coupon code');
                }
            } catch (error) {
                console.error('Error validating coupon:', error);
                alert('An error occurred while validating the coupon');
            }
            }

            function removeCoupon() {
                appliedCoupon = '';
                document.getElementById('hidden_coupon_code').value = '';
                document.getElementById('coupon-info').classList.add('hidden');

                // Reset to original amount
                document.querySelector('.bg-gradient-to-r.from-blue-500.to-blue-700 .text-2xl.font-bold.text-white').innerHTML =
                    `Rp {{ number_format($purchase->amount, 0, ',', '.') }}`;
            }
        </script>
    @endsection

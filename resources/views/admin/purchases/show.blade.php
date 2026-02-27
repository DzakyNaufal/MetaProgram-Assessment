@extends('layouts.admin')

@section('header', 'Detail Pembelian')

@section('content')
    <div class="container px-4 py-8 mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold">Purchase Details</h1>
            <a href="{{ route('admin.purchases.index') }}"
                class="px-4 py-2 font-bold text-white bg-gray-500 rounded hover:bg-gray-700">
                Back to Purchases
            </a>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Purchase Information -->
            <div class="p-6 bg-white rounded-lg shadow-md lg:col-span-2">
                <h2 class="mb-4 text-xl font-bold">Purchase Information</h2>

                <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2">
                    <div>
                        <p class="text-gray-600">Purchase ID</p>
                        <p class="font-semibold">#{{ $purchase->id }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Status</p>
                        <p>
                            <span
                                class="px-2 py-1 rounded-full text-sm
                                @if ($purchase->status == 'pending') bg-yellow-200 text-yellow-800
                                @elseif($purchase->status == 'confirmed') bg-green-200 text-green-800
                                @elseif($purchase->status == 'rejected') bg-red-200 text-red-800
                                @elseif($purchase->status == 'expired') bg-gray-200 text-gray-800 @endif">
                                {{ ucfirst($purchase->status) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-600">Amount</p>
                        <p class="font-semibold">Rp {{ number_format($purchase->amount, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Created At</p>
                        <p>{{ $purchase->created_at->format('d M Y H:i') }}</p>
                    </div>
                    @if ($purchase->expired_at)
                        <div>
                            <p class="text-gray-600">Expired At</p>
                            <p>{{ $purchase->expired_at->format('d M Y H:i') }}</p>
                        </div>
                    @endif
                </div>

                <!-- User Information -->
                <h3 class="mb-3 text-lg font-bold">User Information</h3>
                <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2">
                    <div>
                        <p class="text-gray-600">Name</p>
                        <p class="font-semibold">{{ $purchase->user->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Email</p>
                        <p>{{ $purchase->user->email }}</p>
                    </div>
                </div>

                <!-- Course Information -->
                <h3 class="mb-3 text-lg font-bold">Course Information</h3>
                <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2">
                    <div>
                        <p class="text-gray-600">Name</p>
                        <p class="font-semibold">{{ $purchase->course->title }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600">Price</p>
                        <p>Rp {{ number_format($purchase->course->price, 0, ',', '.') }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-gray-600">Description</p>
                        <p>{{ $purchase->course->description ?: '-' }}</p>
                    </div>
                </div>

                <!-- Payment Details (if available) -->
                @if ($purchase->sender_name)
                    <h3 class="mb-3 text-lg font-bold">Payment Details</h3>
                    <div class="grid grid-cols-1 gap-4 mb-6 md:grid-cols-2">
                        <div>
                            <p class="text-gray-600">Sender Name</p>
                            <p class="font-semibold">{{ $purchase->sender_name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Sender Bank</p>
                            <p>{{ $purchase->sender_bank }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Transfer Date</p>
                            <p>{{ $purchase->transfer_date ? $purchase->transfer_date->format('d M Y') : '-' }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">WhatsApp Number</p>
                            <p>{{ $purchase->whatsapp_number ?: '-' }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-gray-600">Notes</p>
                            <p>{{ $purchase->notes ?: '-' }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Action Panel -->
            <div class="p-6 bg-white rounded-lg shadow-md">
                <h2 class="mb-4 text-xl font-bold">Actions</h2>

                @if ($purchase->status == 'pending')
                    <div class="space-y-4">
                        <button type="button"
                            x-data
                            @click="$dispatch('open-confirm-modal')"
                            class="block w-full px-4 py-3 font-bold text-center text-white bg-green-500 rounded hover:bg-green-700">
                            Confirm Payment
                        </button>

                        <!-- Reject Button -->
                        <button type="button"
                            class="w-full px-4 py-3 font-bold text-white bg-red-500 rounded hover:bg-red-700"
                            onclick="openRejectModal()">
                            Reject Payment
                        </button>
                    </div>
                @elseif($purchase->status == 'confirmed')
                    <div class="relative px-4 py-3 bg-green-100 border border-green-400 rounded text-green-70"
                        role="alert">
                        <strong class="font-bold">Confirmed! </strong>
                        <span class="block sm:inline">This purchase has been confirmed.</span>
                    </div>
                @elseif($purchase->status == 'rejected')
                    <div class="relative px-4 py-3 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                        <strong class="font-bold">Rejected! </strong>
                        <span class="block sm:inline">This purchase has been rejected.</span>
                    </div>
                @elseif($purchase->status == 'expired')
                    <div class="relative px-4 py-3 text-gray-700 bg-gray-100 border border-gray-400 rounded" role="alert">
                        <strong class="font-bold">Expired! </strong>
                        <span class="block sm:inline">This purchase has expired.</span>
                    </div>
                @endif

                <!-- Proof of Payment -->
                @if ($purchase->proof_image)
                    <div class="mt-6">
                        <h3 class="mb-3 text-lg font-bold">Proof of Payment</h3>
                        <div class="p-4 border rounded">
                            @if (pathinfo($purchase->proof_image, PATHINFO_EXTENSION) === 'pdf')
                                <p>PDF Document: <a href="{{ asset('storage/' . $purchase->proof_image) }}" target="_blank"
                                        class="text-blue-500 hover:underline">View PDF</a></p>
                            @else
                                <img src="{{ asset('storage/' . $purchase->proof_image) }}" alt="Proof of Payment"
                                    class="h-auto max-w-full rounded">
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Reject Modal -->
        <div id="rejectModal" class="fixed inset-0 hidden w-full h-full overflow-y-auto bg-gray-600 bg-opacity-50">
            <div class="relative p-5 mx-auto bg-white border rounded-md shadow-lg top-20 w-96">
                <div class="mt-3">
                    <div class="flex items-center justify-between pb-3 border-b">
                        <h3 class="text-lg font-bold">Reject Purchase</h3>
                        <button onclick="closeRejectModal()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <form id="rejectForm" method="POST" action="{{ route('admin.purchases.reject', $purchase->id) }}">
                        @csrf
                        <input type="hidden" name="_method" value="PUT">
                        <div class="mt-4">
                            <label for="reason" class="block mb-2 text-gray-700">Reason for Rejection</label>
                            <textarea id="reason" name="reason" rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required></textarea>
                        </div>
                        <div class="flex justify-end mt-6 space-x-3">
                            <button type="button" onclick="closeRejectModal()"
                                class="px-4 py-2 text-white bg-gray-500 rounded hover:bg-gray-600">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 text-white bg-red-500 rounded hover:bg-red-600">
                                Reject Purchase
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Confirm Payment Modal -->
        <div x-data="{
            show: false,
            init() {
                window.addEventListener('open-confirm-modal', () => {
                    this.show = true;
                });
            },
            confirmPayment() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('admin.purchases.confirm', $purchase->id) }}';

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'PUT';

                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }" x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center" style="display: none;">
            <!-- Backdrop -->
            <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="show = false"></div>

            <!-- Modal Content -->
            <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 overflow-hidden">
                <!-- Header with Success Icon -->
                <div class="bg-gradient-to-r from-green-500 to-green-600 px-6 py-5">
                    <div class="flex items-center">
                        <div class="flex items-center justify-center w-12 h-12 bg-white/20 rounded-xl backdrop-blur-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-bold text-white">Konfirmasi Pembayaran</h3>
                            <p class="text-sm text-green-100">Setujui pembelian ini</p>
                        </div>
                    </div>
                </div>

                <!-- Body -->
                <div class="px-6 py-5">
                    <p class="text-gray-600 mb-3">Apakah Anda yakin ingin mengkonfirmasi pembayaran ini?</p>
                    <div class="p-3 bg-green-50 border border-green-200 rounded-xl mb-4">
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div>
                                <p class="text-gray-500">Jumlah</p>
                                <p class="font-semibold text-green-800">Rp {{ number_format($purchase->amount, 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Pembeli</p>
                                <p class="font-semibold text-green-800">{{ $purchase->user->name }}</p>
                            </div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">Pembayaran akan dikonfirmasi dan user akan mendapatkan akses ke course.</p>
                </div>

                <!-- Footer -->
                <div class="px-6 py-4 bg-gray-50 flex gap-3 justify-end">
                    <button type="button" @click="show = false" class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all">
                        Batal
                    </button>
                    <button type="button" @click="confirmPayment()" class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-green-500 to-green-600 rounded-xl hover:from-green-600 hover:to-green-700 transition-all shadow-lg hover:shadow-xl">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Ya, Konfirmasi
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
        }

        // Close modal when clicking outside of it
        window.onclick = function(event) {
            const modal = document.getElementById('rejectModal');
            if (event.target === modal) {
                modal.classList.add('hidden');
            }
        }
    </script>
@endsection

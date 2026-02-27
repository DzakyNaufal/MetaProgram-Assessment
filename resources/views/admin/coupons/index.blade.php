@extends('layouts.admin')

@section('header', 'Manajemen Kupon')

@section('content')
    <div class="mx-auto max-w-7xl">

        <!-- Header -->
        <div class="mb-8 overflow-hidden bg-white shadow-lg rounded-2xl">
            <div class="px-8 py-10 bg-gradient-to-r from-blue-600 to-blue-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-white">Manajemen Kupon</h1>
                        <p class="mt-2 text-lg text-blue-100">
                            Kelola kode kupon untuk potongan harga pembelian.
                        </p>
                    </div>
                    <div class="p-5 bg-white/20 backdrop-blur-sm rounded-2xl">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4zm0 0h5M7 17h.01M17 17h.01" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Alert -->
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

        <!-- Table Card -->
        <div class="overflow-hidden bg-white shadow-lg rounded-2xl">
            <div
                class="flex flex-col gap-4 px-6 py-5 border-b border-gray-100 sm:flex-row sm:items-center sm:justify-between bg-gray-50">
                <h2 class="text-xl font-semibold text-gray-800">Daftar Kupon</h2>
                <a href="{{ route('admin.coupons.create') }}"
                    class="inline-flex items-center px-5 py-3 text-sm font-bold text-white transition-all bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl shadow hover:shadow-xl hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Kupon
                </a>
            </div>

            @if ($coupons->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    No</th>
                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Kode Kupon</th>
                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Tipe</th>
                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Nilai</th>
                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Minimal Order</th>
                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Penggunaan</th>
                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Berlaku</th>
                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Status</th>
                                <th class="px-6 py-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($coupons as $coupon)
                                <tr class="transition-colors duration-200 hover:bg-blue-50/30">
                                    <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <code class="px-3 py-1.5 text-lg font-bold text-blue-600 bg-blue-50 rounded-lg border border-blue-200">
                                                {{ $coupon->code }}
                                            </code>
                                        </div>
                                        @if ($coupon->description)
                                            <p class="mt-1 text-xs text-gray-500">{{ \Illuminate\Support\Str::limit($coupon->description, 50) }}</p>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full
                                            {{ $coupon->type === 'percentage' ? 'bg-purple-100 text-purple-800' : 'bg-orange-100 text-orange-800' }}">
                                            {{ $coupon->type === 'percentage' ? 'Persentase' : 'Nominal Tetap' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-semibold text-gray-900">
                                            @if ($coupon->type === 'percentage')
                                                {{ $coupon->value }}%
                                            @else
                                                Rp {{ number_format($coupon->value, 0, ',', '.') }}
                                            @endif
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($coupon->min_order_amount)
                                            <span class="text-sm text-gray-600">Rp {{ number_format($coupon->min_order_amount, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-sm text-gray-400">-</span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm text-gray-600">
                                            {{ $coupon->used_count }}
                                            @if ($coupon->max_uses)
                                                / {{ $coupon->max_uses }}
                                            @else
                                                / ∞
                                            @endif
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600">
                                            @if ($coupon->valid_from)
                                                <div>Dari: {{ $coupon->valid_from->format('d M Y') }}</div>
                                            @endif
                                            @if ($coupon->valid_until)
                                                <div>Sampai: {{ $coupon->valid_until->format('d M Y') }}</div>
                                            @endif
                                            @if (!$coupon->valid_from && !$coupon->valid_until)
                                                <span class="text-gray-400">Selamanya</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-3 py-1.5 text-xs font-semibold rounded-full
                                        {{ $coupon->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $coupon->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 space-x-4 text-sm font-medium whitespace-nowrap">
                                        <a href="{{ route('admin.coupons.edit', $coupon) }}"
                                            class="inline-flex items-center text-blue-600 hover:text-[#0c4a6e] font-medium">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>

                                        <button type="button"
                                            x-data
                                            @click="$dispatch('open-delete-modal', { id: {{ $coupon->id }}, title: '{{ $coupon->code }}' })"
                                            class="font-medium text-red-600 hover:text-red-800">
                                            <svg class="inline w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <!-- Empty State -->
                <div class="py-20 text-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 mb-6 rounded-full bg-blue-50">
                        <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4zm0 0h5M7 17h.01M17 17h.01" />
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900">Belum Ada Kupon</h3>
                    <p class="mt-3 text-gray-500">Mulai dengan menambahkan kupon pertama Anda.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{
        show: false,
        couponId: null,
        couponCode: '',
        init() {
            window.addEventListener('open-delete-modal', (e) => {
                this.couponId = e.detail.id;
                this.couponCode = e.detail.title;
                this.show = true;
            });
        },
        confirmDelete() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/coupons/${this.couponId}`;

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';

            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';

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
            <!-- Header with Warning Icon -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-5">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-12 h-12 bg-white/20 rounded-xl backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-white">Hapus Kupon</h3>
                        <p class="text-sm text-red-100">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="px-6 py-5">
                <p class="text-gray-600 mb-3">Apakah Anda yakin ingin menghapus kupon ini?</p>
                <div class="p-3 bg-red-50 border border-red-200 rounded-xl">
                    <p class="text-sm font-semibold text-red-800" x-text="couponCode"></p>
                </div>
                <p class="mt-3 text-xs text-gray-500">Semua data terkait kupon ini akan dihapus secara permanen.</p>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 bg-gray-50 flex gap-3 justify-end">
                <button type="button" @click="show = false" class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition-all">
                    Batal
                </button>
                <button type="button" @click="confirmDelete()" class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-red-500 to-red-600 rounded-xl hover:from-red-600 hover:to-red-700 transition-all shadow-lg hover:shadow-xl">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Ya, Hapus
                    </span>
                </button>
            </div>
        </div>
    </div>
@endsection

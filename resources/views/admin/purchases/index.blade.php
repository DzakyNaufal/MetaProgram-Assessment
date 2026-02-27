@extends('layouts.admin')

@section('header', 'Manajemen Pembelian')

@section('content')
    <div class="p-6">
        <div class="overflow-hidden bg-white shadow-xl sm:rounded-3xl">
            <!-- Header -->
            <div class="px-8 py-10 bg-gradient-to-r from-blue-600 to-blue-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-bold text-white">Manajemen Pembelian</h1>
                        <p class="mt-2 text-lg text-blue-100">
                            Verifikasi dan kelola semua pembelian course.
                        </p>
                    </div>
                    <div class="p-5 bg-white/20 backdrop-blur-sm rounded-2xl">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <!-- Filter Form -->
                <form method="GET" action="{{ route('admin.purchases.index') }}" class="mb-8">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                        <div>
                            <label class="block mb-2 text-sm font-semibold text-gray-700" for="status">Filter Status</label>
                            <select name="status" id="status" class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>✅ Confirmed</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>❌ Rejected</option>
                                <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>⌛ Expired</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full px-6 py-3 font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg hover:shadow-xl">
                                <svg class="inline w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                </svg>
                                Filter
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Purchases Table -->
                <div class="overflow-hidden border border-gray-200 rounded-2xl">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr class="text-sm font-semibold text-left text-gray-700 uppercase bg-gradient-to-r from-gray-50 to-blue-50">
                                    <th class="px-6 py-4">ID</th>
                                    <th class="px-6 py-4">User</th>
                                    <th class="px-6 py-4">Course</th>
                                    <th class="px-6 py-4">Jumlah</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4">Tanggal</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-100">
                                @forelse($purchases as $purchase)
                                    <tr class="transition-colors hover:bg-blue-50/30">
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-800 rounded-lg font-mono font-bold">
                                                #{{ $purchase->id }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-sm mr-3">
                                                    {{ strtoupper(substr($purchase->user->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="font-semibold text-gray-900">{{ $purchase->user->name }}</div>
                                                    <div class="text-xs text-gray-500">{{ $purchase->user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($purchase->course)
                                                <div class="font-medium text-gray-900">{{ $purchase->course->title }}</div>
                                            @else
                                                <div class="text-red-600 italic">Course deleted</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-lg font-bold text-blue-700">
                                                Rp {{ number_format($purchase->amount, 0, ',', '.') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($purchase->status == 'pending')
                                                <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-yellow-100 text-yellow-800">
                                                    <svg class="w-3 h-3 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                    </svg>
                                                    Pending
                                                </span>
                                            @elseif($purchase->status == 'confirmed')
                                                <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-green-100 text-green-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Confirmed
                                                </span>
                                            @elseif($purchase->status == 'rejected')
                                                <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-red-100 text-red-800">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Rejected
                                                </span>
                                            @elseif($purchase->status == 'expired')
                                                <span class="inline-flex items-center px-3 py-1.5 text-xs font-bold rounded-full bg-gray-100 text-gray-600">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Expired
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">
                                            <div>{{ $purchase->created_at->format('d M Y') }}</div>
                                            <div class="text-xs">{{ $purchase->created_at->format('H:i') }} WIB</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('admin.purchases.show', $purchase->id) }}"
                                                    class="inline-flex items-center justify-center w-9 h-9 text-blue-600 bg-blue-50 rounded-lg hover:bg-blue-100 transition-all"
                                                    title="View Details">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>
                                                <button type="button" x-data @click="$dispatch('open-delete-modal', { id: {{ $purchase->id }}, userName: '{{ $purchase->user->name }}', courseTitle: '{{ $purchase->course ? $purchase->course->title : 'Deleted Course' }}' })"
                                                    class="inline-flex items-center justify-center w-9 h-9 text-red-600 bg-red-50 rounded-lg hover:bg-red-100 transition-all"
                                                    title="Hapus Pembelian">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <div class="inline-flex items-center justify-center w-20 h-20 mb-4 rounded-full bg-blue-50">
                                                <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-gray-500 font-medium">Tidak ada pembelian ditemukan.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($purchases->hasPages())
                    <div class="mt-6 px-6 py-4 bg-gray-50 rounded-b-2xl">
                        {{ $purchases->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{
        show: false,
        purchaseId: null,
        userName: '',
        courseTitle: '',
        init() {
            window.addEventListener('open-delete-modal', (e) => {
                this.purchaseId = e.detail.id;
                this.userName = e.detail.userName;
                this.courseTitle = e.detail.courseTitle;
                this.show = true;
            });
        },
        confirmDelete() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/purchases/${this.purchaseId}`;

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
        <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative bg-white rounded-3xl shadow-2xl max-w-lg w-full mx-4 overflow-hidden">
            <!-- Header with Warning Icon -->
            <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-5">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-12 h-12 bg-white/20 rounded-xl backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-white">Hapus Pembelian</h3>
                        <p class="text-sm text-red-100">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="px-6 py-5">
                <p class="text-gray-600 mb-3">Apakah Anda yakin ingin menghapus pembelian ini?</p>
                <div class="p-3 bg-red-50 border border-red-200 rounded-xl mb-4">
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div>
                            <p class="text-gray-500">User</p>
                            <p class="font-semibold text-red-800" x-text="userName"></p>
                        </div>
                        <div>
                            <p class="text-gray-500">Course</p>
                            <p class="font-semibold text-red-800" x-text="courseTitle"></p>
                        </div>
                    </div>
                </div>

                <!-- Cascade Warning -->
                <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl mb-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-amber-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div>
                            <p class="text-sm font-semibold text-amber-800">Peringatan: History user akan terhapus</p>
                            <p class="mt-1 text-xs text-amber-700">Progress, hasil, dan riwayat assessment user untuk course ini akan dihapus secara permanen.</p>
                        </div>
                    </div>
                </div>

                <p class="text-xs text-gray-500">Tindakan ini tidak dapat dibatalkan. Semua data akan dihapus secara permanen.</p>
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

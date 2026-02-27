@extends('layouts.user')

@section('content')
    <div class="min-h-screen py-12 bg-gradient-to-br from-blue-50 via-slate-50 to-blue-100">
        <div class="px-4 mx-auto max-w-4xl sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('courses.show', $course->slug) }}"
                    class="inline-flex items-center gap-2 text-gray-600 hover:text-gray-800 transition-colors">
                    <i class="fas fa-arrow-left"></i>
                    <span>Kembali</span>
                </a>
            </div>

            <!-- Purchase Card -->
            <div class="overflow-hidden bg-white shadow-xl rounded-2xl">
                <!-- Header -->
                <div class="p-8 bg-gradient-to-r from-blue-500 to-blue-600">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex items-center justify-center w-16 h-16 rounded-xl bg-white/20">
                            @if ($category->icon === 'star')
                                <i class="text-3xl text-white fas fa-star"></i>
                            @elseif ($category->icon === 'user')
                                <i class="text-3xl text-white fas fa-user"></i>
                            @elseif ($category->icon === 'briefcase')
                                <i class="text-3xl text-white fas fa-briefcase"></i>
                            @elseif ($category->icon === 'message-circle')
                                <i class="text-3xl text-white fas fa-comment"></i>
                            @elseif ($category->icon === 'users')
                                <i class="text-3xl text-white fas fa-users"></i>
                            @elseif ($category->icon === 'trending-up')
                                <i class="text-3xl text-white fas fa-chart-line"></i>
                            @else
                                <i class="text-3xl text-white fas fa-book"></i>
                            @endif
                        </div>
                        <div class="text-white">
                            <h1 class="text-2xl font-bold">{{ $category->name }}</h1>
                            <p class="opacity-90">{{ $course->title }}</p>
                        </div>
                    </div>
                    <div class="mt-6 p-4 bg-white/10 rounded-xl backdrop-blur-sm">
                        <div class="flex items-center justify-between text-white">
                            <span class="text-lg">Total Pembayaran:</span>
                            <span class="text-3xl font-bold">Rp {{ number_format($category->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-8">
                    <!-- Description -->
                    <div class="mb-8">
                        <h2 class="mb-2 text-lg font-semibold text-gray-800">Deskripsi</h2>
                        <p class="text-gray-600">{{ $category->description }}</p>
                    </div>

                    <!-- Purchase Form -->
                    <form action="{{ route('purchases.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <input type="hidden" name="category_id" value="{{ $category->id }}">
                        <input type="hidden" name="amount" value="{{ $category->price }}">

                        <!-- Select Bank Account -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-semibold text-gray-700">
                                <i class="fas fa-university mr-2"></i>Pilih Rekening Tujuan
                            </label>
                            <select name="bank_account_id" required class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">-- Pilih Bank --</option>
                                @foreach ($bankAccounts as $bank)
                                    <option value="{{ $bank->id }}">
                                        {{ $bank->bank_name }} - {{ $bank->account_number }} ({{ $bank->account_name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sender Name -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-semibold text-gray-700">
                                <i class="fas fa-user mr-2"></i>Nama Pengirim
                            </label>
                            <input type="text" name="sender_name" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Masukkan nama pengirim">
                        </div>

                        <!-- Sender Bank -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-semibold text-gray-700">
                                <i class="fas fa-credit-card mr-2"></i>Bank Pengirim
                            </label>
                            <input type="text" name="sender_bank" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Contoh: BCA, Mandiri, BRI">
                        </div>

                        <!-- Transfer Date -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-semibold text-gray-700">
                                <i class="fas fa-calendar mr-2"></i>Tanggal Transfer
                            </label>
                            <input type="date" name="transfer_date" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <!-- Upload Proof -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-semibold text-gray-700">
                                <i class="fas fa-image mr-2"></i>Bukti Transfer
                            </label>
                            <div class="relative p-6 border-2 border-dashed border-gray-300 rounded-xl hover:border-blue-500 transition-colors">
                                <input type="file" name="proof_image" id="proof_image" required accept="image/*"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                    onchange="document.getElementById('file-name').textContent = this.files[0]?.name || 'Pilih file...'">
                                <div class="text-center">
                                    <i class="text-3xl text-gray-400 fas fa-cloud-upload-alt mb-2"></i>
                                    <p class="text-sm text-gray-600">Klik untuk upload atau drag & drop</p>
                                    <p class="text-xs text-gray-500" id="file-name">Pilih file...</p>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mb-6">
                            <label class="block mb-2 text-sm font-semibold text-gray-700">
                                <i class="fas fa-sticky-note mr-2"></i>Catatan (Opsional)
                            </label>
                            <textarea name="notes" rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                placeholder="Tambahkan catatan jika diperlukan"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full px-6 py-4 text-lg font-bold text-white bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl hover:from-blue-600 hover:to-blue-700 transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                            <i class="fas fa-paper-plane"></i>
                            <span>Kirim Bukti Pembayaran</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Info -->
            <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
                <div class="flex items-start gap-3">
                    <i class="text-blue-500 fas fa-info-circle mt-1"></i>
                    <div class="text-sm text-blue-800">
                        <p class="font-semibold">Informasi Pembayaran</p>
                        <p class="mt-1">Admin akan memverifikasi pembayaran Anda dalam 1x24 jam. Setelah dikonfirmasi, Anda dapat langsung mengakses assessment.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

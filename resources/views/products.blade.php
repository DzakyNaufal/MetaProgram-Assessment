@extends('layouts.user')

@section('content')
    <main class="px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="mb-12 text-center">
            <h2
                class="text-4xl font-bold text-gray-90 sm:text-5xl bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text">
                Our Assessment Products
            </h2>
            <p class="max-w-2xl mx-auto mt-4 text-xl text-gray-600 sm:mt-6">
                Choose the right talent assessment package for your needs.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-10 md:grid-cols-2">
            @foreach ($products as $product)
                <div
                    class="overflow-hidden transition duration-300 transform border shadow-xl border-primary-800/20 bg-gradient-to-br from-white to-slate-50 rounded-2xl hover:shadow-2xl hover:-translate-y-2">
                    <div class="p-8">
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 drop-shadow-sm">{{ $product->name }}</h3>
                                <div class="p-4 mt-4 border rounded-lg bg-primary-500/10 border-primary-500/20">
                                    <p class="leading-relaxed text-gray-700">{{ $product->description }}</p>
                                </div>
                            </div>
                            <div
                                class="flex items-center justify-center w-12 h-12 text-lg font-bold rounded-full shadow-md text-primary-500 bg-primary-50/20">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                        </div>

                        <div class="mt-6 text-center">
                            <div class="text-3xl font-bold text-gray-900 drop-shadow-sm">Rp
                                {{ number_format($product->price, 0, ',', '.') }}</div>
                        </div>

                        @auth
                            <form method="POST" action="{{ route('products.buy') }}" class="mt-8">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                                <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                <button type="submit"
                                    class="w-full px-6 py-3 text-lg font-semibold text-white transition duration-300 border-2 shadow-xl rounded-xl hover:shadow-2xl border-primary-500/30 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                                    style="background-color: #2563eb !important; color: white !important;">
                                    {{-- Inline style untuk force warna, dengan !important untuk override --}}
                                    <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z">
                                        </path>
                                    </svg>
                                    Buy Now
                                </button>
                            </form>
                        @else
                            <div class="mt-8 text-center">
                                <a href="{{ route('login') }}"
                                    class="inline-block w-full px-6 py-3 text-lg font-semibold text-white transition duration-300 border-2 shadow-xl rounded-xl hover:shadow-2xl border-primary-500/30 focus:outline-none focus:ring-4 focus:ring-primary-500/20"
                                    style="background-color: #2563eb !important; color: white !important;">
                                    {{-- Inline style sama untuk link --}}
                                    <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    Login to Purchase
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>
    </main>
@endsection

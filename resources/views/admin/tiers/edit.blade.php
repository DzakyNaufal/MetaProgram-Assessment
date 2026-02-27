@extends('layouts.admin')

@section('header', 'Edit Tier')

@section('content')
    <div class="p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Tier</h1>
            <a href="{{ route('admin.tiers.index') }}" class="inline-block mt-4 text-blue-60 hover:text-blue-900">
                &larr; Back to Tiers
            </a>
        </div>

        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <form action="{{ route('admin.tiers.update', $tier->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $tier->name) }}" required
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-[#0369a1] focus:ring focus:ring-[#0369a1] focus:ring-opacity-50">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                        <input type="number" name="price" id="price" value="{{ old('price', $tier->price) }}"
                            required min="0"
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-[#0369a1] focus:ring focus:ring-[#0369a1] focus:ring-opacity-50">
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" id="description" rows="4"
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-[#0369a1] focus:ring focus:ring-[#0369a1] focus:ring-opacity-50">{{ old('description', $tier->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="features" class="block text-sm font-medium text-gray-700">Features (one per
                            line)</label>
                        <textarea name="features" id="features" rows="4"
                            class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-[#0369a1] focus:ring focus:ring-[#0369a1] focus:ring-opacity-50"
                            placeholder="Enter one feature per line">{{ old('features', $tier->features ? implode("\n", json_decode($tier->features, true)) : '') }}</textarea>
                        @error('features')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_recommended" value="1"
                                {{ old('is_recommended', $tier->is_recommended) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-[#0369a1] shadow-sm focus:border-[#0369a1] focus:ring focus:ring-[#0369a1] focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Recommended Tier</span>
                        </label>
                    </div>

                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_active" value="1"
                                {{ old('is_active', $tier->is_active) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-[#0369a1] shadow-sm focus:border-[#0369a1] focus:ring focus:ring-[#0369a1] focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Active</span>
                        </label>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-4 py-2 text-white bg-[#0369a1] rounded-md hover:bg-[#025187] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0369a1]">
                            Update Tier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

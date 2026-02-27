@extends('layouts.user')

@section('content')
    <div class="py-12">
        <div class="max-w-4xl mx-auto space-y-8 sm:px-6 lg:px-8">
            <div class="p-6 border border-gray-100 shadow-xl sm:p-10 bg-gradient-to-br from-blue-50 to-white sm:rounded-2xl">
                <div class="max-w-2xl">
                    <div class="flex items-center mb-6">
                        <div class="p-3 mr-4 bg-blue-100 rounded-full">
                            <svg class="w-6 h-6 text-blue-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 007 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Update Profile Information</h3>
                    </div>
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div
                class="p-6 border border-gray-100 shadow-xl sm:p-10 bg-gradient-to-br from-green-50 to-white sm:rounded-2xl">
                <div class="max-w-2xl">
                    <div class="flex items-center mb-6">
                        <div class="p-3 mr-4 bg-green-100 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Update Password</h3>
                    </div>
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
@endsection

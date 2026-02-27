@extends('layouts.admin')

@section('header', 'Manajemen Users')

@section('content')
    <div class="p-6">
        <div class="overflow-hidden bg-white shadow-xl sm:rounded-3xl">
            <!-- Header -->
            <div class="px-8 py-10 bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-extrabold text-white">Manajemen Users</h1>
                        <p class="mt-2 text-lg text-blue-100">
                            Kelola semua pengguna di Ur-BrainDevPro
                        </p>
                    </div>
                    <div class="p-5 bg-white/20 backdrop-blur-sm rounded-2xl">
                        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table Card -->
        <div class="mt-6 overflow-hidden bg-white shadow-xl rounded-3xl">
            <div class="flex flex-col gap-4 px-6 py-5 border-b border-gray-100 sm:flex-row sm:items-center sm:justify-between bg-gradient-to-r from-blue-50 to-blue-100">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">
                        Daftar Users ({{ $users->count() }} total)
                    </h2>
                </div>
                <a href="{{ route('admin.users.create') }}"
                    class="inline-flex items-center px-5 py-3 text-sm font-bold text-white transition-all shadow-lg bg-gradient-to-r from-blue-600 to-blue-700 rounded-xl hover:from-blue-700 hover:to-blue-800 hover:shadow-xl hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah User
                </a>
            </div>

            <div class="overflow-x-auto bg-gradient-to-br from-gray-50 to-blue-50">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-blue-50 to-blue-100">
                        <tr>
                            <th scope="col"
                                class="px-6 py-4 text-xs font-bold tracking-wider text-left text-gray-700 uppercase">ID
                            </th>
                            <th scope="col"
                                class="px-6 py-4 text-xs font-bold tracking-wider text-left text-gray-700 uppercase">Name
                            </th>
                            <th scope="col"
                                class="px-6 py-4 text-xs font-bold tracking-wider text-left text-gray-700 uppercase">Email
                            </th>
                            <th scope="col"
                                class="px-6 py-4 text-xs font-bold tracking-wider text-left text-gray-700 uppercase">Role
                            </th>
                            <th scope="col"
                                class="px-6 py-4 text-xs font-bold tracking-wider text-left text-gray-700 uppercase">
                                Created At</th>
                            <th scope="col"
                                class="px-6 py-4 text-xs font-bold tracking-wider text-right text-gray-700 uppercase">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr class="transition-colors duration-200 hover:bg-blue-50/50">
                                <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                    <span class="inline-flex items-center justify-center w-8 h-8 text-sm font-bold text-blue-700 rounded-full shadow-sm bg-gradient-to-r from-blue-50 to-blue-100">
                                        {{ $user->id }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="flex items-center justify-center w-10 h-10 text-sm font-bold text-white shadow-lg bg-gradient-to-br from-blue-600 to-blue-700 rounded-xl">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">{{ $user->email }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                    <span
                                        class="inline-flex px-3 py-1.5 text-xs font-bold rounded-full
                                        {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600 whitespace-nowrap">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                        class="inline-flex items-center px-3 py-1.5 text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg font-semibold transition-all">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>
                                    <button type="button" x-data @click="$dispatch('open-delete-modal', { id: {{ $user->id }}, title: '{{ $user->name }}' })" class="inline-flex items-center px-3 py-1.5 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg font-semibold transition-all ml-2">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12">
                                    <div class="text-center">
                                        <div class="inline-flex items-center justify-center w-16 h-16 mb-4 rounded-full bg-gradient-to-br from-blue-100 to-blue-200">
                                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-lg font-bold text-gray-900">No users found</p>
                                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new user.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(method_exists($users, 'hasPages') && $users->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gradient-to-r from-gray-50 to-blue-50">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-data="{
        show: false,
        userId: null,
        userName: '',
        init() {
            window.addEventListener('open-delete-modal', (e) => {
                this.userId = e.detail.id;
                this.userName = e.detail.title;
                this.show = true;
            });
        },
        confirmDelete() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/users/${this.userId}`;

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
        <div x-show="show" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative w-full max-w-md mx-4 overflow-hidden bg-white shadow-2xl rounded-3xl">
            <!-- Header with Warning Icon -->
            <div class="px-6 py-5 bg-gradient-to-r from-red-500 to-red-600">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-12 h-12 bg-white/20 rounded-xl backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-bold text-white">Hapus User</h3>
                        <p class="text-sm text-red-100">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="px-6 py-5">
                <p class="mb-3 text-gray-600">Apakah Anda yakin ingin menghapus user ini?</p>
                <div class="p-3 border border-red-200 bg-red-50 rounded-xl">
                    <p class="text-sm font-semibold text-red-800" x-text="userName"></p>
                </div>
                <p class="mt-3 text-xs text-gray-500">Semua data terkait user ini akan dihapus secara permanen.</p>
            </div>

            <!-- Footer -->
            <div class="flex justify-end gap-3 px-6 py-4 bg-gray-50">
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

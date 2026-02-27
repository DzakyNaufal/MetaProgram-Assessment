<nav class="space-y-1">
    <!-- Admin Dashboard -->
    <a href="{{ route('admin.dashboard') }}"
        class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-blue-100 text-blue-800' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
        <svg class="flex-shrink-0 w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        <span class="truncate">Dashboard</span>
    </a>

    <!-- Admin Courses -->
    <a href="{{ route('admin.courses.index') }}"
        class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.courses.*') ? 'bg-blue-100 text-blue-800' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
        <svg class="flex-shrink-0 w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        <span class="truncate">Courses</span>
    </a>

    <!-- Admin Contacts -->
    <a href="{{ route('admin.contacts.index') }}"
        class="group flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.contacts.*') ? 'bg-blue-100 text-blue-800' : 'text-gray-700 hover:bg-gray-50 hover:text-gray-900' }}">
        <svg class="flex-shrink-0 w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
        <span class="truncate">Contacts</span>
    </a>

    <!-- Divider -->
    <div class="pt-4 mt-4 border-t border-gray-200"></div>

    <!-- Log Out (Paling Bawah) -->
    <form method="POST" action="{{ route('logout') }}" class="mt-2">
        @csrf
        <button type="submit"
            class="flex items-center w-full px-3 py-2 text-sm font-medium text-gray-700 rounded-md group hover:bg-red-50 hover:text-red-900"
            onclick="event.preventDefault(); this.closest('form').submit();">
            <svg class="flex-shrink-0 w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span class="truncate">Log Out</span>
        </button>
    </form>
</nav>

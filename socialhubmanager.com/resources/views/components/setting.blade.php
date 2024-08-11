@props(['heading'])

<section class="flex">
    <!-- Lateral Menu -->
    <aside class="w-60 py-6 px-4 h-full min-h-screen border-r">
        <h4 class="text-gray-600 text-xs font-bold uppercase text-center mb-6">Menu</h4>
        <ul class="space-y-4">
            <li>
                <a href="/"
                    class="{{ request()->is('/') ? 'text-white bg-blue-500' : '' }} flex items-center rounded-lg py-2 px-2 transform transition hover:scale-110 hover:text-white hover:bg-blue-500">
                    <x-icon name="connect" />
                    Connect to Social Network
                </a>
            </li>
            <li>
                <a href="/post/history"
                    class="{{ request()->is('post/history') ? 'text-white bg-blue-500' : '' }} flex items-center rounded-lg py-2 px-2 transform transition hover:scale-110 hover:text-white hover:bg-blue-500">
                    <x-icon name="history" />
                    Post History
                </a>
            </li>
            <li>
                <a href="/schedules"
                    class="{{ request()->is('schedules') ? 'text-white bg-blue-500' : '' }} flex items-center rounded-lg py-2 px-2 transform transition hover:scale-110 hover:text-white hover:bg-blue-500">
                    <x-icon name="calendar" />
                    Publications Schedules
                </a>
            </li>
            @if (auth()->check() && auth()->user()->socialAccount)
                <li>
                    <a href="/post/create"
                        class="{{ request()->is('post/create') ? 'text-white bg-blue-500' : '' }} flex items-center rounded-lg py-2 px-2 transform transition hover:scale-110 hover:text-white hover:bg-blue-500">
                        <x-icon name="create" />
                        Create Post
                    </a>
                </li>
            @endif
            <li>
                <a href="/post/queued-history"
                    class="{{ request()->is('post/queued-history') ? 'text-white bg-blue-500' : '' }} flex items-center rounded-lg py-2 px-2 transform transition hover:scale-110 hover:text-white hover:bg-blue-500">
                    <x-icon name="clock" />
                    Queued Posts History
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 p-6 bg-white mx-4">
        <h2 class="text-gray-800 font-bold text-xl mb-4">{{ $heading }}</h2>
        <div>
            {{ $slot }}
        </div>
    </main>
</section>

@props(['heading'])

<section class="px-6 py-8">
    <main class="max-w-4px mx-auto mt-5">

        <div class="flex">
            <aside class="w-48 flex-shrink-0 bg-gray-100 rounded-2xl py-2 px-2 mr-5">
                <h4 class="text-xl font-medium text-gray-800 tracking-wider text-center mb-4"> Menu </h4>
                <ul class="space-y-2">
                    <li>
                        <a href="/schedules" class="{{ request()->is('schedules') ? 'text-blue-500' : '' }}">
                            Publications Schedules
                        </a>
                    </li>
                    <li>
                        <a href="/post/create" class="{{ request()->is('post/create') ? 'text-blue-500' : '' }}">
                            Create Post
                        </a>
                    </li>
                    <li>
                        <a href="/post/queued-history" class="{{ request()->is('post/queued-history') ? 'text-blue-500' : '' }}">
                            Queued Posts History
                        </a>
                    </li>
                </ul>
            </aside>

            <section class="flex-1">
                <h1 class="text-xl font-medium text-gray-800 tracking-wider mb-8 pb-2 pt-2 border-b"> {{ $heading }}
                </h1>

                {{ $slot }}
            </section>
        </div>
    </main>
</section>
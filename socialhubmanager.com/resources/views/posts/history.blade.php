<x-layout>
    <x-setting heading="Queued Posts History">
        <div class="">
            <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white">
                <div>
                    <x-dropdown buttonLabel="Status Post">
                        <x-dropdown-item href="/post/queued-history" :active="!request()->has('status')">
                            All
                        </x-dropdown-item>
                        <x-dropdown-item href="/post/queued-history?status=pending" :active="request()->query('status') == 'pending'">
                            Pending
                        </x-dropdown-item>
                        <x-dropdown-item href="/post/queued-history?status=published" :active="request()->query('status') == 'published'">
                            Published
                        </x-dropdown-item>
                    </x-dropdown>
                </div>
            </div>
            @if (count($posts) > 0)
            <div class="relative shadow-md overflow-x-auto sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Post Content
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Social Media
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Publish Date
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                        <tr class="bg-white border-b">
                            <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
                                <div class="ps-3">
                                    <div class="font-normal text-gray-500">{{ strlen($post->content) > 90 ? substr($post->content, 0, 80) . "..." : $post->content }}</div>
                                </div>
                            </th>
                            <td class="px-6 py-4">
                                <div class="font-normal text-gray-500">{{ ucfirst($post->provider) }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <time>
                                    {{ $post->scheduled_at ? $post->scheduled_at->timezone('America/Costa_Rica')->diffForHumans() : $post->queued_at->timezone('America/Costa_Rica')->diffForHumans() }}
                                </time>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @php
                                        if ($post->status == 'published') {
                                            $roundColor = 'bg-green-500';
                                        } elseif ($post->status == 'pending') {
                                            $roundColor = 'bg-yellow-500';
                                        } elseif ($post->status == 'failed') {
                                            $roundColor = 'bg-red-500';
                                        }
                                    @endphp
                                    <div class="h-2.5 w-2.5 rounded-full {{ $roundColor }} me-2 mr-1"></div> {{ ucfirst($post->status) }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <a x-data="{ disabled: '{{ $post->status }}' === 'published' }"
                                    :class="{ 'pointer-events-none opacity-50 cursor-not-allowed': disabled }"
                                    :href="disabled ? '#' : '{{ url('/') }}/auth/{{ $post->provider }}/publish/{{ $post->id }}'"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                    Publish Now
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div id="alert-5" class="flex items-center p-4 rounded-lg bg-gray-50 dark:bg-gray-800" role="alert">
                <x-icon name="info" />
                <span class="sr-only">Info</span>
                <div class="ms-3 text-sm font-medium text-gray-800 ml-1">
                    There aren't any records of this
                    <a href="/post/create" class="font-semibold underline hover:no-underline">publication type in the queue</a>. Click if you want to create one.
                </div>
            </div>
            @endif
        </div>
    </x-setting>
</x-layout>
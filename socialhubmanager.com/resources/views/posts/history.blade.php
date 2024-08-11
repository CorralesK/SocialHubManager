<x-layout>
    <x-setting heading="Queued Posts History">
        <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white">
            <x-posts.dropdown-status uri="/post/queued-history" />
            <x-posts.search />
            <x-posts.link-clear-filters />
        </div>
        @if (count($posts) > 0)
            <div class="relative shadow-md overflow-x-auto sm:rounded-lg mb-3">
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
                                <x-posts.row-content>{{ $post->content }}</x-posts.row-content>
                                <x-posts.row-provider>{{ $post->provider }}</x-posts.row-provider>
                                <td class="px-6 py-4">
                                    <time>
                                        {{ $post->scheduled_at ? $post->scheduled_at->timezone('America/Costa_Rica')->diffForHumans() : $post->queued_at->timezone('America/Costa_Rica')->diffForHumans() }}
                                    </time>
                                </td>
                                <x-posts.row-status>{{ $post->status }}</x-posts.row-status>
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
            {{ $posts->links() }}
        @else
            <x-posts.alert-message>queue</x-alert-message>
        @endif
    </x-setting>
</x-layout>
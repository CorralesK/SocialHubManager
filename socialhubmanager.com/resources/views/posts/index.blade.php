<x-layout>
    <x-setting heading="Post History">
        <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white mt-6">
            <x-posts.dropdown-status uri="/post/history" />
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
                            Created date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Type
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
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
                                {{ $post->created_at->timezone('America/Costa_Rica')->diffForHumans() }}
                            </time>
                        </td>
                        <td class="px-6 py-4">
                            @php
                            if ($post->is_instant) {
                            $type = 'Instant';
                            } elseif ($post->scheduled_at != null) {
                            $type = 'Schedule';
                            } elseif ($post->queued_at != null) {
                            $type = 'Queued';
                            }
                            @endphp
                            <div class="ps-3">
                                <div class="font-normal text-gray-500">{{ $type }}</div>
                            </div>
                        </td>
                        <x-posts.row-status>{{ $post->status }}</x-posts.row-status>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <x-posts.alert-message>record</x-alert-message>
            @endif
    </x-setting>
</x-layout>
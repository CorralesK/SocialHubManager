<x-layout>
    <x-setting heading="Post History">
        <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white mt-6">
            <x-posts.dropdown-type />
            <x-posts.dropdown-status />
            <x-posts.search />
            <x-posts.link-clear-filters />
        </div>
        @if (count($posts) > 0)
            <div class="relative shadow-md overflow-x-auto sm:rounded-lg mb-3">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">Post Content</th>
                            <th scope="col" class="px-6 py-3">Social Media</th>
                            <th scope="col" class="px-6 py-3">Type</th>
                            <th scope="col" class="px-6 py-3">Publish Date</th>
                            <th scope="col" class="px-6 py-3">Created date</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            @php
                                if ($post->is_instant) {
                                    $type = 'Instant';
                                    $publishDate = $post->created_at->timezone('America/Costa_Rica')->diffForHumans();
                                } elseif ($post->scheduled_at != null) {
                                    $type = 'Schedule';
                                    $publishDate = $post->published_queued->timezone('America/Costa_Rica')->diffForHumans();
                                } elseif ($post->queued_at != null) {
                                    $type = 'Queued';
                                    $publishDate = !empty($post->published_queued) ? $post->published_queued->timezone('America/Costa_Rica')->diffForHumans() : 'Pending in Queue';
                                }
                            @endphp
                            <tr class="bg-white border-b">
                                <x-posts.row-content>{{ $post->content }}</x-posts.row-content>
                                <x-posts.td-table>
                                    <x-posts.text-table>{{ ucfirst($post->provider) }}</x-posts.text-table>
                                </x-posts.td-table>
                                <x-posts.td-table>
                                    <x-posts.text-table>{{ $type }}</x-posts.text-table>
                                </x-posts.td-table>
                                <x-posts.td-table>
                                    <time>
                                        {{ $publishDate }}
                                    </time>
                                </x-posts.td-table>
                                <x-posts.td-table>
                                    <time>
                                        {{ $post->created_at->timezone('America/Costa_Rica')->diffForHumans() }}
                                    </time>
                                </x-posts.td-table>
                                <x-posts.row-status>{{ $post->status }}</x-posts.row-status>
                                <td class="px-6 py-4">
                                    @php
                                        $isDisabled = $post->status === 'published';
                                        $linkHref = $isDisabled ? '#' : url("/auth/{$post->provider}/publish/{$post->id}");
                                        $linkClass = $isDisabled ? 'pointer-events-none opacity-50 cursor-not-allowed' : 'font-medium text-blue-600 dark:text-blue-500 hover:bold transform transition hover:scale-110';
                                    @endphp
                                    <a href="{{ $linkHref }}" class="{{ $linkClass }}">
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
            <x-posts.alert-message />
        @endif
    </x-setting>
</x-layout>
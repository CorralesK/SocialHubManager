<div id="alert-5" class="flex items-center p-4 rounded-lg bg-gray-50 dark:bg-gray-800" role="alert">
    <x-icon name="info" />
    <span class="sr-only">Info</span>
    <div class="ms-3 text-sm font-medium text-gray-800 ml-1">
        No posts available in the
        <a href="/post/create" class="font-semibold underline hover:no-underline">{{ $slot }}</a>. Click if you want to create one.
    </div>
</div>
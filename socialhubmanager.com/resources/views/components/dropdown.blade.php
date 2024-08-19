
<div x-data="{ open: false }" class="relative inline-block text-left">
    <button @click="open = !open"
        type="button"
        class="{{ $buttonStyles }}">
        <span class="flex-grow text-left mr-1">{{ $buttonLabel }}</span>
        <x-icon name="down-arrow" />
    </button>

    <div x-show="open" @click.away="open = false" class="z-10 absolute right-0 mt-2 bg-white divide-y divide-gray-100 rounded-lg shadow {{ $menuWidth }}">
        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
            {{ $slot }}
        </ul>
    </div>
</div>
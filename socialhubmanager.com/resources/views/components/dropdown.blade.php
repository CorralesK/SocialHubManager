<div x-data="{ open: false }" class="relative inline-block text-left">
    <button @click="open = !open"
        type="button"
        class="inline-flex w-48 items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-3 w-44">
        <span class="flex-grow text-left">{{ $buttonLabel }}</span>
        <x-icon name="down-arrow" class="ml-2" />
    </button>

    <!-- Dropdown menu -->
    <div x-show="open" @click.away="open = false" class="z-10 absolute right-0 mt-2 bg-white divide-y divide-gray-100 rounded-lg shadow w-48">
        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
            {{ $slot }}
        </ul>
    </div>
</div>
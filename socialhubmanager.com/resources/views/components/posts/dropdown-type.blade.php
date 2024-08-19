<div>
    <x-dropdown
        buttonLabel="Type Post"
        buttonStyles="inline-flex w-48 items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-3"
        menuWidth="w-48"
    >
        @php
            $currentQuery = request()->except('type');
        @endphp
        <x-dropdown-item href="{{ route('history', $currentQuery) }}" :active="!request()->has('type')">
            All
        </x-dropdown-item>
        <x-dropdown-item href="{{ route('history', array_merge($currentQuery, ['type' => 'instant'])) }}" :active="request()->query('type') == 'instant'">
            Instant
        </x-dropdown-item>
        <x-dropdown-item href="{{ route('history', array_merge($currentQuery, ['type' => 'queued'])) }}" :active="request()->query('type') == 'queued'">
            In Queued
        </x-dropdown-item>
    </x-dropdown>
</div>
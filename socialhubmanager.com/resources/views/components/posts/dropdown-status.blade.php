<div>
    <x-dropdown 
        buttonLabel="Status Post"
        buttonStyles="inline-flex w-48 items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-3 w-44"
        menuWidth="w-48"
    >
        @php
            $currentQuery = request()->except('status');
        @endphp
        <x-dropdown-item href="{{ route('history', $currentQuery) }}" :active="!request()->has('status')">
            All
        </x-dropdown-item>
        <x-dropdown-item href="{{ route('history', array_merge($currentQuery, ['status' => 'published'])) }}" :active="request()->query('status') == 'published'">
            Published
        </x-dropdown-item>
        <x-dropdown-item href="{{ route('history', array_merge($currentQuery, ['status' => 'pending'])) }}" :active="request()->query('status') == 'pending'">
            Pending
        </x-dropdown-item>
        <x-dropdown-item href="{{ route('history', array_merge($currentQuery, ['status' => 'failed'])) }}" :active="request()->query('status') == 'failed'">
            Failed
        </x-dropdown-item>
    </x-dropdown>
</div>
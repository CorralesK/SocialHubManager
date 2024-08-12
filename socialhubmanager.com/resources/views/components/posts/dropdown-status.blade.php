<div>
    <x-dropdown buttonLabel="Status Post">
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
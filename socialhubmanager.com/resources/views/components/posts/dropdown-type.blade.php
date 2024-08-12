<div>
    <x-dropdown buttonLabel="Type Post">
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
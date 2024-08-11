<div>
    <x-dropdown buttonLabel="Status Post">
        <x-dropdown-item href="{{ $uri }}" :active="!request()->has('status')">
            All
        </x-dropdown-item>
        <x-dropdown-item href="{{ $uri }}?status=published" :active="request()->query('status') == 'published'">
            Published
        </x-dropdown-item>
        <x-dropdown-item href="{{ $uri }}?status=pending" :active="request()->query('status') == 'pending'">
            Pending
        </x-dropdown-item>
        <x-dropdown-item href="{{ $uri }}?status=published" :active="request()->query('status') == 'failed'">
            Failed
        </x-dropdown-item>
    </x-dropdown>
</div>
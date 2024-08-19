<x-dropdown
    buttonLabel="Two Factor Authentication"
    buttonStyles="text-2xs font-bold hover:text-blue-500 flex flex-row items-center"
    menuWidth="w-56">
    <x-dropdown-item
        href="/two-factor/activate"
        :active="request()->is('two-factor/activate')"
        :disabled="auth()->user()->uses_two_factor"
        aria-disabled="{{ auth()->user()->uses_two_factor }}">
        Activate
    </x-dropdown-item>

    <x-dropdown-item
        href="#"
        onclick="event.preventDefault(); document.getElementById('deactivate-two-factor-form').submit();"
        :disabled="!auth()->user()->uses_two_factor"
        aria-disabled="{{ !auth()->user()->uses_two_factor }}">
        Deactivate
    </x-dropdown-item>
    
    @if (auth()->user()->uses_two_factor)
        <form id="deactivate-two-factor-form" action="/two-factor/deactivate" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    @endif
</x-dropdown>
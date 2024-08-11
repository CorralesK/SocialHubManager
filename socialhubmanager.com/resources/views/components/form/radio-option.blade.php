@props(['name', 'value'])

<div id="{{ $value }}" class="inline-flex items-center px-4 py-2 border rounded mb-2 mx-4 transform transition hover:scale-110 hover:text-blue-700">
    <label for="{{ $name }}-{{ $value }}" class="flex items-center cursor-pointer">
        <input id="{{ $name }}-{{ $value }}" type="radio" name="{{ $name }}" value="{{ $value }}"
            {{ old($name) == $value ? 'checked' : '' }} 
            {{ $attributes->merge(['class' => 'hidden']) }}>

        <span class="flex items-center space-x-2">
            {{ $slot }}
        </span>
    </label>
</div>

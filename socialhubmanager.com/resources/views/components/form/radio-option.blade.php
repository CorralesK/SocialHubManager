@props(['name', 'value'])

<div class="inline-flex items-center mb-2 transition-colors duration-300 peer-checked:bg-gray-700 peer-checked:text-white peer-checked:border-transparent">
    <label
        class="flex items-center cursor-pointer px-4 py-2 border rounded ">
        <input type="radio" name="{{ $name }}" value="{{ $value }}"
            {{ $attributes->merge(['checked' => old($name) == $value ? 'checked' : '']) }} 
            class="hidden peer">
        
        <span class="flex items-center space-x-2">
            {{ $slot }}
        </span>
    </label>
</div>

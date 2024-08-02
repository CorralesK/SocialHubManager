<x-form.field>
    <button 
        type="submit" 
        class="mt-2 w-full rounded-lg bg-blue-500 py-2.5 px-6 text-center text-xs font-bold uppercase text-white shadow-md shadow-blue-500/20 transition-all hover:shadow-lg hover:shadow-blue-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
        {{ $slot }}
    </button>
</x-form.field>
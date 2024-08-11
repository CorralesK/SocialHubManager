<x-layout>
    <x-setting heading="Add New Schedule">
        <x-panel>
            <form method="POST" action="/schedules" enctype="multipart/form-data" class="mt-2">
                @csrf

                <x-form.field>
                    <x-form.label name="day of week" />
                    <select name="day_of_week" id="day_of_week" required class="border border-gray-200 p-2 w-full rounded">
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            <option value="{{ $day }}" {{ old('day_of_week') == $day ? 'selected' : '' }}
                                class="block text-left px-3 text-sm leading-6 text-black hover:bg-blue-500 focus:bg-blue-500 hover:text-white focus:text-white">
                                {{ ucfirst($day) }}
                            </option>
                        @endforeach
                    </select>
                </x-form.field>
                <x-form.input name="time" type="time" />
                <x-form.button> Save </x-form.button>
            </form>
        </x-panel>
    </x-setting>
</x-layout>

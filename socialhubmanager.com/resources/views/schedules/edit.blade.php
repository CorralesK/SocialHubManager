<x-layout>
    <x-setting heading="Edit Schedule">
        <x-panel>
            <form method="POST" action="/schedules/{{ $schedule->id }}" enctype="multipart/form-data" class="mt-2">
                @csrf
                @method('PATCH')

                <x-form.field>
                    <x-form.label name="day_of_week" />
                    <select name="day_of_week" id="day_of_week" required class="border border-gray-200 p-2 w-full rounded">
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            <option value="{{ $day }}"
                                {{ old('day_of_week', $schedule->day_of_week) == $day ? 'selected' : '' }}>
                                {{ ucfirst($day) }}
                            </option>
                        @endforeach
                    </select>
                </x-form.field>

                <x-form.input name="time" type="time" :value="old('time', $schedule->time)" />

                <x-form.button> Update </x-form.button>
            </form>
        </x-panel>
    </x-setting>
</x-layout>

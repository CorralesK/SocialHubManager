<x-layout>
    <x-setting heading="Publications Schedules">
        <div class="overflow-x-auto">
            <div class="flex justify-end mb-4">
                <a href="schedules/create"
                    class="bg-blue-500 text-white uppercase font-semibold text-xs py-2 px-5 rounded-2xl hover:bg-blue-600">
                    Add New Schedule
                </a>
            </div>
            <table class="min-w-full bg-white divide-y divide-gray-200">
                <thead>
                    <tr>
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            <th
                                class="px-6 py-3 border-b border-gray-200 bg-gray-100 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ $day }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < 20; $i++)
                        <tr class="divide-x divide-gray-200">
                            @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <td class="relative py-2 whitespace-nowrap">
                                    @php
                                        $schedule = $schedules->get($day)?->get($i);
                                    @endphp
                                    @if ($schedule)
                                        <div
                                            class="flex justify-center items-center text-center space-x-1 bg-indigo-100 py-2 px-2 rounded-xl w-max mx-auto">
                                            <a href="schedules/{{ $schedule->id }}/edit"
                                                class="text-sm font-medium text-gray-500 hover:text-indigo-700">
                                                {{ \Carbon\Carbon::parse($schedule->time)->format('g:i A') }}
                                            </a>
                                            <form method="POST" action="schedules/{{ $schedule->id }}"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-gray-500 items-center hover:text-red-500"
                                                    title="Delete">
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1" d="M6 6L18 18M6 18L18 6" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </x-setting>
</x-layout>

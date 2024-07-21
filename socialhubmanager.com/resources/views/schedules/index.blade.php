<x-layout>
    <x-setting heading="Manage Schedules">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-2xl">
                <thead>
                    <tr>
                        @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ $day }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @for ($i = 0; $i < 10; $i++)
                        <tr>
                            @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $day)
                                <td class="relative px-6 py-4 whitespace-nowrap">
                                    @php
                                        $schedule = $schedules->get($day)?->get($i);
                                    @endphp
                                    @if ($schedule)
                                        <div class="flex items-center space-x-2 indigo-300">
                                            <a href="{{ route('schedules.edit', $schedule->id) }}" 
                                                class="text-sm font-medium text-gray-500 hover:text-indigo-500">
                                                {{ $schedule->time }}
                                            </a>
                                            <form method="POST" action="{{ route('schedules.destroy', $schedule->id) }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-gray-500 hover:text-gray-900" title="Delete">
                                                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6L18 18M6 18L18 6" />
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

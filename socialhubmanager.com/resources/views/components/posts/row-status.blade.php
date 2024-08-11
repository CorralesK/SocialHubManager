<td class="px-6 py-4">
    <div class="flex items-center">
        @php
        if ($slot == 'published') {
            $roundColor = 'bg-green-500';
        } elseif ($slot == 'pending') {
            $roundColor = 'bg-yellow-500';
        } elseif ($slot == 'failed') {
            $roundColor = 'bg-red-500';
        }
        @endphp
        <div class="h-2.5 w-2.5 rounded-full {{ $roundColor }} me-2 mr-1"></div> {{ ucfirst($slot) }}
    </div>
</td>
@if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
        class="fixed bottom-4 right-4 bg-blue-500 text-white p-4 rounded">
        {{ session('success') }}
    </div>

@elseif (session('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
        class="fixed bottom-4 right-4 bg-blue-500 text-red p-4 rounded">
        {{ session('error') }}
    </div>
@endif

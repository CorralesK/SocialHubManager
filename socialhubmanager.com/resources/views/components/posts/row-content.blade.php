<th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap">
    <div class="ps-3">
        <div class="font-normal text-gray-500">{{ strlen($slot) > 90 ? substr($slot, 0, 80) . "..." : $slot }}</div>
    </div>
</th>
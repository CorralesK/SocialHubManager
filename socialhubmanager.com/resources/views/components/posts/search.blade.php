<div x-data="{ search: '{{ request()->query('search', '') }}' }" class="flex items-center">
    <input
        type="text"
        id="search"
        x-model="search"
        class="block p-3 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 focus:outline-none hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 mr-2"
        placeholder="Search Post by Content">
    <a
        href="#"
        @click.prevent="updateUrl()"
        class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
        <x-icon name="search" />
    </a>
</div>

<script>
    function updateUrl() {
        const search = document.getElementById('search').value;
        if (search.trim() !== '') {
            const url = new URL(window.location.href);
            url.searchParams.set('search', search);
            url.searchParams.delete('page');
            window.location.href = url.toString();
        }
    }
</script>
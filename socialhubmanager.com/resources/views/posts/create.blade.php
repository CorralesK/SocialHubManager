<x-layout>
    <x-setting heading="Create Post">
        <div class="overflow-x-auto">
            <x-panel>
                <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data" class="mt-2">
                    @csrf

                    <div class="mb-4">
                        <label for="content" class="block text-gray-700 text-sm font-bold mb-2">
                            Post Content
                        </label>
                        <textarea id="content" name="content" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">
                            Publish Option
                        </label>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="radio" name="publish_option" value="now" checked class="form-radio">
                                <span class="ml-2">Publish Now</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="radio" name="publish_option" value="queue" class="form-radio">
                                <span class="ml-2">Add to Queue</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="radio" name="publish_option" value="schedule" class="form-radio">
                                <span class="ml-2">Schedule</span>
                            </label>
                        </div>
                    </div>

                    <div id="scheduleDateTimePicker" class="mb-4" style="display: none;">
                        <label for="scheduled_at" class="block text-gray-700 text-sm font-bold mb-2">
                            Schedule Date and Time
                        </label>
                        <input type="datetime-local" id="scheduled_at" name="scheduled_at" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>

                    <x-form.button>Save</x-form.button>
                </form>
            </x-panel>
        </div>
    </x-setting>
</x-layout>

<script>
document.querySelectorAll('input[name="publish_option"]').forEach((elem) => {
    elem.addEventListener("change", function(event) {
        if (event.target.value === "schedule") {
            document.getElementById("scheduleDateTimePicker").style.display = "block";
        } else {
            document.getElementById("scheduleDateTimePicker").style.display = "none";
        }
    });
});
</script>

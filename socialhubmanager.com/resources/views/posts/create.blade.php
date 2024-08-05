<x-layout>
    <x-setting heading="Create Post">
        <div class="overflow-x-auto">
            <x-panel>
                <form method="POST" action="/post" enctype="multipart/form-data" class="mt-2">
                    @csrf

                    <x-form.field>
                        <x-form.label name="Post Content" />
                        <textarea name="content" id="content"
                            class="w-full h-40 border rounded mt-1 py-2 px-3 shadow appearance-none leading-tight text-gray-700" required>{{ old('content') ?? '' }}</textarea>
                        <x-form.error name="content" />
                    </x-form.field>

                    <x-form.field>
                        <x-form.label name="Social Media" />

                        @foreach (auth()->user()->socialAccount as $social)
                            <x-form.radio-option name="provider" value="{{ $social->provider }}">
                                <x-social-icon socialNetwork="{{ $social->provider }}" />
                                {{ $social->provider }}
                            </x-form.radio-option>
                        @endforeach
                    </x-form.field>


                    <x-form.field>
                        <x-form.label name="Publish Option" />

                        <x-form.radio-option name="publish_option" value="now" checked> Publish Now
                        </x-form.radio-option>
                        <x-form.radio-option name="publish_option" value="queue"> Add to Queue </x-form.radio-option>
                        <x-form.radio-option name="publish_option" value="schedule"> Schedule </x-form.radio-option>
                    </x-form.field>

                    <div id="scheduleDateTimePicker" class="mb-4" style="display: none;">
                        <x-form.label name="Schedule Date and Time" />
                        <input class="border border-gray-200 p-2 w-full rounded" name="scheduled_at" id="scheduled_at"
                            type="datetime-local" value="{{ old('scheduled_at') ?? '' }}">

                        <x-form.error name="scheduled_at" />
                    </div>

                    <x-form.button>Save</x-form.button>
                </form>
            </x-panel>
        </div>
    </x-setting>
</x-layout>

<script>
    document.querySelectorAll('input[name="publish_option"]').forEach((elem) => {
        elem.addEventListener("click", function(event) {
            if (event.target.value === "schedule") {
                document.getElementById("scheduleDateTimePicker").style.display = "block";
            } else {
                document.getElementById("scheduleDateTimePicker").style.display = "none";
            }
        });
    });
</script>

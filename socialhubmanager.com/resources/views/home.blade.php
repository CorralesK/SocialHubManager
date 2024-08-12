<x-layout>
    <x-setting heading="Social Networking">
        <div class="flex flex-col justify-center items-center min-h-[800px]">
            <p class="text-xs text-gray-500 tracking-wider mb-8 pb-2 pt-2">
                Which social network would you like to connect with?
            </p>
            <section class="flex justify-center items-center mt-10 space-x-20">
                <a href="auth/twitter" class="flex flex-col items-center text-center transform transition hover:scale-110">
                    <x-social-icon socialNetwork="twitter" size="50" class="mb-2" />
                    <p class="text-sm">Twitter</p>
                </a>
                <a href="/auth/linkedin" class="flex flex-col items-center text-center transform transition text-blue-700 hover:scale-110">
                    <x-social-icon socialNetwork="linkedin" size="50" class="mb-2" />
                    <p class="text-sm">LinkedIn</p>
                </a>
                <a href="/auth/mastodon" class="flex flex-col items-center text-center transform transition text-indigo-900 hover:scale-110">
                    <x-social-icon socialNetwork="mastodon" size="50" class="mb-2" />
                    <p class="text-sm">Mastodon</p>
                </a>
            </section>
        </div>
    </x-setting>
</x-layout>
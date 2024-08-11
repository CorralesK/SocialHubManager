<x-layout>
    <section class="px-6 py-8">
        <main class="max-w-lg mx-auto mt-10">
            <x-panel class="shadow-lg rounded-lg p-8">
                <h1 class="text-3xl text-center font-semibold text-gray-800 mt-1">
                    Sign in to your account
                </h1>

                <form method="POST" action="/login" class="mt-10">
                    @csrf

                    <x-form.input name="email" type="email" autocomplete="username" required />
                    <x-form.input name="password" type="password" autocomplete="current-password" required />

                    <x-form.large-button>
                        Sign In
                    </x-form.large-button>

                    <p class="mt-8 text-sm text-gray-700 mt-10">
                        Don’t have an account yet?
                        <a href="/register" class="font-semibold leading-6 text-blue-500 hover:underline">
                            Sign up
                        </a>
                    </p>
                </form>
            </x-panel>
        </main>
    </section>
</x-layout>
<x-layout>
    <section class="px-6 py-8">
        <main class="max-w-lg mx-auto mt-10">
            <x-panel class="shadow-lg rounded-lg p-8">
                <h1 class="text-3xl text-center font-semibold text-gray-800 mt-1">
                    Create an account
                </h1>

                <form method="POST" action="/register" class="mt-10">
                    @csrf

                    <x-form.input name="name" />
                    <x-form.input name="email" type="email" />
                    <x-form.input name="password" type="password" autocomplete="new-password" />
                    <x-form.large-button>Sign Up</x-form.large-button>
                    <p class="mt-8 text-sm text-gray-700 mt-10">
                        Already have an account?
                        <a href="/login" class="font-semibold leading-6 text-blue-500 hover:underline">
                            Login here
                        </a>
                    </p>
                </form>
            </x-panel>
        </main>
    </section>
</x-layout>
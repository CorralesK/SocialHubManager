<x-layout>
    <section class="px-6 py-8">
        <main class="max-w-lg mx-auto my-10 h-3/6">
            <x-panel class="shadow-lg rounded-lg p-8">
                <h1 class="text-center text-3xl font-semibold text-gray-900 mb-7 border-b border-gray-200 pb-4 mt-2">
                    Verify Two Factor Authentication
                </h1>

                <form action="/two-factor/verify" method="post" class="flex flex-col mt-3">
                    @csrf
                    @method('PATCH')

                    <div class="w-full mb-4">
                        <input type="number" name="otp" placeholder="Enter OTP" class="border border-gray-300 p-3 w-full rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" required>
                        <x-form.error name="otp" />
                    </div>

                    <p class="text-sm font-medium text-gray-700 mb-4 text-center">
                        Please open the Google Authenticator app and enter the current One Time Password (OTP) for the Social Hub Manager.
                    </p>

                    <x-form.large-button>
                        Complete Verification
                    </x-form.large-button>
                </form>
            </x-panel>
        </main>
    </section>
</x-layout>
<x-layout>
    <section class="px-6 py-8">
        <main class="max-w-lg mx-auto my-10 h-3/6">
            <x-panel class="shadow-lg rounded-lg p-8">
                <h1 class="text-3xl text-center text-gray-700 font-semibold mb-7 border-b border-gray-200 pb-4 mt-2">
                    Verify Two Factor Authentication
                </h1>

                <form action="/two-factor/verify" method="post" class="flex flex-col mt-3">
                    @csrf
                    @method('PATCH')

                    <div class="w-full mb-4">
                        <input type="number" name="otp" placeholder="Enter OTP" class="border border-gray-300 p-2 w-full rounded-lg shadow-sm" required>
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
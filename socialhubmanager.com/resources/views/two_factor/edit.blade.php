<x-layout>
    <section class="px-6 py-4 mt-10">
        <main class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-8 my-10 h-3/6">
            <h1 class="text-center text-3xl font-semibold text-gray-900 mb-5 border-b border-gray-200 pb-4">
                Verify Two-Factor Authentication
            </h1>

            <form action="/two-factor/verify" method="post" class="flex flex-col items-center mt-3">
                @csrf
                @method('PATCH')

                <div class="w-full mb-6">
                    <input type="number" name="otp" placeholder="Enter OTP" class="border border-gray-300 p-3 w-full rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150 ease-in-out" required>
                    <x-form.error name="otp" />
                </div>

                <p class="text-sm font-medium text-gray-700 mb-6 text-center">
                    Please open the Google Authenticator app and enter the current One Time Password (OTP) for the Social Hub Manager.
                </p>

                <x-form.button class="w-full bg-blue-500 text-white py-3 rounded-lg shadow-md hover:bg-blue-600 transition duration-150 ease-in-out">
                    Complete Verification
                </x-form.button>
            </form>
        </main>
    </section>
</x-layout>
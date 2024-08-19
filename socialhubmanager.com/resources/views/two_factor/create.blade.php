<x-layout>
    <section class="px-6 py-4 mt-2">
        <main class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-8">
            <h1 class="text-3xl text-center text-gray-700 font-semibold mb-7 border-b border-gray-200 pb-4 mt-2">
                Activate Two Factor Authentication
            </h1>

            <div class="text-center mb-3">
                <p class="text-lg font-medium text-gray-700 mb-3">Scan the QR code below with your Google Authenticator app:</p>
                <img src="{{ $qrCodeUrl }}" alt="QR Code" class="mx-auto mb-4 rounded-lg shadow-sm">
            </div>

            <div class="text-center mb-3">
                <p class="text-base font-medium text-gray-700 mb-2">Alternatively, you can use this key:</p>
                <p class="text-base font-semibold text-gray-900 bg-gray-100 p-2 rounded-lg">{{ $secretKey }}</p>
            </div>

            <div class="text-center">
                <p class="text-sm font-medium text-gray-700">
                    To do that, you must configure your Google Authenticator app and insert a OTP before continuing.
                </p>
            </div>

            <form action="/two-factor/activate" method="post" class="flex flex-col items-center">
                @csrf
                <input type="hidden" name="secret" value="{{ $secretKey }}">

                <div class="w-full mt-4">
                    <input type="number" name="otp" placeholder="Insert OTP" class="border border-gray-300 p-2 w-full rounded-lg shadow-sm" required>
                    <x-form.error name="otp" />
                </div>

                <x-form.button class="shadow-md">
                    Complete Activation
                </x-form.button>
            </form>
        </main>
    </section>
</x-layout>
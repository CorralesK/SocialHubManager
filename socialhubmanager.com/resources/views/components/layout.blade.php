<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Social Hub Manager</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/alpine.min.js" defer></script>
    <style>
        html {
            scroll-behavior: smooth;
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: 'Open Sans', sans-serif;
        }
        .content {
            flex: 1;
        }
    </style>
</head>
<body>
    <!-- Top Bar Menu -->
    <header class="text-gray-700 py-2 px-4">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <a href="/" class="flex items-center">
                    <span class="text-2xl font-bold italic text-blue-600">Social Hub</span>
                    <img src="/images/logo-icon.svg" alt="Socialhub Logo" class="w-20 h-20">
                </a>
            </div>
            <div class="flex items-center space-x-10">
                @if (auth()->check())
                    <a href="/" class="{{ request()->is('/') ? 'text-blue-500' : '' }} text-2xs font-bold hover:text-blue-500">Home</a>
                    <a href="/schedules" class="{{ request()->is('schedules') ? 'text-blue-500' : '' }} text-2xs font-bold hover:text-blue-500">Schedules</a>
                    <x-navbar.dropdown-2fa></x-nav.dropdown-2fa>
                    <a href="/logout" class="text-2xs font-bold hover:text-blue-500">Log out</a>
                @endif
            </div>
        </div>
    </header>

    <section class="content">
        {{ $slot }}
    </section>

    <footer class="text-center py-2 px-2">
        <div class="flex items-center justify-center space-x-2 text-gray-500">
            <span>Social Hub Manager</span>
        </div>
    </footer>

    <x-flash />
</body>
</html>
